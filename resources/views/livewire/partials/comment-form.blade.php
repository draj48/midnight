<form class="mb-6" wire:submit="{{$method}}">
    @csrf
    <label for="{{$inputId}}" class="sr-only">Your message</label>
    <div
        class="py-1.5 px-2 mb-4 bg-white rounded-lg border shadow-sm border-gray-200 dark:bg-gray-800 dark:border-gray-800 flex gap-x-4">

        <textarea id="{{$inputId}}" rows="1"
                  class="block py-3 px-5 w-full text-sm text-gray-900 bg-white rounded-md border border-gray-200 dark:bg-gray-800 dark:border-gray-800 dark:placeholder-gray-400 dark:text-white focus:ring-0 @error($state.'.body')
        border-red-500 @enderror"
                  rows="1"
                  style="resize: none"
                  placeholder="{{__('Write a comment')}}..."
                  wire:model="{{$state}}.body"></textarea>

        <button type="submit"
                class="inline-flex justify-center p-3 text-gray-300 rounded-full cursor-pointer hover:bg-primary-100 dark:text-gray-400 dark:hover:text-gray-300"
                wire:loading.attr="disabled" type="submit">
            <svg aria-hidden="true" class="w-5 h-5 rotate-90" fill="currentColor" viewBox="0 0 20 20"
                 xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"></path>
            </svg>
            <span class="sr-only">Send message</span>
        </button>

    </div>
    @if(!empty($users) && $users->count() > 0)
        @include('livewire.partials.dropdowns.users')
    @endif
    @error($state.'.body')
    <p class="mt-2 text-xs text-red-400">
        {{$message}}
    </p>
    @enderror

</form>
