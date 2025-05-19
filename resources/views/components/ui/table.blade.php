<div
    class="bg-white overflow-x-auto border border-gray-200 rounded-lg shadow-sm overflow-hidden dark:bg-gray-800 dark:border-gray-700 lg:px-4 py-3 @if(isset($class)){{$class}}@endif">
    <!-- Table -->
    <table class="min-w-full divide-y divide-gray-100 dark:divide-gray-700">
        {{$slot}}
    </table>
</div>
