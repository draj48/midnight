@extends('layouts.admin')
@section('content')
    <div class="max-w-7xl mx-auto w-full">
        <!-- Grid -->
        <x-form.layout>
            <!-- End Grid -->
            <form method="post" x-data="{ type: '@if(isset($listing->type)){{$listing->type}}@else{{'subscribe'}}@endif' }">
                @csrf
                <div class="mb-5">
                    <x-form.label for="name" :value="__('Name')"/>
                    <x-form.input type="text" name="name" placeholder="{{__('Name')}}"
                                  value="{{ old('name', isset($listing) ? $listing->name : '') }}"/>
                    <x-form.error :messages="$errors->get('name')" class="mt-2"/>
                </div>
                <div class="mb-5">
                    <x-form.label for="description" :value="__('Description')"/>
                    <x-form.textarea name="description"
                                     placeholder="{{__('Description')}}">{{ old('description', isset($listing) ? $listing->description : '') }}</x-form.textarea>
                    <x-form.error :messages="$errors->get('description')" class="mt-2"/>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-x-10">

                    <div class="mb-5 lg:col-span-4">
                        <x-form.label for="currency" :value="__('Currency')"/>
                        <x-form.select name="currency">
                            @foreach(config('currencies.all') as $key => $value)
                                <option value="{{ $key }}" @if(isset($listing->currency) AND $listing->currency == $key)
                                    {{'selected'}}
                                    @endif>{{ $key }}
                                    - {{ $value }}</option>
                            @endforeach
                        </x-form.select>
                        <x-form.error :messages="$errors->get('currency')" class="mt-2"/>
                    </div>
                    <div class="mb-5 lg:col-span-4">
                        <x-form.label for="interval" :value="__('Interval')"/>
                        <x-form.select name="interval">
                            <option value="month" @if(isset($listing) AND $listing->interval == 'month'){{'selected'}}@endif>{{__('Month')}}</option>
                            <option value="year" @if(isset($listing) AND $listing->interval == 'year'){{'selected'}}@endif>{{__('Year')}}</option>
                        </x-form.select>
                        <x-form.error :messages="$errors->get('interval')" class="mt-2"/>
                    </div>
                    <div class="mb-5 lg:col-span-4">
                        <x-form.label for="price" :value="__('Price')"/>
                        <x-form.input type="text" name="price" placeholder="{{__('Price')}}"
                                      value="{{ old('price', isset($listing) ? $listing->price : '') }}"/>
                        <x-form.error :messages="$errors->get('price')" class="mt-2"/>
                    </div>
                    <div class="mb-5 lg:col-span-6">
                        <x-form.label for="taxes" :value="__('Taxes')"/>
                        <x-form.select name="taxes[]" multiple class="h-40">
                            @foreach($taxes as $tax)
                                <option
                                    value="{{$tax->id}}" @if(isset($listing->taxes) AND is_array($listing->taxes) AND in_array($tax->id, $listing->taxes ?? []))
                                    {{'selected'}}
                                    @endif>{{$tax->name}}</option>
                            @endforeach
                        </x-form.select>
                        <x-form.error :messages="$errors->get('taxes')" class="mt-2"/>
                    </div>
                    <div class="mb-5 lg:col-span-6">
                        <x-form.label for="coupons" :value="__('Coupon')"/>
                        <x-form.select name="coupons[]" multiple class="h-40">
                            @foreach($coupons as $coupon)
                                <option
                                    value="{{ $coupon->id }}" @if(isset($listing->coupons) AND is_array($listing->coupons) AND in_array($coupon->id, $listing->coupons ?? []))
                                    {{'selected'}}
                                    @endif>{{$coupon->name}}</option>
                            @endforeach
                        </x-form.select>
                        <x-form.error :messages="$errors->get('coupons')" class="mt-2"/>
                    </div>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-x-10">
                    <div class="mb-5">
                        <x-form.label for="status" :value="__('Status')"/>
                        <x-form.select name="status" required>
                            <option value="active" @if(isset($listing->status) AND $listing->status == 'active')
                                {{'selected'}}
                                @endif>{{__('Active')}}</option>
                            <option value="disable" @if(isset($listing->status) AND $listing->status == 'disable')
                                {{'selected'}}
                                @endif>{{__('Disable')}}</option>
                        </x-form.select>
                        <x-form.error :messages="$errors->get('status')" class="mt-2"/>
                    </div>
                    <div class="mb-5">
                        <x-form.label for="featured" :value="__('Featured')"/>
                        <x-form.select name="featured">
                            <option value="active" @if(isset($listing->featured) AND $listing->featured == 'active')
                                {{'selected'}}
                                @endif>{{__('Active')}}</option>
                            <option value="disable" @if(isset($listing->featured) AND $listing->featured == 'disable')
                                {{'selected'}}
                                @endif>{{__('Disable')}}</option>
                        </x-form.select>
                        <x-form.error :messages="$errors->get('featured')" class="mt-2"/>
                    </div>
                    <div class="mb-5">
                        <x-form.label for="sorting" :value="__('Sorting')"/>
                        <x-form.input type="number" name="sorting" placeholder="{{__('Sorting')}}"
                                      value="{{ old('sorting', isset($listing) ? $listing->sorting : '') }}"/>
                        <x-form.error :messages="$errors->get('sorting')" class="mt-2"/>
                    </div>
                </div>
                <x-form.primary class="max-w-xs w-full mt-5">{{__('Save change')}}</x-form.primary>
            </form>
        </x-form.layout>
    </div>
@endsection
