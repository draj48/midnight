<div
    class="notify fixed bottom-0 right-0 flex items-center w-full max-w-sm justify-center px-6 py-8 pointer-events-none z-50">
    <div
        x-data="{ showToastr:false, countdown: 4000,intervalx:100 }"
        x-init="
            @this.on('show-toast', () => {
                showToastr = true;
                countdown = 5000;
                intervalx = 100;
                const interval = setInterval(() => {
                    countdown = countdown - intervalx;
                    if (countdown === 0) {
                        showToastr = false;
                        clearInterval(interval);
                    }
                }, intervalx);
            });
         "
        x-show="showToastr"
        x-description="Notification panel, show/hide based on alert state."
        x-transition:enter="transform ease-out duration-300 transition"
        x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
        x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
        x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="flex items-center overflow-hidden relative w-full max-w-sm py-5 px-5 space-x-4 max-w-xs bg-gray-800 text-sm text-white rounded-md shadow-lg dark:bg-gray-700 pointer-events-auto"
    >
        <div class="bg-white/30 rounded-full transition-all duration-150 ease-linear absolute top-0 left-0"
             id="toast-timer"
             :style="{ height:`3px`,width: `${(100 * countdown) / 5000}%` }">
        </div>
        @if($message)
        <div
            class="text-sm font-normal flex-1">{{ $message['message'] }}</div>
        @endif
        <div class="ml-5 flex-shrink-0 flex">
            <button @click="showToastr = false;"
                    class="inline-flex text-white/50 hover:text-white focus:outline-none focus:text-gray-500 transition ease-in-out duration-150">
                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                          d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                          clip-rule="evenodd"></path>
                </svg>
            </button>
        </div>
    </div>

</div>
