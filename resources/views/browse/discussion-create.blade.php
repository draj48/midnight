@extends('layouts.app')
@section('content')
    <div class="container max-w-6xl py-3" x-data="{threadOpen:true}">
        <div class="mb-5">

            <h1 class="text-2xl font-semibold dark:text-white">{{$config['heading']}}</h1>
        </div>
        <div class="flex flex-wrap gap-x-6 lg:gap-x-10">
            <div class="flex-1">

                <form method="post" wire:submit="reportForm">
                    @csrf
                    <div class="mb-5">
                        <x-form.label for="meta_title" :value="__('Heading')"/>
                        <x-form.input id="meta_title" class="block mt-1 w-full" type="text" name="meta_title" size="lg"
                                      placeholder="{{__('Heading')}}"/>
                    </div>
                    <div class="mb-5">
                        <x-form.label for="description" :value="__('Description')"/>
                        <x-markdown name="description" placeholder="{{__('Description')}}"
                                    required></x-markdown>
                    </div>
                    <x-form.primary wire:loading.attr="disabled" type="submit"
                                    class="w-full">{{__('Submit')}}</x-form.primary>
                </form>
            </div>
            <div class="max-w-xs w-full">
            </div>
        </div>

    </div>
@endsection
