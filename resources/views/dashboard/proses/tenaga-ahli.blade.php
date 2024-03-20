@extends('layouts.main')

@section('container')

<div class="flex flex-auto flex-col">
    <div class="grid lg::grid-cols-2 xl:grid-cols-3 gap-6">

        @foreach ($prosess as $proses)
            @foreach ($proses->pekerjaans as $pekerjaan)
                <div class="card">
                    <div class="p-5">
                        <div>
                            <div class="flex justify-between items-center">
                                <h5 class="text-xs text-{{ $pekerjaan->status_pekerjaan_f['color'] }}">{{ $pekerjaan->nama }}</h5>
                                <div class="bg-{{ $pekerjaan->status_pekerjaan_f['color'] }} text-xs text-white rounded py-px px-1.5 font-medium" role="alert">
                                    <i class="uil uil-{{ $pekerjaan->status_pekerjaan_f['icon'] }}"></i>
                                    {{ $pekerjaan->status_pekerjaan_f['name'] }}
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col">
                            <div class="py-3">
                                <h5 class="my-2"><a href="{{ route('pekerjaan.show', $pekerjaan->slug) }}" class="text-base text-dark dark:text-gray-300">{{ $proses->nama }}</a></h5>
                                <p class="text-gray-500 text-sm mb-3 dark:text-gray-400">Pekerjaan dilaksanakan atas perusahaan {{ $pekerjaan->perusahaan->nama }} pada tanggal {{ $pekerjaan->tgl_kontrak_f }} sampai tanggal {{ $pekerjaan->tgl_selesai_f }}.</p>
                                <p class="text-gray-500 text-sm mb-5 dark:text-gray-400">{{ $pekerjaan->deskripsi }}</p>
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
                                                Lama hari
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
                                                {{ $pekerjaan->progress_pekerjaan['color'] == 'secondary' ? 'Gagal menyelesaika dengan tepat waktu' : $pekerjaan->progress_pekerjaan['percent'] . '%' }} | {{ $pekerjaan->status_pekerjaan_f['name'] }}
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
        @endforeach
    </div>

    @if ($prosess->isEmpty())
        <div class="flex justify-center items-center h-20">
            <h4 class="text-gray-900 dark:text-gray-200 text-lg font-medium">Tidak ada Tenaga Ahli yang sedang melakukan pekerjaan.</h4>
        </div>
    @endif
</div>

@endsection