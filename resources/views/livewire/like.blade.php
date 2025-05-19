
<button wire:click="like" class="group flex items-center gap-1.5 p-0 transition-none
         disabled:cursor-not-allowed inner:transition inner:duration-200 hover:text-primary-500 focus-visible:text-primary-500 {{ $comment->isLiked() ? '[&>i>svg]:xfill-primary-500 text-primary-500' : 'text-gray-400 hover:text-gray-500' }}">
    <i class="relative rounded-full p-2 not-italic group-focus-visible:ring-2 group-hover:bg-primary-500/10 group-active:bg-primary-500/20 group-focus-visible:bg-primary-500/10 group-focus-visible:ring-primary-500/80">

        <x-ui.icon name="like" fill="currentColor" class="w-4 h-4"/>
    </i>
    <span class="font-medium text-xs text-gray-900 dark:text-gray-400">{{ $count }}</span>
    <span class="sr-only">likes</span>
</button>
