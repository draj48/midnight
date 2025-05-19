<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Coupon;
use App\Models\Payment;
use App\Models\Tax;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\BadResponseException;

class SubscriptionController extends Controller
{
    public function index(Request $request)
    {
        $config = [
            'title' => __('Subscription'),
            'nav' => 'subscription',
        ];
        $now = \Carbon\Carbon::today();

        $plans = Plan::where('status','active')->orderby('sorting','asc')->limit(8)->get();

        // Query
        return view('subscription.index',compact('config','plans','now'));
    }

    public function billing(Request $request)
    {
        $config = [
            'title' => __('Billing'),
        ];

        // Query
        $listings = Payment::where('user_id',$request->user()->id)->orderBy('id', 'desc')->get();
        return view('subscription.billing',compact('config','listings'));
    }
    public function payment(Request $request)
    {
        $config = [
            'title' => __('Payment'),
        ];

        $plan = Plan::where('id', $request->id)->firstOrFail() ?? abort(404);

        if (\Auth::user()->plan_id == $plan->id) {
            return redirect()->route('dashboard.billing');
        }


        $couponCode = $request->old('coupon');
        $couponIds = $plan->coupons ?? [];
        $coupon = $couponCode
            ? Coupon::where('code', $couponCode)->whereIn('id', $couponIds)->first()
            : null;


        $taxes = Tax::whereIn('id', $plan->taxes ?? [])->ofRegion(old('country') ?? ($request->user()->billing->country ?? null))->orderBy('type')->get();

        // Sum the inclusive tax rates
        $inclTaxRatesPercentage = $taxes->where('type', '=', 0)->sum('percentage');

        // Sum the exclusive tax rates
        $exclTaxRatesPercentage = $taxes->where('type', '=', 1)->sum('percentage');

        // Get the total amount to be charged
        $amount = money_format(checkoutTotal($plan->price, $coupon->percentage ?? null, $exclTaxRatesPercentage, $inclTaxRatesPercentage), $plan->currency, false, false);

        return view('subscription.payment', compact('request', 'plan', 'taxes', 'inclTaxRatesPercentage', 'exclTaxRatesPercentage', 'coupon'));
    }

    public function store(Request $request)
    {

        $plan = Plan::where('id', $request->id)->firstOrFail() ?? abort(404);

        if (\Auth::user()->plan_id == $plan->id) {
            return redirect()->route('dashboard.billing');
        }


        // Update the user's billing information
        $request->user()->billing = [
            'city' => $request->input('city'),
            'country' => $request->input('country'),
            'zip_code' => $request->input('zip_code'),
            'address' => $request->input('address')
        ];

        $request->user()->save();

        // If the user's country has changed, or a coupon was applied
        if ($request->has('country') && !$request->has('payment') || $request->has('coupon') && !$request->has('coupon_set')) {
            return redirect()->back()->withInput();
        }
        $this->validate($request, [
            'payment_method' => 'required',
            'address' => 'required',
            'city' => 'required',
            'zip_code' => 'required',
            'country' => 'required'
        ]);

        $coupon = null;
        $taxes = collect();
        $inclTaxRatesPercentage = null;
        $exclTaxRatesPercentage = null;

        if ($request->filled('coupon')) {
            $coupon = Coupon::where('code', $request->input('coupon'))
                ->whereIn('id', $plan->coupons)
                ->where(function ($query) {
                    $query->where('quantity', '>', 'redeems')
                        ->orWhere('quantity', -1);
                })
                ->firstOrFail();
        }
        if ($plan->taxes) {
            $taxes = Tax::whereIn('id', $plan->taxes)
                ->ofRegion($request->user()->billing->country)
                ->orderBy('type')
                ->get();
            $inclTaxRatesPercentage = $taxes->where('type', 0)->sum('percentage');
            $exclTaxRatesPercentage = $taxes->where('type', 1)->sum('percentage');
        }

        $amount = money_format(
            checkoutTotal(
                $plan->price,
                optional($coupon)->percentage,
                $exclTaxRatesPercentage,
                $inclTaxRatesPercentage
            ),
            $plan->currency,
            false,
            false
        );
        if ($request->input('payment_method') == 'bank') {
            return $this->initBank($request, $plan, $coupon, $taxes, $amount);
        } elseif ($request->input('payment_method') == 'paypal') {
            return $this->initPaypal($request, $plan, $coupon, $taxes, $amount);
        } elseif ($request->input('payment_method') == 'stripe') {
            return $this->initStripe($request, $plan, $coupon, $taxes, $amount);
        }
    }

