@extends('layouts.admin')
@section('content')
    <div class="container">
        <div class="mb-6 grid grid-cols-1 lg:grid-cols-4 gap-5">

            <!-- Card -->
            <div class="flex flex-col bg-white border shadow-sm rounded-xl dark:bg-gray-900 dark:border-gray-800 p-1">
                <div class="px-6 py-5 flex gap-x-6">
                    <div
                        class="flex-shrink-0 flex justify-center items-center text-gray-500 rounded-full dark:text-gray-500">
                        <x-ui.icon name="movie" class="w-9 h-9" stroke="currentColor"/>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">
                            {{__('Movies')}}
                        </p>
                        <div class="flex items-center gap-x-2">
                            <h3 class="mt-1 text-xl lg:text-2xl font-medium text-gray-800 dark:text-gray-200">
                                {{$data['movie']}}
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Card -->
            <!-- Card -->
            <div class="flex flex-col bg-white border shadow-sm rounded-xl dark:bg-gray-900 dark:border-gray-800 p-1">
                <div class="px-6 py-5 flex gap-x-6">
                    <div
                        class="flex-shrink-0 flex justify-center items-center text-gray-500 rounded-full dark:text-gray-500">
                        <x-ui.icon name="tv-2" class="w-9 h-9" stroke="currentColor"/>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">
                            {{__('TV Shows')}}
                        </p>
                        <div class="flex items-center gap-x-2">
                            <h3 class="mt-1 text-xl lg:text-2xl font-medium text-gray-800 dark:text-gray-200">
                                {{$data['tv']}}
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Card -->
            <!-- Card -->
            <div class="flex flex-col bg-white border shadow-sm rounded-xl dark:bg-gray-900 dark:border-gray-800 p-1">
                <div class="px-6 py-5 flex gap-x-6">
                    <div
                        class="flex-shrink-0 flex justify-center items-center text-gray-500 rounded-full dark:text-gray-500">
                        <x-ui.icon name="calendar" class="w-9 h-9" stroke="currentColor"/>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">
                            {{__('Episodes')}}
                        </p>
                        <div class="flex items-center gap-x-2">
                            <h3 class="mt-1 text-xl lg:text-2xl font-medium text-gray-800 dark:text-gray-200">
                                {{$data['episode']}}
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Card -->
            <!-- Card -->
            <div class="flex flex-col bg-white border shadow-sm rounded-xl dark:bg-gray-900 dark:border-gray-800 p-1">
                <div class="px-6 py-5 flex gap-x-6">
                    <div
                        class="flex-shrink-0 flex justify-center items-center text-gray-500 rounded-full dark:text-gray-500">
                        <x-ui.icon name="people" class="w-9 h-9" stroke="currentColor"/>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">
                            {{__('Peoples')}}
                        </p>
                        <div class="flex items-center gap-x-2">
                            <h3 class="mt-1 text-xl lg:text-2xl font-medium text-gray-800 dark:text-gray-200">
                                {{$data['people']}}
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Card -->
            <!-- Card -->
            <div class="flex flex-col bg-white border shadow-sm rounded-xl dark:bg-gray-900 dark:border-gray-800 p-1">
                <div class="px-6 py-5 flex gap-x-6">
                    <div
                        class="flex-shrink-0 flex justify-center items-center text-gray-500 rounded-full dark:text-gray-500">
                        <x-ui.icon name="document" class="w-9 h-9" stroke="currentColor"/>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">
                            {{__('Genres')}}
                        </p>
                        <div class="flex items-center gap-x-2">
                            <h3 class="mt-1 text-xl lg:text-2xl font-medium text-gray-800 dark:text-gray-200">
                                {{$data['genre']}}
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Card -->
            <!-- Card -->
            <div class="flex flex-col bg-white border shadow-sm rounded-xl dark:bg-gray-900 dark:border-gray-800 p-1">
                <div class="px-6 py-5 flex gap-x-6">
                    <div
                        class="flex-shrink-0 flex justify-center items-center text-gray-500 rounded-full dark:text-gray-500">
                        <x-ui.icon name="chat" class="w-9 h-9" stroke="currentColor"/>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">
                            {{__('Comments')}}
                        </p>
                        <div class="flex items-center gap-x-2">
                            <h3 class="mt-1 text-xl lg:text-2xl font-medium text-gray-800 dark:text-gray-200">
                                {{$data['comment']}}
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Card -->
            <!-- Card -->
            <div class="flex flex-col bg-white border shadow-sm rounded-xl dark:bg-gray-900 dark:border-gray-800 p-1">
                <div class="px-6 py-5 flex gap-x-6">
                    <div
                        class="flex-shrink-0 flex justify-center items-center text-gray-500 rounded-full dark:text-gray-500">
                        <x-ui.icon name="flag" class="w-9 h-9" stroke="currentColor"/>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">
                            {{__('Reports')}}
                        </p>
                        <div class="flex items-center gap-x-2">
                            <h3 class="mt-1 text-xl lg:text-2xl font-medium text-gray-800 dark:text-gray-200">
                                {{$data['report']}}
                            </h3>
                        </div>
                    </div>
                </div>

            </div>
            <!-- End Card -->
            <!-- Card -->
            <div class="flex flex-col bg-white border shadow-sm rounded-xl dark:bg-gray-900 dark:border-gray-800 p-1">
                <div class="px-6 py-5 flex gap-x-6">
                    <div
                        class="flex-shrink-0 flex justify-center items-center text-gray-500 rounded-full dark:text-gray-500">
                        <x-ui.icon name="user-report" class="w-9 h-9" stroke="currentColor"/>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">
                            {{__('Users')}}
                        </p>
                        <div class="flex items-center gap-x-2">
                            <h3 class="mt-1 text-xl lg:text-2xl font-medium text-gray-800 dark:text-gray-200">
                                {{$data['user']}}
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Card -->
            @if($data['visitors'])
            <div class="lg:col-span-3">
                <div
                    class="border border-gray-200 rounded-xl shadow-sm bg-white  dark:bg-gray-900 dark:border-gray-800 p-6 lg:p-8">
                    <div id="home-chart" class=""></div>

                    <div class="grid grid-cols-1 md:grid-cols-4 lg:gap-x-6 py-1">

                        <div class="flex items-center gap-x-6">
                            <div
                                class="flex-shrink-0 flex justify-center items-center text-gray-500 rounded-full dark:text-gray-500">
                                <x-ui.icon name="chart-doth" class="w-9 h-9" stroke="currentColor"/>
                            </div>
                            <div>
                                <div
                                    class="font-medium text-xs text-gray-500 dark:text-gray-400">{{__('Page Views')}}</div>
                                <div class="flex items-center gap-x-2">
                                    <h3 class="mt-1 text-xl lg:text-2xl font-medium text-gray-800 dark:text-gray-200">
                                        {{$data['pageViews']}}
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center gap-x-6">
                            <div
                                class="flex-shrink-0 flex justify-center items-center text-gray-500 rounded-full dark:text-gray-500">
                                <x-ui.icon name="user-report" class="w-9 h-9" stroke="currentColor"/>
                            </div>
                            <div>
                                <div
                                    class="font-medium text-xs text-gray-500 dark:text-gray-400">{{__('Sessions')}}</div>
                                <div class="flex items-center gap-x-2">
                                    <h3 class="mt-1 text-xl lg:text-2xl font-medium text-gray-800 dark:text-gray-200">
                                        {{$data['sessions']}}
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center gap-x-6">
                            <div
                                class="flex-shrink-0 flex justify-center items-center text-gray-500 rounded-full dark:text-gray-500">
                                <x-ui.icon name="refresh-2" class="w-9 h-9" stroke="currentColor"/>
                            </div>
                            <div>
                                <div
                                    class="font-medium text-xs text-gray-500 dark:text-gray-400">{{__('Bounce Rate')}}</div>
                                <div class="flex items-center gap-x-2">
                                    <h3 class="mt-1 text-xl lg:text-2xl font-medium text-gray-800 dark:text-gray-200">
                                        {{floor($data['bounceRate']*100).' %'}}
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center gap-x-6">
                            <div
                                class="flex-shrink-0 flex justify-center items-center text-gray-500 rounded-full dark:text-gray-500">
                                <x-ui.icon name="chart-up" class="w-9 h-9" stroke="currentColor"/>
                            </div>
                            <div>
                                <div
                                    class="font-medium text-xs text-gray-500 dark:text-gray-400">{{__('New Sessions')}}</div>
                                <div class="flex items-center gap-x-2">
                                    <h3 class="mt-1 text-xl lg:text-2xl font-medium text-gray-800 dark:text-gray-200">
                                        {{$data['newSessions']}}
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Card -->

            @if(isset($data['popular']))
                <div class="bg-white border shadow-sm rounded-xl dark:bg-gray-900 dark:border-gray-800 p-4 lg:p-6">
                    <header class="pb-3 border-b border-gray-100 dark:border-gray-800">
                        <h3 class="font-medium text-gray-700 dark:text-gray-200">{{__('Most Popular')}}</h3>
                    </header>
                    <div class="grow pt-3">
                        <div class="flex flex-col h-full">
                            <!-- Card content -->
                            <div class="grow">
                                <ul class="flex justify-between text-xs text-gray-400 space-x-2">
                                    <li>{{__('Page Url')}}</li>
                                    <li>{{__('Pageview')}}</li>
                                </ul>
                                @if(count($data['popular'])>0)
                                    <ul class="space-y-2 text-sm text-gray-700 dark:text-gray-300 mt-3 mb-4 -mx-2">
                                        @php
                                            $max = $data['popular'][0]['screenPageViews'];
                                        @endphp
                                        @foreach($data['popular'] as $page)
                                            <!-- Item -->
                                            <li class="relative px-3 py-1.5">
                                                <div
                                                    class="absolute inset-0 bg-primary-500/10 dark:bg-primary-500/20 rounded-lg"
                                                    aria-hidden="true"
                                                    style="width: {{($page['screenPageViews'] / $max) * 100;}}%;"></div>
                                                <div class="relative flex items-center justify-between space-x-10">
                                                    <a href="{{'https://'.$page['fullPageUrl']}}" target="_blank"
                                                       class="truncate hover:text-primary-500 dark:hover:text-white">{{$page['fullPageUrl']}}</a>
                                                    <div
                                                        class="font-medium text-xs">{{$page['screenPageViews']}}</div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @endif
            <div
                class="hidden lg:flex flex-col bg-white border shadow-sm rounded-xl  dark:bg-gray-900 dark:border-gray-800 dark:text-gray-500 p-6 col-span-full">

                <div class="flex items-center lg:gap-x-3 py-1">

                    <x-ui.icon name="server" class="w-10 h-10 opacity-50 lg:ml-2 mr-6" stroke="currentColor"/>
                    <div class="mr-10">
                        <div class="flex items-center">
                            <div
                                class="text-base font-semibold text-gray-800 dark:text-white mr-3">{{phpversion()}}</div>
                        </div>
                        <div class="text-sm text-gray-400 mt-1">php version</div>
                    </div>
                    <div class="hidden md:block w-px h-8 bg-gray-200 dark:bg-gray-800 mr-10" aria-hidden="true"></div>
                    <div class="mr-10">
                        <div class="flex items-center">
                            <div
                                class="text-base font-semibold text-gray-800 dark:text-white mr-3">{{ini_get('allow_url_fopen') ? 'Active' : 'Disable'}}</div>
                        </div>
                        <div class="text-sm text-gray-400 mt-1">allow_url_fopen</div>
                    </div>
                    <div class="hidden md:block w-px h-8 bg-gray-200 dark:bg-gray-800 mr-10" aria-hidden="true"></div>
                    <div class="mr-10">
                        <div class="flex items-center">
                            <div
                                class="text-base font-semibold text-gray-800 dark:text-white mr-3">{{extension_loaded('gd') ? 'Active' : 'Disable'}}</div>
                        </div>
                        <div class="text-sm text-gray-400 mt-1">gd Image</div>
                    </div>
                    <div class="hidden md:block w-px h-8 bg-gray-200 dark:bg-gray-800 mr-10" aria-hidden="true"></div>
                    <div class="mr-10">
                        <div class="flex items-center">
                            <div
                                class="text-base font-semibold text-gray-800 dark:text-white mr-3">{{extension_loaded('curl') ? 'Active' : 'Disable'}}</div>
                        </div>
                        <div class="text-sm text-gray-400 mt-1">Curl</div>
                    </div>
                    <div class="hidden md:block w-px h-8 bg-gray-200 dark:bg-gray-800 mr-10" aria-hidden="true"></div>
                    <div class="mr-10">
                        <div class="flex items-center">
                            <div
                                class="text-base font-semibold text-gray-800 dark:text-white mr-3">{{extension_loaded('mbstring') ? 'Active' : 'Disable'}}</div>
                        </div>
                        <div class="text-sm text-gray-400 mt-1">mbstring</div>
                    </div>
                    <div class="hidden md:block w-px h-8 bg-gray-200 dark:bg-gray-800 mr-10" aria-hidden="true"></div>
                    <div class="mr-10">
                        <div class="flex items-center">
                            <div
                                class="text-base font-semibold text-gray-800 dark:text-white mr-3">{{extension_loaded('openssl') ? 'Active' : 'Disable'}}</div>
                        </div>
                        <div class="text-sm text-gray-400 mt-1">openssl</div>
                    </div>
                    <div class="hidden md:block w-px h-8 bg-gray-200 dark:bg-gray-800 mr-10" aria-hidden="true"></div>
                    <div class="mr-10">
                        <div class="flex items-center">
                            <div
                                class="text-base font-semibold text-gray-800 dark:text-white mr-3">{{extension_loaded('json') ? 'Active' : 'Disable'}}</div>
                        </div>
                        <div class="text-sm text-gray-400 mt-1">json</div>
                    </div>
                </div>
            </div>
            <!-- End Card -->
        </div>
    </div>

    @push('javascript')

        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

        <script>
            // Laravel tarafından alınan verileri JavaScript'e aktar
            var newUsersData = @json($data['visitors']);
            var labels = @json($data['date']);
        </script>
        <script>

            var height = '400';

            var options = {
                series: [{
                    name: '{{__('Visitors')}}',
                    data: newUsersData
                }],
                chart: {
                    fontFamily: 'inherit',
                    type: 'area',
                    height: height,
                    toolbar: {
                        show: false
                    }
                },
                legend: {
                    show: false
                },
                dataLabels: {
                    enabled: false
                },
                colors: ['{{config('settings.color') ? config('settings.color') : '#8871FD'}}'],
                fill: {
                    colors: ['{{config('settings.color') ? config('settings.color') : '#8871FD'}}'],
                    type: 'gradient',
                    gradient: {
                        type: 'vertical',
                        shadeIntensity: 0.15,
                        opacityFrom: 0.3,
                        opacityTo: 0.1,
                        stops: [0, 100]
                    }
                },
                stroke: {
                    curve: 'smooth',
                    show: true,
                    width: 3,
                    colors: ['{{config('settings.color') ? config('settings.color') : '#8871FD'}}']
                },
                xaxis: {
                    categories: labels,
                    axisBorder: {
                        show: false,
                    },
                    axisTicks: {
                        show: false
                    },
                    offsetX: 0,
                    tickAmount: 3,
                    labels: {
                        rotate: 0,
                        rotateAlways: false,
                        show: true,
                        style: {
                            colors: '#a1a1aa',
                            fontSize: '12px'
                        }
                    },
                    crosshairs: {
                        position: 'front',
                        stroke: {
                            color: 'transparent',
                            width: 1,
                            dashArray: 3
                        }
                    },
                    tooltip: {
                        enabled: false,
                        formatter: undefined,
                        offsetY: 0,
                        style: {
                            fontSize: '12px'
                        }
                    }
                },
                yaxis: {
                    tickAmount: 5,
                    labels: {
                        show: false
                    }
                },
                states: {
                    normal: {
                        filter: {
                            type: 'none',
                            value: 0
                        }
                    },
                    hover: {
                        filter: {
                            type: 'none',
                            value: 0
                        }
                    },
                    active: {
                        allowMultipleDataPointsSelection: false,
                        filter: {
                            type: 'none',
                            value: 0
                        }
                    }
                },
                tooltip: {
                    style: {
                        fontSize: '12px'
                    },
                    y: {
                        formatter: function (val) {
                            return val;
                        }
                    }
                },
                grid: {
                    borderColor: '#d4d4d8',
                    strokeDashArray: 6,
                    yaxis: {
                        lines: {
                            show: false
                        }
                    },
                    xaxis: {
                        lines: {
                            show: true
                        }
                    }
                },
                markers: {
                    strokeColor: ['{{config('settings.color') ? config('settings.color') : '#8871FD'}}'],
                    strokeWidth: 3
                }
            };

            var chart = new ApexCharts(document.querySelector("#home-chart"), options);
            chart.render();

        </script>
    @endpush
@endsection
