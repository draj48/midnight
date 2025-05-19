<div x-data="{reportModal:@entangle('reportModal').live}">
    @if(auth()->user())

        <button
            class="w-10 h-10 rounded-full text-gray-500 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-200 flex items-center justify-center tooltip" data-tippy-content="{{__('Report')}}"
            @click.prevent="reportModal = true;">
            <x-ui.icon name="flag" stroke="currentColor" class="w-5 h-5"/>
        </button>

        <div
            class="fixed inset-0 z-50 flex items-center justify-center overflow-auto bg-gray-950/30 backdrop-blur-md z-50 bg-opacity-50"
            x-show="reportModal" x-cloak
        >
            <!-- Modal inner -->
            <div
                class="max-w-xl w-full p-8 xl:p-12 mx-auto text-left bg-white dark:bg-gray-900 rounded-2xl"

                @click.outside="reportModal = false" @keydown.escape.window="reportModal = false"
                x-transition:enter="motion-safe:ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-90"
                x-transition:enter-end="opacity-100 scale-100"
            >
                <!-- Title / Close-->
                <div class="mb-5">

                    <div class="flex items-center justify-between">
                        <h3 class="text-2xl font-semibold text-white">{{__('Report')}}</h3>
                        <button type="button" class="z-50 cursor-pointer dark:text-white text-gray-500 ml-auto rtl:mr-auto rtl:ml-0"
                                @click="reportModal = false">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                    <h3 class="text-xl font-medium text-primary-500 mt-4 rtl:text-right">{{$model->title}}</h3>
                </div>
                @if (count($errors) > 0)
                    @php
                        $errorDiv = null;
                    @endphp
                    @foreach ($errors->all() as $error)
                        @php
                            $errorDiv .= $error;
                        @endphp
                    @endforeach
                    <p class="mb-5 text-xs text-red-400">
                        {{$errorDiv}}
                    </p>
                @endif
                <form method="post" wire:submit="reportForm">
                    @csrf
                    <div class="mb-5">
                        <x-form.label for="type" :value="__('Report')"/>
                        @foreach(config('attr.reports') as $key => $report)
                            <div class="flex items-center space-x-4 mt-2">
                                <x-form.switch type="radio" id="type{{$key}}" name="type" value="{{$key}}" class=" rtl:ml-4" dir="ltr"
                                               wire:model="type"/>
                                <x-form.label for="type{{$key}}" class="md:mb-0 cursor-pointer font-normal"
                                              :value="__($report)"/>
                            </div>
                        @endforeach
                    </div>
                    <div class="mb-5">
                        <x-form.label for="description" :value="__('Description')"/>
                        <x-form.textarea name="description" placeholder="{{__('Description')}}"
                                         wire:model="description"
                                         required></x-form.textarea>
                    </div>
                    <x-form.primary wire:loading.attr="disabled" type="submit"
                                    class="w-full">{{__('Submit')}}</x-form.primary>
                </form>
            </div>
        </div>
    @else
        <a href="{{route('login')}}"
           class="w-10 h-10 rounded-full text-gray-500 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-200 flex items-center justify-center">
            <x-ui.icon name="report" fill="currentColor" class="w-5 h-5"/>
        </a>
    @endif
</div>
