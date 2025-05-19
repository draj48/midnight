<form method="post" wire:submit="requestForm" class="w-full">
    @csrf
    <x-form.primary class="w-full flex items-center !text-left !rounded-full !py-3" size="sm">
        <x-ui.icon name="refresh-2" stroke-width="2" class="w-4 h-4"/>
        <span class="font-normal">{{__('Request')}}</span>
    </x-form.primary>
</form>