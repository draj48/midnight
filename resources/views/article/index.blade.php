@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="mb-5">
            <h2 class="text-gray-900 dark:text-white text-2xl font-semibold">{{__('Blog')}}</h2>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8 mb-6">
            @foreach($listings as $listing)
                <x-card.article :listing="$listing"/>
            @endforeach
        </div>
        {{ $listings->onEachSide(2)->links('partials.pagination') }}
        @include('partials.ads',['id'=> 4])
    </div>

@endsection
