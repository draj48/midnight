@extends('layouts.app')
@section('content')

    <div class="pb-6 lg:pb-16">
        @include('user.partials.header')
        <div class="custom-container">
            <div class="flex space-x-8">
                <div class="flex-1">
                    <h3 class="text-xl font-medium text-gray-700 dark:text-white mb-5">{{__('Activity')}}</h3>
                    <div
                        class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3">
                        @foreach($result['log'] as $item)
                            @if(isset($item->postable->type) AND $item->postable->type == 'movie' OR $item->postable->type == 'tv')
                                <a class="text-sm flex items-center gap-x-8 text-gray-600 decoration-2 group dark:text-gray-500 mb-5"
                                   href="{{route($item->postable->type,$item->postable->slug)}}">
                                    <div class="w-24 aspect-square overflow-hidden relative rounded-md">
                                        <img src="{{$item->postable->storyurl}}"
                                             class="absolute h-full w-full object-cover">
                                    </div>
                                    <div class="flex-1 dark:text-gray-200">
                                        <h3 class="text-base tracking-tighter font-medium text-gray-300 line-clamp-2 group-hover:underline">{{$item->postable->title}}</h3>
                                        <div class="text-xs text-white/50 space-x-3 mt-3 flex items-center">

                                            <div
                                                class="text-xxs bg-gray-800 rounded py-0.5 px-1.5 text-gray-300">{{$item->postable->type == 'movie' ? __('Movie') : __('TV Show')}}</div>

                                        </div>
                                    </div>
                                </a>
                            @else

                                <a class="text-sm flex items-center gap-x-8 text-gray-600 decoration-2 group dark:text-gray-500 mb-5"
                                   href="{{route('episode',['slug'=>$item->postable->post->slug,'season'=>$item->postable->season->season_number,'episode'=>$item->postable->episode_number])}}">
                                    <div class="w-24 aspect-square overflow-hidden relative rounded-md">
                                        <img src="{{$item->postable->post->storyurl}}"
                                             class="absolute h-full w-full object-cover">
                                    </div>
                                    <div class="flex-1 dark:text-gray-200">
                                        <div
                                            class="text-xs text-gray-400 before:content-['#']">{{__(':number Season',['number'=>$item->postable->season_number]).' '.__(':number Episode',['number'=>$item->postable->episode_number])}}</div>
                                        <h3 class="text-base tracking-tighter font-medium text-gray-300 line-clamp-2 group-hover:underline">{{$item->postable->post->title}}</h3>
                                        <div class="text-xs text-white/50 space-x-3 mt-3 flex items-center">
                                            <div
                                                class="text-xxs bg-gray-800 rounded py-0.5 px-1.5 text-gray-300">{{__('Episode')}}</div>
                                        </div>
                                    </div>
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>

                <div class="max-w-sm w-full">
                    <div
                        class="bg-white border border-gray-200 dark:border-gray-900 shadow-sm dark:bg-gray-800 p-8 rounded-xl mb-4">
                        <h3 class=" font-medium text-gray-700 dark:text-white mb-5">{{__('Overview')}}</h3>

                        <hr class="my-4 lg:my-6 border-gray-100 dark:border-gray-700/50">
                        <div class="flex items-center mb-5 space-x-8">
                            <div class="flex-1">
                                <div
                                    class="text-xs text-gray-500 dark:text-gray-400">{{__('Content watched')}}</div>
                                <div class="text-base font-medium text-gray-700 dark:text-gray-100">{{(int)$listing->log_count}}</div>
                            </div>
                        </div>
                        <div class="flex items-center mb-5 space-x-8">
                            <div class="flex-1">
                                <div
                                    class="text-xs text-gray-500 dark:text-gray-400">{{__('Member for')}}</div>
                                <div class="text-sm text-gray-700 dark:text-gray-100">{{$listing->created_at->diffForHumans()}}</div>
                            </div>
                        </div>
                        <div class="flex items-center space-x-8">
                            <div class="flex-1">
                                <div
                                    class="text-xs text-gray-500 dark:text-gray-400">{{__('Content liked')}}</div>
                                <div class="text-base font-medium text-gray-700 dark:text-gray-100">{{(int)$listing->like_count}}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
