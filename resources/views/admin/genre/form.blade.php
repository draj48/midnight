@extends('layouts.admin')
@section('content')
    <div class="max-w-xl mx-auto w-full">
        <!-- Grid -->
        <x-form.layout>
            <!-- End Grid -->
            <form method="post">
                @csrf
                <div class="mb-5">
                    <x-form.label for="title" :value="__('Title')"/>
                    <x-form.input id="title" class="block mt-1 w-full" type="text" name="title"
                                  value="{{ old('title', isset($listing) ? $listing->title : '') }}"
                                  required placeholder="{{__('Title')}}"/>
                    <x-form.error :messages="$errors->get('title')" class="mt-2"/>
                    <div class="flex items-center text-xs mt-2">
                        <span class="font-medium text-gray-500 mr-2">Permalink</span>
                        <span class="text-gray-500">{{url('/').'/'}}</span>
                        <input type="text" name="slug"
                               class="font-medium border-0 py-0 text-xs px-1 inline-flex text-primary-500 bg-transparent focus:ring-0 w-auto placeholder-gray-300 dark:placeholder-gray-500"
                               placeholder="slug"
                               value="{{ old('slug', isset($listing) ? $listing->slug : '') }}">
                    </div>
                </div>
                <div class="mb-5">
                    <x-form.label for="description" :value="__('Description')"/>
                    <x-form.textarea name="description"
                                     placeholder="{{__('Description')}}">{{ old('description', isset($listing) ? $listing->description : '') }}</x-form.textarea>
                    <x-form.error :messages="$errors->get('description')" class="mt-2"/>
                </div>
                <div class="mb-5">
                    <x-form.label for="color" :value="__('Color')"/>
                    <x-form.input id="color" name="color" type="text" class="mt-1 block w-full colorpicker"
                                  :value="old('color', $listing->color ?? '')"
                                  placeholder="{{__('Color')}}"/>
                </div>
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
                    <x-form.error :messages="$errors->get('description')" class="mt-2"/>
                </div>
                <div class="mb-5">
                    <x-form.label for="advanced" :value="__('Advanced')"/>
                    <div class="flex items-center space-x-4 mt-2">
                        <x-form.switch type="checkbox" id="featured" name="featured" value="active"
                                       :checked="isset($listing) AND $listing->featured == 'active' ? true : false"/>
                        <x-form.label for="featured" class="md:mb-0 cursor-pointer font-normal"
                                      :value="__('Show featured')"/>
                    </div>
                </div>
                <x-form.primary class="w-full">{{__('Save change')}}</x-form.primary>
            </form>
        </x-form.layout>
    </div>
    @push('javascript')
        <script src="{{asset('static/js/jquery.js')}}"></script>
        <script src="{{asset('static/js/colorpicker.js')}}"></script>
        <script>

            $('.colorpicker').minicolors({
                control: $(this).attr('data-control') || 'hue',
                inline: $(this).attr('data-inline') === 'true',
                letterCase: 'lowercase',
                opacity: false,
                change: function (hex, opacity) {
                    if (!hex) return;
                    if (opacity) hex += ', ' + opacity;
                    try {
                        console.log(hex);
                    } catch (e) {
                    }
                    $(this).select();
                },
                theme: 'bootstrap'
            });
        </script>
    @endpush
@endsection
