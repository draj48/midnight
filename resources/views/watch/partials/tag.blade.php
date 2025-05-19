
@if(isset($listing->tags))
    @foreach($listing->tags as $tag)
        <a class="bg-gray-100 hover:bg-primary-500 hover:text-white dark:hover:bg-gray-700 dark:hover:text-white dark:bg-gray-800 dark:border-gray-800 dark:text-gray-300/80 text-xs py-2 px-3.5 rounded-lg"
           href="{{route('tag',$tag->slug)}}">{{$tag->tag}}</a>
    @endforeach
@endif
