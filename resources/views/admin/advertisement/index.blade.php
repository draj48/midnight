@extends('layouts.admin')
@section('content')

    <div class="container-fluid">
        <div
            class="border border-gray-200 bg-white dark:bg-gray-900 dark:border-gray-800 text-gray-500 shadow-sm rounded-xl">
            @include('admin.partials.table-header')
            <div class="overflow-auto lg:overflow-visible">
                <table class="table-list">
                    <thead class="">
                    <tr>
                        <th scope="col">
                            <div
                                class="text-xs font-medium tracking-wide text-gray-700 dark:text-gray-200">
                                {{__('Placement')}}
                            </div>
                        </th>
                        <th scope="col"></th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($listings as $listing)
                        <tr>
                            <td>

                                <a class="text-sm text-gray-600 dark:text-gray-200 flex items-center space-x-6 hover:underline"
                                   href="{{route('admin.'.$config['route'].'.edit',$listing->id)}}">
                                    {{$listing->name}}
                                </a>
                            </td>
                            <td>
                                <div class="flex items-center justify-end text-end space-x-5">
                                    <x-form.button-edit
                                        route="{{route('admin.'.$config['route'].'.edit', $listing->id) }}"/>
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
