@extends('layouts.app')
@section('content')
    <div class="pb-6 lg:pb-16">
        <div class="custom-container">
            <div class="mb-6 relative">
                <div class="flex items-center min-h-[40px]">
                    <h1 class="text-xl xl:text-2xl dark:text-white font-semibold capitalize  flex-1">{{$config['heading']}}</h1>
                </div>
            </div>
            <div class="grid grid-cols-2 lg:grid-cols-6 2xl:grid-cols-8 gap-6 xl:gap-8">
                @foreach($listings as $listing)
                    <x-ui.broadcast :listing="$listing" :title="$listing->title" :image="$listing->imageurl"
                                    :vote="$listing->vote_average"
                                    :categories="$listing->categories"/>
                @endforeach
            </div>
            {{ $listings->onEachSide(2)->links('partials.pagination') }}
        </div>
    </div>
@endsection
