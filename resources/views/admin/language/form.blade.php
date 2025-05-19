@extends('layouts.admin')
@section('content')
    <div class="max-w-4xl mx-auto w-full">
        <!-- Grid -->
        <x-form.layout>
            <!-- End Grid -->
            <form method="post">
                @csrf
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                    <div class="col-span-12">
                        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
                            {{__('Language')}}
                        </h2>
                    </div>
                    <div class="col-span-6">
                        <div class="mb-5">
                            <x-form.label for="name" :value="__('Title')"/>
                            <x-form.input id="name" class="block mt-1 w-full" type="text" name="name"
                                          value="{{ old('name', isset($listing) ? $listing->name : '') }}"
                                          required placeholder="{{__('Title')}}"/>
                            <x-form.error :messages="$errors->get('name')" class="mt-2"/>
                        </div>
                    </div>
                    <div class="col-span-6">
                        <div class="mb-5">
                            <x-form.label for="code" :value="__('Code')"/>
                            <x-form.input id="code" class="block mt-1 w-full" type="text" name="code"
                                          value="{{ old('title', isset($listing) ? $listing->code : '') }}"
                                          required placeholder="{{__('Code')}}"/>
                            <x-form.error :messages="$errors->get('code')" class="mt-2"/>
                        </div>
                    </div>
                    @foreach($lang as $key => $val)
                        <div class="col-span-6">
                            <x-form.label for="featured" :value="$key"/>
                            <div class="col-sm-9">
                                <input type="hidden" name="keys[]" value="{{ $key }}">
                                <x-form.input id="name" class="block mt-1 w-full" type="text" name="values[]"
                                              value="{{ $val }}"
                                              required placeholder="{{__('Name')}}"/>
                            </div>
                        </div>
                    @endforeach
                </div>
                <x-form.primary class="w-full mt-5">{{__('Save change')}}</x-form.primary>
            </form>
        </x-form.layout>
    </div>
@endsection
