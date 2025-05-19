
<div class="shrink-0 relative" x-data="{dropdownOpen: false}">
    <x-form.secondary class="shrink-0" size="icon" @click="dropdownOpen=true">
        <x-ui.icon name="sort-2" class="w-5 h-5" stroke="currentColor" stroke-width="1.75"/>
    </x-form.secondary>
    <div x-show="dropdownOpen"
         @click.away="dropdownOpen=false"
         x-transition:enter="ease-out duration-200"
         x-transition:enter-start="-translate-y-2"
         x-transition:enter-end="translate-y-0"
         class="absolute top-0 z-50 w-[26rem] mt-14 left-1/2 -translate-x-1/2 bg-white dark:bg-gray-900 backdrop-blur dark:shadow-none dark:border-gray-800 shadow-sm border border-gray-200 rounded-xl p-8 text-gray-500"
         x-cloak>
        <form method="get" action="{{route('admin.'.$config['route'].'.index')}}">
            <div class="mb-5">
                <x-form.label for="status" :value="__('Status')"/>
                <x-form.select name="status" id="status">
                    <option
                        value="publish" @if($request->status AND $request->status == 'publish')
                        {{'selected'}}
                        @endif>{{__('Publish')}}
                    </option>
                    <option value="draft" @if($request->status AND $request->status == 'draft')
                        {{'selected'}}
                        @endif>{{__('Draft')}}
                    </option>
                </x-form.select>
            </div>
            <div class="mb-5">
                <x-form.label for="featured" :value="__('Advanced')"/>

                <div class="flex items-center space-x-4 mt-2">
                    <x-form.switch type="checkbox" id="featured" name="featured" value="active"
                                   :checked="isset($request->featured) AND $request->featured == 'active' ? true : false"/>
                    <x-form.label for="featured" class="md:mb-0 cursor-pointer font-normal"
                                  :value="__('Show featured')"/>
                </div>
                <div class="flex items-center space-x-4 mt-2">
                    <x-form.switch type="checkbox" id="slider" name="slider" value="active"
                                   :checked="isset($request->slider) AND $request->slider == 'active' ? true : false"/>
                    <x-form.label for="slider" class="md:mb-0 cursor-pointer font-normal"
                                  :value="__('Show slider')"/>
                </div>
                <div class="flex items-center space-x-4 mt-2">
                    <x-form.switch type="checkbox" id="member" name="member" value="active"
                                   :checked="isset($request->member) AND $request->member == 'active' ? true : false"/>
                    <x-form.label for="member" class="md:mb-0 cursor-pointer font-normal"
                                  :value="__('Exclusive to subscriber')"/>
                </div>
            </div>
            <x-form.secondary type="submit" class="w-full">
                <span>Apply</span>
            </x-form.secondary>
        </form>
    </div>
</div>
