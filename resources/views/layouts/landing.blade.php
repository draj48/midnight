<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark" dir="{{app()->getLocale() == 'ar' ? 'rtl' : 'ltr'}}">
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

    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:locale" content="{{app()->getLocale().'_'.strtoupper(app()->getLocale())}}" />
    <meta property="og:type" content="article">
    <meta property="og:title" content="@if(isset($config['title'])){{$config['title']}}@else{{config('settings.title')}}@endif">
    <meta property="og:description" content="@if(isset($config['description'])){{$config['description']}}@else{{config('settings.description')}}@endif">
    @if(!empty($config['image']))
        <meta property="og:image" content="{{ $config['image'] }}"/>
        <meta property="og:image:type" content="{{ pathinfo($config['image'])['extension'] }}"/>
    @endif
    <meta property="og:url" content="{{ url()->current() }}">

    <meta name="twitter:card" content="summary_large_image">


    @php
        $menu = [
        'browse' => [
            'icon' => 'browse',
            'nav' => 'browse',
            'title' => 'Browse',
            'footer' => 'true',
            'vertical' => 'true',
        ],
        'trending' => [
            'icon' => 'trending',
            'nav' => 'trending',
            'title' => 'Trending',
            'footer' => 'true',
            'vertical' => 'true',
        ],
        'topimdb' => [
            'icon' => 'top',
            'nav' => 'top',
            'title' => 'Top IMDb',
            'footer' => 'true',
            'vertical' => 'true',
        ],
        'movies' => [
            'icon' => 'movie',
            'nav' => 'movie',
            'title' => 'Movies',
            'footer' => 'true',
            'vertical' => 'true',
        ],
        'tvshows' => [
            'icon' => 'tv',
            'nav' => 'random',
            'color' => 'text-red-400',
            'title' => 'TV Shows',
            'footer' => 'true',
            'vertical' => 'true',
        ],
        'broadcasts' => [
            'icon' => 'broadcast',
            'nav' => 'broadcast',
            'title' => 'Live broadcast',
            'footer' => 'true',
            'vertical' => 'true',
        ]
    ];
    @endphp
    <link rel="canonical" href="{{ url()->current() }}"/>
    @include('partials.head')
</head>
<body
    class="min-h-screen dark:bg-gray-950 flex flex-col relative"
    x-data="{ searchOpen: false,loading:false,'sidebarToggle': false,compactToggle: localStorage.getItem('compactToggle') === 'true', cookiePolicy: localStorage.getItem('cookiePolicy'), promote: localStorage.getItem('promote')}"
    x-init="$watch('cookiePolicy', val => {
  localStorage.setItem('cookiePolicy', val);
}) ; $watch('promote', val => {
  localStorage.setItem('promote', val);
}); $watch('compactToggle', val => {
  localStorage.setItem('compactToggle', val);
})">
@include('partials.navbar',['hamberger' => 'visible','landing' => 'active'])

<div class="flex-1">
    @yield('content')

</div>
<div class="mt-auto">
    @include('partials.footer')
</div>

<livewire:search-component/>
<script src="{{asset('static/js/lazysizes.js')}}"></script>
<livewire:notify-component/>
@stack('javascript')
<x-ui.toast/>
@if(isset($config['schema']))
    {!! $config['schema'] !!}
@endif
@if(isset($config['breadcrumb']))
    {!! $config['breadcrumb'] !!}
@endif
</body>
</html>
