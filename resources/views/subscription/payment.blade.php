@extends('layouts.app')
@section('content')
    <div class="pb-6 pt-5 lg:pb-16">
        <div class="max-w-lg w-full mx-auto" x-data="{annual: false,selectedOption: 'TR'}">
            <form method="post" x-ref="paymentForm">
                @csrf
                <div class="grid grid-cols-1 gap-4">
                    @foreach(config('attr.payments') as $key => $value)
                        @if(config('settings.'.$key) == 'active')
                            <!-- Card 1 -->
                            <label class="relative block cursor-pointer text-left w-full">
                                <input type="radio" name="payment_method" value="{{$key}}"
                                       class="peer sr-only"
                                       @if(request()->input('payment_method') == $key && old('payment_method') == null || old('payment_method') == $key || $loop->first && old('payment_method') == null)
                                           checked @endif>
                                <div
                                    class="p-4 flex items-center space-x-6 rounded-lg border border-gray-200 dark:border-gray-800 dark:bg-gray-800 hover:border-gray-300 shadow-sm">
                                    <img src="{{Vite::asset('resources/img/payment/'.$key.'.svg')}}"
                                         class="h-7 rounded" alt="Payment">
                                    <div class="">
                                        <div
                                            class="text-xs text-gray-400 dark:text-gray-400 truncate">{{__('Payment method')}}</div>
                                        <div
                                            class="text-sm font-medium text-gray-700 dark:text-white truncate">{{$value['name']}}</div>
                                    </div>
                                </div>
                                <div class="absolute inset-0 border-2 border-transparent peer-checked:border-primary-500 rounded-lg pointer-events-none"></div>
                            </label>
                        @endif
                    @endforeach
                </div>
                <div class="my-6">
                    <h3 class="block text-xl font-medium text-gray-700 mb-5 dark:text-gray-100 dark:font-medium">{{__('Billing information')}}</h3>
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-x-10">
                        <div class="mb-4 lg:col-span-12">

                            <x-form.label for="address" :value="__('Address')"/>
                            <x-form.input id="address" name="address" type="text" class="mt-1 block w-full"
                                          :value="old('address') ?? (Auth::user()->billing->address ?? null)"
                                          placeholder="{{__('Address')}}"/>
                            <x-form.error class="mt-2" :messages="$errors->get('address')"/>
                        </div>
                        <div class="mb-4 lg:col-span-6">

                            <x-form.label for="city" :value="__('City')"/>
                            <x-form.input id="city" name="city" type="text" class="mt-1 block w-full"
                                          :value="old('city') ?? (Auth::user()->billing->city ?? null)"
                                          placeholder="{{__('City')}}"/>
                            <x-form.error class="mt-2" :messages="$errors->get('city')"/>
                        </div>
                        <div class="mb-4 lg:col-span-6">

                            <x-form.label for="zip_code" :value="__('Postal code')"/>
                            <x-form.input id="zip_code" name="zip_code" type="text" class="mt-1 block w-full"
                                          :value="old('zip_code') ?? (Auth::user()->billing->zip_code ?? null)"
                                          placeholder="{{__('Postal code')}}"/>
                            <x-form.error class="mt-2" :messages="$errors->get('zip_code')"/>
                        </div>
                        <div class="mb-4 lg:col-span-12">

                            <x-form.label for="country" :value="__('Country')"/>
                            <x-form.select name="country" x-on:change="$refs.paymentForm.submit()">
                                @foreach(config('countries') as $key => $value)
                                    <option value="{{ $key }}"
                                            @if ((old('country') !== null && $key == old('country')) || (isset(Auth::user()->billing->country) && $key == Auth::user()->billing->country) && old('country') == null) selected @endif>{{ $value }}</option>
                                @endforeach
                            </x-form.select>
                            <x-form.error class="mt-2" :messages="$errors->get('country')"/>
                        </div>
                    </div>
                </div>

                @if($plan->coupons && !$coupon)
                    <div x-data="{ coupon: false }">
                        <div class="text-sm text-gray-500 hover:underline dark:text-gray-300 mb-4 cursor-pointer"
                             @click="coupon = ! coupon">{{__('Have a coupon code ?')}}</div>
                        <div class="mb-4" x-show="coupon">
                            <x-form.label for="coupon" :value="__('Coupon code')"/>
                            <div class="relative">
                                <x-form.input id="coupon" name="coupon" type="text" class="block w-full"
                                              :value="old('coupon')"
                                              placeholder="{{__('Coupon code')}}" x-on:keypress="coupon == true"
                                              x-bind:disabled="!coupon"/>
                                <button
                                    class="text-sm text-primary-500 py-3 px-5 font-medium absolute right-0 top-1/2 -translate-y-1/2">
                                    Apply
                                </button>
                            </div>
                            <x-form.error class="mt-2" :messages="$errors->get('coupon')"/>
                        </div>
                    </div>
                @endif

                <div class="my-6 space-y-3 text-gray-600 dark:text-gray-300">
                    <div class="flex items-center py-1 text-sm">
                        <div>{{__('Subtotal')}}</div>
                        <div
                            class="ml-auto">{{money_format($plan->price,$plan->currency).' '.$plan->currency}}</div>
                    </div>

                    @if($coupon)
                        <div class="flex items-center py-1 text-sm text-green-500">
                            <div>{{__('Discount')}} ({{ $coupon->percentage }}%)</div>
                            <div
                                class="ml-auto">
                                -{{ money_format(calculateDiscount($request->input('interval') == 'yearly' ? $plan->yearly_price : $plan->monthly_price, $coupon->percentage), $plan->currency).' '.$plan->currency }}</div>
                            <input type="hidden" name="coupon" value="{{ $coupon->code }}">
                            <input type="hidden" name="coupon_set" value="true">
                        </div>
                    @endif
                    @foreach($taxes as $tax)
                        <div class="flex items-center py-1 text-sm">
                            <div>{{ $tax->name }} ({{ $tax->percentage }}
                                % {{ $tax->type ? __('excl.') : __('incl.') }})
                            </div>
                            @if($tax->type)
                                <div
                                    class="ml-auto">{{ money_format(checkoutExclusiveTax($plan->price, $coupon->percentage ?? null, $tax->percentage, $inclTaxRatesPercentage), $plan->currency).' '.$plan->currency }}</div>
                            @else
                                <div
                                    class="ml-auto">{{ money_format(calculateInclusiveTax($plan->price, $coupon->percentage ?? null, $tax->percentage, $inclTaxRatesPercentage), $plan->currency).' '.$plan->currency }}</div>
                            @endif
                        </div>
                    @endforeach
                    <div class="flex items-center py-0.75 text-base font-medium">
                        <div>{{__('Total')}}</div>
                        <div
                            class="ml-auto">{{ money_format(checkoutTotal($plan->price, $coupon->percentage ?? null, $exclTaxRatesPercentage, $inclTaxRatesPercentage), $plan->currency) . ' '. $plan->currency }}</div>
                    </div>
                </div>
                <div class="mt-5">
                    <x-form.primary type="submit" name="payment"
                                    class="w-full lg:text-base">
                        {{__('Pay')}}
                        <span class="ml-2"
                              x-show="!annual">{{ money_format(checkoutTotal($plan->price, $coupon->percentage ?? null, $exclTaxRatesPercentage, $inclTaxRatesPercentage), $plan->currency) . ' '. $plan->currency }}</span>
                    </x-form.primary>
                </div>
            </form>
            <div class="mt-5 text-center text-gray-400 dark:text-gray-500 text-sm">
                {!! __('By continuing, you agree with the :terms', ['terms' => mb_strtolower('<a href="'.config('settings.terms_url').'" target="_blank" class="text-gray-500 font-medium hover:underline">'. __('Terms of service') .'</a>')]) !!}
            </div>
        </div>
    </div>
@endsection
