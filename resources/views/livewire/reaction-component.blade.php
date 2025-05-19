<div class="flex items-center gap-x-1">
    <button id="like"
            class="px-4 h-10 rounded-full order-first lg:order-none gap-2 mr-3 lg:mr-0 bg-gray-50 hover:bg-gray-700 hover:text-white dark:bg-gray-800 text-gray-500 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white flex items-center justify-center @if($isReaction == 'like'){{'!text-white !bg-green-600'}}@endif "
            wire:click="reactionButton('like')" wire:loading.attr="disabled">
        <x-ui.icon name="like" fill="currentColor" stroke="none" class="w-4 h-4" stroke-width="2"/>
        <span class="text-xs opacity-70 min-w-[10px]">{{(int)$model->likes()->count()}}</span>
    </button>
    <button id="dislike"
            class="w-10 h-10 rounded-full order-first lg:order-none  mr-2 lg:mr-0 lg:ml-2 bg-gray-50 hover:bg-gray-700 hover:text-white dark:bg-gray-800 text-gray-500 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white flex items-center justify-center @if($isReaction == 'dislike'){{'!text-white !bg-red-600'}}@endif "
            wire:click="reactionButton('dislike')" wire:loading.attr="disabled">
        <x-ui.icon name="dislike" fill="currentColor" stroke="none" class="w-4 h-4"/>
    </button>
</div>
