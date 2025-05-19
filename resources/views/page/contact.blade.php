@extends('layouts.app')
@section('content')
        <div class="max-w-2xl lg:max-w-2xl mx-auto py-5 xl:py-10">
                <div class="text-center mb-6">
                    <h1 class="text-gray-900 dark:text-white text-2xl xl:text-3xl font-semibold mb-2">{{__('Contact')}}</h1>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">{{__('We\'d love to talk about how we can help you.')}}</p>
                </div>
                <form method="post">
                    @csrf
                    <div class="mb-5">
                        <x-form.label for="name" :value="__('Name')"/>
                        <x-form.input id="name" class="block mt-1 w-full" type="text" name="name" size="lg"
                                      value="{{ old('name') }}"
                                      required placeholder="{{__('Name')}}"/>
                    </div>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-x-10">

                        <div class="mb-5">
                            <x-form.label for="email" :value="__('Email')"/>
                            <x-form.input id="email" class="block mt-1 w-full" type="email" name="email"
                                          value="{{ old('email') }}"
                                          required placeholder="{{__('Email')}}"/>
                        </div>
                        <div class="mb-5">
                            <x-form.label for="subject" :value="__('Subject')"/>
                            <x-form.input id="subject" class="block mt-1 w-full" type="text" name="subject"
                                          value="{{ old('subject') }}"
                                          required placeholder="{{__('Subject')}}"/>
                        </div>
                    </div>
                    <div class="mb-5">
                        <x-form.label for="message" :value="__('Message')"/>
                        <x-form.textarea name="message" rows="4" placeholder="{{__('Message')}}">{{ old('message') }}</x-form.textarea>
                    </div>
                    <x-form.primary class="w-full">{{__('Send inquiry')}}</x-form.primary>

                </form>

        </div>
@endsection
