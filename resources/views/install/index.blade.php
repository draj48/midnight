@extends('layouts.install')
@section('content')
    <div class="max-w-2xl mx-auto w-full py-10">
        <div class="mb-6">
            <a class="inline-block" href="{{route('index')}}">
                <x-ui.logo height="38" class="text-gray-700 dark:text-white"/>
            </a>
        </div>
        <div class="mb-6">
            <h3 class="text-2xl mb-1 font-medium text-white">Installation</h3>
            <p class="text-sm text-gray-400">Please make sure the PHP extensions listed below are installed.</p>
        </div>
        <div class="grid grid-cols-3 gap-4 mb-8">
            @foreach ($requirement->extensions() as $label => $satisfied)
                <div
                    class="{{ $satisfied ? 'bg-green-200 text-green-700' : 'bg-red-200 text-red-700' }} rounded-lg p-5">
                    <div class="text-center">
                        <h5 class="mb-0 text-sm font-medium">{{ $label }}</h5>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mb-6">
            <h3 class="text-2xl mb-1 font-medium text-white">Permission</h3>
            <p class="text-sm text-gray-400">Please make sure you have set the correct permissions for the directories listed below.</p>
        </div>
        <div class="grid grid-cols-3 gap-4 mb-8">
            @foreach ($requirement->directories() as $label => $satisfied)
                <div
                    class="{{ $satisfied ? 'bg-green-200 text-green-700' : 'bg-red-200 text-red-700' }} rounded-lg p-5">
                    <div class="text-center">
                        <h5 class="mb-0 text-sm font-medium">{{ $label }}</h5>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="w-full">
            <a href="{{ $requirement->satisfied() ? route('install.config') : '#' }}" class="py-4 px-6 rounded-lg bg-primary-500 flex justify-center align-center font-medium text-white w-full" {{ $requirement->satisfied() ? '' : 'disabled' }}>
                Continue
            </a>
        </div>
    </div>
@endsection
