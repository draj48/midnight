<!DOCTYPE html>
<html class="dark" lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{app()->getLocale() == 'ar' ? 'rtl' : 'ltr'}}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@if(isset($config['title'])){{$config['title']}}@else{{config('settings.title')}}@endif</title>

    <meta itemprop="name" content="@if(isset($config['title'])){{$config['title']}}@else{{config('settings.title')}}@endif">
    <meta itemprop="description" content="@if(isset($config['description'])){{$config['description']}}@else{{config('settings.description')}}@endif">
    @if(!empty($config['image']))
        <meta itemprop="image" content="{{ $config['image'] }}">
    @endif

    <meta property="og:type" content="website">
    <meta property="og:title" content="@if(isset($config['title'])){{$config['title']}}@else{{config('settings.title')}}@endif">
    <meta property="og:description" content="@if(isset($config['description'])){{$config['description']}}@else{{config('settings.description')}}@endif">
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
    class="min-h-screen dark:bg-gray-950 flex flex-col relative"
    x-data="{ searchOpen: false,loading:false,'sidebarToggle': false, cookiePolicy: localStorage.getItem('cookiePolicy')}" x-bind:class="{ 'false': cookiePolicy }" x-init="$watch('cookiePolicy', val => localStorage.setItem('cookiePolicy', val))">


@include('partials.navbar',['class' => '!bg-transparent dark:!bg-transparent','hamburger' => 'hide'])

<div
    class="my-auto relative">
    <div class="absolute lg:flex items-center justify-center top-0 -translate-y-1/2 left-1/2 -translate-x-1/2 pointer-events-none -z-10 w-1/4 aspect-square hidden dark:flex" aria-hidden="true">
        <div class="absolute inset-0 translate-z-0 bg-gray-100 dark:bg-gray-800 rounded-full blur-[120px] opacity-70"></div>
        <div class="absolute w-1/4 h-1/4 translate-z-0 bg-gray-100 dark:bg-gray-800 rounded-full blur-[40px]"></div>
    </div>
    @yield('content')
</div>
@include('partials.footer')
</body>
</html>
