<div class="flex justify-center gap-x-3 mt-8 mb-8">

    @if ($paginator->onFirstPage())
    @else
        <a href="{{ $paginator->previousPageUrl() }}"
           class="py-3 px-5 inline-flex justify-center items-center gap-2 rounded-full border font-medium bg-white text-gray-700 shadow-sm align-middle hover:bg-gray-50 transition-all text-sm dark:bg-gray-800 dark:hover:bg-primary-500 dark:border-gray-800 dark:text-gray-300 dark:hover:border-primary-500 dark:hover:text-white">
            <x-ui.icon name="left" class="w-3.5 h-3.5" fill="currentColor" />
            {{__('Prev')}}
        </a>
    @endif
    @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}"
           class="py-3 px-5 inline-flex justify-center items-center gap-2 rounded-full border font-medium bg-white text-gray-700 shadow-sm align-middle hover:bg-gray-50 transition-all text-sm dark:bg-gray-800 dark:hover:bg-primary-500 dark:border-gray-800 dark:text-gray-300 dark:hover:border-primary-500 dark:hover:text-white">
            {{__('Next')}}
            <x-ui.icon name="right" class="w-3.5 h-3.5" fill="currentColor" />
        </a>
    @endif
</div>
