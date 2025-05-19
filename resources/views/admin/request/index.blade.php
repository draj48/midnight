@extends('layouts.admin')
@section('content')
    <div class="container-fluid">
        <div
            class="border border-gray-200 bg-white dark:bg-gray-900 dark:border-gray-800 text-gray-500 shadow-sm rounded-xl p-1">
            <div class="overflow-auto lg:overflow-visible">
                <table class="table-list">
                    <thead class="">
                    <tr>
                        <th scope="col">
                            <div
                                class="text-xs font-medium tracking-wide text-gray-700 dark:text-gray-200">
                                {{__('Report')}}
                            </div>
                        </th>
                        <th scope="col">
                            <div
                                class="text-xs font-medium tracking-wide text-gray-700 dark:text-gray-200">
                                {{__('Status')}}
                            </div>
                        </th>
                        <th scope="col"></th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($listings as $listing)
                        <tr>
                            <td>
                                <a class="text-sm text-gray-600 dark:text-gray-200 flex items-center space-x-6 group"
                                   href="{{route('admin.'.$listing->type.'.create', ['tmdb_id' => $listing->tmdb_id])}}">
                                    <div
                                        class="aspect-[2/3] rounded-md w-12 overflow-hidden relative">
                                        <img src="{{$listing->image}}"
                                             class="absolute inset-0 object-cover">
                                    </div>
                                    <div class="">
                                        <div
                                            class="font-medium group-hover:underline mb-2">{{$listing->title}}</div>
                                        <div
                                            class="text-xs text-gray-400 dark:text-gray-500">{{$listing->type}}</div>
                                    </div>
                                </a>
                            </td>
                            <td>
                                <div class="text-xs text-gray-400 dark:text-gray-400">
                                    {{$listing->request}}
                                </div>
                            </td>
                            <td>
                                <div class="flex items-center justify-end text-end space-x-5">
                                    <x-form.button-edit
                                        route="{{route('admin.'.$listing->type.'.create', ['tmdb_id' => $listing->tmdb_id]) }}"/>
                                    <x-form.button-delete
                                        route="{{route('admin.'.$config['nav'].'.destroy', $listing->id) }}"/>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                @include('admin.partials.table-footer')
            </div>
        </div>
    </div>
@endsection
