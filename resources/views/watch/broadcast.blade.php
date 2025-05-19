@extends('layouts.app')
@section('content')
    <div class="custom-watch-container">
        <livewire:watch-component :listing="$listing"/>
        <div class="lg:flex gap-6 xl:gap-12 py-8">
            <div class="max-w-[16rem] w-full">
                <div
                    class="aspect-square relative rounded-md transition overflow-hidden cursor-pointer ">
                    <img src="{{$listing->imageurl}}"
                         class="absolute  h-full w-full object-cover">
                </div>
                @if($listing->trailer)
                    <x-form.secondary @click="trailerOpen = true;iframeSrc = '{{$listing->trailer}}'"
                                      class="w-full mt-4">{{__('Watch trailer')}}</x-form.secondary>
                @endif
            </div>
            <div class="flex-1">
                <h1 class="text-3xl tracking-tighter font-semibold text-gray-100 line-clamp-1">{{$listing->title}}</h1>
                <div class="flex items-center text-gray-400 dark:text-gray-400 text-xs mt-3 space-x-4">
                    @if($listing->quality)
                        <span
                            class="bg-gray-500/50 backdrop-blur-lg text-gray-200 text-xxs font-semibold tracking-wide py-0.5 px-1.5 rounded">{{$listing->quality}}</span>
                    @endif
                    <span
                        class="hidden lg:block">{{__('Published on, :date',['date' => $listing->created_at->diffForHumans()])}}</span>
                </div>
                <div class="flex my-5 items-center gap-x-1">
                    <livewire:reaction-component :model="$listing"/>
                    <div class="mx-3 hidden lg:block"></div>
                    <livewire:report-component :model="$listing"/>
                </div>
                <p class="text-x text-gray-400 mt-3">{{$listing->overview}}</p>
                <div class="py-6">
                    <livewire:comments :model="$listing"/>
                </div>
            </div>
        </div>
    </div>
@endsection
