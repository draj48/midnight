<div class="flex items-center gap-3 mb-3 pt-6 px-8">
    @if(!empty($config['create']))
        <x-form.secondary href="{{route('admin.'.$config['route'].'.create')}}"
                          class="!py-0 h-12 w-12 lg:w-auto !px-0 lg:!px-5">
            <x-ui.icon name="add" class="w-5 h-5" stroke="currentColor" stroke-width="1.75"/>
            <span class="hidden lg:block">{{__('Add new')}}</span>
        </x-form.secondary>
    @endif
    @if(isset($config['filter']))
        @include('admin.filter.'.$config['route'])
    @endif
    <div class="relative flex-1">
        <form method="get" action="{{route('admin.'.$config['route'].'.index')}}" class="relative text-gray-400 flex-1"
              @keydown.window.ctrl.q="$refs.searchInput.focus();">

            <div class="absolute left-5 top-1/2 -translate-y-1/2">
                <x-ui.icon name="search" class="w-5 h-5" stroke="currentColor"
                           stroke-width="1.75"/>
            </div>
            <x-form.input type="text" name="q" placeholder="{{__('Search')}} .."
                          class="!px-14 !py-0 !h-12 !rounded-lg" x-ref="searchInput"/>
            <div
                class="font-sans text-xs text-gray-400/70 font-medium dark:text-gray-500 flex items-center gap-2 absolute right-6 top-1/2 -translate-y-1/2">
                <span>⌘</span>
                <span>Q</span>
            </div>
        </form>
    </div>
</div>
