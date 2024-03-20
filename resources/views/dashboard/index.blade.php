@extends('layouts.main')

@section('container')

<div class="space-y-5">
    <div class="grid xl:grid-cols-4 md:grid-cols-2 gap-5">
        <div class="card">
            <div class="p-5">
                <div class="flex items-center gap-5">
                    <i data-lucide="building-2" class="w-14 h-14 fill-primary/20 stroke-primary"></i>
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
                    <i data-lucide="users" class="w-14 h-14 fill-success/20 stroke-success"></i>
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
                    <i data-lucide="briefcase" class="w-14 h-14 fill-info/20 stroke-info"></i>
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
                    <i data-lucide="refresh-ccw-dot" class="w-14 h-14 fill-warning/20 stroke-warning"></i>
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
                        <h5 class="uppercase">Statistik Pekerjaan dan Realisasi</h5>
                    </div>

                    <div dir="ltr">
                        <div id="chart" class="apex-charts"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- overview -->
        <div class="card">
            <div>
                <div class="flex items-center justify-between p-5 border-b">
                    <h5 class="uppercase mb-0 dark:text-gray-300">Overview Status</h5>
                </div>

                @foreach ($status_pekerjaans as $status_pekerjaan)
                <div class="flex p-5 border-b dark:border-gray-600">
                    <div class="flex-grow">
                        <h4 class="text-2xl mt-0 mb-1 dark:text-gray-300">{{ $status_pekerjaan->pekerjaans->count() }}</h4>
                        <span class="text-gray-500 dark:text-gray-400">Pekerjaan {{ $status_pekerjaan->status['name'] }}</span>
                    </div>
                    <i data-lucide="{{ $status_pekerjaan->status['icon-lucide'] }}" class="w-10 h-10 fill-secondary/20 stroke-secondary"></i>
                </div>
                @endforeach

                <div class="flex justify-end">
                    <a href="{{ route('status-pekerjaan.index') }}" class="p-4 text-primary">Lihat semua <i class="uil-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')

<!-- Apex Charts Plugin js -->
<script src="/assets/libs/apexcharts/apexcharts.min.js"></script>

<script>
    let pekerjaan_bulan = {{ Js::from($pekerjaan_bulan) }};
    let realisasi_bulan = {{ Js::from($realisasi_bulan) }};

    var options = {
        series: [{
            name: 'Pekerjaan',
            data: pekerjaan_bulan
        }, {
            name: 'Realisasi',
            data: realisasi_bulan
        }],
        chart: {
            type: 'bar',
            height: 350
        },
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '55%',
                endingShape: 'rounded'
            },
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            show: true,
            width: 2,
            colors: ['transparent']
        },
        xaxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Oct', 'Nov', 'Des'],
        },
        yaxis: {
            // title: {
            //     text: '$ (thousands)'
            // }
        },
        fill: {
            opacity: 1
        },
        tooltip: {
            y: {
                formatter: function (val) {
                    return val;
                }
            }
        }
    };

    var chart = new ApexCharts(document.querySelector("#chart"), options);
    chart.render();
</script>

@endsection