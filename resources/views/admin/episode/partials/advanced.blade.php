<div class="mb-5">
    <x-form.label for="meta_title" :value="__('Meta Title')"/>
    <x-form.input id="meta_title" class="block mt-1 w-full" type="text" name="meta_title"
                  value="{{ old('meta_title', isset($listing) ? $listing->meta_title : '') }}"
                  placeholder="{{__('Meta Title')}}"/>
    <x-form.error :messages="$errors->get('meta_title')" class="mt-2"/>
</div>
<div class="mb-5">
    <x-form.label for="meta_description" :value="__('Meta Description')"/>
    <x-form.textarea name="meta_description"
                     placeholder="{{__('Meta Description')}}">{{ old('meta_description', isset($listing) ? $listing->meta_description : '') }}</x-form.textarea>
    <x-form.error :messages="$errors->get('description')" class="mt-2"/>
</div>

<div class="mb-5">
    <x-form.label for="tmdb_id" :value="__('Themoviedb ID')"/>
    <x-form.input id="tmdb_id" class="block mt-1 w-full" type="text" name="tmdb_id"
                  value="{{ old('tmdb_id', isset($listing) ? $listing->tmdb_id : '') }}"
                  placeholder="{{__('Themoviedb ID')}}" x-model="importerData.tmdb_id"/>
    <x-form.error :messages="$errors->get('tmdb_id')" class="mt-2"/>
</div>
