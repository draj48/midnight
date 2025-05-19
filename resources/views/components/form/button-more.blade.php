<div class="relative inline-flex" x-data="{ open: false }">
    <button
        class="text-gray-500 hover:text-primary-500 dark:text-gray-300 dark:hover:text-primary-500 w-6 h-6 flex items-center justify-center"
        aria-haspopup="true"
        @click.prevent="open = !open" :aria-expanded="open" aria-expanded="false">
        <x-ui.icon name="more" stroke-width="1.5" class="w-5 h-5"/>
    </button>
    <div
        class="origin-top-right z-10 absolute inset-x-0 top-16 mt-px bg-white py-3 w-56 sm:px-3 lg:top-full left-auto right-0 lg:mt-3 lg:-mr-1.5 rounded-lg shadow-md border border-gray-100 text-sm  dark:border-gray-700 dark:bg-gray-800"
        @click.outside="open = false" @keydown.escape.window="open = false" x-show="open"
        x-transition:enter="transition ease-out duration-200 transform"
        x-transition:enter-start="opacity-0 -trangray-y-2"
        x-transition:enter-end="opacity-100 trangray-y-0"
        x-transition:leave="transition ease-out duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" style="display: none;">

        <ul>{{$slot}}</ul>
    </div>
</div>
