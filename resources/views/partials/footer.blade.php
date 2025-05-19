@if(config('settings.promote_text'))
<div class="fixed bottom-4 left-0 right-0 z-40" x-show="!promote" x-cloak>
    <div
        class="block hover:bg-gray-800 transition duration-300 max-w-2xl mx-auto bg-gray-700/80 backdrop-blur-lg w-full rounded-full p-1.5 px-4 overflow-hidden">
        <div class="flex items-center gap-x-6">
            <div class="w-12 h-12 relative">
                <img src="{{asset('static/img/promote.png')}}" class="w-full h-auto">
            </div>
            <a href="{{config('settings.promote_link')}}" class="text-base hover:underline font-medium text-white tracking-tight">{{config('settings.promote_text')}}</a>
            <div
                class="inline-flex cursor-pointer ml-auto rounded-full p-2 text-gray-500 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-50 focus:ring-gray-600  dark:hover:bg-white/20 dark:hover:backdrop-blur-lg dark:text-white/70"
                @click="promote = true">
                <x-ui.icon name="close" class="w-5 h-5" fill="currentColor"/>
            </div>
        </div>
    </div>
</div>
@endif
@if(config('settings.footer_type') == 'small')
<footer class="w-full lg:py-10 custom-container mt-auto">
    <!-- Grid -->
    <div class="text-center">

        <a class="mx-auto inline-flex mb-5" href="{{route('index')}}">
            @if(config('settings.logo'))
                <img src="{{asset('static/img/'.config('settings.logo'))}}" class="w-auto h-10"
                     alt="{{config('settings.site_name')}}">
            @else
                <x-ui.logo height="24" class="text-gray-700 dark:text-white"/>
            @endif
        </a>
        <!-- End Col -->

        <div class="text-center  max-w-2xl w-full mx-auto">
            <p class="text-gray-500 leading-6">{{config('settings.site_about')}}</p>
        </div>

        <ul class="text-center mt-4">
            @foreach(config('menus') as $menu)
                @if($menu->layout == 'all' OR $menu->layout == 'footer')
                    @if($menu->route)
                        <li class="inline-block relative pr-8 last:pr-0 last-of-type:before:hidden before:absolute before:top-1/2 before:right-3 before:-translate-y-1/2 before:content-['/'] before:text-gray-300 dark:before:text-gray-600">
                            <a class="inline-flex gap-x-2 text-sm text-gray-500 hover:text-gray-800 dark:text-gray-400 dark:hover:text-gray-200"
                               href="{{route($menu->route)}}">
                                {{__($menu->title)}}
                            </a>
                        </li>
                    @elseif($menu->url)
                        <li class="inline-block relative pr-8 last:pr-0 last-of-type:before:hidden before:absolute before:top-1/2 before:right-3 before:-translate-y-1/2 before:content-['/'] before:text-gray-300 dark:before:text-gray-600">
                            <a class="inline-flex gap-x-2 text-sm text-gray-500 hover:text-gray-800 dark:text-gray-400 dark:hover:text-gray-200"
                               href="{{$menu->url}}">
                                {{__($menu->title)}}
                            </a>
                        </li>
                    @endif
                @endif
            @endforeach
        </ul>
        <p class="text-gray-500 text-sm mt-4"> © {{date('Y')}} {{config('settings.site_name')}}. All rights reserved.</p>
    </div>
    <!-- End Grid -->
