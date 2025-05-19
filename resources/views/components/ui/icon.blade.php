@props(['name','class'])
<svg
    xmlns="http://www.w3.org/2000/svg"
    stroke-linecap="round"
    stroke-width="1.75"
    stroke-linejoin="round"
    {{ $attributes->merge(['class' => "$class"]) }}>
    <use xlink:href="{{asset('static/sprite/sprite.svg')}}#{{ $name }}"></use>
</svg>
