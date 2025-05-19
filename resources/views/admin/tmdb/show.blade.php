@extends('layouts.admin')
@section('content')

    <div class="container-fluid">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
    <a href="/public/bulk/index.php" class="block bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium py-2 px-3 rounded-md transition-all duration-300 shadow text-center border border-gray-200 rounded-xl shadow-sm dark:bg-gray-900 dark:border-gray-800 p-3">
        Bulk-Import-Custom
    </a>

    <a href="/public/bulk/automovie-mass.php" class="block bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium py-2 px-3 rounded-md transition-all duration-300 shadow text-center border border-gray-200 rounded-xl shadow-sm dark:bg-gray-900 dark:border-gray-800 p-3">
        Bulk-Import-Movies
    </a>

    <a href="/public/bulk/autoshow-mass.php" class="block bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium py-2 px-3 rounded-md transition-all duration-300 shadow text-center border border-gray-200 rounded-xl shadow-sm dark:bg-gray-900 dark:border-gray-800 p-3">
        Bulk-Import-Shows
    </a>
</div>


            <form method="post" action="{{route('admin.tmdb.fetch')}}"
                  class="grid grid-cols-1 lg:grid-cols-12 lg:gap-x-8 gap-4 px-5 py-4 ">
                @csrf
                <div class="lg:col-span-2">
                    <x-form.select name="type">
                        @foreach(config('attr.tmdb.type') as $key => $value)
                            <option value="{{$key}}" @if(isset($request->type) AND $key == $request->type){{'selected'}}@endif>{{__($value)}}</option>
                        @endforeach
                    </x-form.select>
                </div>
                <div class="lg:col-span-6">
                    <x-form.input type="text" name="q" placeholder="{{__('Search')}}"
                                  value="{{old('q') ?? $request->q}}"/>
                </div>
                <div class="lg:col-span-2">
                    <x-form.select name="sortable">
                        @foreach(config('attr.tmdb.sortable') as $key => $value)
                            <option value="{{$key}}">{{__($value)}}</option>
                        @endforeach
                    </x-form.select>
                </div>
                <div class="lg:col-span-2">
                    <x-form.secondary type="submit"
                                      class="w-full">{{__('Fetch data')}}</x-form.secondary>
                </div>
            </form>

            <div class="">
                <table class="min-w-full divide-y divide-gray-100 dark:divide-gray-800">
                    <thead class="bg-gray-50 dark:bg-gray-800">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left">
                            <div
                                class="text-xs font-medium tracking-tight text-gray-700 dark:text-gray-200">
                                {{__('Heading')}}
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-3 text-left">
                            <div
                                class="text-xs font-medium tracking-tight text-gray-700 dark:text-gray-200">
                                {{__('Release date')}}
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-3 text-left">
                            <div
                                class="text-xs font-medium tracking-tight text-gray-700 dark:text-gray-200">
                                {{__('Popularity')}}
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-4 text-right"></th>
                    </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @if(isset($listings))
                        @foreach($listings as $listing)
                            <tr class="form{{$listing['id']}}">
                                <td class="h-px w-px whitespace-nowrap">
                                    <div class="px-6 py-3">
                                        <a class="text-sm text-gray-600 dark:text-gray-200 flex items-center space-x-6 group"
                                           href="">
                                            <div
                                                class="aspect-[2/3] bg-gray-100 rounded-md w-14 overflow-hidden relative">
                                                <img src="{{$listing['image']}}"
                                                     class="absolute inset-0 object-cover">
                                            </div>
                                            <div class="">
                                                <div
                                                    class="font-medium group-hover:underline mb-2">{{$listing['title']}}</div>
                                                <div
                                                    class="text-xs text-gray-400 dark:text-gray-500">{{Str::limit($listing['overview'],80)}}</div>
                                            </div>
                                        </a>
                                    </div>
                                </td>
                                <td class="h-px w-px whitespace-nowrap">
                                    <div class="px-6 py-3">
                                        <div
                                            class="text-sm text-gray-400 dark:text-gray-500">{{date('Y', strtotime($listing['release_date']))}}</div>
                                    </div>
                                </td>
                                <td class="h-px w-px whitespace-nowrap">
                                    <div class="px-6 py-3 flex items-center space-x-6">
                                        <div
                                            class="flex max-w-[100px] w-full h-2 bg-gray-100 rounded-full overflow-hidden dark:bg-gray-700">
                                            <div
                                                class="flex flex-col justify-center  rounded-full overflow-hidden @if($listing['vote_average'] <5){{'bg-red-500'}}@elseif($listing['vote_average'] >=5 AND $listing['vote_average'] <= 7){{'bg-orange-400'}}@elseif($listing['vote_average'] >7){{'bg-emerald-500'}}@endif"
                                                role="progressbar"
                                                style="width: {{($listing['vote_average'] / '10') * 100}}%"
                                                aria-valuenow="78"
                                                aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <div
                                            class="text-sm font-medium text-gray-500 dark:text-gray-300">{{$listing['vote_average']}}</div>
                                    </div>
                                </td>
                                <td class="h-px w-px whitespace-nowrap">
                                    <div class="px-6 py-3 flex justify-end">
                                        <form method="post" action="{{route('admin.tmdb.store')}}" data-id="{{$listing['id']}}" class="ajax-form">
                                            @csrf
                                            <input type="hidden" name="tmdb_id" value="{{$listing['id']}}">
                                            <input type="hidden" name="type" value="{{$listing['type']}}">
                                            <input type="hidden" name="import_people" value="{{config('settings.tmdb_people_limit') > 0 ? 'enable' : 'disable'}}">
                                            <input type="hidden" name="2embed" value="{{config('settings.2embed') > 0 ? 'enable' : 'disable'}}">
                                            <input type="hidden" name="vidsrc" value="{{config('settings.vidsrc') > 0 ? 'enable' : 'disable'}}">
                                            <input type="hidden" name="add_season" value="{{config('settings.add_season') > 0 ? 'enable' : 'disable'}}">
                                            <input type="hidden" name="add_episode" value="{{config('settings.add_episode') > 0 ? 'enable' : 'disable'}}">
                                            <x-form.secondary
                                                class="!px-6"
                                                size="sm"
                                                x-data="{loading:false}"
                                                @click="loading = true; submitForm($event.target.form)"
                                                x-bind:disabled="loading">
                                                    {{__('Import')}}
                                            </x-form.secondary>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
            @if(isset($result['total_results']) AND $result['total_results'] > 0)
                @include('admin.tmdb.pagination')
            @endif
        </div>
    </div>
    @push('javascript')
        <script>
            function submitForm(form) {
                const btn = this;

                const postdata = new FormData(form);
                const formurl = form.getAttribute('action');
                const dataId = form.getAttribute('data-id');

                return fetch(formurl, {
                    method: 'POST',
                    body: postdata
                })
                    .then(response => {
                        if (response.ok) {
                            document.querySelector('.form' + dataId).remove();
                        }
                    })
                    .finally(() => {
                        btn.loading = false;
                    });
            }
            const form = document.querySelector('.ajax-form');
            form.addEventListener('submit', function(event) {
                event.preventDefault();
                submitForm(form);
            });
        </script>
    @endpush
@endsection
