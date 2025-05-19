@php
    $tab = [];
    $tab['overview'] = [
        'title' => 'Overview',
        'nav' => 'profile'
    ];
    $tab['liked'] = [
        'title' => 'Liked',
        'nav' => 'profile.liked'
    ];
    if(isset(Auth::user()->id) AND Auth::user()->id == $listing->id) {
        $tab['history'] = [
            'title' => 'Watch history',
            'nav' => 'profile.history'
        ];
    }
    if(isset(Auth::user()->id) AND Auth::user()->id == $listing->id) {
        $tab['watchlist'] = [
            'title' => 'Watchlist',
            'nav' => 'profile.watchlist'
        ];
    }

@endphp
<div class="custom-container mt-5">
    {!! cover($listing->coverurl,'bg-primary-500 rounded-xl aspect-[6/1]') !!}
</div>
<div class="custom-container py-5">
    <div class="flex space-x-8 lg:px-5">
        <div
            class="w-32 h-32 rounded-full aspect-square bg-gray-800 border-[6px] border-white dark:border-gray-950 -mt-16">
            {!! gravatar($listing->name,$listing->avatarurl,'h-full w-full rounded-full bg-primary-500 text-3xl font-semibold flex items-center justify-center text-white bg-cover') !!}
        </div>
        <div class="flex-1 rtl:pr-8">
            <h1 class="text-xl font-medium text-gray-700 dark:text-white">{{$listing->username}}</h1>
            <p class="text-sm font-medium text-gray-500 dark:text-gray-500">{{$listing->about}}</p>
        </div>
    </div>

    <div
        class="border-b pb-3 border-gray-100 dark:border-gray-900 mt-4" x-data="{ nav: '{{$config['nav']}}'}">
        <ul class="flex gap-x-4 whitespace-nowrap overflow-x-auto sm:overflow-x-visible sm:p-2 lg:p-0">
            @if(count($tab) > 0 )
                @foreach($tab as $key)
                    <li>
                        <a href="{{route($key['nav'],$listing->username)}}"
                           class="w-full py-2.5 px-5 inline-flex justify-center items-center gap-4 text-sm font-medium text-center text-gray-500 rounded-lg hover:bg-gray-50 relative after:absolute after:-bottom-3 after:rounded-full after:left-0 after:right-0 after:h-1 dark:text-gray-400 dark:hover:text-gray-300 dark:hover:bg-gray-800"
                           :class="{ 'after:bg-primary-500 text-primary-500 hover:bg-transparent dark:text-white dark:hover:!bg-transparent': nav === '{{$key['nav']}}'}">
                            {{ __($key['title']) }}
                        </a>
                    </li>
                @endforeach
            @endif
        </ul>
    </div>
</div>
