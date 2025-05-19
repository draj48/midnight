
<div class="mb-4">
    <template x-for="(season, index) in seasons" :key="index">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-x-6">
            <input type="hidden" x-bind:name="`season[${index}][id]`" x-model="season.id">
            <input type="hidden" x-bind:name="`season[${index}][tmdb_id]`" x-model="season.tmdb_id">
            <input type="hidden" x-bind:name="`season[${index}][episode]`" x-model="season.episode">
            <div class="col-span-5">
                <div class="mb-4">
                    <x-form.input type="text" name="season[][name]"
                                  placeholder="{{__('Season name')}}" x-model="season.name" x-bind:name="`season[${index}][name]`"/>
                </div>
            </div>
            <div class="col-span-5">
                <div class="mb-4">
                    <x-form.input type="text" name="season[][season_number]"
                                  placeholder="{{__('Season number')}}" x-model="season.season_number" x-bind:name="`season[${index}][season_number]`"/>
                </div>
            </div>
            <div class="col-span-2">
                <x-form.secondary type="button" @click="removeSeasonField(index,season.id)"
                                  class="w-full">{{__('Remove')}}</x-form.secondary>
            </div>
        </div>
    </template>
    <x-form.secondary type="button" @click="addSeasonField()"
                      class="w-full">{{__('Add new')}}</x-form.secondary>
</div>
