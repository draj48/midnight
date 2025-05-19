
<div class="mb-4">
    <template x-for="(video, index) in videos" :key="index">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-x-6">
            <input type="hidden" x-bind:name="`video[${index}][id]`" x-model="video.id">
            <div class="col-span-3">
                <div class="mb-4">
                    <x-form.select x-model="video.type" x-bind:name="`video[${index}][type]`">
                        <option value="">{{__('Choose')}}</option>
                        @foreach(config('attr.streams') as $key => $value)
                            <option value="{{$key}}">{{__($value)}}</option>
                        @endforeach
                    </x-form.select>
                </div>
            </div>
            <div class="col-span-3">
                <div class="mb-4">
                    <x-form.input type="text" name="video[][label]"
                                  placeholder="{{__('Label')}}" x-model="video.label" x-bind:name="`video[${index}][label]`"/>
                </div>
            </div>
            <div class="col-span-4">
                <div class="mb-4">
                    <x-form.input type="text" name="video[][link]"
                                  placeholder="{{__('http://')}}" x-model="video.link" x-bind:name="`video[${index}][link]`"/>
                </div>
            </div>
            <div class="col-span-2">
                <x-form.secondary type="button" @click="removeVideoField(index,video.id)"
                                  class="w-full">{{__('Remove')}}</x-form.secondary>
            </div>
        </div>
    </template>
    <x-form.secondary type="button" @click="addVideoField()"
                      class="w-full">{{__('Add new')}}</x-form.secondary>
    <x-form.secondary type="button" @click="bulkModal = true;"
                      class="w-full mt-3">{{__('Bulk add')}}</x-form.secondary>
</div>
