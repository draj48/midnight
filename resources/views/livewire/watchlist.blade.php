
<button
    class="w-10 h-10 rounded-full text-gray-500 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-200 flex items-center justify-center @if($isWatchlist == true){{'!bg-gray-700 !text-white'}}@endif tooltip" data-tippy-content="{{__('Add watchlist')}}"
    wire:click.debounce.200ms="watchlist" wire:loading.attr="disabled" >
    <x-ui.icon name="library-add" stroke="currentColor" class="w-5 h-5"/>
</button>
