<div>
    @if($type == 'tv')
        <div x-data="{ openSort: @entangle('openSort').live }">
            <div class="relative inline-flex">
                <button
                    class="py-3 px-4 inline-flex justify-center items-center gap-3 text-sm text-center text-gray-500 dark:bg-gray-800 rounded-lg hover:bg-gray-50 relative after:absolute after:-bottom-2.5 after:rounded-full after:left-0 after:right-0 after:h-1 dark:text-gray-300 dark:hover:text-gray-200 tracking-tight font-medium"
                    @click.prevent="openSort = !openSort" :aria-expanded="openSort" aria-expanded="false">
                    <span>{{$selectSeason->name}}</span>
                    <x-ui.icon name="sort-2" class="w-4 h-4" stroke="currentColor"/>
                </button>
                <div
                    class="origin-top-right z-40 absolute inset-x-0 top-full mt-1 bg-white py-3 w-48 px-3 right-auto left-0 rounded-lg shadow-lg border border-gray-100 text-sm dark:bg-gray-800 dark:border-gray-800"
                    @click.outside="openSort = false" @keydown.escape.window="openSort = false" x-show="openSort"
                    x-transition:enter="transition ease-out duration-200 transform"
                    x-transition:enter-start="opacity-0 -trangray-y-2"
                    x-transition:enter-end="opacity-100 trangray-y-0"
                    x-transition:leave="transition ease-out duration-200"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0" style="display: none;">
                    <div class="flex flex-col">
                        @if(count($model->seasons) > 0 )
                            @foreach($model->seasons as $season)
                                <button
                                    class="w-full py-1.5 px-2 inline-flex items-center gap-5 text-sm text-center text-gray-500 rounded-lg hover:bg-gray-50 relative  dark:text-gray-400 dark:hover:text-gray-300 dark:hover:bg-gray-800/50"
                                    wire:click="updateSeason('{{$season->id}}')">
                                    {{$season->name}}
                                </button>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>


            <div class="grid grid-cols-2 lg:grid-cols-6 2xl:grid-cols-8 gap-6 mt-4">
                @foreach($selectSeason->episodes as $episode)
                    <x-ui.episode :title="$episode->name" :listing="$episode" :image="$episode->imageurl"/>
                @endforeach
            </div>
        </div>
    @else
        <div class="bg-gray-900 h-full max-h-[30rem] rounded-lg" x-data="{ openSort: @entangle('openSort').live }">
            <div class="relative">
                <button
                    class="h-14 w-full px-5 flex items-center justify-start rtl:justify-end gap-5 text-sm text-gray-500 dark:bg-gray-900 rounded-md hover:bg-gray-50 dark:text-gray-300 dark:hover:text-gray-200 tracking-tight font-medium"
                    @click.prevent="openSort = !openSort" :aria-expanded="openSort" aria-expanded="false">
                    <x-ui.icon name="sort-2" class="w-4 h-4" stroke="currentColor"/>
                    <div class="flex-1 text-left rtl:text-right">{{$selectSeason->name}}</div>
                </button>
                <div
                    class="origin-top-right z-40 absolute inset-x-0 top-full mt-1 bg-white py-3 w-48 px-3 right-auto rtl:right-0 rtl:left-auto left-0 rounded-lg shadow-lg border border-gray-100 text-sm dark:bg-gray-800 dark:border-gray-800"
                    @click.outside="openSort = false" @keydown.escape.window="openSort = false" x-show="openSort"
                    x-transition:enter="transition ease-out duration-200 transform"
                    x-transition:enter-start="opacity-0 -trangray-y-2"
                    x-transition:enter-end="opacity-100 trangray-y-0"
                    x-transition:leave="transition ease-out duration-200"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0" style="display: none;">
                    <div class="flex flex-col">
                        @if(count($model->seasons) > 0 )
                            @foreach($model->seasons as $season)
                                <button
                                    class="w-full py-2.5 px-4 inline-flex items-center gap-5 text-sm text-center text-gray-500 rounded-lg hover:bg-gray-50 relative  dark:text-gray-400 dark:hover:text-gray-300 dark:hover:bg-gray-800/50"
                                    wire:click="updateSeason('{{$season->id}}')">
                                    {{$season->name}}
                                </button>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>

            <div
                class="overflow-y-auto scrollbar-y h-[calc(30rem-7rem)] scrollbar scrollbar-thumb-gray-100 dark:scrollbar-thumb-white/10 scrollbar-thin scrollbar-track-transparent">
                <div class="mx-3">
                    @foreach($selectSeason->episodes as $episode)
                        <a href="{{route('episode',['slug'=>$episode->post->slug,'season'=>$episode->season->season_number,'episode'=>$episode->episode_number])}}"
                           class="flex transition items-center px-3 py-2.5 space-x-4 line-clamp-1 text-gray-400 text-sm hover:text-primary-500 hover:bg-primary-500/10 @if(isset(Auth::user()->id) AND $episode->isLog(Auth::user())){{'opacity-40'}}@endif rounded-md @if($selectEpisode == $episode->episode_number){{'text-primary-500 bg-primary-500/10 !opacity-100'}}@endif">
                            <div
                                class="min-w-[90px] font-medium">{{__('Episode #:number',['number'=>$episode->episode_number])}}</div>
                            <div class=" line-clamp-1">{{$episode->name}}</div>
                        </a>
                    @endforeach
                </div>
            </div>
            <div class="flex items-center gap-x-6 h-14 px-6">
                <div class="flex-1 text-gray-400/50 text-sm">
                    {{__('Go to episode')}}
                </div>
                <form method="post" class="bg-gray-800 rounded-lg relative text-white flex items-center py-2 px-3"
                      wire:submit="goto">
                    @csrf
                    <input type="number" required wire:model.live="episode_number"
                           class="bg-transparent w-8 text-center py-0.5 px-1 text-sm border-0 focus:ring-0" value="">
                    <button type="submit" class="text-gray-300">
                        <svg aria-hidden="true" class="w-4 h-4 rotate-90" fill="currentColor" viewBox="0 0 20 20"
                             xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"></path>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    @endif
</div>