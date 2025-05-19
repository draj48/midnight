@extends('layouts.admin')
@section('content')
    <div x-data="post()">
        <form method="post" class="flex space-x-8 2xl:space-x-16" enctype="multipart/form-data">
            <div class="max-w-[90rem] mx-auto w-full" x-data="{ nav: 'overview'}">
                @csrf
                <div class="border-b pb-3 border-gray-100 dark:border-gray-800">
                    <ul class="flex gap-x-4 whitespace-nowrap overflow-x-auto sm:overflow-x-visible sm:p-2 lg:p-0">
                        @if(count($tabs) > 0 )
                            @foreach($tabs as $key => $value)
                                <li class="@if(($config['nav'] == 'movie' AND $key == 'subtitle') OR ($config['nav'] == 'tv' AND $key == 'advanced')){{'ml-0 lg:ml-auto'}}@endif">
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
                                @include('admin.post.partials.'.$key)
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
            <div class="max-w-xs w-full">

                <div class="flex items-center justify-center w-full mb-5">
                    <label for="image-file"
                           class="flex flex-col items-center justify-center w-full aspect-[2/3] border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-white dark:hover:bg-gray-700/50 dark:bg-gray-900 hover:bg-gray-50 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600 relative">

                        <div class="flex flex-col items-center justify-center pt-5 pb-6 relative">
                            <x-ui.icon name="upload" fill="currentColor" class="w-8 h-8 text-gray-500 mb-5"/>
                            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400 font-medium">{{__('Click to upload or drag')}}</p>
                            <p class="text-xs text-gray-400 dark:text-gray-400">PNG or JPG (MAX. {{config('attr.poster.size_x').'x'.config('attr.poster.size_y')}})</p>
                        </div>
                        <!-- Show the image -->
                        <template x-if="imageUrl">
                            <img :src="imageUrl"
                                 class="object-cover w-full aspect-[2/3] absolute inset-0 rounded-lg"
                            >
                        </template>

                        <!-- Show the gray box when image is not available -->
                        <template x-if="!imageUrl">
                            <div
                                class="object-cover w-full aspect-[2/3] absolute inset-0 rounded-lg"
                            ></div>
                        </template>
                        <input name="image" id="image-file" type="file" class="hidden" accept="image/*" x-ref="image"
                               @change="imageViewer().fileChosen">
                    </label>
                    <input type="hidden" name="image_url" :value="importerData.image">
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
                        <x-form.switch type="checkbox" id="slider" name="slider" value="active"
                                       :checked="isset($listing) AND $listing->slider == 'active' ? true : false"/>
                        <x-form.label for="slider" class="md:mb-0 cursor-pointer font-normal"
                                      :value="__('Show slider')"/>
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
                    <div class="flex items-center space-x-4 mt-2">
                        <x-form.switch type="checkbox" id="send_notification" name="send_notification" value="active"/>
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
                @click.away="importerModal = false" x-cloak=""
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
                <form method="post" action="{{route('admin.tmdb.fetchsingle')}}" @submit.prevent="submitForm()"
                      id="importerForm">
                    @csrf
                    <input type="hidden" name="type" value="{{$config['nav'] == 'tv' ? 'tv' : 'movie'}}">
                    <div class="mb-5">
                        <x-form.label for="tmdb_id" :value="__('Themoviedb ID')"/>
                        <div class="relative">
                            <x-form.input id="tmdb_id" class="block mt-1 w-full" type="text" name="tmdb_id"
                                          value="{{ old('tmdb_id', isset($listing) ? $listing->tmdb_id : Request::get('tmdb_id')) }}"
                                          required placeholder="{{__('Themoviedb id')}}" x-ref="tmdbInput"/>
                        </div>
                    </div>
                    <div class="mb-5">
                        <x-form.label for="advanced" :value="__('Advanced')"/>
                        <div class="flex items-center space-x-4 mt-2">
                            <x-form.switch type="checkbox" id="import_people" name="import_people" value="enable" :checked="config('settings.tmdb_people_limit') > 0 ? true : false"/>
                            <x-form.label for="import_people" class="md:mb-0 cursor-pointer font-normal"
                                          :value="__('Import people')"/>
                        </div>
                        @if($config['nav'] == 'tv')
                        <div class="flex items-center space-x-4 mt-2">
                            <x-form.switch type="checkbox" id="import_season" name="import_season" value="active" :checked="config('settings.import_season') == 'active' ? true : false"/>
                            <x-form.label for="import_season" class="md:mb-0 cursor-pointer font-normal"
                                          :value="__('Import season')"/>
                        </div>
                        <div class="flex items-center space-x-4 mt-2">
                            <x-form.switch type="checkbox" id="import_episode" name="import_episode" value="active" :checked="config('settings.import_episode') == 'active' ? true : false"/>
                            <x-form.label for="import_episode" class="md:mb-0 cursor-pointer font-normal"
                                          :value="__('Import episode')"/>
                        </div>
                            @endif
                    </div>
                    <x-form.primary class="w-full mt-3">{{__('Import')}}</x-form.primary>
                </form>
            </div>
        </div>
    </div>
    @push('javascript')
        <script src="{{asset('static/js/jquery.js')}}" type="text/javascript"></script>
        <script src="{{asset('static/js/select.js')}}" type="text/javascript"></script>
        <script>
            $('.selectpicker').selectize({maxItems: 5, create: false})

            function post() {
                return {
                    init() {


                        var self = this;
                        $('.selectize-people').selectize({
                            valueField: 'id',
                            labelField: 'name',
                            searchField: 'name',
                            options: [],
                            maxItems: 1,
                            render: {
                                option: function (item, escape) {

                                    return '<div class="flex items-center space-x-8 px-3 py-1">' +
                                        '<div class="aspect-square w-12 bg-cover rounded-md" style="background-image:url(' + escape(item.image) + '"></div>' +
                                        '<div>' +
                                        (item.name ? '<div class="text-sm font-medium">' + escape(item.name) + '</div>' : '') +
                                        (item.id ? '<div class="text-gray-400 text-xs">' + escape(item.id) + '</div>' : '') +
                                        '</div>' +
                                        '</div>';
                                }
                            },
                            load: function (query, callback) {
                                if (!query.length) return callback();
                                $.ajax({
                                    url: '{{route('admin.people.search')}}?q=' + encodeURIComponent(query),
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

                                    if (value != "" && !self.hasPeople(value)) {
                                        $.ajax({
                                            url: '{{route('admin.people.first')}}?id=' + value,
                                            type: 'GET',
                                            dataType: 'json',
                                            success: function(resp) {

                                                self.peoples.push({
                                                    id: resp.id,
                                                    image: resp.image,
                                                    name: resp.name
                                                });
                                                $('.selectize-people')[0].selectize.clear();
                                            }
                                        });
                                    }
                                }
                            }
                        })
@if(Request::get('tmdb_id'))
                        this.submitForm();
                        @endif
                    },
                    bulkModal: false,
                    importerModal: false,
                    importerSubmit: false,
                    imageUrl: '{{isset($listing->imageurl) ? $listing->imageurl : ''}}',
                    importerData: {!! isset($fetch['data']) ? "JSON.parse('".addslashes(json_encode($fetch['data'], JSON_UNESCAPED_SLASHES))."')" : '[]' !!},
                    peoples: {!! isset($fetch['peoples']) ? "JSON.parse('".addslashes(json_encode($fetch['peoples'], JSON_UNESCAPED_SLASHES))."')" : '[]' !!},
                    tags: {!! isset($listing->tags) ? "JSON.parse('".addslashes($listing->tags)."')" : '[]' !!},
                    videos: {!! isset($fetch['videos']) ? "JSON.parse('".addslashes(json_encode($fetch['videos'], JSON_UNESCAPED_SLASHES))."')" : '[]' !!},
                    subtitles: {!! isset($fetch['subtitles']) ? "JSON.parse('".addslashes(json_encode($fetch['subtitles'], JSON_UNESCAPED_SLASHES))."')" : '[]' !!},
                    seasons: {!! isset($fetch['seasons']) ? "JSON.parse('".addslashes(json_encode($fetch['seasons'], JSON_UNESCAPED_SLASHES))."')" : '[]' !!},
                    addVideoField() {
                        this.videos.push({
                            label: '',
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
                    addSeasonField() {
                        this.seasons.push({
                            name: '',
                            season_number: ''
                        });
                    },
                    @if($config['nav'] == 'movie')
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
                    removeSubField(index,subtitleId = null) {
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
                                success: function(response) {
                                }
                            });
                        }
                    },
                    @endif
                    @if($config['nav'] == 'tv')
                    removeSeasonField(index,seasonId = null) {
                        this.seasons.splice(index, 1);
                        if (seasonId) {
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                                }
                            });
                            $.ajax({
                                url: '{{route('admin.'.$config['route'].'.season.destroy')}}?id=' + seasonId,
                                type: 'DELETE',
                                dataType: 'json',
                                success: function(response) {
                                }
                            });
                        }
                    },
                    @endif
                    hasPeople(people) {
                        var people = this.peoples.find(e => {
                            return e.id === people
                        })
                        return people != undefined
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

                                    const selectize = $('.selectpicker')[0].selectize;
                                    $.each(this.importerData.genres, function (index, data) {
                                        selectize.addItem(data.current_id);
                                    });
                                    // Modify the src value using imageViewer
                                    self.tagline = self.importerData.tagline;
                                    self.imageUrl = self.importerData.image;
                                    self.coverUrl = self.importerData.cover;
                                    self.storyUrl = self.importerData.story;
                                    self.slideUrl = self.importerData.slide;
                                    self.tags = self.importerData.tags;
                                    if(self.importerData.peoples) {
                                        self.peoples = self.importerData.peoples;
                                    }
                                    if(self.importerData.seasons) {
                                        self.seasons = self.importerData.seasons;
                                    }
                                    if(self.importerData.videos) {
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
                    },
                    removePeople(index) {
                        this.peoples.splice(index, 1)

                        this.$el.dispatchEvent(new CustomEvent('peoples-update', {
                            detail: {peoples: this.peoples},
                            bubbles: true,
                        }));
                    },
                    tagSelect() {
                        return {
                            open: false,
                            textInput: '',
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
                }
            }

        </script>
    @endpush
@endsection
