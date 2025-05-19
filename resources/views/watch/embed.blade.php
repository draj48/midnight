@extends('layouts.embed')
@section('content')
    @if($listing->type == 'embed')
        <div class="w-full aspect-video">
        <iframe class="w-full h-full"
            src="{{$listing->link}}"
            allowfullscreen
            allowtransparency
            allow="autoplay"
        ></iframe>
        </div>
    @else
    @if(config('settings.player') == 'videojs')

        @if (strpos($listing->link, 'youtube.com') !== false)
            <div class="w-full aspect-video">
                <video id="player" class="video-js w-full h-full vjs-default-skin" controls
                       data-setup='{ "techOrder": ["youtube"], "sources": [{ "type": "video/youtube", "src": "{{$listing->link}}"}], "youtube": { "customVars": { "wmode": "none" } } }'></video>
            </div>
        @elseif($listing->type == 'mp4')
            <div class="w-full aspect-video">
                <video id="player" class="video-js w-full h-full vjs-default-skin" data-setup="{}" controls
                       preload="auto" poster="{{$listing->postable->post->coverurl ?? $listing->postable->coverurl}}">
                    <source src="{{$listing->link}}" type="video/mp4">
                </video>
            </div>
        @elseif($listing->type == 'hls')
            <div class="w-full aspect-video">
                <video id="player" class="video-js w-full h-full vjs-default-skin" data-setup="{}" controls
                       preload="auto" poster="{{$listing->postable->post->coverurl ?? $listing->postable->coverurl}}">
                    <source src="{{$listing->link}}" type="application/x-mpegURL">
                </video>
            </div>
        @endif

        @push('javascript')
            <script src="{{asset('static/js/player/videojs/js/video.min.js')}}"></script>
            <script src="{{asset('static/js/player/videojs/js/ads.min.js')}}"></script>
            <script src="{{asset('static/js/player/videojs/js/youtube.min.js')}}"></script>
            <script src="{{asset('static/js/player/videojs/js/ima.js')}}"></script>
        @endpush
    @else

        @if (strpos($listing->link, 'youtube.com') !== false)
            <div class="w-full aspect-video">
                <div class="plyr__video-embed" id="player">
                    <iframe
                        src="{{$listing->link}}"
                        allowfullscreen
                        allowtransparency
                        allow="autoplay"
                    ></iframe>
                </div>
            </div>
        @elseif($listing->type == 'mp4')
            <div class="w-full aspect-video">
                <video id="player" class="video-js w-full h-full vjs-default-skin" data-setup="{}" controls
                       preload="auto" poster="{{$listing->postable->post->coverurl ?? $listing->postable->coverurl}}">
                    <source src="{{$listing->link}}" type="video/mp4">
                    @foreach($listing->postable->subtitles as $subtitle)
                        <track kind="captions" label="{{$subtitle->country->name}}" srclang="{{$subtitle->country->code}}" src="{{$subtitle->linkurl}}" />
                    @endforeach
                </video>
            </div>
        @elseif($listing->type == 'hls')
            <div class="w-full aspect-video">
                <video id="player" class="video-js w-full h-full vjs-default-skin" data-setup="{}" controls
                       preload="auto" poster="{{$listing->postable->post->coverurl ?? $listing->postable->coverurl}}">
                    <source src="{{$listing->link}}" type="application/x-mpegURL">
                    @foreach($listing->postable->subtitles as $subtitle)
                        <track kind="captions" label="{{$subtitle->country->name}}" srclang="{{$subtitle->country->code}}" src="{{$subtitle->linkurl}}" />
                    @endforeach
                </video>
            </div>
        @endif

        @push('javascript')
            <script src="{{asset('static/js/player/plyr/plyr.js')}}"></script>
            <script src="{{asset('static/js/player/plyr/plyr.hls.js')}}"></script>
            <script>
                const player = new Plyr('#player');
                player.on('ready', function(event) {
                    var instance = event.detail.plyr;

                    var hslSource = null;
                    var sources = instance.media.querySelectorAll('source'),
                        i;
                    for (i = 0; i < sources.length; ++i) {
                        if (sources[i].src.indexOf('.m3u8') > -1 || sources[i].src.indexOf('.txt') > -1 || sources[i].src.indexOf('.ts') > -1) {
                            hslSource = sources[i].src;
                        }
                    }

                    if (hslSource !== null && Hls.isSupported()) {
                        var hls = new Hls();
                        hls.loadSource(hslSource);
                        hls.attachMedia(instance.media);
                        hls.on(Hls.Events.MANIFEST_PARSED, function() {
                        });
                    }
                });
            </script>
        @endpush
    @endif
    @endif
@endsection
