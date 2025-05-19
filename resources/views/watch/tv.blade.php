@extends('layouts.app')
@section('content')
    <div x-data="{selectedStream:'2embed',trailerOpen:false,iframeSrc: ''}">
        <div class="container">

            <div class="flex lg:hidden gap-x-8">

                <div class="max-w-[6rem] w-full mx-auto">
                    <div
                        class="aspect-[2/3] relative rounded-md transition overflow-hidden cursor-pointer ">
                        <img src="{{$listing->imageurl}}"
                             class="absolute  h-full w-full object-cover">
                    </div>
                </div>
                <div class="flex-1">
                    <h3 class="text-xl tracking-tighter font-semibold text-gray-100 line-clamp-1">{{$listing->title}}</h3>

                    <div class="flex items-center text-gray-400 dark:text-gray-400 text-xs mt-3 space-x-4">
                        @if($listing->quality)
                            <span
                                class="bg-gray-500/50 backdrop-blur-lg text-gray-200 text-xxs font-semibold tracking-wide py-0.5 px-1.5 rounded">{{$listing->quality}}</span>
                        @endif
                        @if($listing->runtime)
                            <span>{{__(':time min',['time' => $listing->runtime])}}</span>
                        @endif
                        @if($listing->release_date)
                            <span>{{$listing->release_date->translatedFormat('Y')}}</span>
                        @endif
                        <span
                            class="hidden lg:block">{{__('Published on, :date',['date' => $listing->created_at->diffForHumans()])}}</span>
                    </div>
                    @if($listing->trailer)
                        <x-form.secondary @click="trailerOpen = true;iframeSrc = '{{$listing->trailer}}'"
                                          class=" mt-3">{{__('Watch trailer')}}</x-form.secondary>
                    @endif
                </div>
            </div>
            @if(isset($listing->arguments->information))
                <div class="bg-red-500 text-white py-4 px-5 my-5 rounded-lg flex items-center gap-x-4">
                    <x-ui.icon name="info" class="w-8 h-8" fill="currentColor"/>
                    <div class="flex-1">
                        <p class="text-white text-sm">{{$listing->arguments->information}}</p>
                    </div>
                </div>
            @endif
            <div class="lg:flex gap-6 xl:gap-12 py-3 relative">

                <div class="max-w-[16rem] w-full mx-auto hidden lg:block">
                    <div
                        class="aspect-[2/3] relative rounded-md transition overflow-hidden cursor-pointer ">
                        <img src="{{$listing->imageurl}}"
                             class="absolute  h-full w-full object-cover">
                    </div>
                    @if($listing->trailer)
                        <x-form.secondary @click="trailerOpen = true;iframeSrc = '{{$listing->trailer}}'"
                                          class="w-full mt-4">{{__('Watch trailer')}}</x-form.secondary>
                    @endif
                </div>
                <div class="flex-1">

                    @if(config('settings.show_titlesub') == 'active')
                        <h2 class="text-lg tracking-tighter font-medium text-gray-400 line-clamp-1 hidden lg:block">{{$listing->title_sub}}</h2>
                    @endif
                    <h1 class="text-3xl tracking-tighter font-semibold text-gray-100 line-clamp-1 hidden lg:block">{{$listing->title}}</h1>
                    <div class="hidden lg:flex items-center text-gray-400 dark:text-gray-400 text-xs mt-3 space-x-4">
                        @if($listing->quality)
                            <span
                                class="bg-gray-500/50 backdrop-blur-lg text-gray-200 text-xxs font-semibold tracking-wide py-0.5 px-1.5 rounded">{{$listing->quality}}</span>
                        @endif
                        @if($listing->runtime)
                            <span>{{__(':time min',['time' => $listing->runtime])}}</span>
                        @endif
                        @if($listing->release_date)
                            <span>{{$listing->release_date->translatedFormat('Y')}}</span>
                        @endif
                        <span
                            class="hidden lg:block">{{__('Published on, :date',['date' => $listing->created_at->diffForHumans()])}}</span>
                    </div>
                    <div class="flex items-center gap-6 my-5">
                        <div
                            class="flex relative w-10 h-10 items-center justify-center text-white ">
                            <span class="text-xs">{{$listing->vote_average}}</span>
                            <svg x="0px" y="0px" viewBox="0 0 36 36"
                                 class="absolute -inset-0 text-amber-400 bg-amber-400/20 w-10 h-10 rounded-full">
                                <circle fill="none" stroke="currentColor" stroke-width="3" cx="18" cy="18" r="16"
                                        stroke-dasharray="{{round($listing->vote_average / 10 * 100)}} 100"
                                        stroke-linecap="round" stroke-dashoffset="0"
                                        transform="rotate(-90 18 18)"></circle>
                            </svg>
                        </div>
                        <div class="flex flex-1 items-center gap-x-1">
                            <livewire:watchlist-component :model="$listing"/>
                            <livewire:report-component :model="$listing"/>
                            <div class="mx-6 hidden lg:block"></div>
                            <livewire:reaction-component :model="$listing"/>
                        </div>
                    </div>

                    <p class="text-gray-400 mt-3">{{$listing->overview}}</p>
                    <div class="my-6 space-y-2 text-sm tracking-tighter">
                        @if($listing->country_id)
                            <div class="grid sm:flex gap-x-3">
                                <div class="min-w-[150px] max-w-[200px] text-gray-500">
                                    {{__('Country')}}
                                </div>
                                <div class="font-medium text-gray-800 dark:text-gray-300">
                                    <a href="{{route('country',['country'=> $listing->country->slug])}}" class="hover:underline">{{$listing->country->name}}</a>
                                </div>
                            </div>
                        @endif
                        @if(count($listing->genres)>0)
                            <div class="grid sm:flex gap-x-3">
                                <div class="min-w-[150px] max-w-[200px] text-gray-500">
                                    {{__('Genre')}}
                                </div>
                                <div class="font-medium text-gray-800 dark:text-gray-300">
                                    @foreach($listing->genres as $genre)
                                        <a href="{{route('genre',['genre' => $genre->slug])}}"
                                           class="not-last-child-after inline-block mr-1 after:content-[','] last:mr-0 last:after:hidden hover:underline">{{$genre->title}}</a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        @if($listing->release_date)
                            <div class="grid sm:flex gap-x-3">
                                <div class="min-w-[150px] max-w-[200px] text-gray-500">
                                    {{__('Released')}}
                                </div>
                                <div class="font-medium text-gray-800 dark:text-gray-400">
                                    {{$listing->release_date->translatedFormat('d M, Y')}}
                                </div>
                            </div>
                        @endif
                        @if(count($listing->peoples)>0)
                            <div class="grid sm:flex gap-x-3">
                                <div class="min-w-[150px] max-w-[200px] text-gray-500">
                                    {{__('Cast')}}
                                </div>
                                <div class="font-medium text-gray-800 dark:text-gray-300">
                                    @foreach($listing->peoples as $people)
                                        <a href="{{route('people',['slug'=> $people->slug])}}"
                                           class="not-last-child-after inline-block mr-1 after:content-[','] last:mr-0 last:after:hidden hover:underline">{{$people->name}}</a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="flex flex-wrap gap-2 mt-5 mb-6">
                        @include('watch.partials.tag')
                    </div>
                    <div class="pb-6">
                        <livewire:comments :model="$listing"/>
                    </div>
                </div>
            </div>
            @if($listing->seasons_count > 0)
            <div class="pb-6">
                <livewire:season-component :model="$listing" type="tv"/>
            </div>
            @endif
            @include('partials.ads',['id'=> 1])
        </div>
        <div class="custom-container">
            <div class="py-6 lg:py-14">
                <div
                    class="flex flex-col lg:flex-row lg:items-center mb-6">
                    <h3 class="text-lg xl:text-xl dark:text-white font-semibold lg:text-left rtl:text-right capitalize flex-1">{{__('Recommended For You')}}</h3>
                </div>
                <div class="grid grid-cols-2 xl:grid-cols-6 2xl:grid-cols-8 gap-6">
                    @foreach($recommends as $recommend)
                            <x-ui.post :listing="$recommend"/>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="fixed inset-0 bg-gray-800/40 backdrop-blur-md z-50 transition-opacity"
             x-show="trailerOpen" x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-out duration-100" x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0" aria-hidden="true" style="display: none;"></div>
        <!-- Modal dialog -->
        <div id="search-modal"
             class="fixed inset-0 z-50 overflow-hidden flex items-start top-20 justify-center px-4 sm:px-6"
             role="dialog" aria-modal="true" x-show="trailerOpen"
             x-transition:enter="transition ease-in-out duration-200"
             x-transition:enter-start="opacity-0 trangray-y-4"
             x-transition:enter-end="opacity-100 trangray-y-0"
             x-transition:leave="transition ease-in-out duration-200"
             x-transition:leave-start="opacity-100 trangray-y-0"
             x-transition:leave-end="opacity-0 trangray-y-4" style="display: none;">
            <div class="bg-white dark:bg-gray-900 overflow-auto max-w-6xl w-full rounded-xl"
                 @click.outside="trailerOpen = false" @keydown.escape.window="trailerOpen = false">

                <iframe :src="iframeSrc" title="Trailer embed" frameborder="0" class="w-full aspect-video"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        allowfullscreen></iframe>

            </div>
        </div>
    </div>
@endsection
