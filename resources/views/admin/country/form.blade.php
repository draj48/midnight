@extends('layouts.admin')
@section('content')
    <div class="max-w-xl mx-auto w-full">
        <!-- Grid -->
        <x-form.layout>
            <!-- End Grid -->
            <form method="post">
                @csrf
                <div class="mb-5">
                    <x-form.label for="name" :value="__('Name')"/>
                    <x-form.input id="name" class="block mt-1 w-full" type="text" name="name"
                                  value="{{ old('name', isset($listing) ? $listing->name : '') }}"
                                  required placeholder="{{__('Name')}}"/>
                    <x-form.error :messages="$errors->get('name')" class="mt-2"/>
                    <div class="flex items-center text-xs mt-2">
                        <span class="font-medium text-gray-500 mr-2">Permalink</span>
                        <span class="text-gray-500">{{url('country').'/'}}</span>
                        <input type="text" name="slug"
                               class="font-medium border-0 py-0 text-xs px-1 inline-flex text-primary-500 bg-transparent focus:ring-0 w-auto placeholder-gray-300 dark:placeholder-gray-500"
                               placeholder="slug"
                               value="{{ old('slug', isset($listing) ? $listing->slug : '') }}">
                    </div>
                </div>
                <div class="mb-5">
                    <x-form.label for="code" :value="__('Code')"/>
                    <x-form.input id="code" name="code" type="text" class="mt-1 block w-full"
                                  :value="old('code', $listing->code ?? '')"
                                  placeholder="{{__('Code')}}"/>
                </div>
                <hr class="my-6 border-gray-100 dark:border-gray-800">
                <div class="mb-5">
                    <x-form.label for="featured" :value="__('Advanced')"/>
                    <div class="flex items-center space-x-4">
                        <x-form.switch type="checkbox" id="subtitle" name="subtitle" value="active"
                                       :checked="isset($listing) AND $listing->subtitle == 'active' ? true : false"/>
                        <x-form.label for="subtitle" class="md:mb-0 cursor-pointer font-normal"
                                      :value="__('Show subtitle')"/>
                    </div>
                    <div class="flex items-center space-x-4 mt-2">
                        <x-form.switch type="checkbox" id="filter" name="filter" value="active"
                                       :checked="isset($listing) AND $listing->filter == 'active' ? true : false"/>
                        <x-form.label for="filter" class="md:mb-0 cursor-pointer font-normal"
                                      :value="__('Show filter')"/>
                    </div>
                    <x-form.error :messages="$errors->get('featured')" class="mt-2"/>
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
