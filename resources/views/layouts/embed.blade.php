<!DOCTYPE html>
<html class="dark" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{config('settings.title')}}</title>
    <meta name="robots" content="noindex">
    <link rel="canonical" href="{{ url()->current() }}"/>
    @include('partials.head')
</head>
<body
    class="overflow-hidden dark:bg-gray-950">
    @yield('content')
    @stack('javascript')
</body>
</html>
