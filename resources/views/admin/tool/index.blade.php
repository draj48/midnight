@extends('layouts.admin')
@section('content')
    <div class="max-w-6xl mx-auto w-full">
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-10">
            <!-- Card -->
            <div
                class="group flex flex-col h-full bg-white border border-gray-200 shadow-sm rounded-xl dark:bg-gray-900 dark:border-gray-800 dark:shadow-0">
                <div class="h-52 flex flex-col justify-center items-center bg-[#01b4e4] text-[#01b4e4] rounded-t-xl">
                </div>
                <div class="p-4 md:p-6">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-300 dark:hover:text-white">
                        Themoviedb
                    </h3>
                    <p class="mt-3 text-sm text-gray-500">
                        A software that develops products for software developers and developments.
                    </p>
                </div>
                <div
                    class="mt-auto flex border-t border-gray-200 divide-x divide-gray-200 dark:border-gray-700 dark:divide-gray-700">
                    <a class="w-full py-3 px-4 inline-flex justify-center items-center gap-2 rounded-bl-xl font-medium bg-white text-gray-700 shadow-sm align-middle hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-primary-500 transition-all text-sm sm:p-4 dark:bg-gray-900 dark:hover:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:text-white dark:focus:ring-offset-gray-800"
                       href="{{route('admin.tmdb.settings')}}">
                        {{__('Config')}}
                    </a>
                    <a class="w-full py-3 px-4 inline-flex justify-center items-center gap-2 rounded-br-xl font-medium bg-white text-gray-700 shadow-sm align-middle hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-primary-500 transition-all text-sm sm:p-4 dark:bg-gray-900 dark:hover:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:text-white dark:focus:ring-offset-gray-800"
                       href="{{route('admin.tmdb.show')}}">
                        {{__('View tool')}}
                    </a>
                </div>
            </div>
            <!-- End Card -->
            <!-- Card -->
            <div
                class="group flex flex-col h-full bg-white border border-gray-200 shadow-sm rounded-xl dark:bg-gray-900 dark:border-gray-800 dark:shadow-0">
                <div class="h-52 flex flex-col justify-center items-center bg-[#e54b4d] text-[#e54b4d] rounded-t-xl">
                </div>
                <div class="p-4 md:p-6">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-300 dark:hover:text-white">
                        One Signal
                    </h3>
                    <p class="mt-3 text-sm text-gray-500">
                        A software that develops products for software developers and developments.
                    </p>
                </div>
                <div
                    class="mt-auto flex border-t border-gray-200 divide-x divide-gray-200 dark:border-gray-700 dark:divide-gray-700">
                    <a class="w-full py-3 px-4 inline-flex justify-center items-center gap-2 rounded-bl-xl font-medium bg-white text-gray-700 shadow-sm align-middle hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-primary-500 transition-all text-sm sm:p-4 dark:bg-gray-900 dark:hover:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:text-white dark:focus:ring-offset-gray-800"
                       href="{{route('admin.onesignal.settings')}}">
                        {{__('Config')}}
                    </a>
                    <a class="w-full py-3 px-4 inline-flex justify-center items-center gap-2 rounded-br-xl font-medium bg-white text-gray-700 shadow-sm align-middle hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-primary-500 transition-all text-sm sm:p-4 dark:bg-gray-900 dark:hover:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:text-white dark:focus:ring-offset-gray-800"
                       href="{{route('admin.onesignal.show')}}">
                        {{__('View tool')}}
                    </a>
                </div>
            </div>
            <!-- End Card -->

        </div>
        <!-- End Grid -->
    </div>
@endsection
