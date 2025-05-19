@extends('layouts.app')
@section('content')
    <div class="pb-6 lg:pb-16 flex space-x-8">
        <div class="flex-1">
            <div
                class="border-b border-gray-100 dark:border-gray-800 pb-2 hidden lg:flex space-x-8 mb-4 pb-2 min-h-[56px]">
                <h1 class="text-gray-900 dark:text-white text-2xl font-semibold flex items-center flex-1 capitalize">{{$listing->title}}</h1>
            </div>
            <div class="@if(config('settings.listing_type') == 'masonry'){{'grid-masonry'}}@else{{'grid grid-cols-2 xl:grid-cols-6 2xl:grid-cols-8 gap-6'}}@endif">
                @php
                    $index = 0;
                @endphp
                @foreach($listing->games as $listing)
                    <x-game route="{{route('game.play',$listing->slug)}}" image="{{$listing->image}}"
                            title="{{$listing->title}}" index="{{$index}}"/>
                    @php
                        $index++;
                    @endphp
                @endforeach
            </div>
            @include('partials.ads',['id'=> 4])
        </div>
    </div>
@endsection
