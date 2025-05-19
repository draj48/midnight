@extends('layouts.app')
@section('content')

    <div class="pb-6 pt-5 lg:pb-16">
        <div class="container">
            @if(auth()->user()->plan_interval != 'prepaid' AND auth()->user()->plan_recurring_at < now())
                <div class="bg-red-500 text-white py-4 px-7 my-6 rounded-xl flex items-center gap-x-6">
                    <x-ui.icon name="info" class="w-8 h-8" fill="currentColor"/>
                    <div class="flex-1">
                        <h3 class="text-base font-medium">{{__('You do not have a subscription yet')}}</h3>
                        <p class="text-white/70 text-sm">{{__('Choose the plan that suits you and get started')}}</p>
                    </div>
                </div>
            @endif
            <div class="lg:flex gap-6 lg:gap-10">
                <div class="flex-1">
                    <h3 class="text-xl font-medium text-gray-700 dark:text-white mb-3">{{__('Payment history')}}</h3>
                    @foreach($listings as $listing)
                        <div class="grid grid-cols-12 items-center gap-6 py-2">
                            <div class="col-span-5">
                                <div
                                    class="text-gray-500 dark:text-gray-400 text-sm font-medium">{{$listing->payment_id}}</div>
                            </div>
                            <div class="col-span-2">

                                <div
                                    class="text-primary-500 font-medium capitalize text-xs">{{$listing->payment_method}}</div>
                            </div>
                            <div class="col-span-2">
                                @if($listing->status == 'completed')
                                    <div
                                        class="inline-flex items-center gap-1.5 py-0.5 px-2 rounded-full text-xxs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
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
                                        class="inline-flex items-center gap-1.5 py-0.5 px-2 rounded-full text-xxs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
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
                                        class="inline-flex items-center gap-1.5 py-0.5 px-2 rounded-full text-xxs font-medium bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200">
                                        <svg class="w-2.5 h-2.5" xmlns="http://www.w3.org/2000/svg"
                                             width="16"
                                             height="16" fill="currentColor" viewBox="0 0 16 16">
                                            <path
                                                d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                                        </svg>
                                        {{__('Pending')}}
                                    </div>
                                @endif
                            </div>
                            <div class="col-span-3">
                                <div
                                    class="text-gray-500 dark:text-gray-400 text-xs">{{$listing->created_at->translatedFormat('d M, Y')}}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
                @if(Auth::user()->plan_recurring_at)
                    <div class="max-w-sm w-full">
                        <div
                            class="bg-white border border-gray-200 dark:border-gray-900 shadow-sm dark:bg-gray-900 p-6 lg:p-8 rounded-xl mb-4">
                            <h3 class=" font-medium text-gray-700 dark:text-gray-200 mb-4">{{__('Your subscription')}}</h3>
                            <h4 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-1">{{Auth::user()->plan->name}}</h4>
                            <div class="text-sm text-gray-400 mt-1">{{Auth::user()->plan->description}}</div>
                            <div class="mt-4">
                    <span
                        class="text-3xl font-semibold text-gray-800 dark:text-gray-200">{{Auth::user()->plan->price}}</span>
                                <span
                                    class="ml-2 text-gray-500">{{Auth::user()->plan->currency}} / {{__(Auth::user()->plan_interval)}}</span>
                            </div>
                            @if(Auth::user()->plan_recurring_at)
                                <div class="text-sm text-gray-500 dark:text-gray-500 mt-4">
                                    <span>{{__('Subscription end').' : '}}</span>
                                    <span
                                        class="text-gray-600 dark:text-gray-200">{{__(Auth::user()->plan_recurring_at->translatedFormat('d M, Y'))}}</span>
                                </div>
                                <div x-data="{ expanded: false }">
                                    <x-form.secondary class="w-full mt-4"
                                                      @click="expanded = ! expanded">{{__('Cancel subscription')}}
                                    </x-form.secondary>
                                    <div class="mt-5" x-show="expanded" x-collapse>
                                        <form method="post">
                                            @csrf

                                            <div class="flex items-center space-x-4 mt-2">
                                                <x-form.switch type="checkbox" id="accept" name="accept"
                                                               value="active"/>
                                                <x-form.label for="accept" class="md:mb-0 cursor-pointer font-normal"
                                                              :value="__('Yes I want to cancel my subscription')"/>
                                            </div>
                                            <x-form.primary class="w-full mt-4"
                                                            @click="expanded = ! expanded">{{__('Cancel subscription')}}</x-form.primary>
                                        </form>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
