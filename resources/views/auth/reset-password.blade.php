@extends('layouts.auth')
@section('content')
    <div class="max-w-lg mx-auto w-full px-4 py-8">
        <div class="text-center">
            <h1 class="block text-3xl font-semibold text-gray-800 dark:text-white">{{__('Reset Password')}}</h1>
        </div>
        <div class="mt-10">
            <form method="POST" action="{{ route('password.store') }}">
                @csrf

                <!-- Password Reset Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email Address -->
                <div>
                    <x-form.label for="email" :value="__('Email')"/>
                    <x-form.input id="email" class="block mt-1 w-full" type="email" name="email"
                                  :value="old('email', $request->email)" required autocomplete="username"/>
                    <x-form.error :messages="$errors->get('email')" class="mt-2"/>
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-form.label for="password" :value="__('Password')"/>
                    <x-form.input id="password" class="block mt-1 w-full" type="password" name="password" placeholder="{{__('Password')}}" required
                                  autocomplete="new-password"/>
                    <x-form.error :messages="$errors->get('password')" class="mt-2"/>
                </div>

                <!-- Confirm Password -->
                <div class="mt-4">
                    <x-form.label for="password_confirmation" :value="__('Confirm Password')"/>

                    <x-form.input id="password_confirmation" class="block mt-1 w-full"
                                  type="password"
                                  name="password_confirmation" placeholder="{{__('Confirm Password')}}" required autocomplete="new-password"/>

                    <x-form.error :messages="$errors->get('password_confirmation')" class="mt-2"/>
                </div>

                <div class="flex items-center justify-end mt-4">
                    <x-form.primary class="w-full">
                        {{ __('Reset Password') }}
                    </x-form.primary>
                </div>
            </form>
        </div>
    </div>
@endsection
