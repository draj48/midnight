@php
if (! isset($scrollTo)) {
    $scrollTo = 'body';
}

$scrollIntoViewJsSnippet = ($scrollTo !== false)
    ? <<<JS
       (\$el.closest('{$scrollTo}') || document.querySelector('{$scrollTo}')).scrollIntoView()
    JS
    : '';
@endphp

<div>
    @if ($paginator->hasPages())
        <nav role="navigation" aria-label="Pagination Navigation" class="flex justify-center gap-x-3 mt-8 mb-8 pagination">
            <span>
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())

                @else
                    @if(method_exists($paginator,'getCursorName'))
                        <button type="button" dusk="previousPage" wire:key="cursor-{{ $paginator->getCursorName() }}-{{ $paginator->previousCursor()->encode() }}" wire:click="setPage('{{$paginator->previousCursor()->encode()}}','{{ $paginator->getCursorName() }}')" x-on:click="{{ $scrollIntoViewJsSnippet }}" wire:loading.attr="disabled" class="py-3 px-5 inline-flex justify-center items-center gap-2 rounded-full border font-medium bg-white text-gray-700 shadow-sm align-middle hover:bg-gray-50 transition-all text-sm dark:bg-gray-800 dark:hover:bg-primary-500 dark:border-gray-800 dark:text-gray-300 dark:hover:border-primary-500 dark:hover:text-white">
                                <x-ui.icon name="left" class="w-3.5 h-3.5" fill="currentColor"/>
            {{__('Prev')}}
                        </button>
                    @else
                        <button
                            type="button" wire:click="previousPage('{{ $paginator->getPageName() }}')" x-on:click="{{ $scrollIntoViewJsSnippet }}" wire:loading.attr="disabled" dusk="previousPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}" class="py-3 px-5 inline-flex justify-center items-center gap-2 rounded-full border font-medium bg-white text-gray-700 shadow-sm align-middle hover:bg-gray-50 transition-all text-sm dark:bg-gray-800 dark:hover:bg-primary-500 dark:border-gray-800 dark:text-gray-300 dark:hover:border-primary-500 dark:hover:text-white">
                                <x-ui.icon name="left" class="w-3.5 h-3.5" fill="currentColor"/>
            {{__('Prev')}}
                        </button>
                    @endif
                @endif
            </span>

            <span>
                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    @if(method_exists($paginator,'getCursorName'))
                        <button type="button" dusk="nextPage" wire:key="cursor-{{ $paginator->getCursorName() }}-{{ $paginator->nextCursor()->encode() }}" wire:click="setPage('{{$paginator->nextCursor()->encode()}}','{{ $paginator->getCursorName() }}')" x-on:click="{{ $scrollIntoViewJsSnippet }}" wire:loading.attr="disabled" class="py-3 px-5 inline-flex justify-center items-center gap-2 rounded-full border font-medium bg-white text-gray-700 shadow-sm align-middle hover:bg-gray-50 transition-all text-sm dark:bg-gray-800 dark:hover:bg-primary-500 dark:border-gray-800 dark:text-gray-300 dark:hover:border-primary-500 dark:hover:text-white">
                                {{__('Next')}}
            <x-ui.icon name="right" class="w-3.5 h-3.5" fill="currentColor"/>
                        </button>
                    @else
                        <button type="button" wire:click="nextPage('{{ $paginator->getPageName() }}')" x-on:click="{{ $scrollIntoViewJsSnippet }}" wire:loading.attr="disabled" dusk="nextPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}" class="py-3 px-5 inline-flex justify-center items-center gap-2 rounded-full border font-medium bg-white text-gray-700 shadow-sm align-middle hover:bg-gray-50 transition-all text-sm dark:bg-gray-800 dark:hover:bg-primary-500 dark:border-gray-800 dark:text-gray-300 dark:hover:border-primary-500 dark:hover:text-white">
                                {{__('Next')}}
            <x-ui.icon name="right" class="w-3.5 h-3.5" fill="currentColor"/>
                        </button>
                    @endif
                @else
                @endif
            </span>
        </nav>
    @endif
</div>
