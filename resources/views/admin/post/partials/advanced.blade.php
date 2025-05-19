<div class="grid grid-cols-1 lg:grid-cols-12 gap-10 mb-5">
    <div class="lg:col-span-4"  x-data="{ file: {{isset($listing->cover) ? "'".$listing->cover."'" : 'null'}} }">
        <x-form.label for="logo" :value="__('Cover')"/>
        <div class="flex items-center justify-center w-full">
            <label for="cover-file" class="flex flex-col items-center justify-center w-full h-52 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                    <x-ui.icon name="upload" fill="currentColor" class="w-8 h-8 text-gray-500 mb-5"/>
                    <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">{{__('Click to upload or drag')}}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">PNG, JPG (MAX. {{config('attr.poster.cover_size_x').'x'.config('attr.poster.cover_size_y')}})</p>
                </div>
                <input id="cover-file" type="file" class="hidden" name="cover" accept="image/*" x-on:change="file = 'Selected'"/>
            </label>
        </div>
        <a href="{{isset($listing->cover) ? $listing->coverurl : '#'}}" target="_blank" class="text-sm p-2 inline-flex text-gray-500 dark:text-gray-400" x-text="file ? file : '{{__('Choose cover file')}}'"></a>
        <input type="hidden" name="cover_url" :value="importerData.cover">
    </div>
    <div class="lg:col-span-4"  x-data="{ file: {{isset($listing->slide) ? "'".$listing->slide."'" : 'null'}} }">
        <x-form.label for="logo" :value="__('Slide')"/>
        <div class="flex items-center justify-center w-full">
            <label for="slide-file" class="flex flex-col items-center justify-center w-full h-52 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                    <x-ui.icon name="upload" fill="currentColor" class="w-8 h-8 text-gray-500 mb-5"/>
                    <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">{{__('Click to upload or drag')}}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">PNG, JPG (MAX. {{config('attr.poster.banner_x').'x'.config('attr.poster.banner_y')}})</p>
                </div>
                <input id="slide-file" type="file" class="hidden" name="slide" accept="image/*" x-on:change="file = 'Selected'"/>
            </label>
        </div>
        <a href="{{isset($listing->slide) ? $listing->slideurl : '#'}}" target="_blank" class="text-sm p-2 inline-flex text-gray-500 dark:text-gray-400" x-text="file ? file : '{{__('Choose cover file')}}'"></a>
        <input type="hidden" name="slide_url" :value="importerData.slide">
    </div>
    <div class="lg:col-span-4"  x-data="{ file: {{isset($listing->story) ? "'".$listing->story."'" : 'null'}} }">
        <x-form.label for="logo" :value="__('Featured')"/>
        <div class="flex items-center justify-center w-full">
            <label for="story-file" class="flex flex-col items-center justify-center w-full h-52 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                    <x-ui.icon name="upload" fill="currentColor" class="w-8 h-8 text-gray-500 mb-5"/>
                    <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">{{__('Click to upload or drag')}}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">PNG, JPG (MAX. {{config('attr.poster.cover_size_x').'x'.config('attr.poster.cover_size_y')}})</p>
                </div>
                <input id="story-file" type="file" class="hidden" name="story" accept="image/*" x-on:change="file = 'Selected'"/>
            </label>
        </div>
        <a href="{{isset($listing->story) ? $listing->storyurl : '#'}}" target="_blank" class="text-sm p-2 inline-flex text-gray-500 dark:text-gray-400" x-text="file ? file : '{{__('Choose cover file')}}'"></a>
        <input type="hidden" name="story_url" :value="importerData.story">
    </div>
</div>
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
    <x-form.label for="information" :value="__('Information box')"/>
    <x-form.input id="information" class="block mt-1 w-full" type="text" name="arguments[information]"
                  value="{{ old('information', isset($listing->arguments->information) ? $listing->arguments->information : '') }}"
                  placeholder="{{__('Information box')}}"/>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-x-8">
    <div class="mb-5">
        <x-form.label for="tmdb_id" :value="__('Themoviedb ID')"/>
        <x-form.input id="tmdb_id" class="block mt-1 w-full" type="text" name="tmdb_id"
                      value="{{ old('tmdb_id', isset($listing) ? $listing->tmdb_id : '') }}"
                      placeholder="{{__('Themoviedb ID')}}" x-model="importerData.tmdb_id"/>
        <x-form.error :messages="$errors->get('tmdb_id')" class="mt-2"/>
    </div>
    <div class="mb-5">
        <x-form.label for="imdb_id" :value="__('Imdb ID')"/>
        <x-form.input id="imdb_id" class="block mt-1 w-full" type="text" name="imdb_id"
                      value="{{ old('imdb_id', isset($listing) ? $listing->imdb_id : '') }}"
                      placeholder="{{__('Imdb ID')}}" x-model="importerData.imdb_id"/>
        <x-form.error :messages="$errors->get('imdb_id')" class="mt-2"/>
    </div>
</div>

