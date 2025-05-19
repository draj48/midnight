<!-- Footer -->
<div
    class="py-6 px-8 gap-3 flex justify-between items-center">
    <div class="max-w-sm space-y-3 hidden lg:block">

        <p class="text-xs text-gray-400 dark:text-gray-400">
            {{ __('Showing :from - :to of :total', ['from' => (int)$listings->firstItem(), 'to' => (int)$listings->lastItem(), 'total' => (int)$listings->total()]) }}
        </p>
    </div>
    {{ $listings->onEachSide(0)->links('admin.partials.pagination') }}

</div>
<!-- End Footer -->
