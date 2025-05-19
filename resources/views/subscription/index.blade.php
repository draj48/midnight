@extends('layouts.app')
@section('content')
    <div class="pb-6 pt-6 lg:pt-8 lg:pb-16">
        <div class="container relative">
            <div class="my-6 lg:my-10" x-data="{annual: false}">
                <div class="mt-5 grid sm:grid-cols-2 lg:grid-cols-4 gap-6 lg:items-center">
                    @foreach($plans as $plan)
                        <!-- Card -->
                        <div
                            class="flex flex-col p-8 relative z-10 bg-white rounded-xl md:p-10 dark:bg-gray-900 shadow-sm">
                            <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200">{{$plan->name}}</h3>
                            <div class="text-sm text-gray-400 mt-1">{{$plan->description}}</div>

                            <div class="mt-5">
                            <span
                                class="text-4xl font-semibold text-gray-800 dark:text-gray-200">{{$plan->price}}</span>
                                <span class="ml-2 text-gray-500">{{$plan->currency}} / {{__($plan->interval)}}</span>
                            </div>

                            <div class="mt-5 w-full" x-cloak x-show="!annual">
                                @if(Auth::user()->plan_id == $plan->id)
                                    <x-form.primary disabled="true"
                                                    class="w-full">{{__('Current plan')}}</x-form.primary>
                                @else
                                    <x-form.primary
                                        href="{!! route('subscription.payment',['id' => $plan->id]) !!}"
                                        class="w-full">{{__('Subscribe')}}</x-form.primary>
                                @endif
                            </div>
                            <div class="mt-5 w-full" x-cloak x-show="annual">
                                @if(Auth::user()->plan_id == $plan->id)
                                    <x-form.primary disabled="true"
                                                    class="w-full">{{__('Current plan')}}</x-form.primary>
                                @else
                                    <x-form.primary
                                        href="{!! route('subscription.payment',['id' => $plan->id]) !!}"
                                        class="w-full">{{__('Subscribe')}}</x-form.primary>
                                @endif
                            </div>
                        </div>
                        <!-- End Card -->
                    @endforeach

                </div>
            </div>
            <!-- SVG Element -->
            <div class="hidden md:block absolute top-0 -right-5 translate-y-16 translate-x-16">
                <svg class="w-16 h-auto text-primary-500 opacity-50" width="121" height="135" viewBox="0 0 121 135" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M5 16.4754C11.7688 27.4499 21.2452 57.3224 5 89.0164" stroke="currentColor" stroke-width="10" stroke-linecap="round"/>
                    <path d="M33.6761 112.104C44.6984 98.1239 74.2618 57.6776 83.4821 5" stroke="currentColor" stroke-width="10" stroke-linecap="round"/>
                    <path d="M50.5525 130C68.2064 127.495 110.731 117.541 116 78.0874" stroke="currentColor" stroke-width="10" stroke-linecap="round"/>
                </svg>
            </div>
            <!-- End SVG Element -->

            <!-- SVG Element -->
            <div class="hidden md:block absolute bottom-0 left-0 translate-y-16 -translate-x-16">
                <svg class="w-56 h-auto text-primary-500 opacity-30" width="347" height="188" viewBox="0 0 347 188" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4 82.4591C54.7956 92.8751 30.9771 162.782 68.2065 181.385C112.642 203.59 127.943 78.57 122.161 25.5053C120.504 2.2376 93.4028 -8.11128 89.7468 25.5053C85.8633 61.2125 130.186 199.678 180.982 146.248L214.898 107.02C224.322 95.4118 242.9 79.2851 258.6 107.02C274.299 134.754 299.315 125.589 309.861 117.539L343 93.4426" stroke="currentColor" stroke-width="7" stroke-linecap="round"/>
                </svg>
            </div>
            <!-- End SVG Element -->
        </div>
    </div>
@endsection
