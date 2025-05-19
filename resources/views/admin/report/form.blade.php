@extends('layouts.admin')
@section('content')
    <div class="max-w-xl mx-auto w-full">
        <a class="text-sm flex items-center space-x-8 font-medium text-gray-600 decoration-2 hover:underline dark:text-gray-500 mb-5"
           href="{{route($listing->postable->type,$listing->postable->slug)}}">
            <div class="w-12 aspect-[2/3] overflow-hidden relative rounded-md">
                <img src="{{$listing->postable->imageurl}}"
                     class="absolute h-full w-full object-cover">
            </div>
            <div class="flex-1">
                {{$listing->postable->title}}
            </div>
        </a>
        <div class="mb-5">

            <h3 class="text-base font-medium text-gray-700 dark:text-white mb-2">{{config('attr.reports')[$listing->type]}}</h3>
            <p class="text-sm font-medium text-gray-500 dark:text-gray-300">{{$listing->description}}</p>
        </div>

        @if($listing->status == 'pending')
            <hr class="my-6 lg:my-10 border-gray-100 dark:border-gray-800">
            <form method="post">
                @csrf
                <div class="mb-5">
                    <x-form.label for="status" :value="__('Status')"/>
                    <x-form.select name="status" required>
                        <option
                            value="solved" @if(isset($listing->status) AND $listing->status == 'solved')
                            {{'selected'}}
                            @endif>{{__('Solved')}}</option>
                        <option
                            value="pending" @if(isset($listing->status) AND $listing->status == 'pending')
                            {{'selected'}}
                            @endif>{{__('Pending')}}</option>
                    </x-form.select>
                    <x-form.error :messages="$errors->get('status')" class="mt-2"/>
                </div>
                <x-form.primary class="w-full">{{__('Save change')}}</x-form.primary>
            </form>
        @endif
    </div>
@endsection
