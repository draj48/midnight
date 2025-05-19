@extends('layouts.admin')
@section('content')
    <div class="max-w-2xl mx-auto w-full">
        <!-- Grid -->
        <x-form.layout>
            <!-- End Grid -->
            <form method="post">
                @csrf
                @if(empty($listing->id))
                    <div class="mb-5">
                        <x-form.label for="name" :value="__('Title')"/>
                        <x-form.input id="name" class="block mt-1 w-full" type="text" name="name"
                                      value="{{ old('name', isset($listing) ? $listing->name : '') }}"
                                      required placeholder="{{__('Title')}}"/>
                        <x-form.error :messages="$errors->get('name')" class="mt-2"/>
                    </div>
                @elseif($listing->id)
                    <div class="mb-5">
                        <x-form.label for="name" :value="__('Title')"/>
                        <x-form.input id="name" class="block mt-1 w-full" type="text" name="name"
                                      value="{{ old('name', isset($listing) ? $listing->name : '') }}"
                                      disabled="" placeholder="{{__('Title')}}"/>
                        <x-form.error :messages="$errors->get('name')" class="mt-2"/>
                    </div>
                @endif
                <div class="mb-5">
                    <x-form.label for="body" :value="__('Code')"/>
                    <x-form.textarea name="body" placeholder="{{__('Code')}}"
                                     rows="5">{{ old('body', isset($listing) ? $listing->body : '') }}</x-form.textarea>
                    <x-form.error :messages="$errors->get('body')" class="mt-2"/>
                </div>
                <div class="mb-5">
                    <x-form.label for="status" :value="__('Status')"/>
                    <x-form.select name="status" x-model="status" id="status">
                        <option value="publish" @if(isset($listing->status) AND $listing->status == 'publish')
                            {{'selected'}}
                            @endif>{{__('Publish')}}</option>
                        <option value="draft" @if(isset($listing->status) AND $listing->status == 'draft')
                            {{'selected'}}
                            @endif>{{__('Draft')}}</option>
                    </x-form.select>
                    <x-form.error :messages="$errors->get('status')" class="mt-2"/>
                </div>
                <x-form.primary class="w-full">{{__('Save change')}}</x-form.primary>
            </form>
        </x-form.layout>
    </div>
@endsection
