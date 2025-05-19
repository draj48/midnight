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
                                {{__('People')}}
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
                                   href="{{route('admin.'.$config['route'].'.edit',$listing->id)}}">
                                    <div
                                        class="aspect-square rounded-md w-12 overflow-hidden relative">
                                        {!! picture($listing->imageurl,config('attr.poster.size_x').','.config('attr.poster.size_y'),'absolute h-full w-full object-cover rounded-md',$listing->name,'people') !!}
                                    </div>
                                    <div class="">
                                        <div
                                            class="font-medium group-hover:underline mb-1">{{$listing->name}}</div>
                                        @if(!empty($listing->gender))
                                            <div
                                                class="text-xs text-gray-400 dark:text-gray-500">{{config('attr.gender')[$listing->gender]}}</div>
                                        @endif
                                    </div>
                                </a>
                            </td>
                            <td>
                                <div class="flex items-center justify-end text-end space-x-5">
                                    <x-form.button-edit
                                        route="{{route('admin.'.$config['route'].'.edit', $listing->id) }}"/>
                                    <x-form.button-delete
                                        route="{{route('admin.'.$config['route'].'.destroy', $listing->id) }}"/>
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
