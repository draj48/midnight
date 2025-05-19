@extends('layouts.app')
@section('content')

    <div class="pb-6 lg:pb-16">
        <div class="custom-container">
            <div class="mb-6 relative">
                <div class="flex items-center">
                    <h1 class="text-2xl font-semibold dark:text-white flex-1">{{$config['heading']}}</h1>
                </div>

            </div>
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                @foreach($listings as $collection)
                    <a href="{{route('collection',$collection->slug)}}" class="group">
                        <div class="flex max-w-md w-full -space-x-2 mb-3">
                            @foreach($collection->postsLimited as $post)
                                <div
                                    class="aspect-[2/3] flex-1 rounded-lg bg-gray-800 relative overflow-hidden ring-4 ring-white dark:ring-gray-950">
                                    {!! picture($post->imageurl,config('attr.poster.size_x').','.config('attr.poster.size_y'),'absolute h-full w-full object-cover',$post->title,'post') !!}
                                </div>
                            @endforeach
                        </div>
                        <h3 class="text-gray-700 group-hover:underline dark:text-gray-200 font-medium">{{$collection->title}}</h3>
                        <div class="text-xs mt-1 text-gray-500 dark:text-gray-400">{{__(':total movie & tv show',['total' => $collection->posts_count])}}</div>
                    </a>
                @endforeach
            </div>
            {{ $listings->onEachSide(2)->links('partials.pagination') }}
        </div>
    </div>
@endsection
