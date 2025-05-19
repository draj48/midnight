@extends('layouts.admin')
@section('content')
    <div class="container-fluid">
        <div class="mb-6 grid grid-cols-1 lg:grid-cols-4 gap-6">

            <div
                class="flex flex-wrap border border-gray-200 rounded-xl shadow-sm bg-white dark:bg-gray-900 dark:border-gray-800 overflow-hidden px-8 py-3  text-gray-800 dark:text-white">
                <!-- Unique Visitors -->
                <div class="flex items-center py-3 gap-x-3">
                    <x-ui.icon name="chart-doth" class="w-10 h-10 opacity-50 mr-6" stroke="currentColor"/>
                    <div>
                        <div class="flex items-center">
                            <div class="text-2xl font-medium text-gray-800 dark:text-white mr-3">{{$count['movie']}}</div>
                        </div>
                        <div class="text-sm text-gray-400 mt-1">{{__('Movie')}}</div>
                    </div>
                </div>
            </div>
            <div
                class="flex flex-wrap border border-gray-200 rounded-xl shadow-sm bg-white dark:bg-gray-900 dark:border-gray-800 overflow-hidden px-8 py-3  text-gray-800 dark:text-white">
                <!-- Unique Visitors -->
                <div class="flex items-center py-3 gap-x-3">
                    <x-ui.icon name="chart-doth" class="w-10 h-10 opacity-50 mr-6" stroke="currentColor"/>
                    <div>
                        <div class="flex items-center">
                            <div class="text-2xl font-medium text-gray-800 dark:text-white mr-3">{{$count['tv']}}</div>
                        </div>
                        <div class="text-sm text-gray-400 mt-1">{{__('TV Show')}}</div>
                    </div>
                </div>
            </div>
            <div
                class="flex flex-wrap border border-gray-200 rounded-xl shadow-sm bg-white dark:bg-gray-900 dark:border-gray-800 overflow-hidden px-8 py-3  text-gray-800 dark:text-white">
                <!-- Unique Visitors -->
                <div class="flex items-center py-3 gap-x-3">
                    <x-ui.icon name="chart-doth" class="w-10 h-10 opacity-50 mr-6" stroke="currentColor"/>
                    <div>
                        <div class="flex items-center">
                            <div class="text-2xl font-medium text-gray-800 dark:text-white mr-3">{{$count['episode']}}</div>
                        </div>
                        <div class="text-sm text-gray-400 mt-1">{{__('Episode')}}</div>
                    </div>
                </div>
            </div>
            <div
                class="flex flex-wrap border border-gray-200 rounded-xl shadow-sm bg-white dark:bg-gray-900 dark:border-gray-800 overflow-hidden px-8 py-3  text-gray-800 dark:text-white">
                <!-- Unique Visitors -->
                <div class="flex items-center py-3 gap-x-3">
                    <x-ui.icon name="chart-doth" class="w-10 h-10 opacity-50 mr-6" stroke="currentColor"/>
                    <div>
                        <div class="flex items-center">
                            <div class="text-2xl font-medium text-gray-800 dark:text-white mr-3">{{$count['people']}}</div>
                        </div>
                        <div class="text-sm text-gray-400 mt-1">{{__('People')}}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-12 gap-6">
            @if(isset($data['sessions']))

                <div
                    class="flex flex-wrap border border-gray-200 rounded-xl shadow-sm bg-white dark:bg-gray-900 dark:border-gray-800 overflow-hidden px-8 py-3  text-gray-800 dark:text-white col-span-full sm:col-span-6 xl:col-span-4">
                    <!-- Unique Visitors -->
                    <div class="flex items-center py-3 gap-x-3">
                        <x-ui.icon name="user-report" class="w-10 h-10 opacity-50 mr-6" stroke="currentColor"/>
                        <div>
                            <div class="flex items-center">
                                <div class="text-2xl font-medium text-gray-800 dark:text-white mr-3">{{$data['sessions']}}</div>
                            </div>
                            <div class="text-sm text-gray-400 mt-1">{{__('Total Sessions')}}</div>
                        </div>
                    </div>
                </div>
            @endif
            @if(isset($data['pageViews']))

                    <div
                        class="flex flex-wrap border border-gray-200 rounded-xl shadow-sm bg-white dark:bg-gray-900 dark:border-gray-800 overflow-hidden px-8 py-3  text-gray-800 dark:text-white col-span-full sm:col-span-6 xl:col-span-4">
                        <!-- Unique Visitors -->
                        <div class="flex items-center py-3 gap-x-3">
                            <x-ui.icon name="show" class="w-10 h-10 opacity-50 mr-6" stroke="currentColor"/>
                            <div>
                                <div class="flex items-center">
                                    <div class="text-2xl font-medium text-gray-800 dark:text-white mr-3">{{$data['pageViews']}}</div>
                                </div>
                                <div class="text-sm text-gray-400 mt-1">{{__('Page Views')}}</div>
                            </div>
                        </div>
                    </div>
            @endif
            @if(isset($data['bounceRate']))
                    <div
                        class="flex flex-wrap border border-gray-200 rounded-xl shadow-sm bg-white dark:bg-gray-900 dark:border-gray-800 overflow-hidden px-8 py-3  text-gray-800 dark:text-white col-span-full sm:col-span-6 xl:col-span-4">
                        <!-- Unique Visitors -->
                        <div class="flex items-center py-3 gap-x-3">
                            <x-ui.icon name="dashboard" class="w-10 h-10 opacity-50 mr-6" stroke="currentColor"/>
                            <div>
                                <div class="flex items-center">
                                    <div class="text-2xl font-medium text-gray-800 dark:text-white mr-3">{{floor($data['bounceRate']*100).' %'}}</div>
                                </div>
                                <div class="text-sm text-gray-400 mt-1">{{__('Bounce Rate')}}</div>
                            </div>
                        </div>
                    </div>
            @endif
            @if(isset($data['visitor']))
                <div class="col-span-full xl:col-span-8">
                    <div
                        class="bg-white dark:bg-gray-900 dark:border-gray-800 shadow-sm p-2 rounded-xl border border-gray-200">
                        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
                        <div class="grow px-5">
                            <!-- Change the height attribute to adjust the chart height -->
                            <div
                                x-data="{
                            values: [
                            @foreach($data['visitor'] as $visitor) {{$visitor['activeUsers'].','}} @endforeach
                            ],
                            labels: [@foreach($data['visitor'] as $visitor) {!! "'".date('d M',strtotime($visitor['date']))."'," !!} @endforeach],

        init() {
            let chart = new ApexCharts(this.$refs.chart, this.options)

            chart.render()

            this.$watch('values', () => {
                chart.updateOptions(this.options)
            })
        },
        get options() {
            return {
                chart: {
                background:'rgba(255,255,255,0)',
            height: '400px',
            type: 'area',
            toolbar: {
                show: false
            },
        },
        dataLabels: { enabled: !1 },
        colors: ['{{config('settings.color') ? config('settings.color') : '#8871FD'}}'],
        fill: { colors: '{{config('settings.color') ? config('settings.color') : '#8871FD'}}', type: 'gradient',
                    gradient: {
                        type: 'vertical',
                        shadeIntensity: 0.15,
                        opacityFrom: 0.3,
                        opacityTo: 0.1,
                        stops: [0, 100]
                    } },
        stroke: {
            width: 3,
            curve: 'straight',
            colors: ['{{config('settings.color') ? config('settings.color') : '#8871FD'}}'],
        },
        xaxis: {
            axisBorder: {
                show: false
            },
            axisTicks: {
                show: false
            },
            crosshairs: {
                show: true
            },
            labels: {
                offsetX: 0,
                offsetY: 5,
                style: {
                    fontSize: '12px',
                    fontWeight: 400,
                    colors: '#B5B5C3',
                },
            }
        },
        yaxis: {
            labels: {
                formatter: function(e) {
                    return e
                },
                style: {
                    fontSize: '12px',
                    fontWeight: 400,
                    colors: '#B5B5C3',
                },
                offsetX: -15
            },
        },
        grid: {
                    borderColor: 'rgba(0,0,0,0.1)',
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
                    },
            padding: {
                top: 0,
                right: 0,
                bottom: 0,
                left: 0
            },
        },
        legend: {
            position: 'top',
            horizontalAlign: 'right',
            offsetY: -50,
            fontSize: '16px',
            markers: {
                width: 10,
                height: 10,
                strokeWidth: 0,
                strokeColor: '#fff',
                fillColors: undefined,
                radius: 12,
                onClick: undefined,
                offsetX: 0,
                offsetY: 0
            },
            itemMargin: {
                horizontal: 0,
                vertical: 20
            }
        },
        tooltip: {
            theme: 'light',
            marker: {
                show: false,
            },
            x: {
                show: false,
            }
        },
                series: [{
                    name: 'Visitor',
                    data: this.values,
                }],
                labels: this.labels
            }
        }
    }"
                                class="w-full"
                            >
                                <div x-ref="chart" class="rounded-lg"></div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            {{--card--}}
            @if(isset($data['popular']))
                <div class="col-span-full xl:col-span-4">
                    <div
                        class="bg-white dark:bg-gray-900 dark:border-gray-800 shadow-sm p-2 h-full rounded-xl border border-gray-200">
                        <header class="px-5 py-3 border-b border-gray-100 dark:border-gray-800">
                            <h3 class="font-medium text-gray-700 dark:text-gray-200">{{__('Most Popular')}}</h3>
                        </header>
                        <div class="grow p-3">
                            <div class="flex flex-col h-full">
                                <!-- Card content -->
                                <div class="grow">
                                    <ul class="flex justify-between text-xs text-gray-400 px-2 space-x-2">
                                        <li>{{__('Page Url')}}</li>
                                        <li>{{__('Pageview')}}</li>
                                    </ul>
                                    @if(count($data['popular'])>0)
                                        <ul class="space-y-2 text-sm text-gray-700  dark:text-gray-200 mt-3 mb-4">
                                            @php
                                                $max = $data['popular'][0]['screenPageViews'];
                                            @endphp
                                            @foreach($data['popular'] as $page)
                                                <!-- Item -->
                                                <li class="relative px-3 py-1">
                                                    <div
                                                        class="absolute inset-0 bg-primary-500/10 dark:bg-primary-500/30 rounded-full"
                                                        aria-hidden="true"
                                                        style="width: {{($page['screenPageViews'] / $max) * 100;}}%;"></div>
                                                    <div class="relative flex items-center justify-between space-x-10">
                                                        <a href="{{'https://'.$page['fullPageUrl']}}" target="_blank"
                                                           class="truncate">{{$page['fullPageUrl']}}</a>
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
                </div>
            @endif
            {{--card--}}

            {{--card--}}
            <div class="flex flex-col col-span-full sm:col-span-6 xl:col-span-3">
                <div
                    class="bg-white dark:bg-gray-900 dark:border-gray-800 shadow-sm py-5 px-7 rounded-xl border border-gray-200 h-full text-gray-500 flex items-center gap-x-8">
                    @if(env('APP_DEBUG') == 'true')
                        <div class="flex justify-center items-center rounded-full p-2.5 bg-yellow-500 bg-opacity-25">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-500" viewBox="0 0 20 20"
                                 fill="currentColor">
                                <path fill-rule="evenodd"
                                      d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                      clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    @else
                        <div class="flex justify-center items-center rounded-full p-2.5 bg-green-500 bg-opacity-25">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500" viewBox="0 0 20 20"
                                 fill="currentColor">
                                <path fill-rule="evenodd"
                                      d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                      clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    @endif
                    <div class="flex-1">
                        <h5 class="text-lg font-semibold text-gray-700 dark:text-white">{{__('Debug Mode')}}</h5>
                        <p class="text-gray-400 dark:text-white/70 mt-1 text-xs">{{__('The debug mode was expected to be `false`, but actually was `true`')}}</p>
                    </div>
                </div>
            </div>
            {{--card--}}
            {{--card--}}
            <div class="flex flex-col col-span-full sm:col-span-6 xl:col-span-3">
                <div
                    class="bg-white dark:bg-gray-900 dark:border-gray-800 shadow-sm py-5 px-7 rounded-xl border border-gray-200 h-full text-gray-500 flex items-center gap-x-8">
                    @if(env('APP_ENV') == 'local')
                        <div class="flex justify-center items-center rounded-full p-2.5 bg-yellow-500 bg-opacity-25">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-500" viewBox="0 0 20 20"
                                 fill="currentColor">
                                <path fill-rule="evenodd"
                                      d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                      clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    @else
                        <div class="flex justify-center items-center rounded-full p-2.5 bg-green-500 bg-opacity-25">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500" viewBox="0 0 20 20"
                                 fill="currentColor">
                                <path fill-rule="evenodd"
                                      d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                      clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    @endif
                    <div class="flex-1">
                        <h5 class="text-lg font-semibold text-gray-700 dark:text-white">{{__('Environment')}}</h5>
                        <p class="text-gray-400 dark:text-white/70 mt-1 text-xs">{{__('The environment was expected to be `production`, but actually was `development`')}}</p>
                    </div>
                </div>
            </div>
            {{--card--}}
            {{--card--}}
            <div class="flex flex-col col-span-full sm:col-span-6 xl:col-span-3">
                <div
                    class="bg-white dark:bg-gray-900 dark:border-gray-800 shadow-sm py-5 px-7 rounded-xl border border-gray-200 h-full text-gray-500 flex items-center gap-x-8">
                    @if(env('APP_ENV') == 'local')
                        <div class="flex justify-center items-center rounded-full p-2.5 bg-yellow-500 bg-opacity-25">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-500" viewBox="0 0 20 20"
                                 fill="currentColor">
                                <path fill-rule="evenodd"
                                      d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                      clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    @else
                        <div class="flex justify-center items-center rounded-full p-2.5 bg-green-500 bg-opacity-25">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500" viewBox="0 0 20 20"
                                 fill="currentColor">
                                <path fill-rule="evenodd"
                                      d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                      clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    @endif
                    <div class="flex-1">
                        <h5 class="text-lg font-semibold text-gray-700 dark:text-white">{{__('Memory Limit')}}</h5>
                        <p class="text-gray-400 dark:text-white/70 mt-1 text-sm">{{ini_get('memory_limit')}}</p>
                    </div>
                </div>
            </div>
            {{--card--}}
            {{--card--}}
            <div class="flex flex-col col-span-full sm:col-span-6 xl:col-span-3">
                <div
                    class="bg-white dark:bg-gray-900 dark:border-gray-800 shadow-sm py-5 px-7 rounded-xl border border-gray-200 h-full text-gray-500 flex items-center gap-x-8">
                    @if(floor((disk_total_space(base_path('/'))-disk_free_space(base_path('/')))/disk_total_space(base_path('/')) * 100) <30)
                        <div class="flex justify-center items-center rounded-full p-2.5 bg-yellow-500 bg-opacity-25">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-500" viewBox="0 0 20 20"
                                 fill="currentColor">
                                <path fill-rule="evenodd"
                                      d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                      clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    @else
                        <div class="flex justify-center items-center rounded-full p-2.5 bg-green-500 bg-opacity-25">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500" viewBox="0 0 20 20"
                                 fill="currentColor">
                                <path fill-rule="evenodd"
                                      d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                      clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    @endif
                    <div class="flex-1">
                        <h5 class="text-lg font-semibold text-gray-700 dark:text-white">{{__('Used Disk Space')}}</h5>
                        <p class="text-gray-400 dark:text-white/70 mt-1 text-sm">{{round((disk_total_space(base_path('/'))-disk_free_space(base_path('/')))/disk_total_space(base_path('/')) * 100,1).'%'}}</p>
                    </div>
                </div>
            </div>
            {{--card--}}
                <div class="border border-gray-200 rounded-xl shadow-sm bg-white dark:bg-gray-900 dark:border-gray-800 text-gray-800 dark:text-white overflow-hidden px-5 py-4 col-span-full sm:col-span-12 xl:col-span-12">

                    <div class="flex flex-wrap px-4">
                        <!-- Unique Visitors -->
                        <div class="flex items-center py-3">

                            <x-ui.icon name="server" class="w-10 h-10 opacity-50 mr-10" stroke="currentColor"/>
                            <div class="mr-10">
                                <div class="flex items-center">
                                    <div class="text-base font-semibold text-gray-800 dark:text-white mr-3">{{phpversion()}}</div>
                                </div>
                                <div class="text-sm text-gray-400 mt-1">php version</div>
                            </div>
                            <div class="hidden md:block w-px h-8 bg-gray-200 dark:bg-gray-800 mr-10" aria-hidden="true"></div>
                            <div class="mr-10">
                                <div class="flex items-center">
                                    <div class="text-base font-semibold text-gray-800 dark:text-white mr-3">{{ini_get('allow_url_fopen') ? 'Active' : 'Disable'}}</div>
                                </div>
                                <div class="text-sm text-gray-400 mt-1">allow_url_fopen</div>
                            </div>
                            <div class="hidden md:block w-px h-8 bg-gray-200 dark:bg-gray-800 mr-10" aria-hidden="true"></div>
                            <div class="mr-10">
                                <div class="flex items-center">
                                    <div class="text-base font-semibold text-gray-800 dark:text-white mr-3">{{extension_loaded('gd') ? 'Active' : 'Disable'}}</div>
                                </div>
                                <div class="text-sm text-gray-400 mt-1">gd Image</div>
                            </div>
                            <div class="hidden md:block w-px h-8 bg-gray-200 dark:bg-gray-800 mr-10" aria-hidden="true"></div>
                            <div class="mr-10">
                                <div class="flex items-center">
                                    <div class="text-base font-semibold text-gray-800 dark:text-white mr-3">{{extension_loaded('curl') ? 'Active' : 'Disable'}}</div>
                                </div>
                                <div class="text-sm text-gray-400 mt-1">Curl</div>
                            </div>
                            <div class="hidden md:block w-px h-8 bg-gray-200 dark:bg-gray-800 mr-10" aria-hidden="true"></div>
                            <div class="mr-10">
                                <div class="flex items-center">
                                    <div class="text-base font-semibold text-gray-800 dark:text-white mr-3">{{extension_loaded('mbstring') ? 'Active' : 'Disable'}}</div>
                                </div>
                                <div class="text-sm text-gray-400 mt-1">mbstring</div>
                            </div>
                            <div class="hidden md:block w-px h-8 bg-gray-200 dark:bg-gray-800 mr-10" aria-hidden="true"></div>
                            <div class="mr-10">
                                <div class="flex items-center">
                                    <div class="text-base font-semibold text-gray-800 dark:text-white mr-3">{{extension_loaded('openssl') ? 'Active' : 'Disable'}}</div>
                                </div>
                                <div class="text-sm text-gray-400 mt-1">openssl</div>
                            </div>
                            <div class="hidden md:block w-px h-8 bg-gray-200 dark:bg-gray-800 mr-10" aria-hidden="true"></div>
                            <div class="mr-10">
                                <div class="flex items-center">
                                    <div class="text-base font-semibold text-gray-800 dark:text-white mr-3">{{extension_loaded('json') ? 'Active' : 'Disable'}}</div>
                                </div>
                                <div class="text-sm text-gray-400 mt-1">json</div>
                            </div>
                        </div>
                    </div>
                </div>
            {{--card--}}
            <div class="flex flex-col col-span-full sm:col-span-6 xl:col-span-6">
                <div
                    class="bg-white dark:bg-gray-900 dark:border-gray-800 shadow-sm py-5 px-7 rounded-xl border border-gray-200 h-full text-gray-500">
                    <header class="px-0 py-3 border-b border-gray-100 dark:border-gray-800">
                        <h3 class="font-medium text-gray-700 dark:text-gray-200">{{__('Pending reports')}}</h3>
                    </header>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-100 dark:divide-gray-800/50">

                            <tbody class="divide-y divide-gray-100 dark:divide-gray-800/50">
                            @foreach($reports as $report)
                                <tr>
                                    <td class="h-px w-px whitespace-nowrap">
                                        <div class="py-3">

                                            <a class="text-sm text-gray-600 dark:text-gray-200 flex items-center space-x-6 group"
                                               href="{{route('admin.report.edit',$report->id)}}">
                                                <div
                                                    class="aspect-poster bg-gray-100 rounded-md w-12 overflow-hidden relative">
                                                    <img src="{{$report->postable->imageurl}}"
                                                         class="absolute inset-0 object-cover">
                                                </div>
                                                <div class="">
                                                    <div
                                                        class="font-medium group-hover:underline mb-1">{{config('attr.reports')[$report->type]}}</div>
                                                    <div
                                                        class="text-xs text-gray-400 dark:text-gray-500">{{$report->postable->title}}</div>
                                                </div>
                                            </a>
                                        </div>
                                    </td>
                                    <td class="h-px w-px whitespace-nowrap">
                                        <div class="px-6 py-3 flex justify-end">
                                            <div
                                                class="text-xs text-gray-400 dark:text-gray-500">
                                                {{$report->created_at->translatedFormat('d M, Y')}}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            {{--card--}}
            <div class="flex flex-col col-span-full sm:col-span-6 xl:col-span-6">
                <div
                    class="bg-white dark:bg-gray-900 dark:border-gray-800 shadow-sm py-5 px-7 rounded-xl border border-gray-200 h-full text-gray-500">
                    <header class="px-0 py-3 border-b border-gray-100 dark:border-gray-800">
                        <h3 class="font-medium text-gray-700 dark:text-gray-200">{{__('Pending comments')}}</h3>
                    </header>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-100 dark:divide-gray-800/50">

                            <tbody class="divide-y divide-gray-100 dark:divide-gray-800/50">
                            @foreach($comments as $comment)
                                <tr>
                                    <td class="h-px w-px whitespace-nowrap">
                                        <div class="py-3">

                                            <a class="text-sm text-gray-600 dark:text-gray-200 flex items-center space-x-6 group"
                                               href="{{route('admin.comment.edit',$comment->id)}}">
                                                <div
                                                    class="aspect-poster bg-gray-100 rounded-md w-12 overflow-hidden relative">
                                                    <img src="{{$comment->commentable->imageurl}}"
                                                         class="absolute inset-0 object-cover">
                                                </div>
                                                <div class="">
                                                    <div
                                                        class="font-medium group-hover:underline mb-1">{{$comment->commentable->title}}</div>
                                                    <div
                                                        class="text-xs text-gray-400 dark:text-gray-500">{{$comment->user->username}}</div>
                                                </div>
                                            </a>
                                        </div>
                                    </td>
                                    <td class="h-px w-px whitespace-nowrap">
                                        <div class="px-6 py-3 flex justify-end">
                                            <div
                                                class="text-xs text-gray-400 dark:text-gray-500">
                                                {{$comment->created_at->translatedFormat('d M, Y')}}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
