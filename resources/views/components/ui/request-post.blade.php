<div class="relative group overflow-hidden">
    <div
        class="aspect-poster relative transition overflow-hidden cursor-pointer before:absolute before:-inset-px before:bg-gradient-to-b  before:to-gray-950/[.4] before:from-gray-950 before:-m-px before:z-[1] before:opacity-0 group-hover:before:opacity-100 block">

        <img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
             data-src="{{$listing['image']}}" class="absolute h-full w-full object-cover rounded-md lazyload">

        <div
            class="absolute right-3 top-3 w-10 h-10 items-center justify-center text-white z-20 hidden group-hover:flex">

            <span class="text-xs">{{$listing['vote_average']}}</span>
            <svg x="0px" y="0px" viewBox="0 0 36 36"
                 class="absolute -inset-0 text-amber-400 bg-amber-400/20 w-10 h-10 rounded-full">
                <circle fill="none" stroke="currentColor" stroke-width="3" cx="18" cy="18" r="16"
                        stroke-dasharray="{{round($listing['vote_average'] / 10 * 100)}} 100"
                        stroke-linecap="round" stroke-dashoffset="0"
                        transform="rotate(-90 18 18)"></circle>
            </svg>

        </div>
        <div
            class="hidden group-hover:flex absolute inset-x-3 bottom-3 z-20 items-center justify-center cursor-pointer rounded-full transition"
        >
            <livewire:request-post :listing="$listing"/>
        </div>
    </div>
    <div
        class="pt-4 transition">
        <h3 class="text-sm tracking-tighter font-medium text-gray-300 line-clamp-1">{{$listing['title']}}</h3>
        <div class="text-xs text-white/50 gap-x-3 mt-1 line-clamp-1">
            {{$listing['title_sub']}}
        </div>
    </div>
</div>
