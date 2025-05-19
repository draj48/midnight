@extends('layouts.app')
@section('content')
    <div class="p-4 sm:p-10 text-center overflow-y-auto mx-auto my-5 lg:my-10 max-w-sm">
        <!-- Icon -->
        <span
            class="mb-4 inline-flex justify-center items-center w-20 h-20 rounded-full border-4 border-green-50 bg-green-100 text-green-500 dark:bg-green-700 dark:border-green-600 dark:text-green-100">
            <x-ui.icon name="finance" class="w-8 h-8" fill="currentColor" />
        </span>
        <!-- End Icon -->

        <h3 class="mb-2 text-xl font-semibold text-gray-800 dark:text-gray-200">
            {{__('Payment completed')}}
        </h3>
        <p class="text-gray-500">{{__('Payment completed successfully')}}</p>

    </div>
@endsection
