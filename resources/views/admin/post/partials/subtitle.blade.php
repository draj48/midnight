
<div class="mb-4">
    <template x-for="(subtitle, index) in subtitles" :key="index">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-x-6">
            <input type="hidden" x-bind:name="`subtitle[${index}][id]`" x-model="subtitle.id">

            <div class="col-span-3">
                <div class="mb-4">
                    <x-form.select name="subtitle[][country_id]" x-model="subtitle.country_id" x-bind:name="`subtitle[${index}][country_id]`">
                        <option>{{__('Choose')}}</option>
                        @foreach($countries as $country)
                            <option data-text="{{$country->code}}" value="{{$country->id}}"
                                    @if(isset($listing->country_id) AND $listing->country_id == $country->id) selected @endif>{{$country->name}}</option>
                        @endforeach
                    </x-form.select>
                </div>
            </div>
            <div class="col-span-7">
                <div class="mb-4">
                    <x-form.file type="file" name="subtitle[][link]"
                                  placeholder="{{__('http://')}}" x-model="subtitle.link" x-bind:name="`subtitle[${index}][link]`"/>
                </div>
            </div>
            <div class="col-span-2">
                <x-form.secondary type="button" @click="removeSubField(index,subtitle.id)"
                                  class="w-full">{{__('Remove')}}</x-form.secondary>
            </div>
        </div>
    </template>
    <x-form.secondary type="button" @click="addSubField()"
                      class="w-full">{{__('Add new')}}</x-form.secondary>
</div>
