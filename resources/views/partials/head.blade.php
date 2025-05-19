<link rel="apple-touch-icon" sizes="180x180" href="{{asset('favicon/apple-touch-icon.png')}}">
<link rel="icon" type="image/png" sizes="32x32" href="{{asset('favicon/favicon-32x32.png')}}">
<link rel="icon" type="image/png" sizes="16x16" href="{{asset('favicon/favicon-16x16.png')}}">
<link rel="manifest" href="{{asset('site.webmanifest')}}">
@vite(['resources/scss/app.scss', 'resources/js/app.js'])

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
           --color-primary-500: @if(config('settings.color')){{hexToRgb(config('settings.color'))}}@else{{hexToRgb('#8b5cf6')}}@endif;
    }
</style>
{!! config('settings.custom_code') !!}
@if(config('settings.onesignal_id'))
    <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" defer></script>
    <script>
        window.OneSignal = window.OneSignal || [];
        OneSignal.push(function () {
            OneSignal.init({
                appId: "{{env('ONESIGNAL_APP_ID')}}"
            });
        });

        OneSignal.push(function () {
            OneSignal.showNativePrompt();
        });
    </script>
@endif
