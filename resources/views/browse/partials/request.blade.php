
<div class="relative overflow-hidden">
    <div
        class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-24 before:absolute before:-top-14 before:start-1/2 before:bg-[url('../img/hero.svg')] before:opacity-40 before:bg-no-repeat before:bg-top before:w-full before:h-full before:-z-[1] before:transform before:-translate-x-1/2 relative">
        <div class="text-center">
            <h1 class="text-4xl font-semibold text-gray-800 dark:text-gray-200">
                {{__('Movie & TV Show Request')}}
            </h1>
            <p class="mt-3 text-gray-600 dark:text-gray-400">
                {{__('Request the movies and series you want to see or watch here, and we\'ll add them quickly')}}
            </p>
            <div class="mt-7 sm:mt-12 mx-auto max-w-4xl relative">
                <form method="post" action="{{route('requestPost')}}" class="flex text-gray-400 relative"
                      @keydown.window.ctrl.q="$refs.searchInput.focus();">
                    @csrf
                    <div class="absolute left-6 top-1/2 -translate-y-1/2">
                        <x-ui.icon name="search" stroke-width="2" class="w-5 h-5"/>
                    </div>
                    <input type="text" name="q"
                           class="placeholder-gray-400/60 text-gray-700 h-14 lg:h-16 px-16 flex-1 w-full text-sm bg-white dark:bg-gray-900 dark:border-gray-800 shadow-gray-100 shadow-sm dark:text-white dark:shadow-none border border-gray-300/80 rounded-full focus:border-primary-500 focus:ring-primary-500 focus:bg-white focus:dark:border-primary-500"
                           placeholder="{{__('Search')}} .." x-ref="searchInput">

                    <div
                        class="font-sans text-xs font-medium flex items-center gap-x-5 absolute right-8 top-1/2 -translate-y-1/2">
                        <div>
                            <input type="radio" id="movie" name="type" value="movie" class="hidden peer"
                                   checked>
                            <label for="movie"
                                   class="text-gray-500 cursor-pointer dark:hover:text-gray-200 dark:peer-checked:text-gray-200 hover:text-white dark:text-gray-400">
                                <div class="block">{{__('Movie')}}</div>
                            </label>
                        </div>
                        <div>
                            <input type="radio" id="tv" name="type" value="tv" class="hidden peer">
                            <label for="tv"
                                   class="text-gray-500 cursor-pointer dark:hover:text-gray-200 dark:peer-checked:text-gray-200 hover:text-white dark:text-gray-400">
                                <div class="block">{{__('TV Show')}}</div>
                            </label>
                        </div>
                    </div>
                </form>

            </div>

        </div>
    </div>
</div>
@if(!empty($listings))
    <div class="grid grid-cols-2 xl:grid-cols-5 2xl:grid-cols-8 gap-8">
        @foreach($listings as $listing)
            <x-ui.request-post :listing="$listing"/>
        @endforeach
    </div>
@endif