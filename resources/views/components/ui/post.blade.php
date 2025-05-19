<div class="relative group overflow-hidden">
    <a href="{{route($listing->type,$listing->slug)}}"
       class="aspect-poster relative transition overflow-hidden cursor-pointer before:absolute before:-inset-px @if(config('settings.poster_type') == 'v2'){{'before:bg-gradient-to-t  before:to-gray-950/[.7]'}}@else{{'before:bg-gradient-to-b  before:to-gray-950/[.4]'}}@endif before:from-gray-950 before:-m-px before:z-[1] before:opacity-0 group-hover:before:opacity-100 block">

        {!! picture($listing->imageurl,config('attr.poster.size_x').','.config('attr.poster.size_y'),'absolute h-full w-full object-cover rounded-md',$listing->title,'post') !!}

        <div
            class="absolute right-3 top-3 w-10 h-10 items-center justify-center text-white z-20 hidden group-hover:flex">

            <span class="text-xs">{{$listing->vote_average}}</span>
            <svg x="0px" y="0px" viewBox="0 0 36 36"
                 class="absolute -inset-0 text-amber-400 bg-amber-400/20 w-10 h-10 rounded-full">
                <circle fill="none" stroke="currentColor" stroke-width="3" cx="18" cy="18" r="16"
                        stroke-dasharray="{{round($listing->vote_average / 10 * 100)}} 100"
                        stroke-linecap="round" stroke-dashoffset="0"
                        transform="rotate(-90 18 18)"></circle>
            </svg>
        </div>
        <div
            class="hidden group-hover:flex absolute left-1/2 top-1/2 -translate-x-1/2 z-20 -translate-y-1/2 h-14 w-14 items-center justify-center cursor-pointer rounded-full bg-white/50 text-white transition"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 20 20"
                fill="currentColor"
                class="hi-mini hi-play h-5 w-5 translate-x-0.5"
            >
                <path
                    d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"
                />
            </svg>
        </div>
    </a>
    @if(config('settings.poster_type') == 'v2')
        <div
            class="p-4 absolute -bottom-10 group-hover:bottom-0 left-0 right-0 transition-all opacity-0 group-hover:opacity-100 z-10">
            <div class="text-xs text-white/50 gap-x-3 mb-0.5">
                @if($listing->runtime)
                    <span>{{__(':time min',['time' => $listing->runtime])}}</span>
                @endif
                @if($listing->release_date)
                    <span>{{$listing->release_date->translatedFormat('Y')}}</span>
                @endif
            </div>
            <h3 class="text-sm tracking-tighter font-medium text-white line-clamp-1">{{$listing->title}}</h3>
            <div class="text-xs text-white/50 gap-x-3 mt-1 flex items-center">
                @foreach($listing->genres->slice(0, 1) as $genre)
                    <span>{{$genre->title}}</span>
                @endforeach
            </div>
        </div>
    @else
    <div
        class="pt-4 transition">
        <div class="text-xs text-white/50 gap-x-3 mb-0.5">
            @if($listing->runtime)
                <span>{{__(':time min',['time' => $listing->runtime])}}</span>
            @endif
            @if($listing->release_date)
                <span>{{$listing->release_date->translatedFormat('Y')}}</span>
            @endif
        </div>
        <h3 class="text-sm tracking-tighter font-medium text-gray-300 line-clamp-1">{{$listing->title}}</h3>
        <div class="text-xs text-white/50 gap-x-3 mt-1 flex items-center">
            @foreach($listing->genres->slice(0, 1) as $genre)
                <span>{{$genre->title}}</span>
            @endforeach
            <span
                class="text-xxs bg-gray-800 rounded py-0.5 px-1.5 text-gray-300 !ml-auto">{{$listing->type == 'movie' ? __('Movie') : __('TV Show')}}</span>
        </div>
    </div>
    @endif
</div>
