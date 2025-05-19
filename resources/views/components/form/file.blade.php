@props(['disabled' => false, 'size'])

@php
    $size = [
        'xs' => 'px-3 py-2 text-xs',
        'sm' => 'px-4 py-2.5 text-sm leading-4',
        'md' => 'px-1 py-0.5 text-sm',
        'lg' => 'px-6 py-4 text-base'
    ][$size ?? 'md']
@endphp

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'block w-full border-gray-200 rounded-md text-sm cursor-pointer '.$size.' border focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-800 dark:border-gray-800 dark:text-gray-400 placeholder-gray-400/70 shadow-sm dark:focus:ring-primary-500 dark:focus:border-primary-500 file:bg-transparent file:border-0
    file:bg-gray-100 file:mr-4
    file:py-3 file:px-4 file:cursor-pointer
    dark:file:bg-gray-800 dark:file:text-gray-400']) !!}>
