<!-- End Announcement Banner -->
<header
    class="w-full z-40 bg-white dark:bg-gray-950 xl:dark:bg-gray-950/80 backdrop-blur-lg sticky top-0 @if(config('settings.layout') == 'vertical'){{'mb-4 custom-container'}}@endif @if(isset($class)){{$class}}@endif">
    <div class="@if(config('settings.layout') != 'vertical'){{'px-6 lg:px-8'}}@endif">
        <div class="flex items-center relative h-16">

            @if(empty($hamburger))
            <div class="lg:hidden mr-5">
                <!-- Hamburger button -->
                <button
                    class="hamburger text-gray-700 dark:text-gray-100"
                    :class="{ 'active': sidebarToggle }"
                    @click.stop="sidebarToggle = !sidebarToggle"
                    aria-controls="mobile-nav"
                    :aria-expanded="sidebarToggle"
                >
                    <span class="sr-only">Menu</span>
                    <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <rect y="4" width="24" height="1.5"/>
                        <rect y="11" width="24" height="1.5"/>
                        <rect y="18" width="24" height="1.5"/>
                    </svg>
                </button>
            </div>
            @endif
            <!-- Site branding -->
            <div class="shrink-0 lg:ml-0 flex items-center gap-x-5">

                @if(empty($hamburger))
                    @if(!config('settings.layout') || config('settings.layout') == 'horizontal')
                        <button
                            class="hamburger text-gray-700 dark:text-white dark:hover:text-gray-300 transition hidden lg:block"
                            @click="compactToggle = !compactToggle; localStorage.setItem('compactToggle', compactToggle ? 'true' : 'false')">
                            <span class="sr-only">Menu</span>
                            <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <rect y="4" width="24" height="1.5"/>
                                <rect y="11" width="24" height="1.5"/>
                                <rect y="18" width="24" height="1.5"/>
                            </svg>
                        </button>
                    @endif
                @endif
                <!-- Logo -->
                <a class="" href="{{route('index')}}">
                    @if(config('settings.logo'))
                        <img src="{{asset('static/img/'.config('settings.logo'))}}" class="w-full h-7"
                             alt="{{config('settings.site_name')}}">
                    @else
                        <x-ui.logo height="24" class="text-gray-700 dark:text-white"/>
                    @endif
                </a>
            </div>
            @if((config('settings.layout') == 'vertical') OR (isset($landing) AND $landing == 'active'))
                <nav class="hidden lg:block 2xl:mx-8 lg:mx-5">
                    <ul class="flex grow justify-end flex-wrap items-center text-sm">
                        @foreach(config('menus') as $menu)
                            @if($menu->layout == 'all' OR $menu->layout == 'header')
                                @if($menu->route)
                                    <li class="@if($loop->index > 6){{'hidden 2xl:block'}}@endif">
                                        <a href="{{route($menu->route)}}"
                                           class="px-3.5 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:text-gray-900 hover:border-primary-500 dark:hover:text-gray-100 hover:rounded-lg flex items-center relative after:absolute after:inset-0 after:rounded-lg hover:after:w-full after:transition hover:after:bg-gray-400/10">
                                            <div
                                                class="tracking-tight font-medium whitespace-nowrap flex-1">{{__($menu->title)}}</div>
                                        </a>
                                    </li>
                                @elseif($menu->url)
                                    <li class="@if($loop->index > 6){{'hidden 2xl:block'}}@endif">
                                        <a href="{{$menu->url}}"
                                           class="px-3.5 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:text-gray-900 hover:border-primary-500 dark:hover:text-gray-100 hover:rounded-lg flex items-center relative after:absolute after:inset-0 after:rounded-lg hover:after:w-full after:transition hover:after:bg-gray-400/10">
                                            <div
                                                class="tracking-tight font-medium whitespace-nowrap flex-1">{{__($menu->title)}}</div>
                                        </a>
                                    </li>
                                @endif
                            @endif
                        @endforeach
                    </ul>
                </nav>
            @endif

            @if(isset($search) AND (!config('settings.layout') || config('settings.layout') == 'horizontal'))

                <div class="hidden lg:block max-w-sm xl:max-w-xl w-full absolute left-1/2 -translate-x-1/2">
                    <button type="button"
                            class="hidden sm:flex items-center w-full text-left space-x-5 px-6 py-3.5 bg-gray-100 hover:bg-gray-200/50 rounded-full text-gray-400 dark:bg-gray-800/70 dark:hover:bg-gray-900 transition-all duration-300 text-sm  dark:text-gray-300/40 text-gray-400"
                            @click.prevent="searchOpen = true;if (searchOpen) $nextTick(()=>{$refs.searchInput.focus()});"
                            aria-controls="search-modal"
                            @keydown.window.ctrl.q="searchOpen = true;if (searchOpen) $nextTick(()=>{$refs.searchInput.focus()});">

                        <x-ui.icon name="search" stroke-width="2" class="w-5 h-5"/>
                        <span class="flex-auto">{{__('Search')}} ..</span>
                        <span
                            class="font-sans text-xs whitespace-nowrap opacity-70 block rtl:hidden">Ctrl + Q</span>
                    </button>
                </div>
            @endif
            <nav class="flex ml-auto rtl:mr-auto rtl:ml-0 lg:w-96">
                <ul class="flex grow justify-end flex-wrap items-center text-sm gap-x-6 lg:gap-x-7">

                    @if(isset($search) AND config('settings.layout') == 'vertical')
                        <li class="hidden lg:block">
                            <button type="button"
                                    class="w-5 h-5 flex items-center text-gray-500 dark:text-gray-400 dark:hover:text-primary-500 hover:text-primary-500 justify-center hover:text-primary-500 transition duration-150 rounded-full"
                                    @click.prevent="searchOpen = true;if (searchOpen) $nextTick(()=>{$refs.searchInput.focus()});"
                                    aria-controls="search-modal"
                                    @keydown.window.ctrl.q="searchOpen = true;if (searchOpen) $nextTick(()=>{$refs.searchInput.focus()});">

                                <x-ui.icon name="search" class="w-5 h-5"/>
                            </button>
                        </li>
                    @endif
                    <li class="block lg:hidden">
                        <button type="button"
                                class="w-5 h-5 flex items-center text-gray-500 dark:text-gray-400 dark:hover:text-primary-500 hover:text-primary-500 justify-center hover:text-primary-500 transition duration-150 rounded-full"
                                @click.prevent="searchOpen = true;if (searchOpen) $nextTick(()=>{$refs.searchInput.focus()});"
                                aria-controls="search-modal"
                                @keydown.window.ctrl.q="searchOpen = true;if (searchOpen) $nextTick(()=>{$refs.searchInput.focus()});">

                            <x-ui.icon name="search" class="w-5 h-5"/>
                        </button>
                    </li>
                    @guest
                        <li class="hidden lg:block">
                            <a href="{{route('login')}}"
                               class="text-gray-700 dark:text-gray-400 dark:hover:text-white hover:text-primary-500 inline-flex items-center px-1 py-2 text-sm">{{__('Sign in')}}</a>
                        </li>
                        @if(config('settings.register') != 'disable')
                            <li class="hidden lg:block">
                                <a href="{{route('register')}}"
                                   class="bg-primary-500 rounded-full border-transparent text-white dark:text-gray-200 hover:text-white hover:bg-primary-500 transition-all inline-flex items-center px-6 lg:px-8 py-3.5 text-sm group ">

                                    <span>{{__('Sign up')}}</span>
                                    <span
                                        class="tracking-normal  group-hover:translate-x-0.5 transition-transform duration-150 ease-in-out ml-3">-&gt;</span>
                                </a>
                            </li>
                        @endif
                        <li class="block lg:hidden">
                            <a href="{{route('login')}}"
                               class="bg-primary-500 rounded-full border-transparent text-white dark:text-gray-200 hover:text-white hover:bg-primary-500 transition-all inline-flex items-center w-10 h-10 flex items-center justify-center text-sm group ">
                                <x-ui.icon name="user" class="w-5 h-5" stroke="currentColor"/>
                            </a>
                        </li>
                    @else

                        @if(Auth::user()->account_type == 'admin')
                            <li class="hidden lg:block">
                                <a href="{{route('admin.index')}}" target="_blank"
                                   class="w-5 h-5 flex items-center text-gray-500 dark:text-gray-400 dark:hover:text-primary-500 hover:text-primary-500 justify-center hover:text-primary-500 transition duration-150 rounded-full">
                                    <x-ui.icon name="external" class="w-5 h-5" stroke="currentColor"/>
                                </a>
                            </li>
                            <li class="w-px h-5 bg-gray-200 dark:bg-gray-800 hidden lg:block"></li>
                        @endif
                        <li class="relative inline-flex" x-data="{ open: false }">
                            <button
                                class="inline-flex justify-center items-center group"
                                aria-haspopup="true"
                                @click.prevent="open = !open" :aria-expanded="open" aria-expanded="false">
                                {!! gravatar(Auth::user()->name,Auth::user()->avatarurl,'h-9 w-9 rounded-full bg-primary-500 text-xs font-bold flex items-center justify-center text-white') !!}
                            </button>
                            <div
                                class="origin-top-right z-10 absolute inset-x-0 top-full mt-3 bg-white py-6 w-56 px-3 left-auto right-0 lg:-mr-1.5 lg:rounded-xl shadow-lg border border-gray-100 text-sm divide-y divide-gray-100 dark:bg-gray-900 dark:border-gray-900 rtl:lg:mr-0 rtl:left-0 rtl:right-auto"
                                @click.outside="open = false" @keydown.escape.window="open = false" x-show="open"
                                x-transition:enter="transition ease-out duration-200 transform"
                                x-transition:enter-start="opacity-0 -trangray-y-2"
                                x-transition:enter-end="opacity-100 trangray-y-0"
                                x-transition:leave="transition ease-out duration-200"
                                x-transition:leave-start="opacity-100"
                                x-transition:leave-end="opacity-0" style="display: none;">
                                <div class="">


                                    <a class="w-full py-2.5 px-6 inline-flex items-center gap-5 text-sm text-center text-gray-500 rounded-lg hover:bg-gray-50 relative after:absolute after:-bottom-2 after:rounded-full after:left-0 after:right-0 after:h-0.5 dark:text-gray-400 dark:hover:text-gray-300 dark:hover:bg-gray-700/50 whitespace-nowrap"
                                       href="{{route('profile',Auth::user()->username)}}">

                                        {{__('My profile')}}
                                    </a>
                                    <a class="w-full py-2.5 px-6 inline-flex items-center gap-5 text-sm text-gray-500 rounded-lg hover:bg-gray-50 relative after:absolute after:-bottom-2 after:rounded-full after:left-0 after:right-0 after:h-0.5 dark:text-gray-400 dark:hover:text-gray-300 dark:hover:bg-gray-700/50 "
                                       href="{{route('profile.history',['username'=>Auth::user()->username])}}">

                                        {{__('Watch history')}}
                                    </a>
                                    <a class="w-full py-2.5 px-6 inline-flex items-center gap-5 text-sm text-gray-500 rounded-lg hover:bg-gray-50 relative after:absolute after:-bottom-2 after:rounded-full after:left-0 after:right-0 after:h-0.5 dark:text-gray-400 dark:hover:text-gray-300 dark:hover:bg-gray-700/50"
                                       href="{{route('profile.liked',['username'=>Auth::user()->username])}}">

                                        {{__('Liked')}}
                                    </a>
                                    <a class="w-full py-2.5 px-6 inline-flex items-center gap-5 text-sm text-center text-gray-500 rounded-lg hover:bg-gray-50 relative after:absolute after:-bottom-2 after:rounded-full after:left-0 after:right-0 after:h-0.5 dark:text-gray-400 dark:hover:text-gray-300 dark:hover:bg-gray-700/50"
                                       href="{{route('profile.watchlist',['username'=>Auth::user()->username])}}">

                                        {{__('Watchlist')}}
                                    </a>
                                    @if(config('settings.subscription') == 'active')
                                        <div class="border-t border-gray-100 dark:border-gray-800/50 mt-4 pt-4"></div>
                                        <a class="w-full py-2.5 px-6 inline-flex items-center gap-5 text-sm text-center text-gray-500 rounded-lg hover:bg-gray-50 relative after:absolute after:-bottom-2 after:rounded-full after:left-0 after:right-0 after:h-0.5 dark:text-gray-400 dark:hover:text-gray-300 dark:hover:bg-gray-700/50"
                                           href="{{route('subscription.billing')}}">

                                            {{__('Billing')}}
                                        </a>
                                        <a class="w-full py-2.5 px-6 inline-flex items-center gap-5 text-sm text-center text-gray-500 rounded-lg hover:bg-gray-50 relative after:absolute after:-bottom-2 after:rounded-full after:left-0 after:right-0 after:h-0.5 dark:text-gray-400 dark:hover:text-gray-300 dark:hover:bg-gray-700/50"
                                           href="{{route('subscription.index')}}">
                                            {{__('Subscription')}}
                                        </a>
                                    @endif
                                    <div class="border-t border-gray-100 dark:border-gray-800/50 mt-4 pt-4"></div>
                                    <a class="w-full py-2.5 px-6 inline-flex items-center gap-5 text-sm text-center text-gray-500 rounded-lg hover:bg-gray-50 relative after:absolute after:-bottom-2 after:rounded-full after:left-0 after:right-0 after:h-0.5 dark:text-gray-400 dark:hover:text-gray-300 dark:hover:bg-gray-700/50"
                                       href="{{route('settings')}}">
                                        {{__('Settings')}}
                                    </a>
                                    <a class="w-full py-2.5 px-6 inline-flex items-center gap-5 text-sm text-center text-gray-500 rounded-lg hover:bg-gray-50 relative after:absolute after:-bottom-2 after:rounded-full after:left-0 after:right-0 after:h-0.5 dark:text-gray-400 dark:hover:text-gray-300 dark:hover:bg-gray-700/50"
                                       href="{{route('logout')}}">
                                        {{__('Logout')}}
                                    </a>
                                </div>
                            </div>
                        </li>
                    @endif
                </ul>
            </nav>
        </div>
    </div>
