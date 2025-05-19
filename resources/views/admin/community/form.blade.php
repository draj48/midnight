@extends('layouts.admin')
@section('content')
    <div class="max-w-2xl mx-auto w-full">
        <!-- Grid -->
        <x-form.layout>
            <!-- End Grid -->
            <form method="post">
                @csrf
                <div class="mb-5">
                    <x-form.label for="title" :value="__('Heading')"/>
                    <x-form.input id="title" class="block mt-1 w-full" type="text" name="title"
                                  value="{{ old('title', isset($listing) ? $listing->title : '') }}"
                                  required placeholder="{{__('Heading')}}"/>
                    <x-form.error :messages="$errors->get('title')" class="mt-2"/>
                    <div class="flex items-center text-xs mt-2">
                        <span class="font-medium text-gray-500 mr-2">Permalink</span>
                        <span class="text-gray-500">{{url('thread').'/'}}</span>
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
                    <x-form.label for="description" :value="__('Related content')"/>
                    <select name="post_id" class="selectize-post" placeholder="{{__('Search')}}">
                        @if(isset($listing))
                        <option value="{{$listing->post_id}}">{{$listing->post->title}}</option>
                        @endif
                    </select>
                </div>
                <div class="mb-5">
                    <x-form.label for="status" :value="__('Status')"/>
                    <x-form.select name="status" id="status">
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
                <x-form.label for="advanced" :value="__('Advanced')"/>
                <div class="flex items-center space-x-4">
                    <x-form.switch type="checkbox" id="featured" name="featured" value="active"
                                   :checked="isset($listing) AND $listing->featured == 'active' ? true : false"/>
                    <x-form.label for="featured" class="md:mb-0 cursor-pointer font-normal"
                                  :value="__('Show featured')"/>
                </div>
                <div class="flex items-center space-x-4 mt-2">
                    <x-form.switch type="checkbox" id="comment" name="comment" value="active"
                                   :checked="isset($listing) AND $listing->comment == 'active' ? true : false"/>
                    <x-form.label for="comment" class="md:mb-0 cursor-pointer font-normal"
                                  :value="__('Closed comment')"/>
                </div>
                </div>
                <x-form.primary class="w-full">{{__('Save change')}}</x-form.primary>
            </form>
        </x-form.layout>
    </div>
    @push('javascript')
        <script src="{{asset('static/js/jquery.js')}}"></script>
        <script src="{{asset('static/js/select.js')}}"></script>
        <script>
            $('.selectize-post').selectize({
                valueField: 'id',
                labelField: 'title',
                searchField: 'title',
                options: [],
                maxItems: 1,
                render: {
                    option: function (item, escape) {

                        return '<div class="flex items-center space-x-8 px-3 py-1">' +
                            '<div class="aspect-square w-12 bg-cover rounded-md" style="background-image:url(' + escape(item.image) + '"></div>' +
                            '<div>' +
                            (item.title ? '<div class="text-sm font-medium">' + escape(item.title) + '</div>' : '') +
                            (item.type ? '<div class="text-gray-400 text-xs">' + escape(item.type) + '</div>' : '') +
                            '</div>' +
                            '</div>';
                    }
                },
                load: function (query, callback) {
                    if (!query.length) return callback();
                    $.ajax({
                        url: '{{route('admin.index.search')}}?q=' + encodeURIComponent(query),
                        type: 'GET',
                        dataType: 'json',
                        error: function () {
                            callback();
                        },
                        success: function (resp) {
                            if (resp.data.length > 0 || resp.data) {
                                callback(resp.data.slice(0, 10));
                            }
                        }
                    });
                },
                create: false,
            })
        </script>
    @endpush
@endsection
