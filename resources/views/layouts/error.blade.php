<!DOCTYPE html>
<html class="dark" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <meta itemprop="name"
          content="@if(isset($config['title'])){{$config['title']}}@else{{config('settings.title')}}@endif">
    <meta itemprop="description"
          content="@if(isset($config['description'])){{$config['description']}}@else{{config('settings.description')}}@endif">
    @if(!empty($config['image']))
        <meta itemprop="image" content="{{ $config['image'] }}">
    @endif

    <meta property="og:type" content="website">
    <meta property="og:title"
          content="@if(isset($config['title'])){{$config['title']}}@else{{config('settings.title')}}@endif">
    <meta property="og:description"
          content="@if(isset($config['description'])){{$config['description']}}@else{{config('settings.description')}}@endif">
    @if(!empty($config['image']))
        <meta property="og:image" content="{{ $config['image'] }}"/>
        <meta property="og:image:type" content="{{ pathinfo($config['image'])['extension'] }}"/>
    @endif
    <meta property="og:url" content="{{ url()->current() }}">

    <meta name="twitter:card" content="summary_large_image">

    <link rel="canonical" href="{{ url()->current() }}"/>
    @include('partials.head')
</head>
<body
    class="min-h-screen dark:bg-gray-950 flex flex-col relative">
@include('partials.navbar')

<div
    class="relative before:absolute before:top-0 before:inset-x-0 before:bg-[url('../img/shape.svg')] before:bg-no-repeat before:bg-top before:w-full before:h-full before:-z-[1] flex items-center flex-1 dark:before:opacity-10">
    <div class="max-w-2xl text-center mx-auto">
        <h1 class="block font-bold text-9xl text-white">@yield('code')</h1>
        <p class="mt-5 text-3xl font-semibold tracking-tight text-gray-500 dark:text-white/60">@yield('message')</p>
        <x-form.primary href="{{route('index')}}" class="!px-8 !rounded-full mt-7 gap-x-3">
            <span>{{__('Back to Homepage')}}</span>
        </x-form.primary>
    </div>
</div>
</body>
</html>
