@extends('layouts.app')
@section('content')
    <div class="max-w-6xl mx-auto w-full py-4 lg:py-8">
        <div class="space-y-5">
            <h1 class="text-3xl font-bold lg:text-4xl dark:text-white">{{$listing->title}}</h1>
            <div class="text-base text-gray-800 dark:text-gray-200 space-y-5 leading-10">{!! $listing->body !!}</div>
        </div>
    </div>
@endsection
