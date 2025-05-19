@extends('layouts.admin')
@section('content')

    <div class="custom-container">
        <div
            class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden dark:bg-gray-900 dark:border-gray-700">
            <div
                class="px-5 py-4 border-b border-gray-200 dark:border-gray-700 lg:flex lg:items-center lg:gap-x-4">

                @if(isset($config['create']))
                    <a href="{{route('admin.'.$config['nav'].'.create')}}"
                       class="py-3 px-5 inline-flex justify-center items-center gap-2 rounded-md border font-medium bg-white text-gray-700 shadow-sm align-middle hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-primary-600 transition-all text-sm dark:bg-gray-900 dark:hover:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:text-white dark:focus:ring-offset-gray-800">
                        <x-ui.icon name="add" fill="currentColor" class="w-5 h-5"/>
                        {{__('Add new')}}
                    </a>
                @endif
                <form method="get" action="{{route('admin.'.$config['nav'].'.index')}}" class="max-w-sm w-full">
                    <label for="search" class="sr-only">Search</label>
                    <div class="relative">
                        <input type="text" id="search" name="q"
                               class="py-3 px-3 pl-11 block w-full border-gray-200 shadow-sm rounded-md text-sm focus:z-10 focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-900 dark:border-gray-700 dark:text-gray-400 placeholder-gray-300"
                               placeholder="{{__('Search')}} ..">
                        <div
                            class="absolute inset-y-0 left-0 flex items-center pointer-events-none pl-4">
                            <x-ui.icon name="search" stroke-width="1.75"
                                       class="h-4 w-4 text-gray-400"/>
                        </div>
                    </div>
                </form>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-800">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left">
                            <div
                                class="text-xs font-medium tracking-wide text-gray-700 dark:text-gray-200">
                                {{__('Heading')}}
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-4 text-right"></th>
                    </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @foreach($listings as $listing)
                        <tr>
                            <td class="h-px w-px whitespace-nowrap">
                                <div class="px-6 py-3">
                                    <a class="text-sm text-gray-600 decoration-2 hover:underline dark:text-gray-200"
                                       href="{{route('admin.'.$config['nav'].'.edit',$listing->id)}}">{{$listing->title}}</a>
                                </div>
                            </td>
                            <td class="h-px w-px whitespace-nowrap">
                                <div class="px-6 py-3 flex justify-end">
                                    <div class="flex items-center justify-end text-end space-x-5">
                                        <x-form.button-edit
                                            route="{{route('admin.'.$config['nav'].'.edit', $listing->id) }}"/>
                                        <x-form.button-delete
                                            route="{{route('admin.'.$config['nav'].'.destroy', $listing->id) }}"/>
                                    </div>
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
