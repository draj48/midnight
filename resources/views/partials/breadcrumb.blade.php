@if(count($breadcrumbs))
    <ol class="flex items-center whitespace-nowrap min-w-0 text-xs" aria-label="Breadcrumb">
        @foreach ($breadcrumbs as $breadcrumb)
            @if (!$loop->last)
                <li class="font-medium text-gray-500 truncate dark:text-gray-400" aria-current="page">
                    @if(isset($breadcrumb['url']))

                    <a class="flex items-center hover:text-primary-500" href="{{ $breadcrumb['url'] }}">
                        {{ $breadcrumb['title'] }}
                        <svg class="flex-shrink-0 h-5 w-5 text-gray-400 dark:text-gray-600 mx-1" width="16" height="16"
                             viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path d="M6 13L10 3" stroke="currentColor" stroke-linecap="round"/>
                        </svg>
                    </a>
                    @else
                        <div class="flex items-center">
                            <span>{{ $breadcrumb['title'] }}</span>
                            <svg class="flex-shrink-0 h-5 w-5 text-gray-400 dark:text-gray-600 mx-1" width="16" height="16"
                                 viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path d="M6 13L10 3" stroke="currentColor" stroke-linecap="round"/>
                            </svg>
                        </div>
                    @endif
                </li>
            @else
                <li class="text-gray-600 dark:text-gray-400">
                    {{ $breadcrumb['title'] }}
                </li>
            @endif
        @endforeach
    </ol>
@endif
