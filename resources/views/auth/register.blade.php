@extends('layouts.auth')
@section('content')
    <div class="max-w-lg mx-auto w-full px-4 py-8">
        <div class="text-center">
            <h1 class="block text-2xl lg:text-3xl font-semibold text-gray-800 dark:text-white">{{__('Create an Account')}}</h1>
        </div>
        <div class="mt-8">
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <!-- Name -->
                <div class="mb-5">
                    <x-form.label for="name" :value="__('Name')"/>
                    <x-form.input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')"
                                  required autofocus autocomplete="name" placeholder="{{__('Name')}}"/>
                    <x-form.error :messages="$errors->get('name')" class="mt-2"/>
                </div>

                <div class="mb-5">
                    <x-form.label for="username" :value="__('Username')"/>
                    <x-form.input id="username" class="block mt-1 w-full" type="text" name="username" :value="old('username')"
                                  required placeholder="{{__('Username')}}"/>
                    <x-form.error :messages="$errors->get('username')" class="mt-2"/>
                </div>
                <!-- Email Address -->
                <div class="mb-5">
                    <x-form.label for="email" :value="__('Email')"/>
                    <x-form.input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                                  required autocomplete="username" placeholder="{{__('Email')}}"/>
                    <x-form.error :messages="$errors->get('email')" class="mt-2"/>
                </div>

                <!-- Password -->
                <div class="mb-5">
                    <x-form.label for="password" :value="__('Password')"/>

                    <x-form.input id="password" class="block mt-1 w-full"
                                  type="password"
                                  name="password"
                                  required autocomplete="new-password" placeholder="{{__('Password')}}"/>

                    <x-form.error :messages="$errors->get('password')" class="mt-2"/>
                </div>


                <div class="mb-5">

                    <x-form.primary class="w-full">
                        {{ __('Sign up') }}
                    </x-form.primary>

                </div>


            </form>
            <div class="text-sm text-gray-400 dark:text-gray-500 mt-8 text-center">
                <span>{{__("Already have an account?")}}</span>
                <a href="{{route('login')}}" class="hover:underline font-medium text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 dark:focus:ring-offset-gray-800">{{__('Sign in')}}</a></div>

            @if(config('settings.register') != 'disable' AND env('GOOGLE_CLIENT_ID'))
            <div class="my-4 space-y-3">
                <x-form.secondary href="{{route('auth.google')}}" class="w-full gap-x-3">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" version="1.1"
                         xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512"
                         style="enable-background:new 0 0 512 512" xml:space="preserve"><g>
                            <path d="M113.47 309.408 95.648 375.94l-65.139 1.378C11.042 341.211 0 299.9 0 256c0-42.451 10.324-82.483 28.624-117.732h.014L86.63 148.9l25.404 57.644c-5.317 15.501-8.215 32.141-8.215 49.456.002 18.792 3.406 36.797 9.651 53.408z"
                                  style="" fill="#fbbb00" data-original="#fbbb00"></path>
                            <path d="M507.527 208.176C510.467 223.662 512 239.655 512 256c0 18.328-1.927 36.206-5.598 53.451-12.462 58.683-45.025 109.925-90.134 146.187l-.014-.014-73.044-3.727-10.338-64.535c29.932-17.554 53.324-45.025 65.646-77.911h-136.89V208.176h245.899z"
                                  style="" fill="#518ef8" data-original="#518ef8" class=""></path>
                            <path d="m416.253 455.624.014.014C372.396 490.901 316.666 512 256 512c-97.491 0-182.252-54.491-225.491-134.681l82.961-67.91c21.619 57.698 77.278 98.771 142.53 98.771 28.047 0 54.323-7.582 76.87-20.818l83.383 68.262z"
                                  style="" fill="#28b446" data-original="#28b446"></path>
                            <path d="m419.404 58.936-82.933 67.896C313.136 112.246 285.552 103.82 256 103.82c-66.729 0-123.429 42.957-143.965 102.724l-83.397-68.276h-.014C71.23 56.123 157.06 0 256 0c62.115 0 119.068 22.126 163.404 58.936z"
                                  style="" fill="#f14336" data-original="#f14336" class=""></path>
                        </g></svg>
                    <span>{{ __('Google with Sign up') }}</span>
                </x-form.secondary>
            </div>
            @endif
        </div>
    </div>
@endsection
