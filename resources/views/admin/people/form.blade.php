@extends('layouts.admin')
@section('content')

    <form method="POST" enctype="multipart/form-data">
        @csrf
        <div class="lg:flex flex-1 flex-row h-full">
            <div class="max-w-6xl w-full mx-auto">
                <div class="mb-5">
                    <x-form.label for="name" :value="__('Name')"/>
                    <x-form.input id="name" class="block mt-1 w-full" type="text" name="name"
                                  value="{{ old('title', isset($listing) ? $listing->name : '') }}"
                                  required placeholder="{{__('Name')}}"/>
                    <x-form.error :messages="$errors->get('name')" class="mt-2"/>
                    <div class="flex items-center text-xs mt-2">
                        <span class="font-medium text-gray-500 mr-2">Permalink</span>
                        <span class="text-gray-500">{{url('/').'/'}}</span>
                        <input type="text" name="slug"
                               class="font-medium border-0 py-0 text-xs px-1 inline-flex text-primary-500 bg-transparent focus:ring-0 w-auto placeholder-gray-300 dark:placeholder-gray-500"
                               placeholder="slug"
                               value="{{ old('slug', isset($listing) ? $listing->slug : '') }}">
                    </div>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-x-8">
                    <div class="mb-5 col-span-4">
                        <x-form.label for="gender" :value="__('Gender')"/>
                        <x-form.select name="gender" id="gender">
                            <option>{{__('Choose')}}</option>
                            @foreach(config('attr.gender') as $key => $value)
                                <option value="{{$key}}" @if(isset($listing->gender) AND $listing->gender == $key) selected @endif>{{__($value)}}</option>
                            @endforeach
                        </x-form.select>
                        <x-form.error :messages="$errors->get('release_date')" class="mt-2"/>
                    </div>
                    <div class="mb-5 col-span-4">
                        <x-form.label for="birthday" :value="__('Birthday')"/>
                        <x-form.input id="birthday" class="block mt-1 w-full" type="date" name="birthday"
                                      value="{{ old('birthday', isset($listing) ? $listing->birthday->format('Y-m-d') : '') }}"
                                      placeholder="{{__('birthday')}}"/>
                        <x-form.error :messages="$errors->get('birthday')" class="mt-2"/>
                    </div>
                    <div class="mb-5 col-span-4">
                        <x-form.label for="death_date" :value="__('Death Date')"/>
                        <x-form.input id="death_date" class="block mt-1 w-full" type="date" name="death_date"
                                      value="{{ old('death_date', isset($listing->death_date) ? $listing->death_date->format('Y-m-d') : '') }}"
                                      placeholder="{{__('death_date')}}"/>
                        <x-form.error :messages="$errors->get('death_date')" class="mt-2"/>
                    </div>
                </div>
                <div class="mb-5">
                    <x-form.label for="birth_place" :value="__('Birth Place')"/>
                    <x-form.input id="birth_place" class="block mt-1 w-full" type="text" name="arguments[birth_place]"
                                  value="{{ old('birth_place', isset($listing->arguments->birth_place) ? $listing->arguments->birth_place : '') }}"
                                  placeholder="{{__('Birth Place')}}"/>
                    <x-form.error :messages="$errors->get('birth_place')" class="mt-2"/>
                </div>
                <div class="mb-5">
                    <x-form.label for="bio" :value="__('Biography')"/>
                    <x-form.textarea name="bio" placeholder="{{__('Biography')}}" rows="4">{{ old('bio', isset($listing) ? $listing->bio : '') }}</x-form.textarea>
                    <x-form.error :messages="$errors->get('bio')" class="mt-2"/>
                </div>
                <hr class="my-6 border-gray-100 dark:border-gray-800">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-x-8">
                    <div class="mb-5">
                        <x-form.label for="tmdb_id" :value="__('Themoviedb ID')"/>
                        <x-form.input id="tmdb_id" class="block mt-1 w-full" type="text" name="tmdb_id"
                                      value="{{ old('tmdb_id', isset($listing) ? $listing->tmdb_id : '') }}"
                                      placeholder="{{__('Themoviedb ID')}}"/>
                        <x-form.error :messages="$errors->get('tmdb_id')" class="mt-2"/>
                    </div>
                    <div class="mb-5">
                        <x-form.label for="imdb_id" :value="__('Imdb ID')"/>
                        <x-form.input id="imdb_id" class="block mt-1 w-full" type="text" name="imdb_id"
                                      value="{{ old('imdb_id', isset($listing) ? $listing->imdb_id : '') }}"
                                      placeholder="{{__('Imdb ID')}}"/>
                        <x-form.error :messages="$errors->get('imdb_id')" class="mt-2"/>
                    </div>
                </div>
            </div>
            <div class="max-w-xs w-full">

                <div class="flex items-center justify-center w-full mb-5"
                     x-data="imageViewer('{{isset($listing->image) ? $listing->imageurl : ''}}')">
                    <label for="dropzone-file"
                           class="flex flex-col items-center justify-center w-full aspect-square border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-white dark:hover:bg-gray-700/50 dark:bg-gray-800 hover:bg-gray-50 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600 relative">

                        <div class="flex flex-col items-center justify-center pt-5 pb-6 relative">
                            <x-ui.icon name="upload" fill="currentColor" class="w-10 h-10 text-gray-500 mb-7"/>
                            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400 font-medium">{{__('Click to upload or drag')}}</p>
                            <p class="text-xs text-gray-400 dark:text-gray-400">PNG, JPG
                                (MAX. {{config('attr.people.size_x').'x'.config('attr.people.size_y')}})</p>
                        </div>
                        <template x-if="imageUrl">
                            <img :src="imageUrl"
                                 class="object-cover w-full aspect-square absolute inset-0 rounded-lg"
                            >
                        </template>
                        <template x-if="!imageUrl">
                            <div
                                class="object-cover w-full aspect-square absolute inset-0 rounded-lg"
                            ></div>
                        </template>
                        <input name="image" id="dropzone-file" type="file" class="hidden" accept="image/*"
                               @change="fileChosen">
                    </label>
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

        </script>
    @endpush
@endsection
