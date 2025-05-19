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
                                {{__('Comment')}}
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
                                   href="{{route('admin.'.$config['nav'].'.edit',$listing->id)}}">
                                    <div
                                        class="aspect-square bg-gray-100 rounded-md w-14 overflow-hidden relative">
                                        {!! picture($listing->commentable->imageurl,config('attr.poster.size_x').','.config('attr.poster.size_y'),'absolute h-full w-full object-cover rounded-md',$listing->commentable->title) !!}
                                    </div>
                                    <div class="">
                                        @if($listing->commentable_type == 'App\Models\Post')
                                            <div
                                                class="font-medium group-hover:underline mb-2">{{$listing->commentable->title}}</div>
                                        @elseif($listing->commentable_type == 'App\Models\PostEpisode')
                                            <div
                                                class="font-medium group-hover:underline mb-2">{{$listing->commentable->post->title}}
                                                <span
                                                    class="text-primary-500 ml-3">{{'S'.$listing->commentable->season_number.' / E'.$listing->commentable->episode_number}}</span>
                                            </div>
                                        @endif

                                        <div
                                            class="text-xs text-gray-400 dark:text-gray-500">{{Str::limit($listing->commentable->overview,80)}}</div>
                                    </div>
                                </a>
                            </td>
                            <td>
                                <div class="text-xs text-gray-400 dark:text-gray-400">
                                    @if($listing->status == 'publish')
                                        <span
                                            class="rounded-md px-2 py-1 text-[10px] font-medium text-white bg-green-600">{{__('Published')}}</span>
                                    @elseif($listing->status == 'draft')
                                        <span
                                            class="rounded-md px-2 py-1 text-[10px] font-medium text-white bg-orange-600">{{__('Pending')}}</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="flex items-center justify-end text-end space-x-5">
                                    <x-form.button-edit
                                        route="{{route('admin.'.$config['nav'].'.edit', $listing->id) }}"/>
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
