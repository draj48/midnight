@extends('layouts.app')
@section('content')
    <div class="container max-w-[100rem] py-3" x-data="{threadOpen:false}">
        <div class="flex flex-wrap gap-x-6 lg:gap-x-10">
            <div class="flex-1">
                <div class="flex items-center gap-6 mb-6">

                    <h1 class="text-2xl font-semibold dark:text-white flex-1" class="!rounded-full">{{$config['heading']}}</h1>
                    @auth()
                        <x-form.primary @click="threadOpen = true;" size="sm">
                            <x-ui.icon name="add" class="w-5 h-5" stroke="currentColor" stroke-width="1.75"/>
                            <span class="hidden lg:block">{{__('Create discussion')}}</span>
                        </x-form.primary>
                    @else
                        <x-form.primary href="{{route('login')}}" size="sm" class="!rounded-full">
                            <x-ui.icon name="add" class="w-5 h-5" stroke="currentColor" stroke-width="1.75"/>
                            <span class="hidden lg:block">{{__('Create discussion')}}</span>
                        </x-form.primary>
                    @endauth
                </div>
                <div class="space-y-3">
                    @foreach($listings as $listing)
                        <!-- Item -->
                        <div
                            class="">
                            <div class="relative flex py-4x pxx-6 gap-x-6">
                                <div class="">
                                    {!! gravatar($listing->user->name,$listing->user->avatarurl,'h-10 w-10 rounded-full bg-gray-800 text-xs font-bold flex items-center justify-center text-white') !!}
                                </div>
                                <div class="flex-1">
                                    @if($listing->post_id)
                                        <div
                                            class="text-sm tracking-tighter font-medium text-amber-400 line-clamp-1 before:content-['#']">
                                            <a href="{{route($listing->post->type,$listing->post->slug)}}"
                                               class="hover:underline">{{$listing->post->title}}</a></div>
                                    @endif
                                    <h3 class="text-gray-100 line-clamp-1 font-medium"><a
                                            href="{{route('discussion',$listing->slug)}}"
                                            class="hover:underline">{{$listing->title}}</a></h3>
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
                                    <a class="text-gray-300 font-medium hover:text-white hover:underline transition duration-150 ease-in-out"
                                       href="post.html">Search Startup Jobs - Week 5 - Build in Public - Slow Week</a>
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
        @auth()
            <div>

                <div class="fixed inset-0 bg-gray-950/30 backdrop-blur-sm z-50 transition-opacity"
                     x-show="threadOpen" x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                     x-transition:leave="transition ease-out duration-100" x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0" aria-hidden="true" style="display: none;"></div>
                <!-- Modal dialog -->
                <div id="search-modal"
                     class="fixed inset-0 z-50 overflow-hidden flex items-start top-20 mb-4 justify-center px-4 sm:px-6"
                     role="dialog" aria-modal="true" x-show="threadOpen"
                     x-transition:enter="transition ease-in-out duration-200"
                     x-transition:enter-start="opacity-0 trangray-y-4"
                     x-transition:enter-end="opacity-100 trangray-y-0"
                     x-transition:leave="transition ease-in-out duration-200"
                     x-transition:leave-start="opacity-100 trangray-y-0"
                     x-transition:leave-end="opacity-0 trangray-y-4" style="display: none;">
                    <div
                        class="bg-white dark:bg-gray-900 overflow-auto max-w-3xl w-full max-h-full rounded-xl p-5 xl:p-12"
                        @click.outside="threadOpen = false" @keydown.escape.window="threadOpen = false">

                        <div class="mb-5">

                            <div class="flex items-center justify-between">
                                <h3 class="text-2xl font-semibold text-white">{{__('New discussion')}}</h3>
                                <button type="button"
                                        class="z-50 cursor-pointer dark:text-white text-gray-500 ml-auto rtl:mr-auto rtl:ml-0"
                                        @click="threadOpen = false">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                         fill="none"
                                         stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <form method="post" action="{{route('discussions.create')}}">
                            @csrf
                            <div class="mb-5">
                                <x-form.label for="title" :value="__('Heading')"/>
                                <x-form.input id="title" class="block mt-1 w-full" type="text" name="title" size="lg"
                                              placeholder="{{__('Heading')}}"/>
                            </div>
                            <div class="mb-5">
                                <x-form.label for="description" :value="__('Description')"/>
                                <x-markdown name="description" placeholder="{{__('Description')}}"
                                            required></x-markdown>
                            </div>
                            <x-form.primary wire:loading.attr="disabled" type="submit"
                                            class="w-full">{{__('Submit')}}</x-form.primary>
                        </form>
                    </div>
                </div>
            </div>

        @endauth
    </div>
@endsection
