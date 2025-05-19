<!-- Footer -->
<div
    class="px-6 py-4 grid gap-3 md:flex md:justify-between md:items-center border-t border-gray-100 dark:border-gray-800">
    <div class="max-w-sm space-y-3">

        <p class="text-xs text-gray-400 dark:text-gray-400">
            {{ __('Total result :total', ['total' => $result['total_results']]) }}
        </p>
    </div>
    <div class="inline-flex gap-x-2">

        @if ($request->page)
            <a href="{{route('admin.tmdb.fetch',['type'=>$request->type,'q' => $request->q,'sortable' => $request->sortable,'page' => $request->page-1,'filter' => 'true'])}}"
               class="py-2 px-3 inline-flex justify-center items-center gap-2 rounded-md border font-medium bg-white text-gray-700 shadow-sm align-middle hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-primary-600 transition-all text-sm dark:bg-gray-900 dark:hover:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:text-white dark:focus:ring-offset-gray-800">
                <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                     fill="currentColor" viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                          d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
                </svg>
                {{__('Prev')}}
            </a>
        @endif
        @if ($request->page != 50)
                <a href="{{route('admin.tmdb.fetch',['type'=>$request->type,'q' => $request->q,'sortable' => $request->sortable,'page' => !empty($request->page) ? $request->page+1 : 2,'filter' => 'true'])}}"
               class="py-2 px-3 inline-flex justify-center items-center gap-2 rounded-md border font-medium bg-white text-gray-700 shadow-sm align-middle hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-primary-600 transition-all text-sm dark:bg-gray-900 dark:hover:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:text-white dark:focus:ring-offset-gray-800">
                {{__('Next')}}
                <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                     fill="currentColor" viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                          d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/>
                </svg>
            </a>
        @endif
    </div>

</div>
<!-- End Footer -->
