@props(['value'])

<label {{ $attributes->merge(['class' => 'block text-sm font-medium text-gray-600 mb-3 dark:text-gray-300 dark:font-normal rtl:text-right']) }}>
    {{ $value ?? $slot }}
</label>