</header>
@if((config('settings.layout') == 'vertical' AND isset($menu)) OR (isset($landing) AND $landing == 'active'))
<aside id="sidebar"
       class="fixed top-[64px] bottom-0 group top-0 left-0 bg-white lg:translate-x-0 lg:right-auto lg:bottom-0 dark:scrollbar-y hidden flex-col z-40 dark:bg-gray-950 transition w-full lg:w-64 transition-all duration-200 ease-out"
       :class="[sidebarToggle ? 'translate-x-0 !flex' : '-translate-x-full hidden']"
       @click.outside="sidebarToggle = false">
    <div
        class="flex flex-col overflow-y-auto scrollbar-y h-full px-2 lg:px-4 scrollbar scrollbar-thumb-gray-100 dark:scrollbar-thumb-white/10 scrollbar-thin scrollbar-track-transparent">
        @foreach(config('menus') as $menu)
            @if($menu->layout == 'all' OR $menu->layout == 'header')
                @if($menu->route)
                    <a href="{{route($menu->route)}}"
                       class="px-4 gap-x-5 py-3 text-sm text-gray-700 dark:text-gray-300 hover:text-gray-900 hover:bg-gray-50/70 hover:border-primary-500 dark:hover:text-gray-100 dark:hover:bg-gray-900 transition rounded-lg flex items-center ">
                        <x-ui.icon fill="currentColor" stroke="none" stroke-width="0" name="{{$menu->icon}}"
                                   class="w-5 h-5" x-bind:class="compactToggle ? 'w-6 h-6' : ''"/>
                        <div
                            class="tracking-tighter whitespace-nowrap flex-1 line-clamp-1"
                            :class="compactToggle ? 'lg:hidden' : 'block'">{{__($menu->title)}}</div>
                    </a>
                @elseif($menu->url)
                    <a href="{{$menu->url}}"
                       class="px-4 gap-x-5 py-3 text-sm text-gray-700 dark:text-gray-300 hover:text-gray-900 hover:bg-gray-50/70 hover:border-primary-500 dark:hover:text-gray-100 dark:hover:bg-gray-900 transition rounded-lg flex items-center ">
                        <div class="w-5 h-5 border-4 rounded-full border-gray-400"
                             x-bind:class="compactToggle ? 'w-6 h-6' : ''"></div>
                        <div
                            class="tracking-tighter whitespace-nowrap flex-1 line-clamp-1"
                            :class="compactToggle ? 'lg:hidden' : 'block'">{{__($menu->title)}}</div>
                    </a>
                @endif
            @endif
            @if($loop->index == 5)
                <div class="border-t border-gray-100 dark:border-gray-800/50 my-6"></div>
            @endif
        @endforeach
        <div class="border-t border-gray-100 dark:border-gray-900/50 mb-6 mt-auto"></div>
        <div class="px-4 lg:px-5 py-6" :class="compactToggle ? 'lg:hidden' : 'block'">
            <div class="flex flex-wrap text-xs text-gray-500 dark:text-gray-500 gap-x-4 gap-y-2">
                @foreach(config('pages') as $page)
                    <a href="{{route('page',$page->slug)}}" class="hover:underline">{{$page->title}}</a>
                @endforeach
            </div>
            <div class="text-xs mt-4 text-gray-500 dark:text-gray-500">
                © {{date('Y')}} {{config('settings.site_name')}}</div>
        </div>
    </div>
</aside>
@endif
