@extends('layouts.admin')
@section('content')
    <div class="max-w-xl mx-auto w-full">
        <div class="flex items-center space-x-8 font-medium text-gray-600 decoration-2 dark:text-gray-500 mb-5">
            <div class="w-12 aspect-poster overflow-hidden relative rounded-md">
                <img src="{{$listing->commentable->imageurl}}" class="absolute h-full w-full object-cover">
            </div>
            <div class="flex-1">

                @if($listing->commentable_type == 'App\Models\Post')
                    <div class="font-medium group-hover:underline mb-2">{{$listing->commentable->title}}</div>
                @elseif($listing->commentable_type == 'App\Models\PostEpisode')
                    <div class="font-medium group-hover:underline mb-2">{{$listing->commentable->post->title}}<span class="text-primary-500 ml-3">{{'S'.$listing->commentable->season_number.' / E'.$listing->commentable->episode_number}}</span></div>
                @endif
            </div>
        </div>

            <hr class="my-6 lg:my-10 border-gray-100 dark:border-gray-800">
            <form method="post">
                @csrf
                <div class="mb-5">
                    <x-form.label for="comment" :value="__('Comment')"/>
                    <x-form.textarea id="comment" name="body">{{$listing->body}}</x-form.textarea>
                </div>
                <div class="mb-5">
                    <x-form.label for="status" :value="__('Status')"/>
                    <x-form.select name="status" required>
                        <option
                            value="publish" @if(isset($listing->status) AND $listing->status == 'publish')
                            {{'selected'}}
                            @endif>{{__('Publish')}}</option>
                        <option
                            value="draft" @if(isset($listing->status) AND $listing->status == 'draft')
                            {{'selected'}}
                            @endif>{{__('Draft')}}</option>
                    </x-form.select>
                    <x-form.error :messages="$errors->get('status')" class="mt-2"/>
                </div>
                <x-form.primary class="w-full">{{__('Save change')}}</x-form.primary>
            </form>
    </div>
@endsection
