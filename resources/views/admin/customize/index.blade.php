@extends('layouts.admin')
@section('content')
    <div class="max-w-3xl mx-auto w-full">
        <form method="post">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-x-10">
                <div class="lg:col-span-6">
                    <div class="mb-5">
                        <x-form.label for="layout" :value="__('Layout')"/>
                        <x-form.select name="layout">
                            <option value="horizontal" @if(config('settings.layout') == 'horizontal')
                                {{'selected'}}
                                @endif>{{__('Horizontal')}}</option>
                            <option value="vertical" @if(config('settings.layout') == 'vertical')
                                {{'selected'}}
                                @endif>{{__('Vertical')}}</option>
                        </x-form.select>
                    </div>
                </div>
                <div class="lg:col-span-6">
                    <div class="mb-5">
                        <x-form.label for="color" :value="__('Theme color')"/>
                        <x-form.input id="color" name="color" type="text" class="mt-1 block w-full h-12 colorpicker"
                                      value="{{ old('color', config('settings.color')) }}"
                                      placeholder="{{__('Theme color')}}"/>
                    </div>
                </div>
                <div class="lg:col-span-6">
                    <div class="mb-5">
                        <x-form.label for="palette" :value="__('Color palette')"/>
                        <x-form.select name="palette">
                            @foreach(config('attr.colors') as $colorx => $key)

                                <option value="{{$colorx}}" @if(config('settings.palette') == $colorx)
                                    {{'selected'}}
                                    @endif>{{$colorx}}</option>
                            @endforeach
                        </x-form.select>
                    </div>
                </div>
                <div class="lg:col-span-6">
                    <div class="mb-5">
                        <x-form.label for="footer_type" :value="__('Footer')"/>
                        <x-form.select name="footer_type">
                            <option value="large" @if(config('settings.footer_type') == 'large')
                                {{'selected'}}
                                @endif>{{__('Large')}}</option>
                            <option value="small" @if(config('settings.footer_type') == 'small')
                                {{'selected'}}
                                @endif>{{__('Small')}}</option>
                        </x-form.select>
                    </div>
                </div>
                <div class="lg:col-span-6">
                    <div class="mb-5">
                        <x-form.label for="listing_filter" :value="__('Listing filter type')"/>
                        <x-form.select name="listing_filter">
                            <option value="v1" @if(config('settings.listing_filter') == 'v1')
                                {{'selected'}}
                                @endif>{{__('Popup')}}</option>
                            <option value="v2" @if(config('settings.listing_filter') == 'v2')
                                {{'selected'}}
                                @endif>{{__('Static')}}</option>
                        </x-form.select>
                    </div>
                </div>
                <div class="lg:col-span-6">
                    <div class="mb-5">
                        <x-form.label for="listing_type" :value="__('Listing type')"/>
                        <x-form.select name="listing_type">
                            <option value="classic" @if(config('settings.listing_type') == 'classic')
                                {{'selected'}}
                                @endif>{{__('Classic')}}</option>
                            <option value="slide" @if(config('settings.listing_type') == 'slide')
                                {{'selected'}}
                                @endif>{{__('Slide')}}</option>
                        </x-form.select>
                    </div>
                </div>
                <div class="lg:col-span-6">
                    <div class="mb-5">
                        <x-form.label for="poster_type" :value="__('Poster type')"/>
                        <x-form.select name="poster_type">
                            <option value="v1" @if(config('settings.poster_type') == 'v1')
                                {{'selected'}}
                                @endif>{{__('Poster and Caption')}}</option>
                            <option value="v2" @if(config('settings.poster_type') == 'v2')
                                {{'selected'}}
                                @endif>{{__('Only poster')}}</option>
                        </x-form.select>
                    </div>
                </div>
                <div class="lg:col-span-6">
                    <div class="mb-5">
                        <x-form.label for="listing_recommend_limit" :value="__('You may also like limit')"/>
                        <x-form.input id="listing_recommend_limit" name="listing_recommend_limit" type="text"
                                      class="mt-1 block w-full"
                                      value="{{ old('listing_recommend_limit', config('settings.listing_recommend_limit')) }}"
                                      placeholder="{{__('You may also like limit')}}"/>

                        <x-form.error class="mt-2" :messages="$errors->get('listing_recommend_limit')"/>
                    </div>
                </div>
                <div class="lg:col-span-6">
                    <div class="mb-5">
                        <x-form.label for="listing_limit" :value="__('Listing limit')"/>
                        <x-form.input id="listing_limit" name="listing_limit" type="text" class="mt-1 block w-full"
                                      value="{{ old('listing_limit', config('settings.listing_limit')) }}"
                                      placeholder="{{__('Listing limit')}}"/>

                        <x-form.error class="mt-2" :messages="$errors->get('listing_limit')"/>
                    </div>
                </div>
                <div class="col-span-full">
                    <div class="mb-5">
                        <x-form.label for="advanced" :value="__('Advanced')"/>
                        <div class="flex items-center space-x-4 mt-2">
                            <x-form.switch type="checkbox" id="top_week" name="top_week" value="active"
                                           :checked="config('settings.top_week') == 'active' ? true : false"/>
                            <x-form.label for="top_week" class="md:mb-0 cursor-pointer font-normal"
                                          :value="__('Top this week')"/>
                        </div>
                        <div class="flex items-center space-x-4 mt-2">
                            <x-form.switch type="checkbox" id="listing_genre" name="listing_genre" value="active"
                                           :checked="config('settings.listing_genre') == 'active' ? true : false"/>
                            <x-form.label for="listing_genre" class="md:mb-0 cursor-pointer font-normal"
                                          :value="__('Show featured genres in listing')"/>
                        </div>
                        <div class="flex items-center space-x-4 mt-2">
                            <x-form.switch type="checkbox" id="show_titlesub" name="show_titlesub" value="active"
                                           :checked="config('settings.show_titlesub') == 'active' ? true : false"/>
                            <x-form.label for="show_titlesub" class="md:mb-0 cursor-pointer font-normal"
                                          :value="__('Show alternative title')"/>
                        </div>
                    </div>
                </div>
                <div class="lg:col-span-12">
                    <hr class="my-6 border-gray-100 dark:border-gray-800">
                </div>
            </div>

            <div class="space-y-3 sortable-module">
                @foreach($modules as $module)
                    <div class="rounded-lg border shadow-sm border-gray-200 dark:bg-gray-900 dark:border-gray-800 px-5 divide-y divide-gray-100 card">
                        <div class="" x-data="{ expanded: false }">

                            <div class="py-4 font-medium text-gray-500 dark:text-gray-300 flex items-center space-x-4 js-handle">
                                <x-ui.icon name="swap" class="w-5 h-5 cursor-pointer" stroke="currentColor"/>
                                <span class="flex-1">{{$module->title}}</span>
                                <x-ui.icon name="settings" class="w-5 h-5 cursor-pointer" stroke="currentColor"
                                           @click="expanded = ! expanded"/>
                            </div>
                            <input type="hidden" name="module[{{$module->id}}][sortable]" value="{{$module->sortable}}"
                                   class="sortable-input">
                            <input type="hidden" name="module[{{$module->id}}][id]" value="{{$module->id}}">
                            <div x-show="expanded" x-collapse>
                                <div class="px-2 py-5 border-t border-gray-100 dark:border-gray-800">
                                    @include('admin.customize.partials.'.$module->slug)
                                </div>
                            </div>
                        </div>
                    </div>

                @endforeach
            </div>
            <x-form.primary class="w-full mt-5" size="lg">{{__('Save change')}}</x-form.primary>
        </form>
    </div>

    @push('javascript')
        <script src="{{asset('static/js/jquery.js')}}"></script>
        <script src="{{asset('static/js/sortable.js')}}"></script>
        <script src="{{asset('static/js/colorpicker.js')}}"></script>
        <script>

            sortable('.sortable-module', {
                forcePlaceholderSize: true,
                handle: '.js-handle'
            });
            sortable('.sortable-module')[0].addEventListener('sortupdate', function (e) {
                $('.sortable-module .card').each(function (i, el) {
                    $(el).find('.sortable-input').val(i);
                });
            });
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

            function imageViewer(src = '') {
                return {
                    imageUrl: src,

                    fileChosen(event) {
                        this.fileToDataUrl(event, src => this.imageUrl = src)
                    },

                    fileToDataUrl(event, callback) {
                        if (!event.target.files.length) return

                        let file = event.target.files[0],
                            reader = new FileReader()

                        reader.readAsDataURL(file)
                        reader.onload = e => callback(e.target.result)
                    },
                }
            }
        </script>
    @endpush
@endsection
