@extends('layouts.admin')
@section('content')
    <div x-data="post()">
        @if(empty($listing->post_id) AND empty($request->post_id))
            <div class="max-w-3xl mx-auto w-full" x-data="{ nav: 'overview'}">
                <div class="mb-5">
                    <x-form.label for="post_id" :value="__('TV Show')"/>
                    <select name="post_id" class="selectize-tv">
                        <option value="">{{__('Choose')}}</option>
                        @foreach($posts as $post)
                            <option value="{{$post->id}}">{{$post->title}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        @elseif(isset($listing->id) || isset($request->post_id))
            <form method="post" class="flex space-x-8 2xl:space-x-16 py-3" enctype="multipart/form-data">
                <div class="max-w-7xl mx-auto w-full" x-data="{ nav: 'overview'}">
                    @csrf
                    <div class="border-b pb-3 border-gray-100 dark:border-gray-800">
                        <ul class="flex gap-x-4 whitespace-nowrap overflow-x-auto sm:overflow-x-visible sm:p-2 lg:p-0">
                            @if(count($tabs) > 0 )
                                @foreach($tabs as $key => $value)
                                    <li class="@if($key == 'subtitle'){{'ml-0 lg:ml-auto'}}@endif">
                                        <a href="#"
                                           class="w-full py-3 px-6 inline-flex justify-center items-center gap-4 text-sm font-medium text-center text-gray-500 rounded-lg hover:bg-gray-50 relative after:absolute after:-bottom-3 after:rounded-full after:left-0 after:right-0 after:h-1 dark:text-gray-400 dark:hover:text-gray-300 dark:hover:bg-gray-800"
                                           :class="{ 'after:bg-primary-500 text-primary-500 hover:bg-transparent dark:text-primary-400 dark:!text-white dark:hover:bg-transparent': nav === '{{$key}}'}"
                                           @click="nav = '{{$key}}'">
                                            {{ $value }}
                                        </a>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                    <div class="py-6">

                        @if(count($tabs) > 0 )
                            @foreach($tabs as $key => $value)
                                <div class="" :class="{ 'active': nav === '{{$key}}' }"
                                     x-show.transition.in.opacity.duration.600="nav === '{{$key}}'">
                                    @include('admin.episode.partials.'.$key)
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
                <div class="max-w-sm w-full">

                    <div class="flex items-center justify-center w-full mb-5">
                        <label for="dropzone-file"
                               class="flex flex-col items-center justify-center w-full aspect-video border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-white dark:hover:bg-gray-700/50 dark:bg-gray-900 hover:bg-gray-50 dark:border-gray-700 dark:hover:border-gray-500 dark:hover:bg-gray-600 relative">

                            <div class="flex flex-col items-center justify-center pt-5 pb-6 relative">
                                <x-ui.icon name="upload" fill="currentColor" class="w-8 h-8 text-gray-500 mb-5"/>
                                <p class="mb-2 text-sm text-gray-500 dark:text-gray-400 font-medium">{{__('Click to upload or drag')}}</p>
                                <p class="text-xs text-gray-400 dark:text-gray-400">PNG or JPG
                                    (Size. {{config('attr.poster.episode_size_x').'x'.config('attr.poster.episode_size_y')}}
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
                            <input name="image" id="dropzone-file" type="file" class="hidden" accept="image/*"
                                   x-ref="image"
                                   @change="imageViewer().fileChosen">
                            <input type="hidden" name="image_url" :value="importerData.image">
                        </label>
                    </div>
                    <input type="hidden" name="tmdb_image" :value="importerData.tmdb_image">
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
                            <x-form.switch type="checkbox" id="comment" name="comment" value="active"
                                           :checked="isset($listing) AND $listing->comment == 'active' ? true : false"/>
                            <x-form.label for="comment" class="md:mb-0 cursor-pointer font-normal"
                                          :value="__('Closed comment')"/>
                        </div>
                        <div class="flex items-center space-x-4 mt-2">
                            <x-form.switch type="checkbox" id="send_notification" name="send_notification"
                                           value="active"/>
                            <x-form.label for="send_notification" class="md:mb-0 cursor-pointer font-normal"
                                          :value="__('Send Push Notification')"/>
                        </div>
                    </div>
                    <x-form.primary class="w-full mt-5">{{__('Save change')}}</x-form.primary>

                    <x-form.secondary type="button"
                                      class="w-full mt-3"
                                      @click="importerModal = true;if (importerModal) $nextTick(()=>{$refs.tmdbInput.focus()});">{{__('Themoviedb importer')}}</x-form.secondary>
                </div>
            </form>

        @endif

            <div
                    class="fixed inset-0 z-50 flex items-center justify-center overflow-auto bg-gray-900/30 backdrop-blur-lg"
                    x-show="bulkModal" x-cloak=""
            >
                <!-- Modal inner -->
                <div
                        class="max-w-3xl w-full px-10 py-10 mx-auto text-left bg-white dark:bg-gray-900 rounded-xl"
                        @click.away="bulkModal = false" x-cloak=""
                        x-transition:enter="motion-safe:ease-out duration-300"
                        x-transition:enter-start="opacity-0 scale-90"
                        x-transition:enter-end="opacity-100 scale-100"
                >
                    <!-- Title / Close-->
                    <div class="flex items-center justify-between">

                        <button type="button" class="z-50 cursor-pointer dark:text-white text-gray-500 ml-auto"
                                @click="bulkModal = false">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>

                    <div class="mb-5">
                        <x-form.label for="overview" :value="__('Video link')"/>
                        <x-form.textarea x-model="bulkInput" placeholder="{{__('https://')}}" rows="10"></x-form.textarea>
                        <div class="text-xs text-gray-500 dark:text-gray-400 py-3">{{__('Each line contains new video link')}}</div>
                    </div>

                    <x-form.primary type="button" @click="bulkVideoField()"
                                    class="w-full">{{__('Import video')}}</x-form.primary>
                </div>
            </div>
        <div
            class="fixed inset-0 z-50 flex items-center justify-center overflow-auto bg-gray-900/30 backdrop-blur-lg"
            x-show="importerModal" x-cloak=""
        >
            <!-- Modal inner -->
            <div
                class="max-w-lg w-full px-10 py-10 mx-auto text-left bg-white dark:bg-gray-900 rounded-xl"
                @click.away="showModal = false" x-cloak=""
                x-transition:enter="motion-safe:ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-90"
                x-transition:enter-end="opacity-100 scale-100"
            >
                <!-- Title / Close-->
                <div class="flex items-center justify-between">

                    <button type="button" class="z-50 cursor-pointer dark:text-white text-gray-500 ml-auto"
                            @click="importerModal = false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                <form method="post" action="{{route('admin.tmdb.fetchepisode')}}" @submit.prevent="submitForm()"
                      id="importerForm">
                    @csrf
                    <div class="mb-5">
                        <x-form.label for="tmdb_id" :value="__('Importer')"/>
                        <div class="relative">

                            <x-form.input id="tmdb_id" class="block mt-1 w-full" type="text" name="tmdb_id"
                                          value="{{ old('tmdb_id', isset($listing->post->tmdb_id) ? $listing->post->tmdb_id : '') }}"
                                          required placeholder="{{__('Themoviedb id')}}" x-ref="tmdbInput"/>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-x-8">
                        <div class="mb-5">
                            <x-form.label for="season_number" :value="__('Season Number')"/>
                            <x-form.input id="season_number" class="block mt-1 w-full" type="text" name="season_number"
                                          value="{{ old('season_number', isset($listing) ? $listing->season->season_number : '') }}"
                                          required placeholder="{{__('Season Number')}}"/>
                        </div>
                        <div class="mb-5">
                            <x-form.label for="season_number" :value="__('Episode Number')"/>

                            <x-form.input id="episode_number" class="block mt-1 w-full" type="text"
                                          name="episode_number"
                                          value="{{ old('episode_number', isset($listing) ? $listing->episode_number : '') }}"
                                          required placeholder="{{__('Episode Number')}}"/>
                        </div>
                    </div>
                    <x-form.primary class="w-full mt-3">{{__('Import')}}</x-form.primary>
                </form>
            </div>
        </div>
    </div>
    @push('javascript')
        <script src="{{asset('static/js/jquery.js')}}" type="text/javascript"></script>
        <script src="{{asset('static/js/select.js')}}" type="text/javascript"></script>
        <script type="text/javascript">
            var seasonData = [];
            var getSeason = [];
            $('.selectize-tv').selectize({
                valueField: 'id',
                labelField: 'title',
                searchField: 'title',
                onChange: function (value) {
                    if (value) {
                        if (value) {
                            window.location.replace("{{route('admin.episode.create').'?post_id='}}" + value);
                        }
                    }
                }
            })


        </script>
        <script>

            function post() {
                return {
                    bulkModal: false,
                    importerModal: false,
                    importerSubmit: false,
                    imageUrl: '{{isset($listing) ? $listing->imageurl : ''}}',
                    importerData: {!! isset($fetch['data']) ? "JSON.parse('".addslashes(json_encode($fetch['data'], JSON_UNESCAPED_SLASHES))."')" : '[]' !!},
                    videos: {!! isset($fetch['videos']) ? "JSON.parse('".addslashes(json_encode($fetch['videos'], JSON_UNESCAPED_SLASHES))."')" : '[]' !!},
                    subtitles: {!! isset($fetch['subtitles']) ? "JSON.parse('".addslashes(json_encode($fetch['subtitles'], JSON_UNESCAPED_SLASHES))."')" : '[]' !!},
                    addVideoField() {
                        this.videos.push({
                            type: '',
                            link: ''
                        });
                    },
                    addSubField() {
                        this.subtitles.push({
                            type: '',
                            name: '',
                            description: ''
                        });
                    },
                    removeVideoField(index, videoId = null) {
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
                                success: function (response) {
                                }
                            });
                        }
                    },
                    removeSubField(index, subtitleId = null) {
                        this.subtitles.splice(index, 1);
                        if (subtitleId) {
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                                }
                            });
                            $.ajax({
                                url: '{{route('admin.'.$config['route'].'.subtitle.destroy')}}?id=' + subtitleId,
                                type: 'DELETE',
                                dataType: 'json',
                                success: function (response) {
                                }
                            });
                        }
                    },
                    submitForm() {
                        const form = document.getElementById('importerForm');
                        const postdata = new FormData(form);
                        const formurl = form.getAttribute('action');
                        const self = this;

                        return fetch(formurl, {
                            method: 'POST',
                            body: postdata
                        }).then((response) => response.json())
                            .then((json) => this.importerData = json)
                            .then(response => {

                                this.$nextTick(() => {

                                    // Modify the src value using imageViewer
                                    self.imageUrl = self.importerData.image;
                                    self.tmdb_image = self.importerData.tmdb_image;
                                    if (self.importerData.videos) {
                                        $.each(self.importerData.videos, function (index, data) {
                                            self.videos.push({
                                                type: data.type,
                                                link: data.link
                                            });
                                        });
                                    }
                                });

                                this.importerModal = false;

                            });

                    },

                    bulkInput:null,
                    bulkVideoField() {
                        const lines = this.bulkInput.split('\n');
                        lines.forEach((line) => {
                            if (line.trim() !== '') {
                                this.videos.push({
                                    label: '',
                                    type: 'embed',
                                    link: line.trim(),
                                });
                            }
                        });
                        this.bulkModal = false;
                        this.bulkInput = null;
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
