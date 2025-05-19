<div class="mb-5">
    <x-form.label for="title" :value="__('Heading')"/>
    <x-form.input id="title" class="block mt-1 w-full" type="text" name="module[{{$module->id}}][title]"
                  value="{{ isset($module->title) ? $module->title : null }}"
                  placeholder="{{__('Heading')}}"/>
</div>
<div class="grid grid-cols-1 lg:grid-cols-2 gap-x-6">

    <div class="mb-5">
        <x-form.label for="listing" :value="__('Listing')"/>
        <x-form.select name="module[{{$module->id}}][arguments][listing]">
            <option value="slide" @if(isset($module->arguments->listing) AND $module->arguments->listing == 'slide'){{'selected'}}@endif>{{__('Slide')}}</option>
            <option value="classic" @if(isset($module->arguments->listing) AND $module->arguments->listing == 'classic'){{'selected'}}@endif>{{__('Classic')}}</option>
        </x-form.select>
    </div>
    <div class="mb-5">
        <x-form.label for="limit" :value="__('Limit')"/>
        <x-form.input id="limit" class="block mt-1 w-full" type="text" name="module[{{$module->id}}][arguments][limit]"
                      value="{{ isset($module->arguments->limit) ? $module->arguments->limit : 10 }}"
                      placeholder="{{__('Limit')}}"/>
    </div>
</div>

<div class="flex items-center space-x-4 mt-2">
    <x-form.switch type="checkbox" id="status{{$module->id}}" name="module[{{$module->id}}][status]" value="active"
                   :checked="isset($module) AND $module->status == 'active' ? true : false"/>
    <x-form.label for="status{{$module->id}}" class="md:mb-0 cursor-pointer font-normal"
                  :value="__('Active')"/>
</div>
