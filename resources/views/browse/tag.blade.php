@extends('layouts.app')
@section('content')
    <div class="pb-6 lg:pb-16">
        <div class="custom-container">
            <div class="mb-6 relative">
                <div class="flex items-center min-h-[40px]">
                    <h1 class="text-xl xl:text-2xl dark:text-white font-semibold lg:text-left capitalize  flex-1">{{__('":tag" containing the tag',['tag' => $listing->tag])}}</h1>
                </div>
            </div>
            <div class="grid grid-cols-2 lg:grid-cols-6 2xl:grid-cols-8 gap-6 xl:gap-8">
                @foreach($posts as $post)
                    <x-ui.post :listing="$post"/>
                @endforeach
            </div>
        </div>
    </div>
@endsection
