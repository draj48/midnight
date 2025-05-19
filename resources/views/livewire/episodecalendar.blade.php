<div class="pb-6 lg:pb-10" x-data="{day:'{{now()->format('Y-m-d')}}'}">
    <div class="bg-gray-900 rounded-xl px-6 pt-4 pb-10 2xl:px-8">
        <div
            class="flex flex-col flex-wrap lg:flex-row items-center mb-6 lg:space-x-12">
            <h3 class="text-gray-900 dark:text-white text-lg font-medium lg:text-left text-center capitalize mb-4 lg:mb-0 rtl:ml-10">{{__('Episode Calendar')}}</h3>
            <div class="flex gap-x-1 group w-full lg:w-auto overflow-x-auto">
                @foreach ($dates as $date)
                    <label class="text-center whitespace-nowrap tracking-tight py-3 px-4 transition duration-300 group text-gray-300 cursor-pointer rounded-lg group-hover:text-gray-400/70 hover:!text-gray-200 @if($loop->index >= 7){{'hidden 2xl:block'}}@endif"
                            @click="day = '{{ $date['date'] }}'" for="day{{$loop->index}}"
                            :class="{ '!bg-gray-800 !text-white': day === '{{ $date['date'] }}' }">
                        <div class="text-xs font-medium">{{ $date['format'] }}</div>
                        <div class="text-xxs opacity-70">{{$date['text']}}</div>
                    </label>
                    <input type="radio" name="day" class="hidden" wire:model.live="day" wire:loading.attr="disabled" value="{{$date['date']}}" id="day{{$loop->index}}">
                @endforeach
            </div>
        </div>

        <div class="grid grid-cols-2 lg:grid-cols-6 2xl:grid-cols-8 gap-6">
            @foreach($listings as $listing)
                <x-ui.episode :title="$listing->post->title" :listing="$listing" :image="$listing->imageurl"/>
            @endforeach
        </div>
    </div>
</div>
