@extends('layouts.install')
@section('content')

    <div class="p-4 sm:p-10 text-center overflow-y-auto mx-auto my-5 lg:my-10 max-w-lg">
        <div class="text-center">
            <h3 class="mb-2 text-xl font-semibold text-gray-800 dark:text-gray-200">
                {{__('Install completed')}}
            </h3>
            <p class="text-gray-500">{{__('Install completed successfully')}}</p>
        </div>
        <div class="grid grid-cols-2 my-10">

            <div class="mb-3">
                <div class="text-gray-300 text-sm mb-1">Email</div>
                <div class="text-gray-100 font-medium text-base">admin@admin.com</div>
            </div>
            <div class="mb-3">
                <div class="text-gray-300 text-sm mb-1">Password</div>
                <div class="text-gray-100 font-medium text-base">admin</div>
            </div>
        </div>

        <a href="{{ route('index') }}" class="py-4 px-6 rounded-full bg-primary-500 flex justify-center align-center font-medium text-white w-full">
            Go to Website
        </a>
    </div>
@endsection
