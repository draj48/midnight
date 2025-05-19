<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\BadResponseException;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'avatar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'plan_ends_at' => 'datetime',
        'plan_recurring_at' => 'datetime',
        'billing' => 'object',
    ];

    protected $dates = [
        'email_verified_at',
        'created_at',
        'plan_created_at',
        'plan_recurring_at',
        'plan_ends_at',
        'plan_trial_ends_at'
    ];

    public function getAvatarUrlAttribute()
    {
        return $this->avatar
            ? asset(config('attr.avatar.path') . $this->avatar)
            : null;
    }


    public function scopeSearchUrl(Builder $query, $value)
    {
        return $query->where('name', 'like', '%'.$value.'%')->orWhere('email', 'like', '%'.$value.'%');
    }
    public function likes(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Reaction::class);
    }

    public function getCoverUrlAttribute()
    {
        return $this->cover
            ? asset(config('attr.avatar.path') . $this->cover)
            : null;
    }

    public function plan()
    {
        // If the current plan is default, or the plan is not active
        return $this->belongsTo('App\Models\Plan');
    }
    public function reaction()
    {
        return $this->hasMany(Reaction::class);
    }

    public function like()
    {
        return $this->hasMany(Reaction::class)->where('reaction','like')->whereNotNull('user_id')->latest();
    }

    public function log()
    {
        return $this->hasMany(Log::class,'user_id')->whereNotNull('user_id')->latest();
    }
    public function watchlist()
    {
        return $this->hasMany(Watchlist::class,'user_id')->whereNotNull('user_id')->latest();
    }

    public function watchlister()
    {
        return $this->morphedByMany(Post::class, 'postable','watchlists')->whereNotNull('user_id');
    }

    public function planSubscriptionCancel()
    {
        if ($this->plan_payment_method == 'paypal') {
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
            } catch (BadResponseException $e) {}

            // Attempt to cancel the subscription
            try {
                $payPalSubscriptionCancelRequest = $httpClient->request('POST', $httpBaseUrl . 'v1/billing/subscriptions/' . $this->plan_subscription_id . '/cancel', [
                        'headers' => [
                            'Authorization' => 'Bearer ' . $payPalAuth->access_token,
                            'Content-Type' => 'application/json'
                        ],
                        'body' => json_encode([
                            'reason' => __('Cancelled')
                        ])
                    ]
                );
            } catch (BadResponseException $e) {}
        }  elseif ($this->plan_payment_method == 'stripe') {
            // Attempt to cancel the current subscription
            try {
                $stripe = new \Stripe\StripeClient(
                    config('settings.stripe_secret')
                );

                $stripe->subscriptions->update(
                    $this->plan_subscription_id,
                    ['cancel_at_period_end' => true]
                );
            } catch (\Exception $e) {}
        } elseif ($this->plan_payment_method == 'razorpay') {
            // Attempt to cancel the current subscription
            try {
                $razorpay = new \Razorpay\Api\Api(config('settings.razorpay_key'), config('settings.razorpay_secret'));

                $razorpay->subscription->fetch($this->plan_subscription_id)->cancel();
            } catch (\Exception $e) {}
        } elseif ($this->plan_payment_method == 'paystack') {
            $httpClient = new HttpClient();

            // Attempt to cancel the current subscription
            try {
                $paystackSubscriptionRequest = $httpClient->request('GET', 'https://api.paystack.co/subscription/' . $this->plan_subscription_id, [
                        'headers' => [
                            'Authorization' => 'Bearer ' . config('settings.paystack_secret'),
                            'Content-Type' => 'application/json',
                            'Cache-Control' => 'no-cache'
                        ]
                    ]
                );

                $paystackSubscription = json_decode($paystackSubscriptionRequest->getBody()->getContents());
            } catch (\Exception $e) {}

            if (isset($paystackSubscription->data->email_token)) {
                try {
                    $httpClient->request('POST', 'https://api.paystack.co/subscription/disable', [
                            'headers' => [
                                'Authorization' => 'Bearer ' . config('settings.paystack_secret'),
                                'Content-Type' => 'application/json',
                                'Cache-Control' => 'no-cache'
                            ],
                            'body' => json_encode([
                                'code' => $this->plan_subscription_id,
                                'token' => $paystackSubscription->data->email_token
                            ])
                        ]
                    );
                } catch (\Exception $e) {}
            }
        }

        // Update the subscription end date and recurring date
        if (!empty($this->plan_recurring_at)) {
            $this->plan_ends_at = $this->plan_recurring_at;
            $this->plan_recurring_at = null;
        }
        $this->save();
    }

}
