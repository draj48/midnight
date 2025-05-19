
<div class="pb-6 lg:pb-10 pt-3">
    <div class="flex gap-x-6 w-full overflow-x-auto lg:overflow-x-visible p-3 lg:p-0">
        @foreach($listings['featured'] as $featured)
        <a href="{{route($featured->type,$featured->slug)}}" class="relative text-center w-20 lg:w-28 cursor-pointer">
            <div
                class="w-20 lg:w-24 h-20 lg:h-24 mx-auto relative rounded-full bg-gray-100 dark:bg-gray-600 ring-4 ring-offset-4 ring-offset-gray-950 ring-primary-500">
                <img src="{{$featured->storyurl}}" class="absolute w-full h-full object-cover rounded-full">
            </div>
            <div class="py-5">
                <h3 class="text-xs lg:text-sm text-gray-700 dark:text-gray-200 font-medium line-clamp-1">{{$featured->title}}</h3>
                <div class="text-xs text-gray-500 dark:text-gray-500 font-medium line-clamp-1 capitalize">{{$featured->type == 'movie' ? __('Movie') : __('TV Show')}}</div>
            </div>
        </a>
        @endforeach
    </div>
</div>
