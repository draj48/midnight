<div class="relative group">
    <a href="{{route('episode',['slug'=>$listing->post->slug,'season'=>$listing->season->season_number,'episode'=>$listing->episode_number])}}"
       class="aspect-video block relative bg-gray-900 rounded-md transition overflow-hidden cursor-pointer before:absolute before:-inset-px before:bg-gradient-to-b before:from-gray-950 before:to-gray-950/[.4] before:-m-px before:z-[1] before:opacity-0 group-hover:before:opacity-100">
        <img src="{{$listing->imageurl}}"
             class="absolute h-full w-full object-cover">

        <div
            class="hidden group-hover:flex absolute left-1/2 top-1/2 -translate-x-1/2 z-20 -translate-y-1/2 h-12 w-12 items-center justify-center cursor-pointer rounded-full bg-white/50 text-white transition"
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
    <div
        class="pt-4 transition">
        <h3 class="text-sm tracking-tighter font-medium text-gray-300 line-clamp-1">{{$listing->name ?? $listing->post->title}}</h3>
        <div class="text-xs text-white/50 space-x-2 mt-0.5">
            <span>{{__('Season').' '.$listing->season->season_number}}</span>
            <span>{{__('Episode').' '.$listing->episode_number}}</span>
        </div>
    </div>
</div>
