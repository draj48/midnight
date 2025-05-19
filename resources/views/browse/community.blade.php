@extends('layouts.app')
@section('content')
    <div class="container py-3">
        <div class="mb-5">

            <h1 class="text-2xl font-semibold dark:text-white">{{$config['heading']}}</h1>
        </div>
        <div class="flex flex-wrap gap-x-6 lg:gap-x-10">
            <div class="flex-1">
                <div class="space-y-3">
                    @foreach($listings as $listing)
                        <!-- Item -->
                        <div
                            class="">
                            <div class="relative flex py-4x pxx-6 gap-x-6">
                                <div class="">

                                    <img
                                        class="w-10 h-10 rounded-full"
                                        src="{{$listing->user->avatarurl}}"
                                        alt="{{$listing->user->name}}">
                                </div>
                                <div class="flex-1">
                                    @if($listing->post_id)
                                        <div
                                            class="text-sm tracking-tighter font-medium text-amber-400 line-clamp-1 before:content-['#']">
                                            <a href="{{route($listing->post->type,$listing->post->slug)}}"
                                               class="hover:underline">{{$listing->post->title}}</a></div>
                                    @endif
                                    <h3 class="text-gray-100 line-clamp-1 font-medium"><a href="{{route('thread',$listing->slug)}}" class="hover:underline">{{$listing->title}}</a></h3>
                                    <div
                                        class="flex items-center text-gray-400 dark:text-gray-400 text-xs mt-1 space-x-4">
                                        @if($listing->user->username)
                                            <a href="{{route('profile',$listing->user->username)}}"
                                               class="text-gray-300 hover:underline">{{$listing->user->username}}</a>
                                        @endif
                                        <div
                                            class="hidden lg:block">{{__('Published on, :date',['date' => $listing->created_at->diffForHumans()])}}</div>
                                        @if($listing->comment_count)
                                            <div
                                                class="hidden lg:block">{{__(':total comment',['total' => $listing->comment_count])}}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="max-w-xs w-full">
                <div class="aspect-square bg-gray-800 rounded-lg"></div>
                <div class="my-5">
                    <div class="text-xs uppercase text-gray-500 font-bold mb-4">New Thread</div>
                    <ul class="space-y-3">
                        @foreach($listings as $listing)
                        <li>
                            <div
                                class="flex items-center text-gray-400 dark:text-gray-400 text-xs mt-1 space-x-4">
                                @if($listing->user->username)
                                    <a href="{{route('profile',$listing->user->username)}}"
                                       class="text-primary-500 hover:underline">{{$listing->user->username}}</a>
                                @endif
                            </div>
                            <h3 class="text-base mb-2">
                                <a class="text-gray-300 font-medium hover:text-white hover:underline transition duration-150 ease-in-out" href="post.html">Search Startup Jobs - Week 5 - Build in Public - Slow Week</a>
                            </h3>
                            <div
                                class="flex items-center text-gray-400 dark:text-gray-400 text-xs mt-1 space-x-4">
                                <div
                                    class="hidden lg:block">{{__('Published on, :date',['date' => $listing->created_at->diffForHumans()])}}</div>
                                @if($listing->comment_count)
                                    <div
                                        class="hidden lg:block">{{__(':total comment',['total' => $listing->comment_count])}}</div>
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
