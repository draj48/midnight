<div class="mb-5">
    <x-form.label for="name" :value="__('Title')"/>
    <x-form.input id="name" class="block mt-1 w-full" type="text" name="name"
                  value="{{ old('name', isset($listing) ? $listing->name : '') }}" size="lg"
                  required placeholder="{{__('Title')}}" x-model="importerData.name"/>
    <x-form.error :messages="$errors->get('title')" class="mt-2"/>
    <div class="flex items-center text-xs mt-2">
        <span class="font-medium text-gray-500 mr-2">Permalink</span>
        <span class="text-gray-500">{{url('/'.__('play').'/').'/'}}</span>
        <input type="text" name="slug"
               class="font-medium border-0 py-0 text-xs px-1 inline-flex text-primary-500 bg-transparent focus:ring-0 w-auto placeholder-gray-300 dark:placeholder-gray-500"
               placeholder="slug"
               value="{{ old('slug', isset($listing) ? $listing->slug : '') }}">
    </div>
</div>
<div class="grid grid-cols-1 lg:grid-cols-2 gap-x-10">

    <div class="mb-5">
        <x-form.label for="episode_number" :value="__('Episode number')"/>
        <x-form.input id="episode_number" class="block mt-1 w-full" type="number" name="episode_number"
                      value="{{ old('episode_number', isset($listing) ? $listing->episode_number : '') }}"
                      placeholder="{{__('Episode number')}}" x-model="importerData.episode_number"/>
        <x-form.error :messages="$errors->get('episode_number')" class="mt-2"/>
    </div>
    <div class="mb-5">
        <x-form.label for="post_season_id" :value="__('Season')"/>
        <x-form.select name="post_season_id" required>
            @if(isset($listing->post_season_id))
                @foreach($listing->post->seasons as $season)
                    <option value="{{$season->id}}" @if($listing->post_season_id == $season->id)
                        {{'selected'}}
                        @endif>{{$season->name}}</option>
                @endforeach
            @endif
            @if(isset($request->post_id))
                @php
                    $seasons = \App\Models\Post::where('id',$request->post_id)->first();
                @endphp
                    <option value="">{{__('Choose')}}</option>
                @foreach($seasons->seasons as $season)
                    <option value="{{$season->id}}">{{$season->name}}</option>
                @endforeach
            @endif
        </x-form.select>
    </div>
</div>
<div class="mb-5">
    <x-form.label for="overview" :value="__('Overview')"/>
    <x-form.textarea name="overview" placeholder="{{__('Overview')}}" rows="4"
                     x-model="importerData.overview">{{ old('overview', isset($listing) ? $listing->overview : '') }}</x-form.textarea>
    <x-form.error :messages="$errors->get('overview')" class="mt-2"/>
</div>
<div class="grid grid-cols-1 lg:grid-cols-12 gap-x-8">

    <div class="mb-5 col-span-4">
        <x-form.label for="runtime" :value="__('Runtime')"/>
        <x-form.input id="runtime" class="block mt-1 w-full" type="text" name="runtime"
                      value="{{ old('runtime', isset($listing) ? $listing->runtime : '') }}"
                      placeholder="{{__('Runtime')}}" x-model="importerData.runtime"/>
        <x-form.error :messages="$errors->get('runtime')" class="mt-2"/>
    </div>
    <div class="mb-5 col-span-4">
        <x-form.label for="quality" :value="__('Video Quality')"/>
        <x-form.select name="quality" id="quality">
            <option value="">{{__('Choose')}}</option>
            @foreach(config('attr.quality') as $quality)
                <option value="{{$quality}}"
                        @if(isset($listing->quality) AND $listing->quality == $quality) selected @endif>{{$quality}}</option>
            @endforeach
        </x-form.select>
        <x-form.error :messages="$errors->get('release_date')" class="mt-2"/>
    </div>
    <div class="mb-5 col-span-4">
        <x-form.label for="view" :value="__('View')"/>
        <x-form.input id="view" class="block mt-1 w-full" type="number" name="view"
                      value="{{ old('view', isset($listing) ? $listing->view : '') }}"
                      placeholder="{{__('View')}}"/>
        <x-form.error :messages="$errors->get('view')" class="mt-2"/>
    </div>
</div>

@push('javascript')
    <script src="{{asset('static/js/jquery.js')}}" type="text/javascript"></script>
    <script src="{{asset('static/js/select.js')}}" type="text/javascript"></script>
    <script type="text/javascript">
        var seasonData = [];
        var getSeason = [];
        $('.selectize-tv').selectize({
            valueField: 'id',
            labelField: 'title',
            searchField: 'title',
            options: [],
            maxItems: 1,
            load: function (query, callback) {
                if (!query.length) return callback();
                $.ajax({
                    url: '{{route('admin.tv.search')}}?q=' + encodeURIComponent(query),
                    type: 'GET',
                    dataType: 'json',
                    error: function () {
                        callback();
                    },
                    success: function (resp) {
                        if (resp.data.length > 0 || resp.data) {
                            callback(resp.data.slice(0, 10));
                            seasonData = resp.data.slice(0, 10);
                        }
                    }
                });
            },
            create: false,
            onChange: function (value) {
                if (value) {
                    if (value) {
                        seasonData.forEach(e => {
                            if (e.id === value) {
                                getSeason = e.seasons;
                            }
                        });

                        var selectizeSeason = $('.selectize-season')[0].selectize;
                        selectizeSeason.clearOptions();
                        selectizeSeason.addOption(getSeason);
                        selectizeSeason.refreshOptions();
                    }
                }
            }
        })

        $('.selectize-season').selectize({
            valueField: 'id',
            labelField: 'name',
            searchField: 'name',
        });

    </script>
@endpush
