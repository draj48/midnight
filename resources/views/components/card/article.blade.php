<a class="group rounded-xl transition-all" href="{{route('article',$listing->slug)}}">
    <div class="relative rounded-lg aspect-video overflow-hidden">
        {!! picture($listing->imageurl,config('attr.article.thumb_size_x').','.config('attr.poster.thumb_size_y'),'absolute h-full w-full object-cover rounded-md',$listing->title) !!}
    </div>
    <h3 class="mt-5 mb-1 text-base lg:text-lg font-medium text-gray-800 dark:text-gray-300 dark:group-hover:text-white">
        {{$listing->title}}
    </h3>
    <div class="text-xs lg:text-sm text-gray-400 dark:text-gray-500">{{$listing->created_at->translatedFormat('d M, Y')}}</div>
</a>
