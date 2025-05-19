@extends('layouts.admin')
@section('content')

    <div class="max-w-2xl mx-auto w-full">
        <form method="POST">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-x-8 py-8 first:pt-0 last:pb-0">
                <div class="col-span-full">
                    <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-5">
                        {{__('Onesignal Config')}}
                    </h2>
                </div>
                <div class="col-span-full">
                    <div class="mb-5">
                        <x-form.label for="onesignal_key" :value="__('Onesignal Message')"/>
                        <x-form.textarea name="onesignal_message" placeholder="{{'[title] published'}}">{{ old('onesignal_message', config('settings.onesignal_message')) }}</x-form.textarea>
                        <div
                            class="mt-3 text-sm text-gray-500 dark:text-gray-300">{{__('Example message theme : [title] published')}}</div>
                    </div>
                </div>
                <div class="col-span-full">
                    <x-form.primary class="w-full">{{__('Save change')}}</x-form.primary>
                </div>
            </div>
        </form>
    </div>
@endsection
