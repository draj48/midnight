<aside id="sidebar"
       class="fixed top-16 xl:top-16 group bottom-0 left-0 bg-white lg:flex lg:translate-x-0 lg:right-auto lg:bottom-0 dark:scrollbar-y flex flex-col z-50 dark:bg-gray-950 w-full lg:w-64 lg:py-0 py-3" :class="sidebarToggle ? 'translate-x-0' : '-translate-x-full'" @click.outside="sidebarToggle = false">
    <ul class="flex flex-col overflow-y-auto scrollbar-y px-4 scrollbar-y h-[calc(100%-7rem)] scrollbar scrollbar-thumb-gray-100 dark:scrollbar-thumb-white/10 scrollbar-thin scrollbar-track-transparent text-sm pb-10 flex-1 text-gray-500 dark:text-gray-500"
        x-data="{selected: @if(isset($config['nav'])){{"'".$config['nav']."'"}}@else{{"'main'"}}@endif}">

        @foreach (config('attr.admin') as $key => $value)
            @if (isset($value['header']) AND $value['header'] == 'true')
                <li class="text-gray-300 dark:text-gray-500 px-4 text-xs mb-4 {{$value['class']}}">
                    {{$value['title']}}
                </li>
            @elseif (isset($value['line']) AND $value['line'] == 'true')
                <li class="border-t border-gray-100/60 dark:border-gray-800 my-5 {{$value['class']}} @if(isset($value['class'])){{$value['class']}}@endif"></li>

            @elseif (isset($value['type']) AND $value['type'] == 'link')
                <li>
                    <a href=""
                       class="hover:underline hover:dark:bg-gray-800/50 hover:dark:text-white hover:text-gray-700 rounded-lg dark:text-gray-400 py-2 px-4 flex items-center gap-5 ease-in-out duration-300">
                        @if(isset($value['icon']))
                            <x-ui.icon name="{{$value['icon']}}" class="w-5 h-5" stroke="currentColor"
                                       stroke-width="1.75"/>
                        @endif
                        <div class="flex-1 dark:font-normal">{{__($value['title'])}}</div>
                    </a>
                </li>
            @else
                <li>
                    <a href="@if (isset($value['menu'])){{'javascript:;'}}@elseif (Route::has($key)){{ route($key) }}@endif"
                       class="font-medium hover:bg-gray-100 hover:dark:bg-gray-800/50 hover:dark:text-white hover:text-gray-700 rounded-lg dark:text-gray-400 py-3 px-4 flex items-center gap-x-5 ease-in-out duration-300"
                       @click="selected !== '{{$value['nav']}}' ? selected = '{{$value['nav']}}' : selected = false"
                       x-bind:class="selected === '{{$value['nav']}}' ? 'dark:text-white text-gray-600 bg-gray-100 dark:bg-gray-800/50': ''">

                        @if(isset($value['icon']))
                            <div class="w-5 h-5 flex items-center justify-center">
                                <x-ui.icon name="{{$value['icon']}}" class="w-5 h-5" stroke="currentColor"
                                           stroke-width="1.75"/>
                            </div>
                        @endif

                        @if(isset($value['subtext']))
                            <div class="flex-1">
                                <div class="dark:font-normal flex-1">{{__($value['title'])}}</div>
                                @if($value['subtext'])
                                    @if($value['nav'] == 'comment')
                                        <div
                                            class="text-xs opacity-50 font-normal mt-1">{{__($value['subtext'],['total' => short_number(\App\Models\Comment::where('status','draft')->count())])}}</div>
                                    @elseif($value['nav'] == 'report')
                                        <div
                                            class="text-xs opacity-50 font-normal mt-1">{{__($value['subtext'],['total' => short_number(\App\Models\Report::where('status','pending')->count())])}}</div>
                                    @endif
                                @endif
                            </div>
                        @else
                            <div class="flex-1 dark:font-normal">{{__($value['title'])}}</div>
                        @endif
                        @if (isset($value['menu']))
                            <svg class="text-gray-400 h-4 w-4 shrink-0" x-state:on="Expanded"
                                 x-state:off="Collapsed"
                                 :class="{ 'rotate-90 text-gray-500': selected === '{{$value['nav']}}', 'text-gray-400': !(open) }"
                                 viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" x-transition>
                                <path fill-rule="evenodd"
                                      d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z"
                                      clip-rule="evenodd"></path>
                            </svg>
                        @endif
                    </a>

                    @if (isset($value['menu']))
                        <ul class="overflow-hidden transition-[height] duration-1000" x-cloak=""
                            x-bind:class="selected === '{{$value['nav']}}' ? 'pt-2 pb-3 h-auto' : 'h-0'" x-transition>
                            @foreach ($value['menu'] as $subKey => $subValue)
                                <li class="last:mb-0">
                                    <a class="px-5 py-1 text-sm text-gray-500/80 dark:text-gray-400/70 hover:text-gray-700 dark:hover:text-gray-300 flex gap-x-7 items-center"
                                       href="@if (Route::has($subKey)){{ route($subKey) }}@endif">
                                        <span
                                            class="ml-1 inline-flex h-1 w-1 rounded-full bg-current transition-all duration-200 opacity-40"></span>
                                        <span class="flex-1">{{__($subValue['title'])}}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </li>
            @endif
        @endforeach
    </ul>
</aside>
