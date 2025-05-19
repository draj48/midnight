@extends('layouts.auth')
@section('content')
    <div class="max-w-lg mx-auto w-full px-4 py-8">
        <div class="text-center">
            <h1 class="block text-3xl font-semibold text-gray-800 dark:text-white">{{__('Forgot Password')}}</h1>
        </div>
        <div class="mt-10">

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-form.label for="email" :value="__('Email')"/>
                    <x-form.input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                                  required autofocus autocomplete="username" placeholder="{{__('Email')}}"/>
                    <x-form.error :messages="$errors->get('email')" class="mt-2"/>
                </div>

                <div class="flex items-center justify-end mt-4">
                    <x-form.primary class="w-full">
                        {{ __('Email Password Reset Link') }}
                    </x-form.primary>
                </div>
            </form>
        </div>
    </div>
@endsection
