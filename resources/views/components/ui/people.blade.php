<a href="{{route('people',$listing->slug)}}" class="relative block group">
    <div
        class="aspect-square relative rounded-lg transition overflow-hidden cursor-pointer">
        {!! picture($listing->imageurl,config('attr.poster.size_x').','.config('attr.poster.size_y'),'absolute h-full w-full object-cover rounded-md',$listing->name,'people') !!}
    </div>
    <div
        class="pt-3 transition text-center">
        <h3 class="text-base tracking-tighter font-medium text-white line-clamp-1">{{$listing->name}}</h3>
    </div>
</a>
