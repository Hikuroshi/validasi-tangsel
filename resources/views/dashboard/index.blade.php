@extends('layouts.main')

@section('css')

<link href="/assets/libs/jsvectormap/css/jsvectormap.min.css" rel="stylesheet" type="text/css">

@endsection

@section('container')

<div class="space-y-5">
    <div class="grid xl:grid-cols-4 md:grid-cols-2 gap-5">
        <div class="card">
            <div class="p-5">
                <div class="flex items-center gap-5">
                    <i data-lucide="calendar-check" class="w-14 h-14 fill-primary/20 stroke-primary"></i>
                    <div>
                        <span class="text-xs text-gray-500 uppercase font-bold dark:text-gray-400">Perusahaan</span>
                        <h3 class="text-2xl dark:text-gray-300">{{ $perusahaan }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="p-5">
                <div class="flex items-center gap-5">
                    <i data-lucide="calendar-check" class="w-14 h-14 fill-success/20 stroke-success"></i>
                    <div>
                        <span class="text-xs text-gray-500 uppercase font-bold dark:text-gray-400">Tenaga Ahli</span>
                        <h3 class="text-2xl dark:text-gray-300">{{ $tenaga_ahli }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="p-5">
                <div class="flex items-center gap-5">
                    <i data-lucide="calendar-check" class="w-14 h-14 fill-info/20 stroke-info"></i>
                    <div>
                        <span class="text-xs text-gray-500 uppercase font-bold dark:text-gray-400">Pekerjaan</span>
                        <h3 class="text-2xl dark:text-gray-300">{{ $pekerjaan }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="p-5">
                <div class="flex items-center gap-5">
                    <i data-lucide="calendar-check" class="w-14 h-14 fill-warning/20 stroke-warning"></i>
                    <div>
                        <span class="text-xs text-gray-500 uppercase font-bold dark:text-gray-400">Pekerjaan Berlangsung</span>
                        <h3 class="text-2xl dark:text-gray-300">{{ $pekerjaan_berlangsung }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- stats + charts -->
    <div class="grid xl:grid-cols-3 gap-5">
        <div class="xl:col-span-2">
            <div class="card">
                <div class="p-6">
                    <div class="flex items-center justify-between pb-3">
                        <h5 class="uppercase">Revenue</h5>

                        <div class="h-4">
                            <div class="hs-dropdown relative inline-flex [--placement:left-top] rtl:[--placement:right-top]">
                                <button type="button" class="hs-dropdown-toggle  rounded">
                                    <i class="uil uil-ellipsis-v text-base"></i>
                                </button>

                                <div class="hs-dropdown-menu transition-[opacity,margin] w-40 duration hs-dropdown-open:opacity-100 opacity-0 z-10 bg-white shadow rounded dark:bg-gray-800 dark:border dark:border-gray-700 dark:divide-gray-600 hidden">
                                    <a class="flex items-center gap-x-3.5 py-2 px-3 text-sm text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300" href="javascript:;">
                                        Today
                                    </a>
                                    <a class="flex items-center gap-x-3.5 py-2 px-3 text-sm text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300" href="javascript:;">
                                        7 Days
                                    </a>
                                    <a class="flex items-center gap-x-3.5 py-2 px-3 text-sm text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300" href="javascript:;">
                                        15 Days
                                    </a>
                                    <hr class="my-2 dark:border-gray-600">
                                    <a class="flex items-center gap-x-3.5 py-2 px-3 text-sm text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300" href="javascript:;">
                                        1 Months
                                    </a>
                                    <a class="flex items-center gap-x-3.5 py-2 px-3 text-sm text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300" href="javascript:;">
                                        6 Months
                                    </a>
                                    <hr class="my-2 dark:border-gray-600">
                                    <a class="flex items-center gap-x-3.5 py-2 px-3 text-sm text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300" href="javascript:;">
                                        1 Year
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="revenue-chart" class="apex-charts mt-3" dir="ltr"></div>
                </div>
            </div>
        </div>

        <!-- overview -->
        <div class="card">
            <div>
                <div class="flex items-center justify-between p-5 mb-4">
                    <h5 class="uppercase mb-0 dark:text-gray-300">Overview Status</h5>

                    <div class="h-4">
                        <div class="hs-dropdown relative inline-flex [--placement:left-top] rtl:[--placement:right-top]">
                            <button type="button" class="hs-dropdown-toggle  rounded">
                                <i class="uil uil-ellipsis-v text-base"></i>
                            </button>

                            <div class="hs-dropdown-menu transition-[opacity,margin] w-40 duration hs-dropdown-open:opacity-100 opacity-0 z-10 bg-white shadow rounded py-2 dark:bg-gray-800 dark:border dark:border-gray-700 dark:divide-gray-600 hidden">
                                <a class="flex items-center gap-x-3.5 py-2 px-3 text-sm text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300" href="javascript:;">
                                    <i class="uil uil-edit-alt me-1.5"></i>
                                    <span>Edit</span>
                                </a>
                                <a class="flex items-center gap-x-3.5 py-2 px-3 text-sm text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300" href="javascript:;">
                                    <i class="uil uil-refresh me-1.5"></i>
                                    <span>Refresh</span>
                                </a>
                                <hr class="my-2 dark:border-gray-600">
                                <a class="flex items-center gap-x-3.5 py-2 px-3 text-sm text-danger hover:bg-gray-100 dark:hover:bg-gray-700" href="javascript:;">
                                    <i class="uil uil-trash-alt me-1.5"></i>
                                    <span>Delete</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- stat 1 -->
                <div class="flex p-5 border-b dark:border-gray-600">
                    <div class="flex-grow">
                        <h4 class="text-2xl mt-0 mb-1 dark:text-gray-300">121,000</h4>
                        <span class="text-gray-500 dark:text-gray-400">Total Visitors</span>
                    </div>
                    <i data-lucide="users" class="w-10 h-10 fill-secondary/20 stroke-secondary"></i>
                </div>

                <!-- stat 2 -->
                <div class="flex p-5 border-b dark:border-gray-600">
                    <div class="flex-grow">
                        <h4 class="text-2xl mt-0 mb-1 dark:text-gray-300">21,000</h4>
                        <span class="text-gray-500 dark:text-gray-400">Total Product Views</span>
                    </div>
                    <i data-lucide="image" class="w-10 h-10 fill-secondary/20 stroke-secondary"></i>
                </div>

                <!-- stat 3 -->
                <div class="flex p-5 border-b dark:border-gray-600">
                    <div class="flex-grow">
                        <h4 class="text-2xl mt-0 mb-1 dark:text-gray-300">$21.5</h4>
                        <span class="text-gray-500 dark:text-gray-400">Revenue Per Visitor</span>
                    </div>
                    <i data-lucide="shopping-bag" class="w-10 h-10 fill-secondary/20 stroke-secondary"></i>
                </div>

                <!-- stat 4 -->
                <div class="flex justify-end">
                    <a href="#" class="p-4 text-primary">View All <i class="uil-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')

<script src="/assets/libs/apexcharts/apexcharts.min.js"></script>
<script src="/assets/js/pages/dashboard.init.js"></script>

@endsection