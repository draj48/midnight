<div x-data @tags-update="{ tagsList: $event.detail.tags }"  data-tags='[{{ $slot }}]'>
    <div x-data="tagSelect()" x-init="init('parentEl')" @click.away="clearSearch()" @keydown.escape="clearSearch()">
        <div class="relative" @keydown.enter.prevent="addTag(textInput)">
            <x-form.input type="text" x-model="textInput" x-ref="textInput" @input="search($event.target.value)" placeholder="{{__('Tag')}}"/>

            <div :class="[open ? 'block' : 'hidden']">
                <div class="absolute z-40 left-0 mt-1 w-full">
                    <div class="py-1 text-sm bg-white rounded shadow border border-gray-100">
                        <a @click.prevent="addTag(textInput)" class="block py-2 px-5 cursor-pointer text-gray-700 hover:text-primary-500">{{__('Add tag')}} "<span class="font-semibold" x-text="textInput"></span>"</a>
                    </div>
                </div>
            </div>
            <input type="hidden" x-model="tags" id="tagsList" name="tag" multiple="multiple"/>
            <!-- selections -->
            <template x-for="(tag, index) in tags">
                <div class="bg-gray-100 text-gray-500 dark:bg-gray-800 dark:text-gray-300 inline-flex items-center text-sm rounded-md py-1 mt-2 mr-1">
                    <span class="ml-3 leading-relaxed truncate max-w-xs" x-text="tag"></span>
                    <div @click.prevent="removeTag(index)" class="w-6 h-4 cursor-pointer inline-block align-middle text-gray-500 hover:text-gray-600 focus:outline-none">
                        <svg class="w-4 h-4 fill-current mx-auto" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M15.78 14.36a1 1 0 0 1-1.42 1.42l-2.82-2.83-2.83 2.83a1 1 0 1 1-1.42-1.42l2.83-2.82L7.3 8.7a1 1 0 0 1 1.42-1.42l2.83 2.83 2.82-2.83a1 1 0 0 1 1.42 1.42l-2.83 2.83 2.83 2.82z"/></svg>
                    </div>
                </div>
            </template>
        </div>
    </div>
</div>
