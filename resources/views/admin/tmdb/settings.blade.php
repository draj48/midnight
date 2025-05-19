@extends('layouts.admin')
@section('content')

    <div class="max-w-2xl mx-auto w-full">
        <form method="POST">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-x-8 py-8 first:pt-0 last:pb-0">
                <div class="col-span-full">
                    <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-5">
                        {{__('Themoviedb Config')}}
                    </h2>
                </div>
                <div class="col-span-full">
                    <div class="mb-5">
                        <x-form.label for="tmdb_api" :value="__('Themoviedb Api Key')"/>
                        <x-form.input id="tmdb_api" name="tmdb_api" type="text" class="mt-1 block w-full"
                                      value="{{ old('tmdb_api', config('settings.tmdb_api')) }}"
                                      placeholder="{{__('Themoviedb Api Key')}}"/>

                        <x-form.error class="mt-2" :messages="$errors->get('tmdb_api')"/>
                    </div>
                </div>
                <div class="mb-5">
                    <x-form.label for="tmdb_language" :value="__('Themoviedb Language')"/>
                    <x-form.input id="tmdb_language" name="tmdb_language" type="text" class="mt-1 block w-full"
                                  value="{{ old('tmdb_language', config('settings.tmdb_language')) }}"
                                  placeholder="{{__('Themoviedb Language')}}"/>
                    <x-form.error class="mt-2" :messages="$errors->get('tmdb_language')"/>
                </div>

                <div class="mb-5">
                    <x-form.label for="tmdb_people_limit" :value="__('Themoviedb People limit')"/>
                    <x-form.input id="tmdb_people_limit" name="tmdb_people_limit" type="text" class="mt-1 block w-full"
                                  value="{{ old('tmdb_people_limit', config('settings.tmdb_people_limit')) }}"
                                  placeholder="{{__('Themoviedb People limit')}}"/>
                    <x-form.error class="mt-2" :messages="$errors->get('tmdb_people_limit')"/>
                </div>
                <div class="col-span-full">
                    <div class="mb-5">
                        <x-form.label for="advanced" :value="__('Advanced')"/>
                        <div class="flex items-center space-x-4 mt-2">
                            <x-form.switch type="checkbox" id="draft_post" name="draft_post" value="active"
                                           :checked="config('settings.draft_post') == 'active' ? true : false"/>
                            <x-form.label for="draft_post" class="md:mb-0 cursor-pointer font-normal"
                                          :value="__('Save additions as drafts')"/>
                        </div>
                        <div class="flex items-center space-x-4 mt-2">
                            <x-form.switch type="checkbox" id="tmdb_image" name="tmdb_image" value="active"
                                           :checked="config('settings.tmdb_image') == 'active' ? true : false"/>
                            <x-form.label for="tmdb_image" class="md:mb-0 cursor-pointer font-normal"
                                          :value="__('Use themoviedb image')"/>
                        </div>
                        <div class="flex items-center space-x-4 mt-2">
                            <x-form.switch type="checkbox" id="vidsrc" name="vidsrc" value="active"
                                           :checked="config('settings.vidsrc') == 'active' ? true : false"/>
                            <x-form.label for="vidsrc" class="md:mb-0 cursor-pointer font-normal"
                                          :value="__('Import video (vidsrc.me)')"/>
                        </div>
                        <div class="flex items-center space-x-4 mt-2">
                            <x-form.switch type="checkbox" id="add_season" name="import_season" value="active"
                                           :checked="config('settings.import_season') == 'active' ? true : false"/>
                            <x-form.label for="add_season" class="md:mb-0 cursor-pointer font-normal"
                                          :value="__('Import season')"/>
                        </div>
                        <div class="flex items-center space-x-4 mt-2">
                            <x-form.switch type="checkbox" id="add_episode" name="import_episode" value="active"
                                           :checked="config('settings.import_episode') == 'active' ? true : false"/>
                            <x-form.label for="add_episode" class="md:mb-0 cursor-pointer font-normal"
                                          :value="__('Import episode')"/>
                        </div>
                    </div>
                </div>
                <div class="col-span-full">

                    <x-form.primary class="w-full">{{__('Save change')}}</x-form.primary>
                </div>
            </div>
        </form>
    </div>
@endsection
