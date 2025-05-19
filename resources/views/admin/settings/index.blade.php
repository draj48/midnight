@extends('layouts.admin')
@section('content')
    <div class="max-w-7xl mx-auto w-full px-4" x-data="{ nav: 'general'}">
        <form method="post" enctype="multipart/form-data">
            @csrf
            <div
                class="border-b pb-3 border-gray-100 dark:border-gray-800">
                <ul class="flex gap-x-4 whitespace-nowrap overflow-x-auto sm:overflow-x-visible sm:p-2 lg:p-0">
                    @if(count($tab) > 0 )
                        @foreach($tab as $key)
                            <li>
                                <a href="#"
                                   class="w-full py-3 px-6 inline-flex justify-center items-center gap-4 text-sm font-medium text-center text-gray-500 rounded-lg hover:bg-gray-50 relative after:absolute after:-bottom-3 after:rounded-full after:left-0 after:right-0 after:h-1 dark:text-gray-400 dark:hover:text-gray-300 dark:hover:bg-gray-800"
                                   :class="{ 'after:bg-primary-500 text-primary-500 hover:bg-transparent dark:text-white dark:hover:bg-transparent': nav === '{{$key['nav']}}'}"
                                   @click="nav = '{{$key['nav']}}'">
                                    {{ __($key['title']) }}
                                </a>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>
            <div class="py-6">
                @if(count($tab) > 0 )
                    @foreach($tab as $key)
                        <div class="" :class="{ 'active': nav === '{{$key['nav']}}' }"
                             x-show.transition.in.opacity.duration.600="nav === '{{$key['nav']}}'">
                            @include('admin.settings.'.$key['nav'])
                        </div>
                    @endforeach
                @endif
                <x-form.primary class="max-w-xs w-full ">{{__('Save change')}}</x-form.primary>
            </div>
        </form>
    </div>
    <x-form.tinymce/>
@endsection
