<a href="{{route('broadcast',$listing->slug)}}" class="relative block group">
    <div
        class="aspect-square relative rounded-lg transition overflow-hidden cursor-pointer before:absolute before:-inset-px before:bg-gradient-to-b before:from-gray-950 before:to-gray-950/[.4] before:-m-px before:z-[1] before:opacity-0 group-hover:before:opacity-100">
        {!! picture($listing->imageurl,config('attr.poster.size_x').','.config('attr.poster.size_y'),'absolute h-full w-full object-cover rounded-md',$listing->title) !!}
        <div
            class="hidden group-hover:flex absolute left-1/2 top-1/2 -translate-x-1/2 z-20 -translate-y-1/2 h-16 w-16 items-center justify-center cursor-pointer rounded-full bg-white/50 text-white transition"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 20 20"
                fill="currentColor"
                class="hi-mini hi-play h-6 w-6 translate-x-0.5"
            >
                <path
                    d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"
                />
            </svg>
        </div>
    </div>
    <div
        class="pt-3 transition text-center">
        <h3 class="text-base tracking-tighter font-medium text-white line-clamp-1">{{$listing->title}}</h3>
    </div>
</a>
