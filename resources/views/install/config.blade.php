@extends('layouts.install')
@section('content')
    <div class="max-w-xl mx-auto w-full py-10">
        <div class="mb-6">
            <a class="inline-block" href="{{route('index')}}">
                <x-ui.logo height="38" class="text-gray-700 dark:text-white"/>
            </a>
        </div>
        <div class="mb-8">

            <h3 class="text-2xl mb-1 font-medium text-white">Database Configuration</h3>
        </div>
        @if (session()->has('error'))
            <div class="text-red-500 py-3">
                {{ request()->session()->get('error') }}
            </div>
        @endif
        <form method="POST" action="{{ route('install.store') }}" class="form-horizontal">
            @csrf
            <div class="mb-6">
                <x-form.label for="license_key" :value="__('License Key')"/>
                <x-form.input id="license_key" class="block mt-1 w-full" type="text" name="license_key"
                              value="{{ old('license_key')}}"
                              placeholder="{{__('License Key')}}"/>
                <x-form.error :messages="$errors->get('license_key')" class="mt-2"/>
                <div class="text-xs text-gray-500 py-3">Valid for codelug.com registered user. You can only write codester for codester user</div>
            </div>

            <div class="mb-6">
                <x-form.label for="host" :value="__('Database Host')"/>
                <x-form.input id="host" class="block mt-1 w-full" type="text" name="host"
                              value="{{ old('host')}}"
                              required placeholder="{{__('Host')}}"/>
                <x-form.error :messages="$errors->get('host')" class="mt-2"/>
            </div>

            <div class="mb-6">
                <x-form.label for="port" :value="__('Database Port')"/>
                <x-form.input id="port" class="block mt-1 w-full" type="text" name="port"
                              value="{{ old('port') }}"
                              placeholder="{{__('Port')}}"/>
                <x-form.error :messages="$errors->get('port')" class="mt-2"/>
            </div>
            <div class="mb-6">
                <x-form.label for="name" :value="__('Database Name')"/>
                <x-form.input id="name" class="block mt-1 w-full" type="text" name="name"
                              value="{{ old('name')}}"
                              required placeholder="{{__('Name')}}"/>
                <x-form.error :messages="$errors->get('name')" class="mt-2"/>
            </div>
            <div class="mb-6">
                <x-form.label for="username" :value="__('Database Username')"/>
                <x-form.input id="username" class="block mt-1 w-full" type="text" name="username"
                              value="{{ old('username')}}"
                              required placeholder="{{__('Username')}}"/>
                <x-form.error :messages="$errors->get('username')" class="mt-2"/>
            </div>
            <div class="mb-6">
                <x-form.label for="password" :value="__('Database Password')"/>
                <x-form.input id="password" class="block mt-1 w-full" type="text" name="password"
                              value="{{ old('password') }}"
                              placeholder="{{__('Password')}}"/>
                <x-form.error :messages="$errors->get('password')" class="mt-2"/>
            </div>
            <x-form.primary type="submit" class="w-full" size="lg">{{__('Install')}}</x-form.primary>
        </form>
    </div>
@endsection
