@extends('layouts.admin')
@section('content')
    <div class="max-w-xl mx-auto w-full">
        <!-- End Grid -->
        <form method="post">
            @csrf
            <div class="mb-5">
                <x-form.label for="name" :value="__('Name')"/>
                <x-form.input type="text" name="name" placeholder="{{__('Name')}}" value="{{ old('name', isset($listing) ? $listing->name : '') }}"/>
                <x-form.error :messages="$errors->get('name')" class="mt-2"/>
            </div>
            <div class="mb-5 lg:col-span-6">
                <x-form.label for="code" :value="__('Code')"/>
                <x-form.input type="text" name="code" placeholder="{{__('Code')}}" value="{{ old('code', isset($listing) ? $listing->code : '') }}"/>
                <x-form.error :messages="$errors->get('code')" class="mt-2"/>
            </div>
            <div class="mb-5 lg:col-span-12">
                <x-form.label for="percentage" :value="__('Percentage')"/>
                <x-form.input type="text" name="percentage" placeholder="{{__('Percentage')}}" value="{{ old('percentage', isset($listing) ? $listing->percentage : '') }}"/>
                <x-form.error :messages="$errors->get('percentage')" class="mt-2"/>
            </div>
            <div class="mb-5">
                <x-form.label for="quantity" :value="__('Quantity')"/>
                <x-form.input type="number" name="quantity" placeholder="{{__('Quantity')}}" value="{{ old('quantity', isset($listing) ? $listing->quantity : '') }}"/>
                <x-form.error :messages="$errors->get('quantity')" class="mt-2"/>
            </div>
            <x-form.primary class="w-full mt-5">{{__('Save change')}}</x-form.primary>
        </form>
    </div>
@endsection
