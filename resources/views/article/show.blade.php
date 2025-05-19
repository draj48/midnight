@extends('layouts.app')
@section('content')
    <div class="max-w-4xl mx-auto w-full py-4 lg:py-8">
        <div class="space-y-5 lg:space-y-8">
            <div class="space-y-3 px-5">
                <h1 class="text-3xl font-bold lg:text-4xl dark:text-white">{{$listing->title}}</h1>

                <div class="flex items-center gap-x-5">

                    <ul class="text-sm text-gray-500">
                        <li class="inline-block relative pr-6 last:pr-0 last-of-type:before:hidden before:absolute before:top-1/2 before:right-2 before:-translate-y-1/2 before:w-1 before:h-1 before:bg-gray-300 before:rounded-full dark:text-gray-400 dark:before:bg-gray-600">
                            {{$listing->created_at->translatedFormat('d M, Y')}}
                        </li>
                    </ul>
                </div>
            </div>
            <p class="text-lg text-gray-800 dark:text-gray-200 px-5">{{$listing->description}}</p>

            <figure>
                <img class="w-full object-cover rounded-xl" src="{{$listing->getImageUrlAttribute()}}"
                     alt="{{$listing->title}}">
            </figure>
            <div class="text-lg text-gray-800 dark:text-gray-200 space-y-5 leading-10 px-5">{!! $listing->body !!}</div>

            <div class="grid lg:flex lg:justify-between lg:items-center gap-y-5 lg:gap-y-0 px-5">
                <!-- Badges/Tags -->
                <div>
                    @foreach($listing->tags as $tag)
                        <a href=""
                           class="m-0.5 inline-flex items-center gap-1.5 py-2 px-3 rounded-md text-sm bg-gray-100 text-gray-700 hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700 dark:text-gray-200">{{$tag->tag}}</a>
                    @endforeach

                </div>
                <!-- End Badges/Tags -->

            </div>

        </div>
    </div>
@endsection
