<aside id="sidebar"
       class="fixed shrink-0 top-16 max-h-[calc(100vh-theme(space.16))] min-h-[calc(100vh-theme(space.16))] bottom-0 group left-0 bg-white lg:flex lg:translate-x-0 lg:right-auto lg:bottom-0 dark:scrollbar-y flex flex-col z-40 dark:bg-gray-950 w-full lg:w-64 transition-all duration-200 ease-out rtl:left-auto rtl:right-0"
       :class="[sidebarToggle ? 'translate-x-0' : '-translate-x-full', compactToggle ? 'lg:!w-auto group' : '']"
       @click.outside="sidebarToggle = false">
    <div
        class="flex flex-col overflow-y-auto scrollbar-y h-full px-2 lg:px-4 scrollbar scrollbar-thumb-gray-100 dark:scrollbar-thumb-white/10 scrollbar-thin scrollbar-track-transparent">
        @foreach(config('menus') as $menu)
            @if($menu->layout == 'all' OR $menu->layout == 'header')
                @if($menu->route)
                    <a href="{{route($menu->route)}}"
                       class="px-3 gap-x-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:text-gray-900 hover:bg-gray-50/70 hover:border-primary-500 dark:hover:text-gray-100 dark:hover:bg-gray-900 transition rounded-lg flex items-center ">
                        <x-ui.icon stroke="currentColor" stroke-width="1.75" name="{{$menu->icon}}"
                                   class="w-[22px] h-[22px]" x-bind:class="compactToggle ? '!w-6 !h-6' : ''"/>
                        <div
                            class="tracking-tighter whitespace-nowrap flex-1 line-clamp-1"
                            :class="compactToggle ? 'lg:hidden' : 'block'">{{__($menu->title)}}</div>
                    </a>
                @elseif($menu->url)
                    <a href="{{$menu->url}}"
                       class="px-4 gap-x-4 py-3 text-sm text-gray-700 dark:text-gray-300 hover:text-gray-900 hover:bg-gray-50/70 hover:border-primary-500 dark:hover:text-gray-100 dark:hover:bg-gray-900 transition rounded-lg flex items-center ">
                        <div class="w-4 h-4 border-2 rounded-full border-gray-400"
                             x-bind:class="compactToggle ? '!w-4 !h-4' : ''"></div>
                        <div
                            class="tracking-tighter whitespace-nowrap flex-1 line-clamp-1"
                            :class="compactToggle ? 'lg:hidden' : 'block'">{{__($menu->title)}}</div>
                    </a>
                @endif
            @endif
            @if($loop->index == 5)
                <div class="border-t border-gray-100 dark:border-gray-900/70 mx-2 my-6"></div>
            @endif
        @endforeach
        @if(config('settings.sidenav_featured') == 'active')
            <div class="border-t border-gray-100 dark:border-gray-900/70 mx-2 my-6"></div>
            <div
                class="h-full px-4 overflow-y-auto scrollbar-thumb-gray-100 dark:scrollbar-thumb-white/10 scrollbar-thin scrollbar-track-transparent"
                :class="compactToggle ? 'lg:hidden' : 'block'">
                <div class="text-gray-300 dark:text-gray-500 text-sm mb-1">
                    {{__('Featured')}}
                </div>
                @foreach(\App\Models\Post::where('featured', 'active')->limit(10)->get() as $post)
                    <a href="{{route($post->type,$post->slug)}}" class="py-1.5 block">
                        <div
                            class="text-gray-500 dark:text-gray-400 text-sm hover:underline hover:text-white line-clamp-1">{{$post->title}}</div>
                        <div class="flex items-center gap-x-2 text-gray-400 dark:text-gray-500">
                            <x-ui.icon stroke="currentColor" stroke-width="1.75" name="trending"
                                       class="w-3.5 h-3.5"/>
                            <div class="text-xs">{{__(':view view', ['view' => $post->view])}}</div>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</aside>
