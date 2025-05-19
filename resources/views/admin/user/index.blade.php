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
                                {{__('User')}}
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

                                    {!! gravatar($listing->name,$listing->avatarurl,'h-10 w-10 rounded-full bg-primary-500 text-xs font-bold flex items-center justify-center text-white') !!}
                                    <div class="">
                                        <div
                                            class="font-medium group-hover:underline">{{$listing->name}}</div>
                                        <div
                                            class="text-xs text-gray-400 dark:text-gray-500">{{$listing->username}}</div>
                                    </div>
                                </a>
                            </td>
                            <td>
                                <div class="flex items-center justify-end text-end space-x-5">
                                    <x-form.button-edit
                                        route="{{route('admin.'.$config['route'].'.edit', $listing->id) }}"/>
                                    @if(auth()->user()->id != $listing->id)
                                        <x-form.button-delete
                                            route="{{route('admin.'.$config['route'].'.destroy', $listing->id) }}"/>
                                    @endif
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
