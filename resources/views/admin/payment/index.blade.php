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
                        <th scope="col">
                            <div
                                class="text-xs font-medium tracking-wide text-gray-700 dark:text-gray-200">
                                {{__('Plan')}}
                            </div>
                        </th>
                        <th scope="col">
                            <div
                                class="text-xs font-medium tracking-wide text-gray-700 dark:text-gray-200">
                                {{__('Payment method')}}
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
                                   href="{{route('admin.'.$config['route'].'.edit',$listing->id)}}">

                                    {!! gravatar($listing->user->name,$listing->user->avatarurl,'h-10 w-10 rounded-full bg-primary-500 text-xs font-bold flex items-center justify-center text-white') !!}
                                    <div class="">
                                        <div
                                            class="font-medium group-hover:underline">{{$listing->user->name}}</div>
                                        <div
                                            class="text-xs text-gray-400 dark:text-gray-500">{{$listing->user->email}}</div>
                                    </div>
                                </a>
                            </td>
                            <td>

                                <div class="text-sm text-gray-600 dark:text-gray-200 flex items-center space-x-6">
                                    {{$listing->plan->name}}
                                </div>
                            </td>
                            <td>
                                <div class="text-sm text-gray-600 dark:text-gray-200 flex items-center space-x-6">
                                    {{$listing->payment_method}}
                                </div>
                            </td>
                            <td>
                                @if($listing->status == 'completed')
                                    <div
                                        class="inline-flex items-center gap-1.5 py-0.5 px-2 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                        <svg class="w-2.5 h-2.5" xmlns="http://www.w3.org/2000/svg"
                                             width="16"
                                             height="16" fill="currentColor" viewBox="0 0 16 16">
                                            <path
                                                d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                                        </svg>
                                        {{__('Completed')}}
                                    </div>
                                @elseif($listing->status == 'cancelled')
                                    <div
                                        class="inline-flex items-center gap-1.5 py-0.5 px-2 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                        <svg class="w-2.5 h-2.5" xmlns="http://www.w3.org/2000/svg"
                                             width="16"
                                             height="16" fill="currentColor" viewBox="0 0 16 16">
                                            <path
                                                d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                                        </svg>
                                        {{__('Cancelled')}}
                                    </div>
                                @else
                                    <div
                                        class="inline-flex items-center gap-1.5 py-0.5 px-2 rounded-full text-xs font-medium bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200">
                                        <svg class="w-2.5 h-2.5" xmlns="http://www.w3.org/2000/svg"
                                             width="16"
                                             height="16" fill="currentColor" viewBox="0 0 16 16">
                                            <path
                                                d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                                        </svg>
                                        {{__('Pending')}}
                                    </div>
                                @endif
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