    private function initStripe(Request $request, Plan $plan, $coupon, $taxRates, $amount)
    {
        $stripe = new \Stripe\StripeClient(
            config('settings.stripe_secret')
        );

        // Attempt to retrieve the product
        try {
            $stripeProduct = $stripe->products->retrieve($plan->id);

            // Check if the plan's name has changed
            if ($plan->name != $stripeProduct->name) {

                // Attempt to update the product
                try {
                    $stripeProduct = $stripe->products->update($stripeProduct->id, [
                        'name' => $plan->name
                    ]);
                } catch (\Exception $e) {
                    return back()->with('error', $e->getMessage());
                }
            }
        } catch (\Exception $e) {
            // Attempt to create the product
            try {
                $stripeProduct = $stripe->products->create([
                    'id' => $plan->id,
                    'name' => $plan->name,
                    'description' => $plan->description
                ]);
            } catch (\Exception $e) {
                return back()->with('error', $e->getMessage());
            }
        }

        $stripeAmount = in_array($plan->currency, config('currencies.zero_decimals')) ? $amount : ($amount * 100);

        $stripePlan = $plan->id . '_' .$plan->interval . '_' . $stripeAmount . '_' . $plan->currency;

        // Attempt to retrieve the plan
        try {
            $stripePlan = $stripe->plans->retrieve($stripePlan);
        } catch (\Exception $e) {
            // Attempt to create the plan
            try {
                $stripePlan = $stripe->plans->create([
                    'amount' => $stripeAmount,
                    'currency' => $plan->currency,
                    'interval' => $plan->interval,
                    'product' => $stripeProduct->id,
                    'id' => $stripePlan,
                ]);
            } catch (\Exception $e) {
                return back()->with('error', $e->getMessage());
            }
        }

        // Attempt to create the checkout session
        try {
            $stripeSession = $stripe->checkout->sessions->create([
                'success_url' => route('subscription.completed'),
                'cancel_url' => route('subscription.cancelled'),
                'payment_method_types' => ['card'],
                'line_items' => [
                    [
                        'price' => $stripePlan->id,
                        'quantity' => 1,
                    ],
                ],
                'mode' => 'subscription',
                'subscription_data' => [
                    'metadata' => [
                        'user' => $request->user()->id,
                        'plan' => $plan->id,
                        'plan_amount' => $plan->price,
                        'amount' => $amount,
                        'currency' => $plan->currency,
                        'interval' => $plan->interval,
                        'coupon' => $coupon->id ?? null,
                        'taxes' => $taxRates->pluck('id')->implode('_')
                    ],
                ]
            ]);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return view('subscription.stripe', ['stripeSession' => $stripeSession]);
    }

    private function initBank(Request $request, Plan $plan, $coupon, $taxes, $amount)
    {

        $payment = new Payment();
        $payment->user_id = $request->user()->id;
        $payment->plan_id = $plan->id;
        $payment->payment_id = Str::random(10);
        $payment->payment_method = 'bank';
        $payment->amount = $amount;
        $payment->currency = $plan->currency;
        $payment->interval = $plan->interval;
        $payment->status = 'pending';
        $payment->coupons = $coupon->id ?? null;
        $payment->taxes = $taxes->pluck('id')->implode('_');
        $payment->save();
        return redirect()->route('subscription.pending');
    }

    private function initPayPal(Request $request, Plan $plan, $coupon, $taxRates, $amount) {
        $httpClient = new HttpClient();

        $httpBaseUrl = 'https://'.(config('settings.paypal_mode') == 'sandbox' ? 'api-m.sandbox' : 'api-m').'.paypal.com/';

        // Attempt to retrieve the auth token
        try {
            $payPalAuthRequest = $httpClient->request('POST', $httpBaseUrl . 'v1/oauth2/token', [
                    'auth' => [config('settings.paypal_client_id'), config('settings.paypal_secret')],
                    'form_params' => [
                        'grant_type' => 'client_credentials'
                    ]
                ]
            );

            $payPalAuth = json_decode($payPalAuthRequest->getBody()->getContents());
        } catch (BadResponseException $e) {
            return back()->with('error', $e->getResponse()->getBody()->getContents());
        }

        $payPalProduct = 'product_' . $plan->id;

        // Attempt to retrieve the product
        try {
            $payPalProductRequest = $httpClient->request('GET', $httpBaseUrl . 'v1/catalogs/products/' . $payPalProduct, [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $payPalAuth->access_token,
                        'Content-Type' => 'application/json'
                    ]
                ]
            );

            $payPalProduct = json_decode($payPalProductRequest->getBody()->getContents());
        } catch (\Exception $e) {
            // Attempt to create the product
            try {
                $payPalProductRequest = $httpClient->request('POST', $httpBaseUrl . 'v1/catalogs/products', [
                        'headers' => [
                            'Authorization' => 'Bearer ' . $payPalAuth->access_token,
                            'Content-Type' => 'application/json'
                        ],
                        'body' => json_encode([
                            'id' => $payPalProduct,
                            'name' => $plan->name,
                            'description' => $plan->description,
                            'type' => 'SERVICE'
                        ])
                    ]
                );

                $payPalProduct = json_decode($payPalProductRequest->getBody()->getContents());
            } catch (BadResponseException $e) {
                return back()->with('error', $e->getResponse()->getBody()->getContents());
            }
        }

        $payPalAmount = $amount;

        $payPalPlan = 'plan_' . $plan->id . '_' .$request->input('interval') . '_' . $payPalAmount . '_' . $plan->currency;

        // Attempt to create the plan
        try {
            $payPalPlanRequest = $httpClient->request('POST', $httpBaseUrl . 'v1/billing/plans', [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $payPalAuth->access_token,
                        'Content-Type' => 'application/json'
                    ],
                    'body' => json_encode([
                        'product_id' => $payPalProduct->id,
                        'name' => $payPalPlan,
                        'status' => 'ACTIVE',
                        'billing_cycles' => [
                            [
                                'frequency' => [
                                    'interval_unit' => strtoupper($plan->interval),
                                    'interval_count' => 1,
                                ],
                                'tenure_type' => 'REGULAR',
                                'sequence' => 1,
                                'total_cycles' => 0,
                                'pricing_scheme' => [
                                    'fixed_price' => [
                                        'value' => $payPalAmount,
                                        'currency_code' => $plan->currency,
                                    ],
                                ]
                            ]
                        ],
                        'payment_preferences' => [
                            'auto_bill_outstanding' => true,
                            'payment_failure_threshold' => 0,
                        ],
                    ])
                ]
            );

            $payPalPlan = json_decode($payPalPlanRequest->getBody()->getContents());
        } catch (BadResponseException $e) {
            dd($e->getResponse()->getBody()->getContents());
        }

