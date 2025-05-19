@if(count($listings['blog'])>0)
<div class="pb-6 lg:pb-10">
    <div class="mb-5">
        <h3 class="text-lg xl:text-xl dark:text-white font-semibold lg:text-left capitalize flex-1">{{$module->title}}</h3>
    </div>
    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach($listings['blog'] as $article)
        <a class="group block" href="{{route('article',$article->slug)}}">
            <div class="aspect-video rounded-lg relative overflow-hidden">
                {!! picture($article->imageurl,config('attr.article.thumb_size_x').','.config('attr.article.thumb_size_y'),'absolute h-full w-full object-cover',$article->title) !!}
            </div>
            <h3 class="mt-3 text-lg font-medium text-gray-800 group-hover:text-blue-600 dark:text-gray-300 dark:group-hover:text-white">
                {{$article->title}}
            </h3>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{$article->created_at->translatedFormat('d M, Y')}}
            </p>
        </a>
        @endforeach
    </div>
</div>
@endif