</footer>
@else
<footer class="w-full lg:py-10 custom-container mt-auto">
    <!-- Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-12 gap-10 mb-10">
        <div class="col-span-full hidden lg:col-span-4 lg:block">
            <a class="flex-none text-xl text-gray-700 font-semibold dark:text-white" href="{{route('index')}}" aria-label="Brand">

                @if(config('settings.logo'))
                    <img src="{{asset('static/img/'.config('settings.logo'))}}" class="w-auto h-10"
                         alt="{{config('settings.site_name')}}">
                @else
                    <x-ui.logo height="24" class="text-gray-700 dark:text-white"/>
                @endif
            </a>
            <p class="mt-5 text-sm text-gray-400 leading-6 max-w-sm w-full">{{config('settings.site_about')}}</p>
            <!-- Language Dropdown -->
            <div class="text-white ml-auto inline-flex relative mt-4" x-data="{ open: false }">

                <x-form.secondary class="!py-2.5 tracking-tighter !rounded-full !font-normal !px-5 gap-x-3"
                                  @click.prevent="open = !open" :aria-expanded="open" aria-expanded="false">
                    @php
                        $selectLang = \App\Models\Language::where('code',app()->getLocale())->first();
                    @endphp
                    <span>{{ $selectLang->name }}</span>
                    <x-ui.icon name="swap" class="w-4 h-4" stroke="currentColor" stroke-width="1.75"/>
                </x-form.secondary>
                <div
                    class="z-10 absolute inset-x-0 w-52 bottom-full mb-3 bg-white p-3 left-0 rounded-lg shadow-lg border border-gray-100 text-sm dark:bg-gray-800 dark:border-gray-800"
                    @click.outside="open = false" @keydown.escape.window="open = false" x-show="open"
                    x-transition:enter="transition ease-out duration-200 transform"
                    x-transition:enter-start="opacity-0 -trangray-y-2"
                    x-transition:enter-end="opacity-100 trangray-y-0"
                    x-transition:leave="transition ease-out duration-200"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0" style="display: none;">
                    <div class="w-full max-w-xs">
                        <ul class="grid grid-cols-1">
                            @foreach (\App\Models\Language::get() as $language)
                                <li>
                                    <a href="{{ route('lang.switch',$language->code)}}"
                                       class="text-gray-500 dark:text-gray-300 hover:text-primary-500 dark:hover:text-white dark:hover:bg-gray-700/50 py-2.5 px-3 rounded-lg flex gap-x-3 items-center tracking-tighter">
                                        <img src="{{asset('static/img/flags/'.$language->code.'.svg')}}"
                                             class="h-4 w-auto rounded-full">
                                        <span>{{ $language->name }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <p class="mt-3 text-xs sm:text-sm text-gray-500 dark:text-gray-500">
                © {{date('Y')}} {{config('settings.site_name')}}. All rights reserved.</p>

            <!-- Social Brands -->
            <div class="space-x-1 mt-3">
                @if(config('settings.twitter'))
                    <a class="inline-flex justify-center items-center w-10 h-10 text-center text-gray-500 hover:bg-gray-100 rounded-full focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 focus:ring-offset-white transition dark:text-gray-500 dark:hover:text-gray-200 dark:hover:bg-gray-800 dark:focus:ring-offset-slate-900"
                       href="{{config('settings.twitter')}}" target="_blank">
                        <x-ui.icon name="twitter" fill="currentColor" class="w-4 h-4"/>
                    </a>
                @endif
                @if(config('settings.facebook'))
                    <a class="inline-flex justify-center items-center w-10 h-10 text-center text-gray-500 hover:bg-gray-100 rounded-full focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 focus:ring-offset-white transition dark:text-gray-500 dark:hover:text-gray-200 dark:hover:bg-gray-800 dark:focus:ring-offset-slate-900"
                       href="{{config('settings.facebook')}}" target="_blank">
                        <x-ui.icon name="facebook" fill="currentColor" class="w-4 h-4"/>
                    </a>
                @endif
                @if(config('settings.instagram'))
                    <a class="inline-flex justify-center items-center w-10 h-10 text-center text-gray-500 hover:bg-gray-100 rounded-full focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 focus:ring-offset-white transition dark:text-gray-500 dark:hover:text-gray-200 dark:hover:bg-gray-800 dark:focus:ring-offset-slate-900"
                       href="{{config('settings.instagram')}}" target="_blank">
                        <x-ui.icon name="instagram" fill="currentColor" class="w-4 h-4"/>
                    </a>
                @endif
                @if(config('settings.youtube'))
                    <a class="inline-flex justify-center items-center w-10 h-10 text-center text-gray-500 hover:bg-gray-100 rounded-full focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 focus:ring-offset-white transition dark:text-gray-500 dark:hover:text-gray-200 dark:hover:bg-gray-800 dark:focus:ring-offset-slate-900"
                       href="{{config('settings.youtube')}}" target="_blank">
                        <x-ui.icon name="youtube" fill="currentColor" class="w-4 h-4"/>
                    </a>
                @endif
            </div>
            <!-- End Social Brands -->
        </div>
        <!-- End Col -->
        <div class=" lg:col-span-3">
            <h4 class="text-sm font-medium text-gray-700 dark:text-gray-100">{{__('Browse')}}</h4>
            <div class="mt-4 grid grid-cols-2 gap-3 text-sm">
                @foreach(config('menus') as $menu)
                    @if($menu->layout == 'all' OR $menu->layout == 'footer')
                        @if($menu->route)
                            <a href="{{route($menu->route)}}"
                               class="inline-flex gap-x-2 text-gray-600 hover:text-gray-800 hover:underline dark:text-gray-400 dark:hover:text-gray-200">
                                {{__($menu->title)}}
                            </a>
                        @elseif($menu->url)
                            <a href="{{$menu->url}}"
                               class="inline-flex gap-x-2 text-gray-600 hover:text-gray-800 hover:underline dark:text-gray-400 dark:hover:text-gray-200">
                                {{__($menu->title)}}
                            </a>
                        @endif
                    @endif
                @endforeach

            </div>
        </div>
        <!-- End Col -->

        <div class=" lg:col-span-3">
            <h4 class="text-sm font-medium text-gray-700 dark:text-gray-100">{{__('About')}}</h4>
            <div class="mt-4 grid grid-cols-2 gap-3 text-sm">
                @foreach(config('pages') as $page)
                    <a href="{{route('page',$page->slug)}}"
                       class="inline-flex gap-x-2 text-gray-600 hover:text-gray-800 hover:underline dark:text-gray-400 dark:hover:text-gray-200">
                        {{$page->title}}
                    </a>
                @endforeach
            </div>
        </div>

    </div>
    <!-- End Grid -->

</footer>
@endif
@if(config('settings.cookie'))
    <div
        class="fixed bottom-4 right-4 z-[60] sm:max-w-lg" x-show="!cookiePolicy" x-cloak>
        <!-- Card -->
        <div class="p-7 bg-white rounded-2xl shadow-sm dark:bg-gray-800">
            <div class="flex gap-x-6">
                <svg class="h-10" xmlns="http://www.w3.org/2000/svg"
                     xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                     viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
<path style="fill:#FFC033;" d="M471.801,434.713C423.206,484.554,358.118,512,288.536,512c-13.594,0-26.945-1.07-39.97-3.114
	C126.312,489.645,32.533,383.558,32.533,255.997c0-68.08,26.308-132.124,74.091-180.327c38.833-39.172,88.241-64.261,141.941-72.588
	c12.376-1.936,24.968-2.965,37.723-3.074c27.798-0.217,55.217,3.967,81.444,12.498c8.652,2.816,15.49,9.681,18.279,18.347
	c2.789,8.652,1.232,18.184-4.143,25.482c-19.308,26.254-29.517,57.41-29.517,90.109c0,48.636,22.422,93.197,61.54,122.267
	c8.896,6.608,12.863,18.239,9.884,28.949c-1.977,7.095-2.979,14.434-2.979,21.813c0,30.574,16.898,58.29,44.087,72.358
	c7.555,3.9,12.877,11.252,14.244,19.674C480.48,419.927,477.745,428.606,471.801,434.713z"/>
                    <path style="fill:#F9A926;" d="M471.801,434.713C423.206,484.554,358.118,512,288.536,512c-13.594,0-26.945-1.07-39.97-3.114V3.082
	c12.376-1.936,24.968-2.965,37.723-3.074c27.798-0.217,55.217,3.967,81.444,12.498c8.652,2.816,15.49,9.681,18.279,18.347
	c2.789,8.652,1.232,18.184-4.143,25.482c-19.308,26.254-29.517,57.41-29.517,90.109c0,48.636,22.422,93.197,61.54,122.267
	c8.896,6.608,12.863,18.239,9.884,28.949c-1.977,7.095-2.979,14.434-2.979,21.813c0,30.574,16.898,58.29,44.087,72.358
	c7.555,3.9,12.877,11.252,14.244,19.674C480.48,419.927,477.745,428.606,471.801,434.713z"/>
                    <path style="fill:#A6673A;" d="M270.027,177.519c0,31.237-25.401,56.638-56.638,56.638s-56.638-25.401-56.638-56.638
	s25.401-56.638,56.638-56.638S270.027,146.282,270.027,177.519z"/>
                    <path style="fill:#99522E;" d="M270.027,177.519c0,31.237-25.401,56.638-56.638,56.638V120.88
	C244.625,120.88,270.027,146.282,270.027,177.519z"/>
                    <path style="fill:#A6673A;" d="M253.63,315.709c0,35.665-29.03,64.681-64.695,64.681s-64.681-29.016-64.681-64.681
	s29.016-64.695,64.681-64.695S253.63,280.044,253.63,315.709z"/>
                    <path style="fill:#99522E;" d="M253.63,315.709c0,35.665-29.03,64.681-64.695,64.681V251.014
	C224.6,251.014,253.63,280.044,253.63,315.709z"/>
                    <path style="fill:#A6673A;" d="M356.751,362.314c0,27.134-22.084,49.218-49.232,49.218c-27.134,0-49.218-22.084-49.218-49.218
	c0-27.148,22.084-49.232,49.218-49.232C334.667,313.082,356.751,335.166,356.751,362.314z"/>
                    <path style="fill:#99522E;" d="M356.751,362.314c0,27.134-22.084,49.218-49.232,49.218v-98.45
	C334.667,313.082,356.751,335.166,356.751,362.314z"/>
</svg>


                <p class="text-sm text-gray-800 dark:text-gray-200">
                    {!! __('By browsing this website, you accept our :cookie.', ['cookie' => mb_strtolower('<a href="'.config('settings.cookie_url').'" target="_blank" class="inline-flex items-center gap-x-1.5 text-primary-500 decoration-2 hover:underline font-medium">'. __('Cookies Policy').'</a>')]) !!}
                </p>

                <div>
                    <button type="button"
                            class="inline-flex rounded-full p-2 text-gray-500 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-50 focus:ring-gray-600  dark:hover:bg-gray-600 dark:text-gray-400"
                            @click="cookiePolicy = true">
                        <span class="sr-only">Dismiss</span>
                        <x-ui.icon name="close" class="w-5 h-5" fill="currentColor"/>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endif
