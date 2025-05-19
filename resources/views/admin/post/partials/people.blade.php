<div class="mb-5">
    <label class="sr-only">Search</label>
    <input name="search_people" class="selectize-people" placeholder="{{__('Search')}}">
</div>
<template x-for="(people, index) in peoples" :key="index">
    <div
        class="border-b border-gray-100 dark:border-gray-800 text-gray-500 dark:text-gray-300 flex items-center text-sm pb-3 mb-3">
        <input type="hidden" x-bind:name="`people[${people.id}][id]`" x-bind:value="people.id">
        <input type="hidden" x-bind:name="`people[${people.id}][api]`" x-bind:value="people.api">
        <div class="aspect-square w-12 rounded relative overflow-hidden">
            <img
                src="" x-bind:src="people.image"
                alt="" class="absolute h-full w-full object-cover"/>
        </div>
        <div class="flex-1 ml-6">
            <div class="text-base font-medium" x-text="people.name"></div>
        </div>
        <button @click.prevent="removePeople(index)"
                class="w-6 h-6 inline-block align-middle text-gray-500 hover:text-gray-600 focus:outline-none">
            <svg class="w-6 h-6 fill-current mx-auto" xmlns="http://www.w3.org/2000/svg"
                 viewBox="0 0 24 24">
                <path fill-rule="evenodd"
                      d="M15.78 14.36a1 1 0 0 1-1.42 1.42l-2.82-2.83-2.83 2.83a1 1 0 1 1-1.42-1.42l2.83-2.82L7.3 8.7a1 1 0 0 1 1.42-1.42l2.83 2.83 2.82-2.83a1 1 0 0 1 1.42 1.42l-2.83 2.83 2.83 2.82z"/>
            </svg>
        </button>
    </div>
</template>
