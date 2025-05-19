<div class="pb-6">
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
        @foreach($genres as $genre)
            <div>
                <a href="{{route('genre',['genre' => $genre->slug])}}"
                   class="rounded-lg flex px-5 overflow-hidden items-center text-white relative bg-gray-800/70 hover:bg-primary-500 hover:text-white text-xs space-x-4 transition group" style="background-color: {{$genre->color}} !important;">
                    <div class="flex-1 py-3">
                        <div class="text-sm font-medium">{{$genre->title}}</div>
                        <div class="text-xs opacity-60">{{__(':total movie & tv show',['total' => $genre->posts_count])}}</div>
                    </div>
                    <div class="relative -bottom-3 ml-auto mt-3">
                        <div class="image aspect-square w-20 rounded-lg bg-black/20 absolute -left-8 top-2 rotate-[-8deg]"></div>
                        <div class="image aspect-square w-20 rounded-lg rotate-[9deg] group-hover:rotate-[2deg] group-hover:-translate-x-[7px] group-hover:-translate-y-[6px] transition-all" style="background-color: {{$genre->color}} !important;">
                            {!! picture($genre->getImage(),config('attr.poster.size_x').','.config('attr.poster.size_y'),'absolute h-full w-full object-cover rounded-lg',$genre->title,'post') !!}
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
</div>
