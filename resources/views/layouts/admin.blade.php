<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@if(isset($config['title'])){{$config['title']}}@else{{config('settings.title')}}@endif</title>
        <link rel="apple-touch-icon" sizes="180x180" href="{{asset('favicon/apple-touch-icon.png')}}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{asset('favicon/favicon-32x32.png')}}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{asset('favicon/favicon-16x16.png')}}">
        <link rel="manifest" href="{{asset('site.webmanifest')}}">
        <!-- Scripts -->
        @vite([
            'resources/scss/app.scss',
            'resources/js/app.js'
        ])
        <script>
            if (localStorage.getItem('dark-mode') == 'true' || !('dark-mode' in localStorage)) {
                document.querySelector('html').classList.add('dark');
            } else {
                document.querySelector('html').classList.remove('dark');
            }
        </script>
        <style>
            :root {

            @if(config('settings.palette'))
                @foreach(config('attr.colors.'.config('settings.palette')) as $color => $value)
                    {{'--color-gray-'.$color.':'.hexToRgb('#'.$value)}};
            @endforeach
        @else
            @foreach(config('attr.colors.zinc') as $color => $value)
                {{'--color-gray-'.$color.':'.hexToRgb('#'.$value)}};
                @endforeach
            @endif
--color-primary-500: @if(config('settings.color')){{hexToRgb(config('settings.color'))}}@else{{hexToRgb('#6366f1')}}@endif;
            }
        </style>
    </head>
    <body class="min-h-screen bg-white dark:bg-gray-950" x-data="{'sidebarToggle': false, cookiePolicy: localStorage.getItem('cookiePolicy')}" x-bind:class="{ 'false': cookiePolicy }" x-init="$watch('cookiePolicy', val => localStorage.setItem('cookiePolicy', val))">

        @include('admin.partials.sidenav')
        <div class="flex flex-col">
            @include('admin.partials.navbar')
            <div class="w-full pb-8 md:px-8 lg:pl-72">
                @yield('content')
            </div>
        </div>
        <script src="{{asset('static/js/lazysizes.js')}}"></script>
        @stack('javascript')
        <x-ui.toast />
        @livewireStyles
        @livewireScriptConfig
    </body>
</html>
