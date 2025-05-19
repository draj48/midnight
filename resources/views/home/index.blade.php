@extends('layouts.app')
@section('content')
    @push('javascript')
        <script src="{{asset('static/js/swiper.js')}}"></script>
    @endpush
    <div class="custom-container">
        @foreach($modules as $module)
            @include('home.partials.'.$module->slug)
            @if($loop->index % 3 == 0)
                @include('partials.ads',['id'=> 4])
            @endif
        @endforeach
        @if(config('settings.footer_description'))
            <div
                class="pb-6 lg:pb-10">{!! editor_preview(config('settings.footer_description')) !!}</div>
        @endif
    </div>
@endsection
