@extends('layouts.app')
@section('content')
    <div class="container max-w-[100rem] py-3" x-data="{threadOpen:false}">
        <div class="flex flex-wrap gap-x-6 lg:gap-x-10">
            <div class="flex-1">
                <div class="mb-5">
                    <h1 class="text-2xl lg:text-3xl font-semibold dark:text-white">{{$listing->title}}</h1>
                    <div
                        class="flex items-center text-gray-400 dark:text-gray-400 text-xs mt-2 space-x-4">
                        @if($listing->user->username)
                            <a href="{{route('profile',$listing->user->username)}}"
                               class="text-gray-300 hover:underline">{{$listing->user->username}}</a>
                        @endif
                        <div
                            class="hidden lg:block">{{__('Published on, :date',['date' => $listing->created_at->diffForHumans()])}}</div>
                        @if($listing->comment_count)
                            <div
                                class="bg-gray-500/50 backdrop-blur-lg text-gray-200 text-xxs font-semibold tracking-wide py-0.5 px-1.5 rounded">{{$listing->comment_count}}</div>
                        @endif
                    </div>
                    <p class="text-gray-400 mt-3">{{$listing->description}}</p>

                    @if($listing->post_id)

                            <a href="{{route($listing->post->type,$listing->post->slug)}}"
                               class="flex items-center py-5 gap-x-6 group">

                                <div class="w-16 aspect-poster relative overflow-hidden bg-gray-800 rounded-md">
                                    {!! picture($listing->post->imageurl,config('attr.poster.size_x').','.config('attr.poster.size_y'),'absolute h-full w-full object-cover',$listing->title,'post') !!}
                                </div>
                                <div class="flex-fill">
                                    <h3 class="text-gray-300 text-lg group-hover:underline font-medium">{{$listing->post->title}}</h3>

                                    <div class="flex items-center text-sm text-gray-800 dark:text-gray-400 gap-6 mt-3">

                                        <div
                                            class="flex relative w-9 h-9 items-center justify-center text-white ">
                                            <span class="text-xs">{{$listing->post->vote_average}}</span>
                                            <svg x="0px" y="0px" viewBox="0 0 36 36"
                                                 class="absolute -inset-0 text-amber-400 bg-amber-400/20 w-9 h-9 rounded-full">
                                                <circle fill="none" stroke="currentColor" stroke-width="3" cx="18" cy="18" r="16"
                                                        stroke-dasharray="{{round($listing->post->vote_average / 10 * 100)}} 100"
                                                        stroke-linecap="round" stroke-dashoffset="0"
                                                        transform="rotate(-90 18 18)"></circle>
                                            </svg>
                                        </div>

                                        @if($listing->post->runtime)
                                            <span>{{$listing->post->runtime.' '.__('min')}}</span>
                                        @endif
                                        <div
                                            class="text-xxs bg-gray-800 inline-flex rounded py-0.5 px-1.5 text-gray-300">{{$listing->type == 'movie' ? __('Movie') : __('TV Show')}}</div>
                                        @if($listing->post->release_date)
                                            <div class="font-medium text-gray-800 dark:text-gray-400">
                                                {{$listing->post->release_date->translatedFormat('Y')}}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </a>
                    @endif
                    <div class="my-6">
                        <livewire:comments :model="$listing"/>
                    </div>
                </div>
            </div>
            <div class="max-w-xs w-full">
                <div class="aspect-square bg-gray-800 rounded-lg"></div>
                <div class="my-5">
                    <div class="text-xs uppercase text-gray-600 font-bold mb-4">New Discussions</div>
                    <ul class="space-y-3">
                        @foreach($newests as $newest)
                            <li>
                                <div
                                    class="flex items-center text-gray-400 dark:text-gray-400 text-xs mt-1 space-x-4">
                                    @if($listing->user->username)
                                        <a href="{{route('profile',$listing->user->username)}}"
                                           class="text-primary-500 hover:underline">{{$listing->user->username}}</a>
                                    @endif
                                </div>
                                <h3 class="text-sm mb-2">
                                    <a class="text-gray-300 font-medium hover:text-white hover:underline transition duration-150 ease-in-out"
                                       href="post.html">Search Startup Jobs - Week 5 - Build in Public - Slow Week</a>
                                </h3>
                                <div
                                    class="flex items-center text-gray-400 dark:text-gray-400 text-xs mt-1 space-x-4">
                                    <div
                                        class="hidden lg:block">{{__('Published on, :date',['date' => $listing->created_at->diffForHumans()])}}</div>
                                    @if($listing->comment_count)
                                        <div
                                            class="bg-gray-500/50 backdrop-blur-lg text-gray-200 text-xxs font-semibold tracking-wide py-0.5 px-1.5 rounded">{{$listing->comment_count}}</div>
                                    @endif
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
