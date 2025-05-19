@extends('layouts.admin')
@section('content')
    <div x-data="post()">
        <form method="post" class="flex space-x-8 2xl:space-x-16" enctype="multipart/form-data">
            <div class="max-w-7xl mx-auto w-full">
                @csrf

                <div class="mb-5">
                    <x-form.label for="title" :value="__('Title')"/>
                    <x-form.input id="title" class="block mt-1 w-full" type="text" name="title"
                                  value="{{ old('title', isset($listing) ? $listing->title : '') }}" size="lg"
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
                    <x-form.label for="overview" :value="__('Overview')"/>
                    <x-form.textarea name="overview" placeholder="{{__('Overview')}}" rows="4">{{ old('overview', isset($listing) ? $listing->overview : '') }}</x-form.textarea>
                    <x-form.error :messages="$errors->get('overview')" class="mt-2"/>
                </div>


                <div class="mb-4">
                    <template x-for="(video, index) in videos" :key="index">
                        <div class="grid grid-cols-1 lg:grid-cols-12 gap-x-6">
                            <input type="hidden" x-bind:name="`video[${index}][id]`" x-model="video.id">
                            <div class="col-span-3">
                                <div class="mb-4">
                                    <x-form.select x-model="video.type" x-bind:name="`video[${index}][type]`">
                                        <option value="">{{__('Choose')}}</option>
                                        @foreach(config('attr.streams') as $key => $value)
                                            <option value="{{$key}}">{{__($value)}}</option>
                                        @endforeach
                                    </x-form.select>
                                </div>
                            </div>
                            <div class="col-span-3">
                                <div class="mb-4">
                                    <x-form.input type="text" name="video[][label]"
                                                  placeholder="{{__('Label')}}" x-model="video.label" x-bind:name="`video[${index}][label]`"/>
                                </div>
                            </div>
                            <div class="col-span-4">
                                <div class="mb-4">
                                    <x-form.input type="text" name="video[][link]"
                                                  placeholder="{{__('http://')}}" x-model="video.link" x-bind:name="`video[${index}][link]`"/>
                                </div>
                            </div>
                            <div class="col-span-2">
                                <x-form.secondary type="button" @click="removeVideoField(index,video.id)"
                                                  class="w-full">{{__('Remove')}}</x-form.secondary>
                            </div>
                        </div>
                    </template>
                    <x-form.secondary type="button" @click="addVideoField()"
                                      class="w-full">{{__('Add new')}}</x-form.secondary>
                </div>

                <hr class="my-6 lg:my-10 border-gray-100 dark:border-gray-800">
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
                    <x-form.label for="information" :value="__('Information box')"/>
                    <x-form.input id="information" class="block mt-1 w-full" type="text" name="arguments[information]"
                                  value="{{ old('information', isset($listing->arguments->information) ? $listing->arguments->information : '') }}"
                                  placeholder="{{__('Information box')}}"/>
                    <div
                        class="text-xs text-gray-400 dark:text-gray-600 mt-2">{{__('Alternative title is used for the translation of the content into your language.')}}</div>
                    <x-form.error :messages="$errors->get('information')" class="mt-2"/>
                </div>
            </div>
            <div class="max-w-xs w-full">

                <div class="flex items-center justify-center w-full mb-5" x-data="{imageUrl:'{{isset($listing->image) ? asset(config('attr.poster.path').$listing->image) : ''}}'}">
                    <label for="image-file"
                           class="flex flex-col items-center justify-center w-full aspect-square border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-white dark:hover:bg-gray-700/50 dark:bg-gray-800 hover:bg-gray-50 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600 relative">

                        <div class="flex flex-col items-center justify-center pt-5 pb-6 relative">
                            <x-ui.icon name="upload" fill="currentColor" class="w-8 h-8 text-gray-500 mb-5"/>
                            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400 font-medium">{{__('Click to upload or drag')}}</p>
                            <p class="text-xs text-gray-400 dark:text-gray-400">PNG or JPG
                                (Size. {{config('attr.poster.broadcast_size_x').'x'.config('attr.poster.broadcast_size_y')}}
                                )</p>
                        </div>
                        <!-- Show the image -->
                        <template x-if="imageUrl">
                            <img :src="imageUrl"
                                 class="object-cover w-full aspect-square absolute inset-0 rounded-lg"
                            >
                        </template>

                        <!-- Show the gray box when image is not available -->
                        <template x-if="!imageUrl">
                            <div
                                class="object-cover w-full aspect-square absolute inset-0 rounded-lg"
                            ></div>
                        </template>
                        <input name="image" id="image-file" type="file" class="hidden" accept="image/*" x-ref="image"
                               @change="imageViewer().fileChosen">
                    </label>
                </div>
                <div class="flex items-center justify-center w-full mb-5" x-data="{imageUrl:'{{isset($listing->cover) ? asset(config('attr.poster.path').$listing->cover) : ''}}'}">
                    <label for="cover-file"
                           class="flex flex-col items-center justify-center w-full aspect-video border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-white dark:hover:bg-gray-700/50 dark:bg-gray-800 hover:bg-gray-50 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600 relative">

                        <div class="flex flex-col items-center justify-center pt-5 pb-6 relative">
                            <x-ui.icon name="upload" fill="currentColor" class="w-8 h-8 text-gray-500 mb-5"/>
                            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400 font-medium">{{__('Click to upload or drag')}}</p>
                            <p class="text-xs text-gray-400 dark:text-gray-400">PNG or JPG
                                (Size. {{config('attr.poster.broadcast_cover_size_x').'x'.config('attr.poster.broadcast_cover_size_y')}}
                                )</p>
                        </div>
                        <!-- Show the image -->
                        <template x-if="imageUrl">
                            <img :src="imageUrl"
                                 class="object-cover w-full aspect-video absolute inset-0 rounded-lg"
                            >
                        </template>

                        <!-- Show the gray box when image is not available -->
                        <template x-if="!imageUrl">
                            <div
                                class="object-cover w-full aspect-video absolute inset-0 rounded-lg"
                            ></div>
                        </template>
                        <input name="cover" id="cover-file" type="file" class="hidden" accept="image/*" x-ref="image"
                               @change="imageViewer().fileChosen">
                    </label>
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
                    <div class="flex items-center space-x-4 mt-2">
                        <x-form.switch type="checkbox" id="featured" name="featured" value="active"
                                       :checked="isset($listing) AND $listing->featured == 'active' ? true : false"/>
                        <x-form.label for="featured" class="md:mb-0 cursor-pointer font-normal"
                                      :value="__('Show featured')"/>
                    </div>
                    <div class="flex items-center space-x-4 mt-2">
                        <x-form.switch type="checkbox" id="member" name="member" value="active"
                                       :checked="isset($listing) AND $listing->member == 'active' ? true : false"/>
                        <x-form.label for="member" class="md:mb-0 cursor-pointer font-normal"
                                      :value="__('Exclusive to subscriber')"/>
                    </div>
                    <div class="flex items-center space-x-4 mt-2">
                        <x-form.switch type="checkbox" id="comment" name="comment" value="active"
                                       :checked="isset($listing) AND $listing->comment == 'active' ? true : false"/>
                        <x-form.label for="comment" class="md:mb-0 cursor-pointer font-normal"
                                      :value="__('Closed comment')"/>
                    </div>
                </div>
                <x-form.primary class="w-full mt-5">{{__('Save change')}}</x-form.primary>
            </div>
        </form>

    </div>
    @push('javascript')
        <script src="{{asset('static/js/jquery.js')}}" type="text/javascript"></script>
        <script src="{{asset('static/js/select.js')}}" type="text/javascript"></script>

        <script>

            function post() {
                return {
                    imageUrl :null,
                    videos: {!! isset($fetch['videos']) ? "JSON.parse('".addslashes(json_encode($fetch['videos'], JSON_UNESCAPED_SLASHES))."')" : '[]' !!},
                    removeVideoField(index,videoId = null) {
                        this.videos.splice(index, 1);
                        if (videoId) {
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                                }
                            });
                            $.ajax({
                                url: '{{route('admin.'.$config['route'].'.video.destroy')}}?id=' + videoId,
                                type: 'DELETE',
                                dataType: 'json',
                                success: function(response) {
                                }
                            });
                        }
                    },
                    addVideoField() {
                        this.videos.push({
                            type: '',
                            link: ''
                        });
                    },
                    imageViewer(src = '') {
                        return {
                            fileChosen(event) {
                                this.imageViewer().fileToDataUrl(event, src => this.imageUrl = src)
                            },
                            fileToDataUrl(event, callback) {
                                if (!event.target.files.length) return

                                let file = event.target.files[0],
                                    reader = new FileReader()

                                reader.onload = e => callback(e.target.result)
                                reader.readAsDataURL(file)
                            }
                        }
                    }
                }
            }
        </script>
    @endpush
@endsection
