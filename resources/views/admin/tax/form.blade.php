@extends('layouts.admin')
@section('content')
    <div class="container max-w-3xl mx-auto w-full">
        <!-- End Grid -->
        <form method="post">
            @csrf
            <div class="mb-5">
                <x-form.label for="name" :value="__('Name')"/>
                <x-form.input type="text" name="name" placeholder="{{__('Name')}}" value="{{ old('name', isset($listing) ? $listing->name : '') }}"/>
                <x-form.error :messages="$errors->get('name')" class="mt-2"/>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-x-10">
                <div class="mb-5 lg:col-span-6">
                    <x-form.label for="type" :value="__('Type')"/>
                    <x-form.select name="type">
                        <option value="0" @if(isset($listing->type) AND $listing->type == '0') {{'selected'}} @endif>{{__('Inclusive')}}</option>
                        <option value="1" @if(isset($listing->type) AND $listing->type == '1') {{'selected'}} @endif>{{__('Exclusive')}}</option>
                    </x-form.select>
                    <x-form.error :messages="$errors->get('type')" class="mt-2"/>
                </div>
                <div class="mb-5 lg:col-span-6">
                    <x-form.label for="percentage" :value="__('Percentage')"/>
                    <x-form.input type="text" name="percentage" placeholder="{{__('Percentage')}}" required value="{{ old('percentage', isset($listing) ? $listing->percentage : '') }}"/>
                    <x-form.error :messages="$errors->get('percentage')" class="mt-2"/>
                </div>
            </div>
            <div class="mb-5 lg:col-span-6">

                <x-form.label for="regions" :value="__('Regions')"/>
                <x-form.select name="regions[]" multiple class="h-64">
                    @foreach(config('countries') as $key => $value)
                        <option value="{{ $key }}" @if(isset($listing->regions) AND is_array($listing->regions) AND in_array($key, $listing->regions ?? [])) {{'selected'}} @endif>{{ __($value) }}</option>
                    @endforeach
                </x-form.select>
                <x-form.error :messages="$errors->get('regions')" class="mt-2"/>
                <div class="text-gray-400 dark:text-gray-400 text-xs mt-2">{{__('Leave empty to apply the tax rate on all regions.')}}</div>
            </div>
            <x-form.primary class="w-full mt-5">{{__('Save change')}}</x-form.primary>
        </form>
    </div>
@endsection
