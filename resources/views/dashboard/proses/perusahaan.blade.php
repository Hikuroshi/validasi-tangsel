@extends('layouts.main')

@section('container')

<div class="card">
    <div class="flex justify-between items-center p-5">
        <div class="flex justify-between items-center">
            <h4 class="text-gray-900 dark:text-gray-200 text-lg font-medium">Daftar Proses Perusahaan</h4>
        </div>

        <div class="flex items-center gap-3">
            <div class="md:flex hidden items-center gap-2.5 text-sm font-semibold">
                <div class="static overflow-y-hidden">
                    <form action="{{ route('proses.perusahaan') }}" method="GET">
                        <div class="relative flex items-center border rounded dark:border-gray-600">
                            <input type="text" name="search" class="form-input border-0 border-dark/10 ps-8 dark:border-gray-600" placeholder="Cari perusahaan...">
                            <span class="uil uil-search absolute text-base leading-9 left-2.5 top-0"></span>
                            <button class="btn bg-primary/20 text-primary rounded" type="submit">
                                <i class="uil uil-file-search-alt"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div>
                <div class="hs-dropdown relative inline-flex [--placement:left-top]">
                    <button id="hs-dropright" type="button" class="hs-dropdown-toggle btn bg-secondary text-white rounded">
                        <i class="uil uil-sort-amount-down text-base"></i>
                    </button>

                    <div class="hs-dropdown-menu transition-[opacity,margin] w-40 duration hs-dropdown-open:opacity-100 opacity-0 hidden z-10 bg-white shadow rounded py-2 dark:bg-gray-800 dark:border dark:border-gray-700 dark:divide-gray-600" aria-labelledby="hs-dropright">
                        <a class="flex items-center py-1.5 px-5 text-sm text-gray-500 hover:bg-light hover:text-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300" href="javascript:void(0)">
                            Request
                        </a>
                        <a class="flex items-center py-1.5 px-5 text-sm text-gray-500 hover:bg-light hover:text-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300" href="javascript:void(0)">
                            On Progress
                        </a>
                        <a class="flex items-center py-1.5 px-5 text-sm text-gray-500 hover:bg-light hover:text-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300" href="javascript:void(0)">
                            Reporting
                        </a>
                        <a class="flex items-center py-1.5 px-5 text-sm text-gray-500 hover:bg-light hover:text-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300" href="javascript:void(0)">
                            Pending
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="flex flex-auto flex-col">

    @foreach ($prosess as $proses)
    <div class="card my-5">
        <div class="card-header">
            <div class="flex justify-center items-center">
                <h4 class="card-title">{{ $proses->nama }}</h4>
            </div>
        </div>
    </div>
    <div class="grid lg::grid-cols-2 xl:grid-cols-3 gap-6">
        @foreach ($proses->pekerjaans as $pekerjaan)
        <div class="card">
            <div class="p-5">
                <div>
                    <div class="flex justify-between items-center">
                        <h5 class="text-xs text-{{ $pekerjaan->status_pekerjaan->status['color'] }}">{{ $pekerjaan->nama }}</h5>
                        <div class="bg-{{ $pekerjaan->status_pekerjaan->status['color'] }} text-xs text-white rounded py-px px-1.5 font-medium" role="alert">
                            <i class="uil uil-{{ $pekerjaan->status_pekerjaan->status['icon'] }}"></i>
                            {{ $pekerjaan->status_pekerjaan->status['name'] }}
                        </div>
                    </div>
                </div>
                <div class="flex flex-col">
                    <div class="py-3">
                        <h5 class="my-2"><a href="{{ route('pekerjaan.show', $pekerjaan->slug) }}" class="text-base text-dark dark:text-gray-300">{{ $proses->nama }}</a></h5>
                        <p class="text-gray-500 text-sm mb-3 dark:text-gray-400">Pekerjaan dilaksanakan atas perusahaan {{ $pekerjaan->perusahaan->nama }} pada tanggal {{ $pekerjaan->tgl_kontrak_f }} sampai tanggal {{ $pekerjaan->tgl_selesai_f }}.</p>
                        <p class="text-gray-500 text-sm mb-5 dark:text-gray-400">{{ $pekerjaan->deskripsi }}</p>

                        <p>Daftar Tenaga Ahli:</p>
                        <ul class="ps-9 list-disc">
                            @foreach ($pekerjaan->tenaga_ahlis as $tenaga_ahli)
                            <li>{{ $tenaga_ahli->nama }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="border-t dark:border-gray-600">
                <div class="p-5">
                    <div class="sm:flex items-center justify-center gap-10">
                        <div class="flex items-center gap-4">
                            <div class="hs-tooltip inline-block [--trigger:hover]">
                                <a class="hs-tooltip-toggle block text-center" href="javascript:;">
                                    <span class="text-gray-500 dark:text-gray-400">
                                        <i class="uil uil-calender text-lg me-1"></i> <span>{{ Carbon\Carbon::parse($pekerjaan->tgl_kontrak)->format('d M') }}</span>
                                    </span>
                                    <div class="hs-tooltip-content hs-tooltip-shown:opacity-100 hs-tooltip-shown:visible opacity-0 transition-opacity inline-block absolute invisible z-10 py-1 px-2 bg-black border text-sm text-white rounded shadow dark:border-black" role="tooltip">
                                        Tanggal Kontrak
                                        <div class="bg-black w-2.5 h-2.5 -bottom-[5px] start-[40%] rotate-45 -z-10 rounded-[1px] absolute"></div>
                                    </div>
                                </a>
                            </div>

                            <div class="hs-tooltip inline-block [--trigger:hover]">
                                <a class="hs-tooltip-toggle block text-center" href="javascript:;">
                                    <span class="text-gray-500 dark:text-gray-400">
                                        <i class="uil uil-clock text-lg me-1"></i> <span>{{ $pekerjaan->sisa_hari }}</span>
                                    </span>
                                    <div class="hs-tooltip-content hs-tooltip-shown:opacity-100 hs-tooltip-shown:visible opacity-0 transition-opacity inline-block absolute invisible z-10 py-1 px-2 bg-black border text-sm text-white rounded shadow dark:border-black" role="tooltip">
                                        Sisa hari
                                        <div class="bg-black w-2.5 h-2.5 -bottom-[5px] start-[40%] rotate-45 -z-10 rounded-[1px] absolute"></div>
                                    </div>
                                </a>
                            </div>

                            <div class="hs-tooltip inline-block [--trigger:hover]">
                                <a class="hs-tooltip-toggle block text-center" href="javascript:;">
                                    <span class="text-gray-500 dark:text-gray-400">
                                        <i class="uil uil-bill text-lg me-1"></i><span>{{ $pekerjaan->thn_anggaran }}</span>
                                    </span>
                                    <div class="hs-tooltip-content hs-tooltip-shown:opacity-100 hs-tooltip-shown:visible opacity-0 transition-opacity inline-block absolute invisible z-10 py-1 px-2 bg-black border text-sm text-white rounded shadow dark:border-black" role="tooltip">
                                        Tahun Anggaran
                                        <div class="bg-black w-2.5 h-2.5 -bottom-[5px] start-[40%] rotate-45 -z-10 rounded-[1px] absolute"></div>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <div class="flex-grow sm:pt-0 pt-5">
                            <div class="hs-tooltip [--trigger:hover]">
                                <a class="hs-tooltip-toggle block text-center" href="javascript:;">
                                    <div class="text-gray-500 dark:text-gray-400 w-[100%]">
                                        <div class="flex w-full h-1.5 bg-gray-200 rounded-full overflow-hidden dark:bg-gray-600">
                                            <div class="flex flex-col justify-center overflow-hidden bg-{{ $pekerjaan->progress_pekerjaan['color'] }}" role="progressbar" style="width: {{ $pekerjaan->progress_pekerjaan['percent'] }}%" aria-valuenow="{{ $pekerjaan->progress_pekerjaan['percent'] }}" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                    <div class="hs-tooltip-content hs-tooltip-shown:opacity-100 hs-tooltip-shown:visible opacity-0 transition-opacity inline-block absolute invisible z-10 py-1 px-2 bg-black border text-sm text-white rounded shadow dark:border-black" role="tooltip">
                                        {{ $pekerjaan->progress_pekerjaan['color'] == 'secondary' ? 'Gagal menyelesaika dengan tepat waktu' : $pekerjaan->progress_pekerjaan['percent'] . '%' }} | {{ $pekerjaan->status_pekerjaan->status['name'] }}
                                        <div class="bg-black w-2.5 h-2.5 -bottom-[5px] start-[40%] rotate-45 -z-10 rounded-[1px] absolute"></div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endforeach

    @if ($prosess->isEmpty())
    <div class="flex justify-center items-center h-20 pt-20">
        <h4 class="text-gray-900 dark:text-gray-200 text-lg font-medium">Tidak ada Perusahaan yang sedang melakukan pekerjaan.</h4>
    </div>
    @endif
</div>

@endsection