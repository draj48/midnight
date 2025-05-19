@extends('layouts.app')
@section('content')
    <div class="pb-6 lg:pb-16">
        @include('user.partials.header')
        <div class="container">
            <h3 class="text-xl font-medium text-gray-700 dark:text-white mb-5">{{__($config['heading'])}}</h3>
            <div
                class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3">
                @foreach($result as $item)
                    @if($item->postable->type == 'movie' OR $item->postable->type == 'tv')
                        <a class="text-sm flex items-center gap-x-8 text-gray-600 decoration-2 group dark:text-gray-500 mb-5"
                           href="{{route($item->postable->type,$item->postable->slug)}}">
                            <div class="w-24 aspect-square overflow-hidden relative rounded-md">
                                <img src="{{$item->postable->storyurl}}"
                                     class="absolute h-full w-full object-cover">
                            </div>
                            <div class="flex-1 dark:text-gray-200">
                                <h3 class="text-base tracking-tighter font-medium text-gray-300 line-clamp-2 group-hover:underline">{{$item->postable->title}}</h3>
                                <div class="text-xs text-white/50 space-x-3 mt-1 flex items-center">
                                    <div
                                        class="hidden lg:block">{{__('Watched on, :date',['date' => $item->created_at->diffForHumans()])}}</div>

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
                                <div class="text-xs text-white/50 space-x-3 mt-1 flex items-center">

                                    <div
                                        class="hidden lg:block">{{__('Watched on, :date',['date' => $item->created_at->diffForHumans()])}}</div>

                                </div>
                            </div>
                        </a>
                    @endif
                @endforeach
            </div>
            {{ $result->onEachSide(2)->links('partials.pagination') }}
        </div>
    </div>
@endsection
