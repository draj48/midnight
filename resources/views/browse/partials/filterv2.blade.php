<div class="pb-4 mb-2" x-data="{ expanded: false }">

    <div class="lg:flex items-center gap-x-6 xl:gap-x-10">
        <div class="flex items-center">
            <h1 class="text-2xl font-semibold dark:text-white tracking-tighter flex-1">{{$param['heading']}}</h1>
            <button
                class="w-6 h-6 flex xl:hidden items-center justify-center rounded-full dark:text-gray-400 ml-auto text-gray-700"
                @click="expanded = ! expanded">
                <x-ui.icon name="filter" class="w-6 h-6" fill="currentColor"/>
            </button>
        </div>
        <form method="get"
              class="items-center gap-0 lg:gap-1 my-4 lg:my-0 flex-col lg:flex-row ml-auto hidden xl:flex tracking-tight"
              :class="expanded ? '!flex xl:flex' : 'hidden'"
              wire:submit="filter">
            @csrf

            <div class="relative w-full lg:w-auto" x-data="{ open: false}">
                <button type="button"
                        class="w-full py-2.5 px-3 inline-flex justify-center items-center gap-3 text-sm font-medium text-center text-gray-500 rounded-lg dark:text-gray-400 dark:hover:text-gray-300"
                        @click.prevent="open = !open" :aria-expanded="open" :class="open ? 'dark:!text-gray-300' : ''">
                    <span class="@if(isset($release)) {{'dark:!text-gray-100'}}@endif">{{__('Type')}}</span>
                    <span
                        class="rounded bg-gray-200 dark:bg-gray-800 dark:text-gray-300 px-1.5  text-xxs font-semibold tabular-nums capitalize hidden @if(isset($type)) {{'!block'}}@endif text-gray-700">{{isset($type) ? __(config('attr.types')[$type]) : null}}</span>
                    <x-ui.icon name="sort-2" class="w-4 h-4 ml-auto" stroke="currentColor"/>
                </button>
                <div
                    class="z-10 absolute top-full bg-white p-6 mt-3 left-0 xl:left-1/2 xl:-translate-x-1/2 rounded-xl shadow-lg w-full lg:w-[24rem] text-sm dark:bg-gray-900"
                    @click.outside="open = false" @keydown.escape.window="open = false" x-show="open"
                    x-transition:enter="transition ease-out duration-200 transform"
                    x-transition:enter-start="opacity-0 -trangray-y-2"
                    x-transition:enter-end="opacity-100 trangray-y-0"
                    x-transition:leave="transition ease-out duration-200"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0" style="display: none;">


                    <div class="gap-2 flex flex-wrap">

                        <div>
                            <input type="radio" id="typeall" name="type"
                                   value="all" class="hidden peer" @if(empty($type)){{'checked'}}@endif>
                            <label for="typeall"
                                   class="inline-flex items-center justify-between w-full py-2 px-3.5 text-gray-500 bg-white rounded-full text-xs cursor-pointer dark:hover:text-gray-200 peer-checked:!bg-primary-500 peer-checked:!text-white hover:text-gray-600 dark:peer-checked:text-gray-300 peer-checked:text-gray-600 hover:bg-gray-50 dark:text-gray-300 dark:bg-gray-800 dark:hover:bg-gray-700">
                                {{__('All')}}
                            </label>
                        </div>
                        @foreach(config('attr.types') as $valueType => $keyType)
                            <div>
                                <input type="radio" id="type{{$keyType}}" name="type" wire:model="type"
                                       value="{{$valueType}}" class="hidden peer">
                                <label for="type{{$keyType}}"
                                       class="inline-flex items-center justify-between w-full py-2 px-3.5 text-gray-500 bg-white rounded-full text-xs cursor-pointer dark:hover:text-gray-200 peer-checked:!bg-primary-500 peer-checked:!text-white hover:text-gray-600 dark:peer-checked:text-gray-300 peer-checked:text-gray-600 hover:bg-gray-50 dark:text-gray-300 dark:bg-gray-800 dark:hover:bg-gray-700">
                                    {{__($keyType)}}
                                </label>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-6 space-x-3">
                        <x-form.secondary type="submit" size="md"
                                          class="!text-xsx min-w-[16rem] w-full !rounded-full"
                                          x-on:click="open = false">{{__('Apply')}}</x-form.secondary>
                    </div>
                </div>
            </div>
            <div class="relative w-full lg:w-auto" x-data="{ open: false}">
                <button type="button"
                        class="w-full py-2.5 px-3 inline-flex justify-center items-center gap-3 text-sm font-medium text-center text-gray-500 rounded-lg dark:text-gray-400 dark:hover:text-gray-300"
                        @click.prevent="open = !open" :aria-expanded="open" :class="open ? 'dark:!text-gray-300' : ''">
                        <span
                            class="@if(isset($genre) AND count($genre) > 0) {{'dark:!text-gray-100'}}@endif">{{__('Genre')}}</span>
                    <span
                        class="rounded bg-gray-200 dark:bg-gray-800 dark:text-gray-300 px-1.5  text-xxs font-semibold tabular-nums capitalize hidden @if(isset($genre) AND count($genre) > 0) {{'!block'}}@endif text-gray-700">{{count($genre)}}</span>
                    <x-ui.icon name="sort-2" class="w-4 h-4 ml-auto" stroke="currentColor"/>
                </button>
                <div
                    class="z-10 absolute top-full bg-white p-6 mt-3 left-0 xl:left-1/2 xl:-translate-x-1/2 rounded-xl shadow-lg w-full lg:w-[34rem] text-sm dark:bg-gray-900"
                    @click.outside="open = false" @keydown.escape.window="open = false" x-show="open"
                    x-transition:enter="transition ease-out duration-200 transform"
                    x-transition:enter-start="opacity-0 -trangray-y-2"
                    x-transition:enter-end="opacity-100 trangray-y-0"
                    x-transition:leave="transition ease-out duration-200"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0" style="display: none;">

                    <div class="gap-2 flex flex-wrap">
                        @foreach(\App\Models\Genre::get() as $genre)

                            <div>
                                <input type="checkbox" id="category{{$genre->id}}" name="genre[]"
                                       value="{{$genre->id}}" class="sr-only peer" wire:model="genre">
                                <label for="category{{$genre->id}}"
                                       class="inline-flex items-center justify-between w-full py-2 px-3.5 text-gray-500 bg-white rounded-full text-xs cursor-pointer dark:hover:text-gray-200 peer-checked:!bg-primary-500 peer-checked:!text-white hover:text-gray-600 dark:peer-checked:text-gray-300 peer-checked:text-gray-600 hover:bg-gray-50 dark:text-gray-300 dark:bg-gray-800 dark:hover:bg-gray-700">
                                    {{$genre->title}}
                                </label>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-6 space-x-3">
                        <x-form.secondary type="submit" size="md"
                                          class="!text-xsx min-w-[16rem] w-full !rounded-full"
                                          x-on:click="open = false">{{__('Apply')}}</x-form.secondary>
                    </div>
                </div>
            </div>

            <div class="relative w-full lg:w-auto" x-data="{ open: false}">
                <button type="button"
                        class="w-full py-2.5 px-3 inline-flex justify-center items-center gap-3 text-sm font-medium text-center text-gray-500 rounded-lg dark:text-gray-400 dark:hover:text-gray-300"
                        @click.prevent="open = !open" :aria-expanded="open" :class="open ? 'dark:!text-gray-300' : ''">
                        <span
                            class="@if(isset($country) AND count($country) > 0) {{'dark:!text-gray-100'}}@endif">{{__('Country')}}</span>
                    <span
                        class="rounded bg-gray-200 dark:bg-gray-800 dark:text-gray-300 px-1.5  text-xxs font-semibold tabular-nums capitalize hidden @if(isset($country) AND count($country) > 0) {{'!block'}}@endif text-gray-700">{{count($country)}}</span>
                    <x-ui.icon name="sort-2" class="w-4 h-4 ml-auto" stroke="currentColor"/>
                </button>
                <div
                    class="z-10 absolute top-full bg-white p-6 mt-3 left-0 xl:left-1/2 xl:-translate-x-1/2 rounded-xl shadow-lg w-full lg:w-[34rem] text-sm dark:bg-gray-900"
                    @click.outside="open = false" @keydown.escape.window="open = false" x-show="open"
                    x-transition:enter="transition ease-out duration-200 transform"
                    x-transition:enter-start="opacity-0 -trangray-y-2"
                    x-transition:enter-end="opacity-100 trangray-y-0"
                    x-transition:leave="transition ease-out duration-200"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0" style="display: none;">

                    <div class="gap-2 flex flex-wrap">
                        @foreach(\App\Models\Country::where('filter','active')->get() as $country)

                            <div>
                                <input type="checkbox" id="country{{$country->id}}" name="country[]"
                                       value="{{$country->id}}" class="sr-only peer" wire:model="country">
                                <label for="country{{$country->id}}"
                                       class="inline-flex items-center justify-between w-full py-2 px-3.5 text-gray-500 bg-white rounded-full text-xs cursor-pointer dark:hover:text-gray-200 peer-checked:!bg-primary-500 peer-checked:!text-white hover:text-gray-600 dark:peer-checked:text-gray-300 peer-checked:text-gray-600 hover:bg-gray-50 dark:text-gray-300 dark:bg-gray-800 dark:hover:bg-gray-700">
                                    {{$country->name}}
                                </label>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-6 space-x-3">
                        <x-form.secondary type="submit" size="md"
                                          class="!text-xsx min-w-[16rem] w-full !rounded-full"
                                          x-on:click="open = false">{{__('Apply')}}</x-form.secondary>
                    </div>
                </div>
            </div>

            <div class="relative w-full lg:w-auto" x-data="{ open: false}">
                <button type="button"
                        class="w-full py-2.5 px-3 inline-flex justify-center items-center gap-3 text-sm font-medium text-center text-gray-500 rounded-lg dark:text-gray-400 dark:hover:text-gray-300"
                        @click.prevent="open = !open" :aria-expanded="open" :class="open ? 'dark:!text-gray-300' : ''">
                    <span class="@if(isset($release)) {{'dark:!text-gray-100'}}@endif">{{__('Released')}}</span>
                    <span
                        class="rounded bg-gray-200 dark:bg-gray-800 dark:text-gray-300 px-1.5  text-xxs font-semibold tabular-nums capitalize hidden @if(isset($release)) {{'!block'}}@endif text-gray-700">{{$release}}</span>
                    <x-ui.icon name="sort-2" class="w-4 h-4 ml-auto" stroke="currentColor"/>
                </button>
                <div
                    class="z-10 absolute top-full bg-white p-6 mt-3 left-0 xl:left-1/2 xl:-translate-x-1/2 rounded-xl shadow-lg w-full lg:w-[24rem] text-sm dark:bg-gray-900"
                    @click.outside="open = false" @keydown.escape.window="open = false" x-show="open"
                    x-transition:enter="transition ease-out duration-200 transform"
                    x-transition:enter-start="opacity-0 -trangray-y-2"
                    x-transition:enter-end="opacity-100 trangray-y-0"
                    x-transition:leave="transition ease-out duration-200"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0" style="display: none;">


                    <div class="gap-2 flex flex-wrap">
                        <div>
                            <input type="radio" id="releaseall" name="release"
                                   value="all" class="hidden peer" @if(empty($release)){{'checked'}}@endif>
                            <label for="releaseall"
                                   class="inline-flex items-center justify-between w-full py-2 px-3.5 text-gray-500 bg-white rounded-full text-xs cursor-pointer dark:hover:text-gray-200 peer-checked:!bg-primary-500 peer-checked:!text-white hover:text-gray-600 dark:peer-checked:text-gray-300 peer-checked:text-gray-600 hover:bg-gray-50 dark:text-gray-300 dark:bg-gray-800 dark:hover:bg-gray-700">
                                {{__('All')}}
                            </label>
                        </div>
                        @php
                            $currentYear = date('Y');
                        @endphp
                        @for($i = $currentYear; $i >= ($currentYear - 5); $i--)

                            <div>
                                <input type="radio" id="release{{$i}}" name="release" wire:model="release"
                                       value="{{$i}}" class="hidden peer">
                                <label for="release{{$i}}"
                                       class="inline-flex items-center justify-between w-full py-2 px-3.5 text-gray-500 bg-white rounded-full text-xs cursor-pointer dark:hover:text-gray-200 peer-checked:!bg-primary-500 peer-checked:!text-white hover:text-gray-600 dark:peer-checked:text-gray-300 peer-checked:text-gray-600 hover:bg-gray-50 dark:text-gray-300 dark:bg-gray-800 dark:hover:bg-gray-700">
                                    {{$i}}
                                </label>
                            </div>
                        @endfor
                        <div>
                            <input type="radio" id="releaseolder" name="release" wire:model="release"
                                   value="{{$currentYear-6}}" class="hidden peer">
                            <label for="releaseolder"
                                   class="inline-flex items-center justify-between w-full py-2 px-3.5 text-gray-500 bg-white rounded-full text-xs cursor-pointer dark:hover:text-gray-200 peer-checked:!bg-primary-500 peer-checked:!text-white hover:text-gray-600 dark:peer-checked:text-gray-300 peer-checked:text-gray-600 hover:bg-gray-50 dark:text-gray-300 dark:bg-gray-800 dark:hover:bg-gray-700">
                                {{__('Older')}}
                            </label>
                        </div>
                    </div>

                    <div class="mt-6 space-x-3">
                        <x-form.secondary type="submit" size="md"
                                          class="!text-xsx min-w-[16rem] w-full !rounded-full"
                                          x-on:click="open = false">{{__('Apply')}}</x-form.secondary>
                    </div>
                </div>
            </div>

            <div class="relative w-full lg:w-auto" x-data="{ open: false}">
                <button type="button"
                        class="w-full py-2.5 px-3 inline-flex justify-center items-center gap-3 text-sm font-medium text-center text-gray-500 rounded-lg dark:text-gray-400 dark:hover:text-gray-300"
                        @click.prevent="open = !open" :aria-expanded="open" :class="open ? 'dark:!text-gray-300' : ''">
                        <span
                            class="@if(isset($vote_average)) {{'dark:!text-gray-100'}}@endif">{{__('IMDb')}}</span>
                    <span
                        class="rounded bg-gray-200 dark:bg-gray-800 dark:text-gray-300 px-1.5  text-xxs font-semibold tabular-nums capitalize hidden @if(isset($vote_average)) {{'!block'}}@endif text-gray-700">{{$vote_average}}</span>
                    <x-ui.icon name="sort-2" class="w-4 h-4 ml-auto" stroke="currentColor"/>
                </button>
                <div
                    class="z-10 absolute top-full bg-white p-6 mt-3 left-0 xl:left-1/2 xl:-translate-x-1/2 rounded-xl shadow-lg w-full lg:w-[24rem] text-sm dark:bg-gray-900"
                    @click.outside="open = false" @keydown.escape.window="open = false" x-show="open"
                    x-transition:enter="transition ease-out duration-200 transform"
                    x-transition:enter-start="opacity-0 -trangray-y-2"
                    x-transition:enter-end="opacity-100 trangray-y-0"
                    x-transition:leave="transition ease-out duration-200"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0" style="display: none;">

                    <div class="gap-2 flex flex-wrap">
                        @for ($vote = 4; $vote <= 10; $vote++)
                            <div>
                                <input type="radio" id="vote{{$vote}}" name="vote_average"
                                       value="{{$vote}}" class="sr-only peer" wire:model="vote_average">
                                <label for="vote{{$vote}}"
                                       class="inline-flex items-center justify-between w-full py-2 px-3.5 text-gray-500 bg-white rounded-full text-xs cursor-pointer dark:hover:text-gray-200 peer-checked:!bg-primary-500 peer-checked:!text-white hover:text-gray-600 dark:peer-checked:text-gray-300 peer-checked:text-gray-600 hover:bg-gray-50 dark:text-gray-300 dark:bg-gray-800 dark:hover:bg-gray-700">
                                    {{$vote}}
                                </label>
                            </div>
                        @endfor
                    </div>
                    <div class="mt-6 space-x-3">
                        <x-form.secondary type="submit" size="md"
                                          class="!text-xsx min-w-[16rem] w-full !rounded-full"
                                          x-on:click="open = false">{{__('Apply')}}</x-form.secondary>
                    </div>
                </div>
            </div>

            <div class="relative w-full lg:w-auto" x-data="{ open: false,selected: ''}">
                <button type="button"
                        class="w-full py-2.5 px-3 inline-flex justify-center items-center gap-3 text-sm font-medium text-center text-gray-500 rounded-lg dark:text-gray-400 dark:hover:text-gray-300"
                        @click.prevent="open = !open" :aria-expanded="open" :class="open ? 'dark:!text-gray-300' : ''">
                    <span class="@if(isset($quality)) {{'dark:!text-gray-300'}}@endif">{{__('Quality')}}</span>
                    <span
                        class="rounded bg-gray-200 dark:bg-gray-800 dark:text-gray-300 px-1.5  text-xxs font-semibold tabular-nums capitalize hidden @if(isset($quality)) {{'!block'}}@endif text-gray-700">{{$quality}}</span>
                    <x-ui.icon name="sort-2" class="w-4 h-4 ml-auto" stroke="currentColor"/>
                </button>
                <div
                    class="z-10 absolute top-full bg-white p-6 mt-3 left-0 xl:left-1/2 xl:-translate-x-1/2 rounded-xl shadow-lg w-full lg:w-[20rem] text-sm dark:bg-gray-900"
                    @click.outside="open = false" @keydown.escape.window="open = false" x-show="open"
                    x-transition:enter="transition ease-out duration-200 transform"
                    x-transition:enter-start="opacity-0 -trangray-y-2"
                    x-transition:enter-end="opacity-100 trangray-y-0"
                    x-transition:leave="transition ease-out duration-200"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0" style="display: none;">

                    <div class="gap-2 flex flex-wrap">
                        @foreach(config('attr.quality') as $quality)
                            <div>
                                <input type="radio" id="quality{{$quality}}" name="quality"
                                       value="{{$quality}}" class="sr-only peer" wire:model="quality">
                                <label for="quality{{$quality}}"
                                       class="inline-flex items-center justify-between w-full py-2 px-3.5 text-gray-500 bg-white rounded-full text-xs cursor-pointer dark:hover:text-gray-200 peer-checked:!bg-primary-500 peer-checked:!text-white hover:text-gray-600 dark:peer-checked:text-gray-300 peer-checked:text-gray-600 hover:bg-gray-50 dark:text-gray-300 dark:bg-gray-800 dark:hover:bg-gray-700">
                                    {{$quality}}
                                </label>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-6 space-x-3">
                        <x-form.secondary type="submit" size="md"
                                          class="!text-xsx min-w-[16rem] w-full !rounded-full"
                                          x-on:click="open = false">{{__('Apply')}}</x-form.secondary>
                    </div>
                </div>
            </div>
            <div class="w-px h-5 mx-6 bg-gray-200 dark:bg-gray-800 hidden lg:block"></div>
            <div class="ml-auto relative w-full lg:w-auto" x-data="{ openSort: @entangle('openSort') }">
                <button
                    class="w-full py-2.5 px-3 inline-flex justify-center items-center gap-3 text-sm font-medium text-center text-gray-500 rounded-lg hover:bg-gray-50 dark:text-gray-400 dark:hover:text-gray-300 dark:hover:bg-gray-800"
                    @click.prevent="openSort = !openSort" :aria-expanded="openSort" aria-expanded="false">
                    <span>{{isset($sort) ? __(config('attr.sortable')[$sort]['title']) : __('Newest')}}</span>
                    <x-ui.icon name="swap" class="w-4 h-4 ml-auto" stroke="currentColor"/>
                </button>
                <div
                    class="origin-top-right z-40 absolute inset-x-0 top-full mt-1 bg-white py-3 w-48 px-3 left-auto right-0 rounded-lg shadow-lg border border-gray-100 text-sm dark:bg-gray-900 dark:border-gray-900"
                    @click.outside="openSort = false" @keydown.escape.window="openSort = false" x-show="openSort"
                    x-transition:enter="transition ease-out duration-200 transform"
                    x-transition:enter-start="opacity-0 -trangray-y-2"
                    x-transition:enter-end="opacity-100 trangray-y-0"
                    x-transition:leave="transition ease-out duration-200"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0" style="display: none;">
                    <div class="flex flex-col">
                        @foreach(config('attr.sortable') as $key => $value)
                            @if($key == 'title')
                                <div class="border-t border-gray-100 dark:border-gray-800 my-3"></div>
                            @endif
                            <button
                                class="w-full py-2 px-3.5 inline-flex items-center gap-5 text-sm text-center text-gray-500 rounded-lg hover:bg-gray-50 relative  dark:text-gray-400 dark:hover:text-gray-300 dark:hover:bg-gray-800/50 {{ isset($sort) AND $sort === $key ? 'text-white' : '' }}"
                                wire:click="updateSort('{{$key}}')">
                                {{__($value['title'])}}
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
