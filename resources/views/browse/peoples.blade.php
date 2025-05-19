@extends('layouts.app')
@section('content')
    <div class="pb-6 lg:pb-16">
        <div class="custom-container">
            <div class="mb-6 relative">
                <h1 class="text-2xl font-semibold dark:text-white">{{$config['heading']}}</h1>
            </div>
            <div class="grid grid-cols-2 lg:grid-cols-6 2xl:grid-cols-8 gap-6 xl:gap-8">
                @foreach($listings as $listing)
                    <x-ui.people :listing="$listing"/>
                @endforeach
            </div>
            {{ $listings->onEachSide(2)->links('partials.pagination') }}
        </div>
    </div>
@endsection
