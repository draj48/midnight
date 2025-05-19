@extends('layouts.admin')
@section('content')
    <div class="max-w-2xl mx-auto w-full" x-data="post()">
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
                    <x-form.label for="game" :value="__('Content')"/>
                    <div class="mb-5">
                        <input name="search_people" class="selectize-post" placeholder="{{__('Search')}}">
                    </div>
                    <template x-for="(post, index) in posts" :key="index">
                        <div
                            class="border-b border-gray-100 dark:border-gray-800 text-gray-500 dark:text-gray-300 flex items-center text-sm pb-3 mb-3">
                            <input type="hidden" x-bind:name="`post[]`" x-bind:value="post.id">
                            <div class="aspect-[2/3] w-12 rounded relative overflow-hidden">
                                <img
                                    src="" x-bind:src="post.image"
                                    alt="" class="absolute h-full w-full object-cover"/>
                            </div>
                            <div class="flex-1 ml-6">
                                <div class="text-base font-medium mb-1" x-text="post.title"></div>
                                <div class="text-sm text-gray-400" x-text="post.type"></div>
                            </div>
                            <button @click.prevent="removePost(index)"
                                    class="w-6 h-6 inline-block align-middle text-gray-500 hover:text-gray-600 focus:outline-none">
                                <svg class="w-6 h-6 fill-current mx-auto" xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 24 24">
                                    <path fill-rule="evenodd"
                                          d="M15.78 14.36a1 1 0 0 1-1.42 1.42l-2.82-2.83-2.83 2.83a1 1 0 1 1-1.42-1.42l2.83-2.82L7.3 8.7a1 1 0 0 1 1.42-1.42l2.83 2.83 2.82-2.83a1 1 0 0 1 1.42 1.42l-2.83 2.83 2.83 2.82z"/>
                                </svg>
                            </button>
                        </div>
                    </template>

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
        <script src="{{asset('static/js/jquery.js')}}" type="text/javascript"></script>
        <script src="{{asset('static/js/select.js')}}" type="text/javascript"></script>
        <script type="text/javascript">
            function post() {
                return {
                    init() {
                        var self = this;
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
                            onChange: function (value) {
                                if (value) {
                                    if (!self.hasPost(value)) {
                                        $.ajax({
                                            url: '{{route('admin.index.first')}}?id=' + value,
                                            type: 'GET',
                                            dataType: 'json',
                                            success: function(resp) {
                                                self.posts.push({
                                                    id: resp.id,
                                                    type: resp.type,
                                                    image: resp.image,
                                                    title: resp.title
                                                });
                                                $('.selectize-post')[0].selectize.clear();
                                            }
                                        });
                                    }
                                }
                            }
                        })
                    },
                    posts: {!! isset($fetch['posts']) ? "JSON.parse('".addslashes(json_encode($fetch['posts'], JSON_UNESCAPED_SLASHES))."')" : '[]' !!},
                    hasPost(post) {
                        var post = this.posts.find(e => {
                            return e.id === post
                        })
                        return post
                    },
                    removePost(index) {
                        this.posts.splice(index, 1)

                        this.$el.dispatchEvent(new CustomEvent('posts-update', {
                            detail: {posts: this.posts},
                            bubbles: true,
                        }));
                    },
                }
            }
        </script>
    @endpush
@endsection
