@extends('layouts.app')
@section('content')

    <div x-data="stepper()" x-cloak>
        <div class="max-w-3xl mx-auto px-4 py-10">
            <form method="post" action="{{route('browse')}}">
                @csrf


                <div x-show.transition="step != 'complete'">
                    <!-- Top Navigation -->
                    <div class="border-b-2 dark:border-gray-800 py-4">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                            <div
                                class="flex-1 text-lg xl:text-2xl font-medium text-gray-700 dark:text-white leading-tight">
                                <div x-show="step === 1">
                                    {{__('Type')}}
                                </div>

                                <div x-show="step === 2">
                                    {{__('Genre')}}
                                </div>

                                <div x-show="step === 3">
                                    {{__('Released')}}
                                </div>
                                <div x-show="step === 4">
                                    {{__('Country')}}
                                </div>
                            </div>

                            <div class="flex items-center md:w-64">
                                <div class="w-full bg-white dark:bg-gray-900 rounded-full mr-2">
                                    <div
                                        class="rounded-full bg-primary-500 text-xs leading-none h-1.5 text-center text-white"
                                        :style="'width: '+ parseInt(step / 4 * 100) +'%'"></div>
                                </div>
                                <div class="text-xs w-10 text-gray-600" x-text="parseInt(step / 4 * 100) +'%'"></div>
                            </div>
                        </div>
                    </div>
                    <!-- /Top Navigation -->

                    <!-- Step Content -->
                    <div class="py-10">
                        <div x-show.transition.in="step === 1">

                            <div class="gap-x-4 grid grid-cols-3 flex-wrap">
                                <div>
                                    <input type="radio" id="type" name="type"
                                           value="all" class="hidden peer" checked>
                                    <label for="type"
                                           class="inline-flex items-center justify-center w-full py-4 px-5 text-sm text-gray-500 bg-white rounded-full cursor-pointer dark:hover:text-gray-200 peer-checked:!bg-primary-500 peer-checked:!text-white hover:text-gray-600 dark:peer-checked:text-gray-300 peer-checked:text-gray-600 hover:bg-gray-50 dark:text-gray-300 dark:bg-gray-800 dark:hover:bg-gray-700">
                                        {{__('All')}}
                                    </label>
                                </div>
                                @foreach(config('attr.types') as $key => $title)
                                    <div>
                                        <input type="radio" id="type{{$key}}" name="type"
                                               value="{{$key}}" class="hidden peer">
                                        <label for="type{{$key}}"
                                               class="inline-flex items-center justify-center w-full py-4 px-5 text-sm text-gray-500 bg-white rounded-full cursor-pointer dark:hover:text-gray-200 peer-checked:!bg-primary-500 peer-checked:!text-white hover:text-gray-600 dark:peer-checked:text-gray-300 peer-checked:text-gray-600 hover:bg-gray-50 dark:text-gray-300 dark:bg-gray-800 dark:hover:bg-gray-700">
                                            {{$title}}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div x-show.transition.in="step === 2">
                            <div class="gap-2 flex flex-wrap">
                                @foreach(\App\Models\Genre::get() as $genre)
                                    <div>
                                        <input type="checkbox" id="category{{$genre->id}}" name="genre[]"
                                               value="{{$genre->id}}" class="hidden peer">
                                        <label for="category{{$genre->id}}"
                                               class="inline-flex items-center justify-between w-full py-3 px-6 text-gray-500 bg-white rounded-full text-xs cursor-pointer dark:hover:text-gray-200 peer-checked:!bg-primary-500 peer-checked:!text-white hover:text-gray-600 dark:peer-checked:text-gray-300 peer-checked:text-gray-600 hover:bg-gray-50 dark:text-gray-300 dark:bg-gray-800 dark:hover:bg-gray-700">
                                            {{$genre->title}}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div x-show.transition.in="step === 3">
                            <div class="gap-2 flex flex-wrap">
                                <div>
                                    <input type="radio" id="releaseall" name="release"
                                           value="all" class="hidden peer" @if(empty($release))
                                        {{'checked'}}
                                        @endif>
                                    <label for="releaseall"
                                           class="inline-flex items-center justify-between w-full py-3 px-6 text-gray-500 bg-white rounded-full text-xs cursor-pointer dark:hover:text-gray-200 peer-checked:!bg-primary-500 peer-checked:!text-white hover:text-gray-600 dark:peer-checked:text-gray-300 peer-checked:text-gray-600 hover:bg-gray-50 dark:text-gray-300 dark:bg-gray-800 dark:hover:bg-gray-700">
                                        {{__('All')}}
                                    </label>
                                </div>
                                @php
                                    $currentYear = date('Y');
                                @endphp
                                @for($i = $currentYear; $i >= ($currentYear - 5); $i--)

                                    <div>
                                        <input type="radio" id="release{{$i}}" name="release" wire:model="release"
                                               value="{{$i}}" class="hidden peer">
                                        <label for="release{{$i}}"
                                               class="inline-flex items-center justify-between w-full py-3 px-6 text-gray-500 bg-white rounded-full text-xs cursor-pointer dark:hover:text-gray-200 peer-checked:!bg-primary-500 peer-checked:!text-white hover:text-gray-600 dark:peer-checked:text-gray-300 peer-checked:text-gray-600 hover:bg-gray-50 dark:text-gray-300 dark:bg-gray-800 dark:hover:bg-gray-700">
                                            {{$i}}
                                        </label>
                                    </div>
                                @endfor
                                <div>
                                    <input type="radio" id="releaseolder" name="release" wire:model="release"
                                           value="{{$currentYear-6}}" class="hidden peer">
                                    <label for="releaseolder"
                                           class="inline-flex items-center justify-between w-full py-3 px-6 text-gray-500 bg-white rounded-full text-xs cursor-pointer dark:hover:text-gray-200 peer-checked:!bg-primary-500 peer-checked:!text-white hover:text-gray-600 dark:peer-checked:text-gray-300 peer-checked:text-gray-600 hover:bg-gray-50 dark:text-gray-300 dark:bg-gray-800 dark:hover:bg-gray-700">
                                        {{__('Older')}}
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div x-show.transition.in="step === 4">

                            <div class="gap-2 flex flex-wrap">
                                @foreach(\App\Models\Country::where('filter','active')->get() as $country)
                                    <div>
                                        <input type="checkbox" id="country{{$country->id}}" name="country[]"
                                               wire:model="country"
                                               value="{{$country->id}}" class="hidden peer">
                                        <label for="country{{$country->id}}"
                                               class="inline-flex items-center justify-between w-full py-3 px-6 text-gray-500 bg-white rounded-full text-xs cursor-pointer dark:hover:text-gray-200 peer-checked:!bg-primary-500 peer-checked:!text-white hover:text-gray-600 dark:peer-checked:text-gray-300 peer-checked:text-gray-600 hover:bg-gray-50 dark:text-gray-300 dark:bg-gray-800 dark:hover:bg-gray-700">
                                            {{$country->name}}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <!-- / Step Content -->
                    <div class="flex justify-between" x-show="step != 'complete'">
                        <div class="w-1/2">
                            <x-form.secondary type="button" class="!rounded-full" x-show="step > 1"
                                              @click="step--">{{__('Prev')}}</x-form.secondary>
                        </div>
                        <div class="w-1/2 text-right">
                            <x-form.primary type="button" class="!rounded-full" x-show="step < 4"
                                            @click="step++">{{__('Next')}}</x-form.primary>
                            <x-form.success type="submit" class="!rounded-full" @click="step = 'complete'"
                                            x-show="step === 4">{{__('Complete')}}</x-form.success>
                        </div>
                    </div>
                </div>
            </form>
        </div>

    </div>

    <script>
        function stepper() {
            return {
                step: 1,
            }
        }
    </script>
@endsection