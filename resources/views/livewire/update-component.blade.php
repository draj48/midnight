@if(isset($data['current']) AND env('APP_VERSION') != $data['current'])
    <div
        class="max-w-lg w-full shadow-sm text-center rounded-xl border border-gray-200  bg-white p-8 xl:py-10 xl:px-12 mx-auto my-8">
        <div class="text-center pb-5 text-primary-500 dark:text-white">
            <x-ui.icon name="request" class="w-12 h-12 mx-auto" fill="currentColor"/>
        </div>
        <h3 class="text-xl font-semibold mb-2 text-gray-700 dark:text-white">System Updater</h3>
        <div class="text-gray-500 text-sm mb-2">Current installed software version: {{env('APP_VERSION')}}</div>
        <div class="text-gray-700 font-medium text-base mb-2">New update available: {{$data['current']}}</div>
        <div class="mt-6">
            <x-form.primary class="w-full max-w-xs mx-auto !rounded-full" wire:click="updateClick" href="#" wire:loading.attr="disabled">
                <span wire:loading.remove>Update now</span>
                <span wire:loading>Updating..</span>
            </x-form.primary>
        </div>

        <hr class="my-6 border-gray-100">
        <h4 class="font-medium text-base mb-3 text-left">Changelog</h4>
        <ul class="list-disc list-inside text-left text-sm space-y-1 text-gray-500 dark:text-gray-200">
            @foreach(explode("\n", $data['changelog']) as $changelog)
                <li>{{$changelog}}</li>
            @endforeach
        </ul>
        @if($message)
            <div class="mt-3 text-sm text-green-600">{{ $message }}</div>
        @endif
    </div>
@else
    <div
        class="max-w-lg w-full shadow-sm text-center rounded-xl border border-gray-200  bg-white p-8 xl:py-10 xl:px-12 mx-auto my-8">
        <div class="text-center pb-5 text-primary-500 dark:text-white">
            <x-ui.icon name="request" class="w-12 h-12 mx-auto" fill="currentColor"/>
        </div>
        <h3 class="text-xl font-semibold mb-2 text-gray-700 dark:text-white">System Updater</h3>
        <div class="text-gray-500 text-sm mb-4">Current installed software version: {{env('APP_VERSION')}}</div>
        <div class="text-green-500 font-medium text-lg mb-2">Using the latest version</div>
    </div>
@endif