        // Attempt to create the subscription
        try {
            $payPalSubscriptionRequest = $httpClient->request('POST', $httpBaseUrl . 'v1/billing/subscriptions', [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $payPalAuth->access_token,
                        'Content-Type' => 'application/json'
                    ],
                    'body' => json_encode([
                        'plan_id' => $payPalPlan->id,
                        'application_context' => [
                            'brand_name' => config('settings.site_name'),
                            'locale' => 'en-US',
                            'shipping_preference' => 'SET_PROVIDED_ADDRESS',
                            'user_action' => 'SUBSCRIBE_NOW',
                            'payment_method' => [
                                'payer_selected' => 'PAYPAL',
                                'payee_preferred' => 'IMMEDIATE_PAYMENT_REQUIRED',
                            ],
                            'return_url' => route('subscription.completed'),
                            'cancel_url' => route('subscription.cancelled')
                        ],
                        'custom_id' => http_build_query([
                            'user' => $request->user()->id,
                            'plan' => $plan->id,
                            'plan_amount' => $plan->price,
                            'amount' => $amount,
                            'currency' => $plan->currency,
                            'interval' => $plan->interval,
                            'coupon' => $coupon->id ?? null,
                            'taxes' => $taxRates->pluck('id')->implode('_'),
                        ])
                    ])
                ]
            );

            $payPalSubscription = json_decode($payPalSubscriptionRequest->getBody()->getContents());
        } catch (BadResponseException $e) {
            return back()->with('error', $e->getResponse()->getBody()->getContents());
        }

        return redirect($payPalSubscription->links[0]->href);
    }

    public function cancelSubscription(Request $request)
    {
        if($request->input('accept') == 'active') {
            $request->user()->planSubscriptionCancel();
        }

        return redirect()->route('subscription.billing')->with('success', __('Subscription canceled'));
    }
    public function completed()
    {
        return view('subscription.completed');
    }

    public function pending()
    {
        return view('subscription.pending');
    }

    public function cancelled()
    {
        return view('subscription.cancelled');
    }
}
