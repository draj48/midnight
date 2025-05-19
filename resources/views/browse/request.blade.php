@extends('layouts.app')
@section('content')
    <div class="container text-white">
        @if(config('settings.request_status') == 'active')
            @if(config('settings.request_member') == 'active' AND auth()->check())
                @include('browse.partials.request')
            @elseif(config('settings.request_member') != 'active')
                @include('browse.partials.request')
            @else
                <div class="relative overflow-hidden">
                    <div
                        class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-24 before:absolute before:-top-14 before:start-1/2 before:bg-[url('../img/hero.svg')] before:opacity-40 before:bg-no-repeat before:bg-top before:w-full before:h-full before:-z-[1] before:transform before:-translate-x-1/2 relative">
                        <div class="text-center">
                            <h1 class="text-4xl font-semibold text-gray-800 dark:text-gray-200">
                                {{__('Request is for members only')}}
                            </h1>
                            <p class="mt-3 text-gray-600 dark:text-gray-400">
                                {{__('Request the movies and series you want to see or watch here, and we\'ll add them quickly')}}
                            </p>
                        </div>
                    </div>
                </div>
            @endif
        @else
            <div class="relative overflow-hidden">
                <div
                    class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-24 before:absolute before:-top-14 before:start-1/2 before:bg-[url('../img/hero.svg')] before:opacity-40 before:bg-no-repeat before:bg-top before:w-full before:h-full before:-z-[1] before:transform before:-translate-x-1/2 relative">
                    <div class="text-center">
                        <h1 class="text-4xl font-semibold text-gray-800 dark:text-gray-200">
                            {{__('Request closed')}}
                        </h1>
                    </div>
                </div>
            </div>
        @endif()
    </div>
@endsection
