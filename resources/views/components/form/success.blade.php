@props(['disabled' => false])

<x-form.button :disabled="$disabled" {{ $attributes->merge(['type' => 'submit', 'class' => 'border border-transparent text-white bg-green-500 hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 dark:hover:bg-green-500 dark:focus:ring-offset-gray-800']) }}>
    {{ $slot }}
</x-form.button>
