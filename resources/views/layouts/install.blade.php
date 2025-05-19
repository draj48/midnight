<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ 'Install' }}</title>
    <!-- Scripts -->
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
    <style>
        :root {
            @foreach(config('attr.colors.zinc') as $color => $value)
                {{'--color-gray-'.$color.':'.hexToRgb('#'.$value)}};
            @endforeach
            --color-primary-500: @if(config('settings.color')){{hexToRgb(config('settings.color'))}}@else{{hexToRgb('#8b5cf6')}}@endif;
        }
    </style>
</head>
<body
    class="min-h-screen bg-white dark:bg-gray-950 flex flex-col relative">
<div
    class="relative before:absolute before:top-0 before:inset-x-0 before:bg-[url('../img/shape.svg')] before:bg-no-repeat before:bg-top before:w-full before:h-full before:-z-[1]  dark:before:opacity-10 my-8">
    @yield('content')
</div>
</body>
</html>
