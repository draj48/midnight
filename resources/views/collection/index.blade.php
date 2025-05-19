@extends('layouts.app')
@section('content')

    <div class="pb-6 lg:pb-12">
        <div class="mb-5">
            <h2 class="text-gray-900 dark:text-white text-2xl font-semibold">{{__('Collections')}}</h2>
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-4">
            @foreach($listings as $listing)
                <a href="{{route('collection.show',$listing->slug)}}" class="group">
                    <div class="flex -space-x-2 mb-3">
                        @foreach($listing->gamesLimited as $game)
                            <div
                                class="aspect-square flex-1 rounded-lg bg-gray-800 relative overflow-hidden ring-4 ring-white dark:ring-gray-900">
                                {!! picture(asset(config('attr.game.path')),'thumb-'.$game->image,config('attr.game.thumb_x').','.config('attr.game.thumb_y'),'absolute h-full w-full object-cover',$game->title) !!}
                            </div>
                        @endforeach
                    </div>
                    <h3 class="text-gray-700 group-hover:underline dark:text-gray-200 font-medium">{{$listing->title}}</h3>
                </a>
            @endforeach
        </div>
    </div>

@endsection
