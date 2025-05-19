@extends('layouts.admin')
@section('content')

    <form method="POST" enctype="multipart/form-data">
        @csrf
        <div class="max-w-4xl mx-auto">

            <div class="mb-5">
                <x-form.label for="title" :value="__('Heading')"/>
                <x-form.input id="title" class="block mt-1 w-full" type="text" name="title"
                              value="{{ old('title', isset($listing) ? $listing->title : '') }}"
                              required placeholder="{{__('Title')}}"/>
                <x-form.error :messages="$errors->get('title')" class="mt-2"/>
                <div class="flex items-center text-xs mt-2">
                    <span class="font-medium text-gray-500 mr-2">Permalink</span>
                    <span class="text-gray-500">{{'page/'}}</span>
                    <input type="text" name="slug"
                           class="font-medium border-0 py-0 text-xs px-1 inline-flex text-primary-500 bg-transparent focus:ring-0 w-auto placeholder-gray-300 dark:placeholder-gray-500"
                           placeholder="slug"
                           value="{{ old('slug', isset($listing) ? $listing->slug : '') }}">
                </div>
            </div>
            <div class="mb-5">
                <x-form.label for="description" :value="__('Description')"/>
                <x-form.textarea name="description" placeholder="{{__('Description')}}"
                                 required>{{ old('description', isset($listing) ? $listing->description : '') }}</x-form.textarea>
                <x-form.error :messages="$errors->get('description')" class="mt-2"/>
            </div>
            <x-form.textarea name="body"
                             id="editor">{!! old('body', isset($listing) ? $listing->body : '')  !!}</x-form.textarea>
            <hr class="my-6 border-gray-100 dark:border-gray-800">
            <div class="mb-5">
                <x-form.label for="meta_title" :value="__('Meta Title')"/>
                <x-form.input id="meta_title" class="block mt-1 w-full" type="text" name="meta_title"
                              value="{{ old('meta_title', isset($listing) ? $listing->meta_title : '') }}"
                              placeholder="{{__('Meta Title')}}"/>
                <x-form.error :messages="$errors->get('meta_title')" class="mt-2"/>
            </div>
            <div class="mb-5">
                <x-form.label for="meta_description" :value="__('Meta Description')"/>
                <x-form.textarea name="meta_description"
                                 placeholder="{{__('Meta Description')}}">{{ old('meta_description', isset($listing) ? $listing->meta_description : '') }}</x-form.textarea>
                <x-form.error :messages="$errors->get('meta_description')" class="mt-2"/>
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
            <div class="mb-5">
                <x-form.label for="featured" :value="__('Featured')"/>
                <div class="flex items-center space-x-4 mt-5">
                    <x-form.switch type="checkbox" id="featured" name="featured" value="active"
                                   :checked="isset($listing) AND $listing->featured == 'active' ? true : false"/>
                    <x-form.label for="featured" class="md:mb-0 cursor-pointer font-normal"
                                  :value="__('Show')"/>
                </div>
                <x-form.error :messages="$errors->get('featured')" class="mt-2"/>
            </div>
            <x-form.primary class="w-full mb-5">{{__('Save change')}}</x-form.primary>
        </div>
    </form>
    <x-form.tinymce/>
@endsection
