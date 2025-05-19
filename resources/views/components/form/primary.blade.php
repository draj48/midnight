@props(['disabled' => false])

<x-form.button :disabled="$disabled" {{ $attributes->merge(['type' => 'submit', 'class' => 'border border-transparent text-white bg-primary-500 hover:bg-primary-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 dark:hover:bg-primary-500/70 dark:focus:ring-offset-gray-800']) }}>
    {{ $slot }}
</x-form.button>
