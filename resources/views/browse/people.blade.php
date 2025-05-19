@extends('layouts.app')
@section('content')

    <div class="container">
        <div class="lg:flex gap-6 xl:gap-12 py-8">
            <div class="max-w-xs w-full">
                <div
                    class="aspect-square relative rounded-md transition overflow-hidden cursor-pointer ">
                    <img src="{{$listing->imageurl}}"
                         class="absolute  h-full w-full object-cover">
                </div>
                <div class="my-4">
                    <h3 class="text-lg font-medium text-gray-700 dark:text-white mb-3">{{__('Overview')}}</h3>
                    <div class="py-2">
                        <div class="text-white text-sm font-medium">{{__('Know for')}}</div>
                        <div class="text-gray-400 text-sm">{{__('Acting')}}</div>
                    </div>
                    <div class="py-2">
                        <div class="text-white text-sm font-medium">{{__('Gender')}}</div>
                        <div class="text-gray-400 text-sm">{{$listing->gender == '2' ? __('Male') : __('Female')}}</div>
                    </div>
                    @if(!empty($listing->arguments->birth_place))
                        <div class="py-2">
                            <div class="text-white text-sm font-medium">{{__('Birth Place')}}</div>
                            <div class="text-gray-400 text-sm">{{$listing->arguments->birth_place}}</div>
                        </div>
                    @endif
                    @if(!empty($listing->birthday))
                        <div class="py-2">
                            <div class="text-white text-sm font-medium">{{__('Birthday')}}</div>
                            <div
                                class="text-gray-400 text-sm">{{$listing->birthday->translatedFormat('d M, Y').' ('.__(':age years old',['age' => $listing->birthday->diffInYears()]).')'}}</div>
                        </div>
                    @endif
                    @if(!empty($listing->death_date))
                        <div class="py-2">
                            <div class="text-white text-sm font-medium">{{__('Death date')}}</div>
                            <div
                                class="text-gray-400 text-sm">{{$listing->death_date->translatedFormat('d M, Y')}}</div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="flex-1">
                <h1 class="text-2xl font-semibold text-white mb-4">{{$listing->name}}</h1>
                @if(!empty($listing->bio))
                <h3 class="text-lg font-medium text-gray-700 dark:text-white mb-3">{{__('Biography')}}</h3>
                <div x-data="{ open: false, maxLength: 500, fullText: '', slicedText: '' }"
                     x-init="fullText = $el.firstElementChild.textContent.trim(); slicedText = fullText.slice(0, maxLength)">
                    <p x-text="open ? fullText : slicedText" x-transition
                       class="text-gray-300 mt-3 leading-7">{{$listing->bio}}</p>

                    <button class="text-gray-400/70 text-sm hover:underline" @click="open = ! open"
                            x-text="open ? '{{__('Show less')}}' : '{{__('Show more')}}'"></button>
                </div>
                @endif
                <div class="my-6">
                    <h3 class="text-lg font-medium text-gray-700 dark:text-white mb-5">{{__('Known For')}}</h3>

                    <div class="grid grid-cols-2 lg:grid-cols-6 gap-6">
                        @foreach($listing->posts->slice(0, 6) as $people)
                            <x-ui.post :listing="$people"/>
                        @endforeach
                    </div>
                </div>
                <div class="my-6">
                    <h3 class="text-lg font-medium text-gray-700 dark:text-white mb-4">{{__('Acting')}}</h3>
                    <div class="bg-gray-900 rounded-lg px-6 py-3 divide-y divide-gray-800/30">
                        @foreach($listing->posts as $post)
                        <a href="{{route($post->type,$post->slug)}}" class="flex group flex-wrap gap-x-6 items-center py-3">
                            <div class="w-20 text-gray-400 text-sm">{{$post->release_date->translatedFormat('Y')}}</div>
                            <div class="w-4 h-4 rounded-full border-gray-600 border-2"></div>
                            <div class="flex-1">
                                <div class="text-gray-200 group-hover:underline text-sm font-medium">{{$post->title}}</div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
