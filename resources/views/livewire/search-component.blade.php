<div>

    <div class="fixed inset-0 bg-gray-950/30 backdrop-blur-sm z-50 transition-opacity"
         x-show="searchOpen" x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-out duration-100" x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0" aria-hidden="true" style="display: none;"></div>
    <!-- Modal dialog -->
    <div id="search-modal"
         class="fixed inset-0 z-50 overflow-hidden flex items-start top-20 mb-4 justify-center px-4 sm:px-6"
         role="dialog" aria-modal="true" x-show="searchOpen"
         x-transition:enter="transition ease-in-out duration-200"
         x-transition:enter-start="opacity-0 trangray-y-4"
         x-transition:enter-end="opacity-100 trangray-y-0"
         x-transition:leave="transition ease-in-out duration-200"
         x-transition:leave-start="opacity-100 trangray-y-0"
         x-transition:leave-end="opacity-0 trangray-y-4" style="display: none;">
        <div class="bg-white overflow-auto max-w-3xl w-full max-h-full rounded-xl px-2 py-1"
             @click.outside="searchOpen = false" @keydown.escape.window="searchOpen = false">
            <!-- Search form -->
            <div class="relative">
                <label for="modal-search" class="sr-only">Search</label>
                <input id="modal-search"
                       class="w-full border-0 focus:ring-transparent bg-transparent placeholder-gray-400/50 text-sm appearance-none py-3 pl-14 pr-4"
                       type="search" placeholder="{{__('Search')}} .." x-ref="searchInput" name="q" wire:model.live.debounce.500ms="q"/>
                <button class="absolute inset-0 right-auto group" type="submit" aria-label="Search">
                    <x-ui.icon name="search" stroke-width="2"
                               class="w-5 h-5 shrink-0 fill-current text-gray-400 group-hover:text-gray-500 ml-4 mr-4"/>
                </button>
                <div role="status" class="absolute right-0 top-1/2 -translate-y-1/2" wire:loading>
                    <svg aria-hidden="true" class="inline w-6 h-6 mr-3 text-gray-200 animate-spin dark:text-gray-100 fill-primary-500" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                    </svg>
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            @if(count($posts)>0)
                <div class="mb-3 last:mb-0 py-4 px-2">
                    <div class="text-xs text-gray-400 px-2 mb-2">{{__('Results')}}</div>
                    <ul class="text-sm">
                        @foreach($posts as $post)
                            <li>
                                <a class="text-sm text-gray-600 p-2 dark:text-gray-200 flex space-x-6 group items-center"
                                   href="{{route($post->type,$post->slug)}}">
                                    <div class="aspect-poster bg-gray-100 rounded-md w-14 overflow-hidden relative">
                                        {!! picture($post->imageurl,config('attr.poster.size_x').','.config('attr.poster.size_y'),'absolute h-full w-full object-cover rounded-md',$post->title,'post') !!}
                                    </div>
                                    <div class="">
                                        <div
                                            class="font-medium group-hover:underline mb-1 text-gray-700 line-clamp-1">{{$post->title}}</div>
                                        <div class="text-xs text-gray-400 dark:text-gray-500 line-clamp-2">{{Str::limit($post->overview,80)}}</div>
                                    </div>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="border-t text-center border-gray-100 mt-3">
                    <a href="{{route('search',$q)}}"
                       class="text-sm text-gray-400 hover:underline py-3 px-4 inline-flex hover:text-primary-500">{{__('View all result')}}</a>
                </div>
            @endif
        </div>
    </div>
</div>
