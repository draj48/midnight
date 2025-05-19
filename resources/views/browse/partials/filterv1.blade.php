<div class="mb-6 relative">
    <div class="flex items-center gap-6">
        <h1 class="text-2xl font-semibold dark:text-white">{{$param['heading']}}</h1>
        <div class="flex items-center space-x-8 ml-auto">
            <ul class="flex items-center justify-center whitespace-nowrap overflow-x-auto overflow-x-visible">
                <li>
                    <button
                        class="w-full py-2.5 px-4 inline-flex justify-center items-center gap-3 text-sm text-center text-gray-500 rounded-lg hover:bg-gray-50 dark:text-gray-400 dark:hover:text-gray-300 dark:hover:bg-gray-800"
                        wire:click="filterOpen = true;">
                        <x-ui.icon name="sort-2" class="w-5 h-5" stroke="currentColor" stroke-width="1.75"/>
                        <span>{{__('Filter')}}</span>
                    </button>
                </li>
                <li class="w-px h-5 mx-6 bg-gray-200 dark:bg-gray-900 hidden lg:block"></li>
                <li class="relative" x-data="{ openSort: @entangle('openSort') }">
                    <button
                        class="w-full py-2.5 px-4 inline-flex justify-center items-center gap-3 text-sm text-center text-gray-500 rounded-lg hover:bg-gray-50 relative after:absolute after:-bottom-2.5 after:rounded-full after:left-0 after:right-0 after:h-1 dark:text-gray-400 dark:hover:text-gray-300 dark:hover:bg-gray-800"
                        @click.prevent="openSort = !openSort" :aria-expanded="openSort" aria-expanded="false">
                        <span>{{isset($sort) ? __(config('attr.sortable')[$sort]['title']) : __('Newest')}}</span>
                        <x-ui.icon name="swap" class="w-4 h-4" stroke="currentColor" stroke-width="1.75"/>
                    </button>
                    <div
                        class="origin-top-right z-40 absolute inset-x-0 top-full mt-1 bg-white py-3 w-48 px-3 left-auto right-0 rounded-xl shadow-lg border border-gray-100 text-sm dark:bg-gray-900 dark:border-gray-900"
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
                                    <div class="border-t border-gray-100 dark:border-gray-900 my-3"></div>
                                @endif
                                <button
                                    class="w-full py-2.5 px-4 inline-flex items-center gap-5 text-sm text-center text-gray-500 rounded-lg hover:bg-gray-50 relative  dark:text-gray-400 dark:hover:text-gray-300 dark:hover:bg-gray-800/50 {{ isset($sort) AND $sort === $key ? 'text-white' : '' }}"
                                    wire:click="updateSort('{{$key}}')">
                                    {{__($value['title'])}}
                                </button>
                            @endforeach
                        </div>
                    </div>
                </li>
            </ul>

        </div>
    </div>

</div>

<div class="fixed inset-0 bg-gray-950/30 backdrop-blur-md z-50 transition-opacity"
     x-show="filterOpen" x-transition:enter="transition ease-out duration-200"
     x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-out duration-100" x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0" aria-hidden="true" style="display: none;"></div>
