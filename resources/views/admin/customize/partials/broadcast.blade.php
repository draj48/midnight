
<div class="mb-5">
    <x-form.label for="title" :value="__('Heading')"/>
    <x-form.input id="title" class="block mt-1 w-full" type="text" name="module[{{$module->id}}][title]"
                  value="{{ isset($module->title) ? $module->title : null }}"
                  placeholder="{{__('Heading')}}"/>
</div>
<div class="mb-5">
    <x-form.label for="limit" :value="__('Limit')"/>
    <x-form.input id="limit" class="block mt-1 w-full" type="text" name="module[{{$module->id}}][arguments][limit]"
                  value="{{ isset($module->arguments->limit) ? $module->arguments->limit : null }}"
                  placeholder="{{__('Limit')}}"/>
</div>

<div class="flex items-center space-x-4 mt-2">
    <x-form.switch type="checkbox" id="status" name="module[{{$module->id}}][status]" value="active"
                   :checked="isset($module) AND $module->status == 'active' ? true : false"/>
    <x-form.label for="status" class="md:mb-0 cursor-pointer font-normal"
                  :value="__('Active')"/>
</div>
