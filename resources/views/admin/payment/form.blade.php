@extends('layouts.admin')
@section('content')
    <div class="container">
        <div class="max-w-7xl mx-auto w-full">
            <!-- Grid -->
            <div class="grid md:grid-cols-2 gap-3">
                <div>
                    <div class="grid space-y-4">

                        <dl class="grid sm:flex gap-x-3 text-sm">
                            <dt class="min-w-[150px] max-w-[200px] text-gray-500">
                                {{__('Customer')}}
                            </dt>
                            <dd class="font-medium text-gray-800 dark:text-gray-200">
                                <span class="block text-base font-semibold mb-1">{{$listing->user->name}}</span>
                                <span class="block text-sm mb-3">{{$listing->user->email}}</span>
                                <address class="not-italic font-normal">
                                    {{$listing->user->billing->address}},<br>
                                    {{$listing->user->billing->city}}, {{$listing->user->billing->zip_code}}<br>
                                    {{$listing->user->billing->country}}<br>
                                </address>
                            </dd>
                        </dl>
                        <dl class="grid sm:flex gap-x-3 text-sm">
                            <dt class="min-w-[150px] max-w-[200px] text-gray-500">
                                {{__('Date')}}
                            </dt>
                            <dd class="font-medium text-gray-800 dark:text-gray-200">
                                {{$listing->created_at->translatedFormat('d M, Y')}}
                            </dd>
                        </dl>
                        <dl class="grid sm:flex gap-x-3 text-sm">
                            <dt class="min-w-[150px] max-w-[200px] text-gray-500">
                                {{__('Payment method')}}
                            </dt>
                            <dd class="font-medium text-gray-800 dark:text-gray-200 flex items-center space-x-4">

                                <img src="{{Vite::asset('resources/img/payment/'.$listing->payment_method.'.svg')}}"
                                     class="h-5 rounded" alt="Payment">
                                <span class="font-medium capitalize text-sm">{{$listing->payment_method}}</span>

                            </dd>
                        </dl>
                        <dl class="grid sm:flex gap-x-3 text-sm">
                            <dt class="min-w-[150px] max-w-[200px] text-gray-500">
                                {{__('Status')}}
                            </dt>
                            <dd class="text-gray-800 dark:text-gray-200">

                                @if($listing->status == 'completed')
                                    <div
                                        class="inline-flex items-center gap-1.5 py-0.5 px-2 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                        <svg class="w-2.5 h-2.5" xmlns="http://www.w3.org/2000/svg"
                                             width="16"
                                             height="16" fill="currentColor" viewBox="0 0 16 16">
                                            <path
                                                d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                                        </svg>
                                        {{__('Completed')}}
                                    </div>
                                @elseif($listing->status == 'cancelled')
                                    <div
                                        class="inline-flex items-center gap-1.5 py-0.5 px-2 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                        <svg class="w-2.5 h-2.5" xmlns="http://www.w3.org/2000/svg"
                                             width="16"
                                             height="16" fill="currentColor" viewBox="0 0 16 16">
                                            <path
                                                d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                                        </svg>
                                        {{__('Cancelled')}}
                                    </div>
                                @else
                                    <div
                                        class="inline-flex items-center gap-1.5 py-0.5 px-2 rounded-full text-xs font-medium bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200">
                                        <svg class="w-2.5 h-2.5" xmlns="http://www.w3.org/2000/svg"
                                             width="16"
                                             height="16" fill="currentColor" viewBox="0 0 16 16">
                                            <path
                                                d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                                        </svg>
                                        {{__('Pending')}}
                                    </div>
                                @endif
                            </dd>
                        </dl>
                    </div>
                    @if($listing->status == 'pending')
                        <hr class="my-6 lg:my-10 border-gray-100 dark:border-gray-800">
                        <form method="post">
                            @csrf
                            <div class="mb-5">
                                <x-form.label for="status" :value="__('Status')"/>
                                <x-form.select name="status" required>
                                    <option
                                        value="completed" @if(isset($listing->status) AND $listing->status == 'completed')
                                        {{'selected'}}
                                        @endif>{{__('Completed')}}</option>
                                    <option
                                        value="pending" @if(isset($listing->status) AND $listing->status == 'pending')
                                        {{'selected'}}
                                        @endif>{{__('Pending')}}</option>
                                    <option
                                        value="cancelled" @if(isset($listing->status) AND $listing->status == 'cancelled')
                                        {{'selected'}}
                                        @endif>{{__('Cancelled')}}</option>
                                </x-form.select>
                                <x-form.error :messages="$errors->get('status')" class="mt-2"/>
                            </div>
                            <x-form.primary class="w-full">{{__('Save change')}}</x-form.primary>
                        </form>
                    @endif
                </div>
                <!-- Col -->

                <div>
                    <div class="grid space-y-4">
                        <dl class="grid sm:flex gap-x-3 text-sm">
                            <dt class="min-w-[150px] max-w-[200px] text-gray-500">
                                {{__('Payment ID')}}
                            </dt>
                            <dd class="text-gray-800 dark:text-gray-200">
                                <div class="inline-flex items-center gap-x-1.5 text-blue-600 decoration-2 font-medium">
                                    {{$listing->payment_id}}
                                </div>
                            </dd>
                        </dl>
                        <dl class="grid sm:flex gap-x-3 text-sm">
                            <dt class="min-w-[150px] max-w-[200px] text-gray-500">
                                {{__('Interval')}}
                            </dt>
                            <dd class="font-medium capitalize text-gray-800 dark:text-gray-200">
                                {{$listing->interval}}
                            </dd>
                        </dl>
                        <dl class="grid sm:flex gap-x-3 text-sm">
                            <dt class="min-w-[150px] max-w-[200px] text-gray-500">
                                {{__('Currency')}}
                            </dt>
                            <dd class="font-medium text-gray-800 dark:text-gray-200">
                                {{$listing->currency}}
                            </dd>
                        </dl>
                        <dl class="grid sm:flex gap-x-3 text-sm">
                            <dt class="min-w-[150px] max-w-[200px] text-gray-500">
                                {{__('Price')}}
                            </dt>
                            <dd class="font-medium capitalize text-gray-800 dark:text-gray-200">
                                {{money_format($listing->amount,$listing->currency)}}
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