<!-- Modal dialog -->
<div id="filter-modal"
     class="fixed inset-0 z-50 overflow-hidden flex items-start top-0 lg:top-20 justify-center lg:px-6"
     role="dialog" aria-modal="true" x-show="filterOpen"
     x-transition:enter="transition ease-in-out duration-200"
     x-transition:enter-start="opacity-0 trangray-y-4"
     x-transition:enter-end="opacity-100 trangray-y-0"
     x-transition:leave="transition ease-in-out duration-200"
     x-transition:leave-start="opacity-100 trangray-y-0"
     x-transition:leave-end="opacity-0 trangray-y-4" style="display: none;">
    <div class="bg-white h-full lg:h-auto dark:bg-gray-900 overflow-auto lg:max-w-5xl w-full p-6 xl:p-10 max-h-full lg:rounded-2xl"
         @click.outside="filterOpen = false" @keydown.escape.window="filterOpen = false">
        <form wire:submit="filter" method="post">
            @csrf
            <div class="grid grid-cols-1 xl:grid-cols-2 gap-x-6">

                <div class="mb-5">
                    <x-form.label class="text-xs dark:text-gray-400" :value="__('Type')"/>
                    <div class="gap-2 flex flex-wrap">
                        <div>
                            <input type="radio" id="typeall" name="type"
                                   value="all" class="hidden peer" @if(empty($type)){{'checked'}}@endif>
                            <label for="typeall"
                                   class="inline-flex items-center justify-between w-full py-2.5 px-4 text-gray-500 bg-white rounded-full text-xs cursor-pointer dark:hover:text-gray-200 peer-checked:!bg-primary-500 peer-checked:!text-white hover:text-gray-600 dark:peer-checked:text-gray-300 peer-checked:text-gray-600 hover:bg-gray-50 dark:text-gray-300 dark:bg-gray-800 dark:hover:bg-gray-700">
                                {{__('All')}}
                            </label>
                        </div>
                        @foreach(config('attr.types') as $valueType => $keyType)
                            <div>
                                <input type="radio" id="type{{$keyType}}" name="type" wire:model="type"
                                       value="{{$valueType}}" class="hidden peer">
                                <label for="type{{$keyType}}"
                                       class="inline-flex items-center justify-between w-full py-2.5 px-4 text-gray-500 bg-white rounded-full text-xs cursor-pointer dark:hover:text-gray-200 peer-checked:!bg-primary-500 peer-checked:!text-white hover:text-gray-600 dark:peer-checked:text-gray-300 peer-checked:text-gray-600 hover:bg-gray-50 dark:text-gray-300 dark:bg-gray-800 dark:hover:bg-gray-700">
                                    {{__($keyType)}}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="mb-5">
                    <x-form.label class="text-xs dark:text-gray-400" :value="__('Quality')"/>
                    <div class="gap-2 flex flex-wrap">
                        <div>
                            <input type="radio" id="qualityall" name="quality"
                                   value="all" class="hidden peer" @if(empty($quality)){{'checked'}}@endif>
                            <label for="qualityall"
                                   class="inline-flex items-center justify-between w-full py-2.5 px-4 text-gray-500 bg-white rounded-full text-xs cursor-pointer dark:hover:text-gray-200 peer-checked:!bg-primary-500 peer-checked:!text-white hover:text-gray-600 dark:peer-checked:text-gray-300 peer-checked:text-gray-600 hover:bg-gray-50 dark:text-gray-300 dark:bg-gray-800 dark:hover:bg-gray-700">
                                {{__('All')}}
                            </label>
                        </div>
                        @foreach(config('attr.quality') as $quality)
                            <div>
                                <input type="radio" id="quality{{$quality}}" name="quality" wire:model="quality"
                                       value="{{$quality}}" class="hidden peer">
                                <label for="quality{{$quality}}"
                                       class="inline-flex items-center justify-between w-full py-2.5 px-4 text-gray-500 bg-white rounded-full text-xs cursor-pointer dark:hover:text-gray-200 peer-checked:!bg-primary-500 peer-checked:!text-white hover:text-gray-600 dark:peer-checked:text-gray-300 peer-checked:text-gray-600 hover:bg-gray-50 dark:text-gray-300 dark:bg-gray-800 dark:hover:bg-gray-700">
                                    {{$quality}}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="mb-5">
                <x-form.label class="text-xs dark:text-gray-400" :value="__('Genre')"/>

                <div class="gap-2 flex flex-wrap">
                    @foreach(\App\Models\Genre::get() as $genre)
                        <div>
                            <input type="checkbox" id="category{{$genre->id}}" name="genre[]"
                                   wire:model="genre"
                                   value="{{$genre->id}}" class="hidden peer">
                            <label for="category{{$genre->id}}"
                                   class="inline-flex items-center justify-between w-full py-2.5 px-4 text-gray-500 bg-white rounded-full text-xs cursor-pointer dark:hover:text-gray-200 peer-checked:!bg-primary-500 peer-checked:!text-white hover:text-gray-600 dark:peer-checked:text-gray-300 peer-checked:text-gray-600 hover:bg-gray-50 dark:text-gray-300 dark:bg-gray-800 dark:hover:bg-gray-700">
                                {{$genre->title}}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="mb-5">
                <x-form.label class="text-xs dark:text-gray-400" :value="__('Released')"/>
                <div class="gap-2 flex flex-wrap">
                    <div>
                        <input type="radio" id="releaseall" name="release"
                               value="all" class="hidden peer" @if(empty($release)){{'checked'}}@endif>
                        <label for="releaseall"
                               class="inline-flex items-center justify-between w-full py-2.5 px-4 text-gray-500 bg-white rounded-full text-xs cursor-pointer dark:hover:text-gray-200 peer-checked:!bg-primary-500 peer-checked:!text-white hover:text-gray-600 dark:peer-checked:text-gray-300 peer-checked:text-gray-600 hover:bg-gray-50 dark:text-gray-300 dark:bg-gray-800 dark:hover:bg-gray-700">
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
                                   class="inline-flex items-center justify-between w-full py-2.5 px-4 text-gray-500 bg-white rounded-full text-xs cursor-pointer dark:hover:text-gray-200 peer-checked:!bg-primary-500 peer-checked:!text-white hover:text-gray-600 dark:peer-checked:text-gray-300 peer-checked:text-gray-600 hover:bg-gray-50 dark:text-gray-300 dark:bg-gray-800 dark:hover:bg-gray-700">
                                {{$i}}
                            </label>
                        </div>
                    @endfor
                    <div>
                        <input type="radio" id="releaseolder" name="release" wire:model="release"
                               value="{{$currentYear-6}}" class="hidden peer">
                        <label for="releaseolder"
                               class="inline-flex items-center justify-between w-full py-2.5 px-4 text-gray-500 bg-white rounded-full text-xs cursor-pointer dark:hover:text-gray-200 peer-checked:!bg-primary-500 peer-checked:!text-white hover:text-gray-600 dark:peer-checked:text-gray-300 peer-checked:text-gray-600 hover:bg-gray-50 dark:text-gray-300 dark:bg-gray-800 dark:hover:bg-gray-700">
                            {{__('Older')}}
                        </label>
                    </div>
                </div>
            </div>
            <div class="mb-5">
                <x-form.label class="text-xs dark:text-gray-400" :value="__('Country')"/>

                <div class="gap-2 flex flex-wrap">
                    @foreach(\App\Models\Country::where('filter','active')->get() as $country)
                        <div>
                            <input type="checkbox" id="country{{$country->id}}" name="country[]"
                                   wire:model="country"
                                   value="{{$country->id}}" class="hidden peer">
                            <label for="country{{$country->id}}"
                                   class="inline-flex items-center justify-between w-full py-2.5 px-4 text-gray-500 bg-white rounded-full text-xs cursor-pointer dark:hover:text-gray-200 peer-checked:!bg-primary-500 peer-checked:!text-white hover:text-gray-600 dark:peer-checked:text-gray-300 peer-checked:text-gray-600 hover:bg-gray-50 dark:text-gray-300 dark:bg-gray-800 dark:hover:bg-gray-700">
                                {{$country->name}}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="mt-5 text-center space-y-3">
                <x-form.secondary type="submit" size="md" class="w-full !rounded-full">{{__('Apply')}}</x-form.secondary>
            </div>
        </form>
    </div>
</div>
