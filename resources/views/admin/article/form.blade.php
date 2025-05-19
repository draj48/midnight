@extends('layouts.admin')
@section('content')

    <form method="POST" enctype="multipart/form-data">
        @csrf
        <div class="lg:flex flex-1 flex-row h-full">
            <div class="max-w-6xl mx-auto">
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
                    <x-form.textarea name="meta_description" placeholder="{{__('Meta Description')}}"
                    >{{ old('meta_description', isset($listing) ? $listing->meta_description : '') }}</x-form.textarea>
                    <x-form.error :messages="$errors->get('meta_description')" class="mt-2"/>
                </div>
            </div>
            <div class="max-w-sm w-full">

                <div class="flex items-center justify-center w-full mb-5"
                     x-data="imageViewer('{{isset($listing->image) ? asset(config('attr.article.path').'thumb-'.$listing->image) : ''}}')">
                    <label for="dropzone-file"
                           class="flex flex-col items-center justify-center w-full aspect-video border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-white dark:hover:bg-gray-700/50 dark:bg-gray-800 hover:bg-gray-50 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600 relative">

                        <div class="flex flex-col items-center justify-center pt-5 pb-6 relative">
                            <x-ui.icon name="upload" fill="currentColor" class="w-10 h-10 text-gray-500 mb-7"/>
                            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400 font-medium">{{__('Click to upload or drag')}}</p>
                            <p class="text-xs text-gray-400 dark:text-gray-400">PNG, JPG or GIF
                                (MAX. {{config('attr.article.size_x').'x'.config('attr.article.size_y')}})</p>
                        </div>
                        <template x-if="imageUrl">
                            <img :src="imageUrl"
                                 class="object-cover w-full aspect-video absolute inset-0 rounded-lg"
                            >
                        </template>
                        <template x-if="!imageUrl">
                            <div
                                class="object-cover w-full aspect-video absolute inset-0 rounded-lg"
                            ></div>
                        </template>
                        <input name="image" id="dropzone-file" type="file" class="hidden" accept="image/*"
                               @change="fileChosen">
                    </label>
                </div>
                <div class="mb-5">
                    <x-form.label for="tag" :value="__('Tags')"/>
                    <x-form.tag>
                        @if(isset($listing->tags))
                            @foreach($listing->tags as $tag)
                                @if($loop->last)
                                    {{'"'.$tag->tag.'"'}}
                                @else
                                    {{'"'.$tag->tag.'",'}}
                                @endif
                            @endforeach
                        @endif
                    </x-form.tag>
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
                    <x-form.label for="featured" :value="__('Advanced')"/>
                    <div class="flex items-center space-x-4 mt-5">
                        <x-form.switch type="checkbox" id="featured" name="featured" value="active"
                                       :checked="isset($listing) AND $listing->featured == 'active' ? true : false"/>
                        <x-form.label for="featured" class="md:mb-0 cursor-pointer font-normal"
                                      :value="__('Show featured')"/>
                    </div>
                    <x-form.error :messages="$errors->get('featured')" class="mt-2"/>
                </div>
                <x-form.primary class="w-full mb-5">{{__('Save change')}}</x-form.primary>
            </div>
        </div>
    </form>
    <x-form.tinymce/>
    @push('javascript')
        <script>

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

            function tagSelect() {
                return {
                    open: false,
                    textInput: '',
                    tags: [],
                    init() {
                        this.tags = JSON.parse(this.$el.parentNode.getAttribute('data-tags'));
                    },
                    addTag(tag) {
                        tag = tag.trim()
                        if (tag != "" && !this.hasTag(tag)) {
                            this.tags.push(tag)
                        }
                        this.clearSearch()
                        this.$refs.textInput.focus()
                        this.fireTagsUpdateEvent()
                    },
                    fireTagsUpdateEvent() {
                        this.$el.dispatchEvent(new CustomEvent('tags-update', {
                            detail: {tags: this.tags},
                            bubbles: true,
                        }));
                    },
                    hasTag(tag) {
                        var tag = this.tags.find(e => {
                            return e.toLowerCase() === tag.toLowerCase()
                        })
                        return tag != undefined
                    },
                    removeTag(index) {
                        this.tags.splice(index, 1)
                        this.fireTagsUpdateEvent()
                    },
                    search(q) {
                        if (q.includes(",")) {
                            q.split(",").forEach(function (val) {
                                this.addTag(val)
                            }, this)
                        }
                        this.toggleSearch()
                    },
                    clearSearch() {
                        this.textInput = ''
                        this.toggleSearch()
                    },
                    toggleSearch() {
                        this.open = this.textInput != ''
                    }
                }
            }
        </script>
    @endpush
@endsection
