<div class="pb-6 lg:pb-16" x-data="{filterOpen:@entangle('filterOpen'),loading:@entangle('loading')}">
    <div class="custom-container">

        @if(config('settings.listing_filter') == 'v2')
            @include('browse.partials.filterv2')
        @else
            @include('browse.partials.filterv1')
        @endif
        @if(config('settings.listing_genre') == 'active')
            @include('browse.partials.genre')
        @endif
        <div class="grid grid-cols-2 xl:grid-cols-6 2xl:grid-cols-8 gap-6">
            @for ($i = 1; $i <=8; $i++)
                <div class="relative group animate-pulse" wire:loading wire:target="filter">
                    <div
                        class="aspect-[2/3] relative bg-gray-900 rounded-lg">
                    </div>
                    <div
                        class="pt-4 transition">
                        <div class="text-xs text-white/50 space-x-3 mb-2 flex items-center">
                            <span class="h-3 w-20 rounded-lg bg-gray-900 block"></span>
                            <span class="h-3 w-14 rounded-lg bg-gray-900 block"></span>
                        </div>
                        <h3 class="text-sm tracking-tighter font-medium text-gray-300 line-clamp-1">
                            <div class="w-10/12 h-4 rounded-lg bg-gray-900"></div>
                        </h3>
                    </div>
                </div>
            @endfor
        </div>
        <div class="grid grid-cols-2 xl:grid-cols-6 2xl:grid-cols-8 gap-6" wire:loading.remove wire:target="filter">

            @foreach($listings as $listing)
                <x-ui.post :listing="$listing" :title="$listing->title" :image="$listing->imageurl"
                           :vote="$listing->vote_average"
                           :genres="$listing->genres"/>

                @if($loop->index == 7)
                    <div class="col-span-full">
                        @include('partials.ads',['id'=> 3])
                    </div>
                @endif
                @if($loop->index == 7 AND (empty($page) OR $page == 1) AND config('settings.top_week') == 'active')

                    <div class="col-span-full">
                        <div class="xl:py-5">
                            <div class="rounded-xl h-full p-6 xl:p-8 bg-gray-900">
                                <h3 class="text-xl font-semibold text-gray-700 dark:text-gray-300 mb-5 flex items-center space-x-3">
                                    <span class="text-2xl">🔥</span>
                                    <span>{{__('Top this week')}}</span>
                                </h3>
                                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                                    @foreach($recommends as $recommend)
                                        <div class="flex space-x-8 items-center relative">
                                            <a href="{{route($recommend->type,$recommend->slug)}}"
                                               class="flex-1 group flex gap-x-6">

                                                <div
                                                    class="aspect-[2/3] w-16 relative bg-gray-900 rounded-md transition overflow-hidden cursor-pointer group-hover:opacity-60">
                                                    <img src="{{$recommend->imageurl}}"
                                                         class="absolute h-full w-full object-cover">

                                                </div>
                                                <div class="flex-1">

                                                    <div class="text-xs text-white/50 space-x-3 mb-0.5">
                                                        @if($recommend->runtime)
                                                            <span>{{__(':time min',['time' => $recommend->runtime])}}</span>
                                                        @endif
                                                        @if($recommend->release_date)
                                                            <span>{{$recommend->release_date->translatedFormat('Y')}}</span>
                                                        @endif
                                                    </div>
                                                    <h3 class="text-sm tracking-tighter group-hover:underline font-medium text-gray-300 line-clamp-1">{{$recommend->title}}</h3>
                                                    <div
                                                        class="text-xs text-white/50 space-x-3 mt-2 flex items-center">
                                                        @foreach($recommend->genres->slice(0, 1) as $genre)
                                                            <span>{{$genre->title}}</span>
                                                        @endforeach
                                                        <span
                                                            class="text-xxs bg-gray-800 rounded py-0.5 px-1.5 text-gray-300">{{$recommend->type == 'movie' ? __('Movie') : __('TV Show')}}</span>
                                                    </div>
                                                </div>

                                                <div
                                                    class="relative flex w-11 h-11 items-center justify-center text-white z-20 mr-6">
                                                    <span class="text-xs">{{$recommend->vote_average}}</span>
                                                    <svg x="0px" y="0px" viewBox="0 0 36 36"
                                                         class="absolute -inset-0 text-amber-400 bg-amber-400/20 w-11 h-11 rounded-full">
                                                        <circle fill="none" stroke="currentColor" stroke-width="3"
                                                                cx="18" cy="18" r="16"
                                                                stroke-dasharray="{{round($recommend->vote_average / 10 * 100)}} 100"
                                                                stroke-linecap="round" stroke-dashoffset="0"
                                                                transform="rotate(-90 18 18)"></circle>
                                                    </svg>
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-full hidden 2xl:block">

                    </div>
                @endif
            @endforeach
        </div>
        {{ $listings->links() }}
    </div>

</div>

