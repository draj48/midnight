<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\User;
use App\Models\Plan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $config = [
            'title' => __('Payments'),
            'nav' => 'finance',
            'route' => 'payment',
        ];

        // Filter
        $search = $request->input('q');
        $searchBy = in_array($request->input('search_by'), ['title']) ? $request->input('search_by') : 'title';
        $sort = in_array($request->sorting, ['asc', 'desc']) ? $request->sorting : 'desc';
        $perPage = config('attr.page_limit');

        // Query
        $listings = Payment::when($search, function ($query) use ($search) {
            return $query->searchUrl($search);
        })->orderBy('id', 'ASC')->paginate($perPage)->appends(['q' => $search, 'sort' => $sort]);

        return view('admin.payment.index', compact('config', 'listings'));
    }

    public function edit($id)
    {
        $config = [
            'title' => __('Payment'),
            'nav' => 'finance',
        ];


        $listing    = Payment::where('id', $id)->firstOrFail() ?? abort(404);

        return view('admin.payment.form', compact('config', 'listing'));
    }

    public function update(Request $request,$id)
    {
        $payment                = Payment::findOrFail($id);
        $payment->status        = $request->input('status');
        $payment->save();

        $user   = User::findOrFail($payment->user_id);
        $plan   = Plan::where('id',$payment->plan_id)->first();

        if($request->status == 'completed') {

            $user->plan_id             = $payment->plan_id;
            $user->plan_amount         = $payment->amount;
            $user->plan_interval       = $payment->interval;
            $user->plan_currency       = $payment->currency;
            $user->plan_payment_method = $payment->payment_method;
            $user->plan_created_at     = Carbon::now();
            if($payment->interval == 'year') {
                $user->plan_recurring_at        = Carbon::now()->addYear();
            } elseif($payment->interval == 'month') {
                $user->plan_recurring_at        = Carbon::now()->addMonth();
            }

            $user->save();
        }


        return redirect()->route('admin.payment.edit',$payment->id)->with('success', __(':title updated', ['title' => __('User')]));
    }
}
