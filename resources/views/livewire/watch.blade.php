<div class="mb-6" x-data="{stream:'0'}">
    @if((($listing->type == 'movie' AND $listing->member == 'active') OR (isset($listing->post->type) AND $listing->post->type == 'tv' AND $listing->post->member == 'active')) AND (auth()->check() && (empty(auth()->user()->plan_recurring_at) OR auth()->user()->plan_recurring_at < now()) OR !auth()->check()))
        <div
            class="aspect-video relative before:absolute transition before:inset-0 before:bg-gradient-to-b before:from-gray-950 before:to-transparent before:z-10 after:absolute after:inset-0 after:bg-gradient-to-t after:from-gray-950 after:to-transparent after:via-gray-950/60 after:z-10"
            x-cloak="">
            <div
                class="absolute inset-0 before:absolute before:right-0 before:top-0 before:bottom-0 before:w-1/5 before:bg-gradient-to-l before:from-gray-950 before:to-transparent after:absolute after:left-0 after:top-0 after:bottom-0 after:w-1/2 after:bg-gradient-to-r after:from-gray-950 after:to-transparent z-10"></div>
            <img src="{{$cover}}"
                 class="absolute h-full w-full object-cover">
            <div class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 z-20 w-full">
                <div class="max-w-4xl w-full mx-auto text-center">
                    <h3 class="text-3xl 2xl:text-6xl font-bold text-white mb-4 tracking-widest texture-text">{{__('Exclusive to subscriber')}}</h3>
                    <p class="mt-2 text-lg lg:text-2xl text-gray-800 dark:text-gray-400  tracking-wide texture-text capitalize">{{__('You have to subscribe to watch')}}</p>
                    <x-form.primary size="lg" href="{{route('subscription.index')}}"
                                    class="!px-8 xl:!px-14 text-sm mt-6 !rounded-full">{{__('Subscribe')}}</x-form.primary>
                </div>
            </div>
        </div>
    @else
        @if(config('settings.preloader') == 'active' AND $isPreloader == true)
            <div
                class="aspect-video relative before:absolute transition before:inset-0 before:bg-gradient-to-b before:from-gray-950 before:to-transparent before:z-10 after:absolute after:inset-0 after:bg-gradient-to-t after:from-gray-950 after:to-transparent after:via-gray-950/60 after:z-10"
                x-cloak="">
                <div
                    class="absolute inset-0 before:absolute before:right-0 before:top-0 before:bottom-0 before:w-1/5 before:bg-gradient-to-l before:from-gray-950 before:to-transparent after:absolute after:left-0 after:top-0 after:bottom-0 after:w-1/2 after:bg-gradient-to-r after:from-gray-950 after:to-transparent z-10"></div>
                <img src="{{$cover}}"
                     class="absolute h-full w-full object-cover">

                <div
                    class="flex absolute left-1/2 top-1/2 -translate-x-1/2 z-20 -translate-y-1/2 h-16 w-16 lg:w-24 lg:h-24 items-center justify-center hover:scale-110 cursor-pointer rounded-full bg-gray-300/25 text-white transition"
                    wire:click="watching">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                        class="lg:h-9 lg:w-9 w-6 h-6 translate-x-0.5"
                    >
                        <path
                            d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"
                        />
                    </svg>
                </div>
            </div>

        @else
            @if(empty($videos))
                <div
                    class="aspect-video relative before:absolute transition before:inset-0 before:bg-gradient-to-b before:from-gray-950 before:to-transparent before:z-10 after:absolute after:inset-0 after:bg-gradient-to-t after:from-gray-950 after:to-transparent after:via-gray-950/60 after:z-10"
                    x-cloak="">
                    <div
                        class="absolute inset-0 before:absolute before:right-0 before:top-0 before:bottom-0 before:w-1/5 before:bg-gradient-to-l before:from-gray-950 before:to-transparent after:absolute after:left-0 after:top-0 after:bottom-0 after:w-1/2 after:bg-gradient-to-r after:from-gray-950 after:to-transparent z-10"></div>
                    <img src="{{$cover}}"
                         class="absolute h-full w-full object-cover">
                    <div class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 z-20">
                        <div class="max-w-2xl mx-auto text-center">
                            <h3 class="text-3xl 2xl:text-6xl font-bold text-white mb-4 tracking-widest texture-text">{{__('Upcoming')}}</h3>
                            <p class="mt-2 text-lg lg:text-2xl text-gray-800 dark:text-gray-400  tracking-wide texture-text capitalize">{{__('Stay tuned, video will be added soon')}}</p>
                        </div>
                    </div>
                </div>
            @else
                <div class="-mx-3 lg:mx-0">
                    <iframe id="video-iframe" class="aspect-video !w-full !h-auto rounded-lg" width="1280" height="720"
                            src="{{ $videos[0]['link'] ?? '' }}" title="Video player" frameborder="0"
                            allowfullscreen
                            allowtransparency></iframe>
                </div>
                @if(count($videos)>1)
                    <div class="my-4 text-center">
                        <ul class="inline-flex overflow-x-auto lg:overflow-x-visible flex-nowrap max-w-full gap-x-3 whitespace-nowrap">
                            @foreach($videos as $key => $video)
                                <li>
                                    <button
                                        class="w-full py-3 px-5 inline-flex justify-center items-center gap-2 text-sm font-medium tracking-tighter text-center text-gray-500 rounded-full bg-gray-50 dark:bg-gray-800 relative after:hidden lg:after:block after:absolute after:-bottom-3 after:rounded-full after:left-0 after:right-0 after:h-1 dark:text-gray-400 dark:hover:text-gray-300 dark:hover:bg-gray-700"
                                        :class="{ '!bg-primary-500 !text-white before:absolute before:w-6 before:h-6 before:-z-10 before:rounded before:rotate-45 before:bg-primary-500 before:left-1/2 before:-translate-x-1/2 before:-top-1': stream === '{{$loop->index}}'}"
                                        x-on:click="stream = '{{$loop->index}}';  document.getElementById('video-iframe').src = '{{$video['link']}}';">
                                        <x-ui.icon name="link" class="w-4 h-4" fill="currentColor"/>
                                        <span>{{ $video['label'] ?? __('Stream').' #'.$key+1 }}</span>
                                    </button>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            @endif
        @endif
    @endif
</div>
