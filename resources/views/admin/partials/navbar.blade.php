<header
    class="sticky top-0 inset-x-0 w-full flex flex-wrap sm:justify-start sm:flex-nowrap z-30 bg-white text-sm dark:bg-gray-950 h-16">
    <nav class="flex basis-full items-center w-full mx-auto px-4 sm:px-6 md:px-8" aria-label="Global">
        <div class="lg:hidden">
            <button
                class="hamburger text-gray-500 dark:text-gray-300"
                :class="{ 'active': sidebarToggle }"
                @click.stop="sidebarToggle = !sidebarToggle"
                aria-controls="mobile-nav"
                :aria-expanded="sidebarToggle"
            >
                <span class="sr-only">Menu</span>
                <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <rect y="4" width="24" height="2"/>
                    <rect y="11" width="24" height="2"/>
                    <rect y="18" width="24" height="2"/>
                </svg>
            </button>
        </div>
        <!-- End Sidebar Toggle -->
        <div class="shrink-0 ml-5 lg:ml-0 flex items-center">
            <a href="{{route('admin.index')}}" class="text-gray-700 dark:text-gray-100 hover:text-gray-900">
                <x-ui.logo height="22" class=""/>
            </a>
            <span
                class="text-gray-300 dark:text-gray-500 text-xxs font-semibold ml-4 hidden sm:block">v{{env('APP_VERSION')}}</span>
        </div>

        <div class="w-full flex items-center justify-end ml-auto sm:justify-between sm:gap-x-3 sm:order-3">

            <div class="flex grow justify-end flex-wrap items-center text-sm gap-x-2 text-gray-500 dark:text-gray-400">
                <a class="inline-flex flex-shrink-0 justify-center items-center h-10 w-10 font-medium rounded-full hover:bg-gray-100 dark:hover:bg-gray-800"
                   href="{{route('admin.cache.clear')}}" data-tippy-content="Clear cache">
                    <x-ui.icon name="delete" class="w-5 h-5" stroke="currentColor"
                               stroke-width="1.75"/>
                </a>
                <a href="{{route('index')}}" target="_blank"
                   class="inline-flex flex-shrink-0 justify-center items-center h-10 w-10 font-medium rounded-full hover:bg-gray-100 dark:hover:bg-gray-800">
                    <x-ui.icon name="external" class="w-5 h-5" stroke="currentColor"/>
                </a>
                <input type="checkbox" name="light-switch" id="light-switch" class="light-switch sr-only"/>
                <label
                    class="inline-flex flex-shrink-0 justify-center items-center h-10 w-10 font-medium rounded-full hover:bg-gray-100 dark:hover:bg-gray-800 cursor-pointer"
                    for="light-switch">
                    <x-ui.icon name="moon-2" class="w-5 h-5 dark:hidden" stroke="currentColor"/>
                    <x-ui.icon name="sun-2" class="w-5 h-5 dark:block hidden" stroke="currentColor"/>
                </label>
                <div class="w-px h-5 bg-gray-200 hidden lg:block mx-4 dark:bg-gray-800"></div>
                <!-- User button -->
                <div class="relative inline-flex" x-data="{ open: false }">
                    <button
                        class="inline-flex justify-center items-center group"
                        aria-haspopup="true"
                        @click.prevent="open = !open" :aria-expanded="open" aria-expanded="false">
                        {!! gravatar(Auth::user()->name,Auth::user()->avatarurl,'h-9 w-9 rounded-full bg-primary-500 text-xs font-bold flex items-center justify-center text-white') !!}
                    </button>
                    <div
                        class="origin-top-right z-10 absolute inset-x-0 top-full mt-3 bg-white py-6 w-56 px-3 left-auto right-0 lg:-mr-1.5 lg:rounded-lg rounded-lg shadow-lg border border-gray-100 text-sm divide-y divide-gray-100 dark:bg-gray-900 dark:border-gray-900"
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
                </div>
            </div>
        </div>
    </nav>
</header>
