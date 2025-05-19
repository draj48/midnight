<div class="pb-6 lg:pb-10">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-x-10">
        <a href="{{route('browse.find')}}" class="relative hidden sm:flex items-center px-5 gap-x-6 py-4 bg-gray-900 hover:bg-primary-500 transition-all duration-300 rounded-xl w-full mt-5">
            <img src="{{Vite::asset('resources/img/ai.svg')}}" class="h-16 w-16 -mt-8">
            <div class="flex-1">
                <p class="text-white">
                    {{__('Find content that suits your taste')}}
                </p>
                <div class="inline-flex items-center gap-x-2 text-xs text-white/70 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                    {{__('Find it now')}}
                    <svg class="flex-shrink-0 w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                         viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                         stroke-linejoin="round">
                        <path d="m9 18 6-6-6-6"/>
                    </svg>
                </div>
            </div>
        </a>
        <a href="" class="relative hidden sm:flex items-center px-5 gap-x-6 py-4 bg-gray-900 hover:bg-primary-500 transition-all duration-300 rounded-xl w-full mt-5">
            <img src="{{Vite::asset('resources/img/change.svg')}}" class="h-16 w-16 -mt-8">
            <div class="flex-1">
            <p class="text-white">
                {{__('Spin the wheel of luck')}}
            </p>
                <div class="inline-flex items-center gap-x-2 text-xs text-white/70 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                {{__('Try your chance')}}
                <svg class="flex-shrink-0 w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                     viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                     stroke-linejoin="round">
                    <path d="m9 18 6-6-6-6"/>
                </svg>
            </div>
            </div>
        </a>
    </div>
</div>
