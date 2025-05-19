@props(['disabled' => false])

<x-form.button :disabled="$disabled" {{ $attributes->merge(['type' => 'button', 'class' => 'border bg-white text-gray-700 shadow-sm align-middle hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-primary-600 transition-all text-sm dark:bg-gray-800 dark:hover:bg-gray-700 dark:hover:border-gray-700 dark:border-gray-800 dark:text-gray-300 dark:hover:text-white dark:focus:ring-offset-gray-800']) }}>
    {{ $slot }}
</x-form.button>
