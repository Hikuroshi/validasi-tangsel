@extends('layouts.main')

@section('css')

<link href="/assets/libs/jsvectormap/css/jsvectormap.min.css" rel="stylesheet" type="text/css">

@endsection

@section('container')

<div class="space-y-5">
    <div class="grid xl:grid-cols-4 md:grid-cols-2 gap-5">
        <div class="card">
            <div class="p-5">
                <div class="flex">
                    <div class="flex-grow">
                        <span class="text-xs text-gray-500 uppercase font-bold dark:text-gray-400">Badan Usaha</span>
                        <h3 class="text-2xl dark:text-gray-300">$2100</h3>
                    </div>
                    <div class="text-center flex-shrink-0">
                        <div id="today-revenue-chart" class="apex-charts"></div>
                        <span class="text-success fw-bold fs-13"><i class='uil uil-arrow-up'></i> 10.21%</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="p-5">
                <div class="flex">
                    <div class="flex-grow">
                        <span class="text-xs text-gray-500 uppercase font-bold dark:text-gray-400">Product Sold</span>
                        <h3 class="text-2xl dark:text-gray-300">558</h3>
                    </div>
                    <div class="align-self-center flex-shrink-0">
                        <div id="today-product-sold-chart" class="apex-charts">
                        </div>
                        <span class="text-danger fw-bold fs-13"><i class='uil uil-arrow-down'></i> 5.05%</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="p-5">
                <div class="flex">
                    <div class="flex-grow">
                        <span class="text-xs text-gray-500 uppercase font-bold dark:text-gray-400">New Customers</span>
                        <h3 class="text-2xl dark:text-gray-300">65</h3>
                    </div>
                    <div class="align-self-center flex-shrink-0">
                        <div id="today-new-customer-chart" class="apex-charts">
                        </div>
                        <span class="text-success fw-bold fs-13"><i class='uil uil-arrow-up'></i> 25.16%</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="p-5">
                <div class="flex">
                    <div class="flex-grow">
                        <span class="text-xs text-gray-500 uppercase font-bold dark:text-gray-400">New Visitors</span>
                        <h3 class="text-2xl dark:text-gray-300">958</h3>
                    </div>
                    <div class="align-self-center flex-shrink-0">
                        <div id="today-new-visitors-chart" class="apex-charts">
                        </div>
                        <span class="text-danger fw-bold fs-13"><i class='uil uil-arrow-down'></i> 5.05%</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- stats + charts -->
    <div class="grid xl:grid-cols-4 gap-5">
        <!-- overview -->
        <div class="card">
            <div>
                <div class="flex items-center justify-between p-5 mb-4">
                    <h5 class="uppercase mb-0 dark:text-gray-300">Overview</h5>

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

        <div>
            <div class="card">
                <div class="p-5">
                    <div class="flex items-center justify-between">
                        <h5 class="uppercase">Targets</h5>

                        <div class="h-4">
                            <div class="hs-dropdown relative inline-flex [--placement:left-top]">
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

                    <div id="targets-chart" class="apex-charts mt-3" dir="ltr"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- row -->

    <!-- products -->
    <div class="grid xl:grid-cols-12 gap-5">
        <div class="xl:col-span-5">
            <div class="card">
                <div class="p-5">
                    <div class="flex items-start justify-between">
                        <h5 class="uppercase">Sales By Category</h5>

                        <div class="h-4">
                            <div class="hs-dropdown relative inline-flex [--placement:left-top] rtl:[--placement:bottom-left]">
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

                    <div id="sales-by-category-chart" class="apex-charts my-4" dir="ltr"></div>
                </div>
            </div> <!-- end card-->
        </div> <!-- end col-->

        <div class="xl:col-span-7">
            <div class="card">
                <div class="p-5">
                    <div class="flex items-center justify-between">
                        <h5 class="uppercase">Recent Orders</h5>
                        <a href="#" class="btn bg-primary/90 text-white btn-sm hover:bg-primary">
                            <i class='uil uil-export me-1'></i> Export
                        </a>
                    </div>
                    <div class="overflow-auto">
                        <div class="min-w-full inline-block align-middle">
                            <div class="overflow-hidden">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="px-4 py-4 text-start text-sm font-semibold text-gray-500 dark:text-gray-400">#</th>
                                            <th scope="col" class="px-4 py-4 text-start text-sm font-semibold text-gray-500 dark:text-gray-400">Product</th>
                                            <th scope="col" class="px-4 py-4 text-start text-sm font-semibold text-gray-500 dark:text-gray-400">Customer</th>
                                            <th scope="col" class="px-4 py-4 text-start text-sm font-semibold text-gray-500 dark:text-gray-400">Price</th>
                                            <th scope="col" class="px-4 py-4 text-start text-sm font-semibold text-gray-500 dark:text-gray-400">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                                        <tr class="hover:bg-gray-100 dark:hover:bg-transparent">
                                            <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-500 dark:text-gray-400">#98754</td>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">ASOS Ridley High</td>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">Otto B</td>
                                            <td class="px-4 py-4 whitespace-nowrap text-start text-gray-500 dark:text-gray-400">$79.49</td>
                                            <td class="px-4 py-4 whitespace-nowrap text-start text-gray-500 dark:text-gray-400"><span class="inline-flex items-center gap-1.5 py-0.5 px-1.5 rounded text-xs font-medium bg-warning/10 text-warning">Pending</span></td>
                                        </tr>

                                        <tr class="hover:bg-gray-100 dark:hover:bg-transparent">
                                            <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-500 dark:text-gray-400">#98753</td>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">Marco Lightweight Shirt</td>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">Mark P</td>
                                            <td class="px-4 py-4 whitespace-nowrap text-start text-gray-500 dark:text-gray-400">$125.49</td>
                                            <td class="px-4 py-4 whitespace-nowrap text-start text-gray-500 dark:text-gray-400"><span class="inline-flex items-center gap-1.5 py-0.5 px-1.5 rounded text-xs font-medium bg-success/10 text-success">Delivered</span></td>
                                        </tr>

                                        <tr class="hover:bg-gray-100 dark:hover:bg-transparent">
                                            <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-500 dark:text-gray-400">#98752</td>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">Half Sleeve Shirt</td>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">Dave B</td>
                                            <td class="px-4 py-4 whitespace-nowrap text-start text-gray-500 dark:text-gray-400">$35.49</td>
                                            <td class="px-4 py-4 whitespace-nowrap text-start text-gray-500 dark:text-gray-400"><span class="inline-flex items-center gap-1.5 py-0.5 px-1.5 rounded text-xs font-medium bg-danger/10 text-danger">Declined</span></td>
                                        </tr>

                                        <tr class="hover:bg-gray-100 dark:hover:bg-transparent">
                                            <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-500 dark:text-gray-400">#98751</td>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">Lightweight Jacket</td>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">Shreyu N</td>
                                            <td class="px-4 py-4 whitespace-nowrap text-start text-gray-500 dark:text-gray-400">$49.49</td>
                                            <td class="px-4 py-4 whitespace-nowrap text-start text-gray-500 dark:text-gray-400"><span class="inline-flex items-center gap-1.5 py-0.5 px-1.5 rounded text-xs font-medium bg-success/10 text-success">Declined</span></td>
                                        </tr>

                                        <tr class="hover:bg-gray-100 dark:hover:bg-transparent">
                                            <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-500 dark:text-gray-400">#98750</td>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">Marco Shoes</td>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">Rik N</td>
                                            <td class="px-4 py-4 whitespace-nowrap text-start text-gray-500 dark:text-gray-400">$69.49</td>
                                            <td class="px-4 py-4 whitespace-nowrap text-start text-gray-500 dark:text-gray-400"><span class="inline-flex items-center gap-1.5 py-0.5 px-1.5 rounded text-xs font-medium bg-danger/10 text-danger">Declined</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div><!-- end table-responsive-->
                </div>
            </div> <!-- end card-->
        </div> <!-- end col-->
    </div>
    <!-- end row -->
</div>

@endsection

@section('js')

<script src="/assets/libs/apexcharts/apexcharts.min.js"></script>
<script src="/assets/js/pages/dashboard.init.js"></script>

@endsection