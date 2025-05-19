@extends('layouts.app')
@section('content')

    <div class="p-4 sm:p-10 text-center overflow-y-auto mx-auto my-5 lg:my-10 max-w-2xl">
        <!-- Icon -->
        <span
            class="mb-4 inline-flex justify-center items-center w-20 h-20 rounded-full border-4 border-amber-50 bg-amber-100 text-amber-500 dark:bg-amber-700 dark:border-amber-600 dark:text-amber-100">
          <x-ui.icon name="finance" class="w-8 h-8" fill="currentColor" />
        </span>
        <!-- End Icon -->

        <h3 class="mb-2 text-xl font-semibold text-gray-800 dark:text-gray-200">
            {{__('Payment pending')}}
        </h3>
        <p class="text-gray-500">{{__('Payment is currently awaiting approval')}}</p>
        @if(config('settings.bank_detail'))
        <div class="text-lg text-gray-800 dark:text-gray-200 space-y-5 mt-6 leading-10 px-5">{!! config('settings.bank_detail') !!}</div>
        @endif
    </div>
@endsection
