@if(isset($module->arguments->listing) AND $module->arguments->listing == 'slide')
<livewire:episodecalendar/>
@else
    @if(count($listings['episode']) > 0)
    <div class="pb-6 lg:pb-10">
            <div
                class="flex flex-col flex-wrap lg:flex-row items-center mb-6 lg:space-x-12">
                <h3 class="text-gray-900 dark:text-white text-lg font-medium lg:text-left text-center capitalize mb-4 lg:mb-0 rtl:ml-10">{{__($module->title)}}</h3>
            </div>

            <div class="grid grid-cols-2 lg:grid-cols-6 2xl:grid-cols-8 gap-6">
                @foreach($listings['episode'] as $listing)
                    <x-ui.episode :title="$listing->post->title" :listing="$listing" :image="$listing->imageurl"/>
                @endforeach
            </div>
    </div>

    @endif
@endif
