@props(['disabled' => false, 'size','href'=>false])

@php
    $size = [
        'xs' => 'px-3 py-2 text-xs',
        'sm' => 'px-4 py-2.5 text-sm leading-4',
        'md' => 'px-6 py-3.5 text-sm',
        'lg' => 'px-6 py-4 !text-base',
        'icon' => 'p-0 flex items-center justify-center w-12 h-12'
    ][$size ?? 'md']
@endphp
@if($href)
    <a {!! $attributes->merge(['href'=> $href,'class' => "inline-flex whitespace-nowrap gap-x-3 items-center justify-center $size rounded-base font-[450] disabled:opacity-50 disabled:pointer-events-none transition"]) !!}>
        {{ $slot }}
    </a>
@else
    <button {{ $disabled ? 'disabled' : '' }} {{ $attributes->merge(['class' => "inline-flex whitespace-nowrap gap-x-3 items-center justify-center $size rounded-base font-[450] disabled:opacity-50 disabled:pointer-events-none transition"]) }}>
        {{ $slot }}
    </button>
@endif
