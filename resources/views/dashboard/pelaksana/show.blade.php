@extends('layouts.main')

@section('css')

<!-- Gridjs Plugin css -->
<link href="/assets/libs/gridjs/theme/mermaid.min.css" rel="stylesheet" type="text/css" >

<!-- Select2 CSS -->
<link rel="stylesheet" href="/assets/css/select2.min.css">

@endsection

@section('container')

<div class="card">
    <div class="border-b p-4 dark:border-gray-600">
        <h6 class="uppercase dark:text-gray-300">Ulasan Pekerjaan/Kontrak</h6>
    </div>

    <div class="p-6">
        <div class="grid xl:grid-cols-4 md:grid-cols-2 gap-6">
            <div class="flex items-center gap-5">
                <i data-lucide="calendar-check" class="w-10 h-10 fill-secondary/20 stroke-secondary"></i>
                <div>
                    <h4 class="text-lg text-gray-700 dark:text-gray-300 font-semibold">{{ $pelaksana->tgl_mulai_f }}</h4>
                    <span class="text-sm dark:text-gray-400">Tanggal Mulai</span>
                </div>
            </div>

            <div class="flex items-center gap-5">
                <i data-lucide="users" class="w-10 h-10 fill-secondary/20 stroke-secondary"></i>
                <div>
                    <h4 class="text-lg text-gray-700 dark:text-gray-300 font-semibold">{{ $pelaksana->tenaga_ahlis->count() }}</h4>
                    <span class="text-sm dark:text-gray-400">Tenaga Ahli</span>
                </div>
            </div>

            <div class="flex items-center gap-5">
                <i data-lucide="clock-5" class="w-10 h-10 fill-secondary/20 stroke-secondary"></i>
                <div>
                    <h4 class="text-lg text-gray-700 dark:text-gray-300 font-semibold">{{ now()->diffForHumans($pelaksana->tgl_mulai) }}</h4>
                    <span class="text-sm dark:text-gray-400">Waktu</span>
                </div>
            </div>

            <div class="flex flex-col items-center gap-1">
                <h4 class="text-lg text-gray-700 dark:text-gray-300 font-semibold">Status</h4>

                <button type="button" data-hs-overlay="#update-status" class="w-full border border-{{ $pelaksana->status_pelaksana_f['color'] }}/20 btn bg-{{ $pelaksana->status_pelaksana_f['color'] }}/20 text-{{ $pelaksana->status_pelaksana_f['color'] }} hover:bg-{{ $pelaksana->status_pelaksana_f['color'] }} hover:text-white py-2 px-3 rounded">
                    <i class="uil uil-{{ $pelaksana->status_pelaksana_f['icon'] }} me-1"></i>
                    {{ $pelaksana->status_pelaksana_f['name'] }}
                </button>
                <div id="update-status" class="hs-overlay hidden w-full h-full fixed top-1/3 left-0 z-[60] overflow-x-hidden overflow-y-auto">
                    <div class="hs-overlay-open:opacity-100 hs-overlay-open:duration-500 opacity-0 transition-all sm:max-w-lg sm:w-full m-3 sm:mx-auto">
                        <div class="flex flex-col bg-white border shadow-sm rounded dark:bg-gray-800 dark:border-gray-700 dark:shadow-slate-700/[.7]">
                            <div class="flex justify-between items-center pt-3 px-4">
                                <h3 class="font-bold text-gray-800 dark:text-white">
                                    Status Pelaksana
                                </h3>
                                <button type="button" class="hs-dropdown-toggle inline-flex flex-shrink-0 justify-center items-center h-8 w-8 rounded text-gray-500 hover:text-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2 focus:ring-offset-white transition-all text-sm dark:focus:ring-gray-700 dark:focus:ring-offset-gray-800" data-hs-overlay="#update-status">
                                    <span class="sr-only">Tutup</span>
                                    <i class="uil uil-times text-2xl"></i>
                                </button>
                            </div>
                            <div class="p-4 overflow-y-auto">
                                <form method="POST" action="{{ route('status-pelaksana.store', $pelaksana->slug) }}">
                                    @method('put')
                                    @csrf

                                    <div class="mb-3">
                                        <label class="mb-2" for="status_pelaksana">Status <span class="text-danger">*</span></label>
                                        <div class="mb-3">
                                            <select id="status_pelaksana" name="status_pelaksana" class="form-select" required>
                                                <option>Pilih Status</option>
                                                @foreach ($status_pelaksanas as $key => $value)
                                                    <option value="{{ $key }}" @selected(old('status_pelaksana', $pelaksana->status_pelaksana_f['slug']) == $key)>
                                                        {{ $value }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('status_pelaksana')
                                                <p class="inline-block text-danger"><small>{{ $message }}</small></p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="mb-2" for="keterangan">Keterangan <span class="text-danger">*</span></label>
                                        <div class="mb-3">
                                            <textarea id="keterangan" name="keterangan" class="form-input" rows="5" placeholder="Keterangan" required>{{ old('keterangan', $pelaksana->status_pelaksana_f['keterangan']) }}</textarea>
                                            @error('keterangan')
                                            <p class="inline-block text-danger"><small>{{ $message }}</small></p>
                                            @enderror
                                        </div>
                                    </div>

                                    <button type="submit" class="btn bg-primary text-white hover:bg-primary mt-5">
                                        Simpan
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card mt-6">
    <div class="card-header">
        <div class="flex justify-between items-center">
            <h4 class="card-title">{{ $title }}</h4>
        </div>
    </div>

    <div class="p-3">
        <div class="grid md:grid-cols-2 gap-6">
            <table class="min-w-full">
                <tr>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">Badan Usaha</td>
                    <td>:</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $pelaksana->badan_usaha->nama }}</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">Pekerjaan</td>
                    <td>:</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $pelaksana->pekerjaan->nama }}</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">No Kontrak</td>
                    <td>:</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $pelaksana->no_kontrak }}</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">Tanggal Kontrak</td>
                    <td>:</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $pelaksana->tgl_kontrak_f }}</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">Status</td>
                    <td>:</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                        <span class="inline-flex items-center gap-1.5 py-0.5 px-1.5 rounded text-xs font-medium bg-{{ $pelaksana->status_pelaksana_f['color'] }}/10 text-{{ $pelaksana->status_pelaksana_f['color'] }}">
                            <i class="uil uil-{{ $pelaksana->status_pelaksana_f['icon'] }}"></i>
                            {{ $pelaksana->status_pelaksana_f['name'] }}
                        </span>
                    </td>
                </tr>
            </table>
            <table class="min-w-full">
                <tr>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">Tanggal Mulai</td>
                    <td>:</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $pelaksana->tgl_mulai_f }}</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">Tanggal Selesai</td>
                    <td>:</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $pelaksana->tgl_selesai_f }}</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">PPK</td>
                    <td>:</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $pelaksana->ppk }}</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">PPTK</td>
                    <td>:</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $pelaksana->pptk }}</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">PHO</td>
                    <td>:</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $pelaksana->pho }}</td>
                </tr>
            </table>
        </div>
    </div>
</div>

<div class="card mt-6">
    <div class="card-header">
        <div class="flex justify-between items-center">
            <h4 class="card-title">Detail Pekerjaan</h4>
        </div>
    </div>

    <div class="p-3">
        <div class="grid md:grid-cols-2 gap-6">
            <table class="min-w-full">
                <tr>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">Jenis Jasa</td>
                    <td>:</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $pelaksana->pekerjaan->sub_pekerjaan->jenis_pekerjaan->jenis_jasa->nama }}</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">Jenis Pekerjaan</td>
                    <td>:</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $pelaksana->pekerjaan->sub_pekerjaan->jenis_pekerjaan->nama }}</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">Sub Pekerjaan</td>
                    <td>:</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $pelaksana->pekerjaan->sub_pekerjaan->nama }}</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">Nama Pekerjaan</td>
                    <td>:</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $pelaksana->pekerjaan->nama }}</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">Deskripsi</td>
                    <td>:</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $pelaksana->pekerjaan->deskripsi }}</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">Nilai Pagu</td>
                    <td>:</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $pelaksana->pekerjaan->nilai_pagu_f }}</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">Nilai Kontrak</td>
                    <td>:</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $pelaksana->pekerjaan->nilai_kontrak_f }}</td>
                </tr>
            </table>
            <table class="min-w-full">
                <tr>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">Kecamatan</td>
                    <td>:</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $pelaksana->pekerjaan->kecamatan->nama }}</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">Lokasi</td>
                    <td>:</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $pelaksana->pekerjaan->lokasi }}</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">Sumber Dana</td>
                    <td>:</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $pelaksana->pekerjaan->sumber_dana }}</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">Tahun Anggaran</td>
                    <td>:</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $pelaksana->pekerjaan->thn_anggaran }}</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">Metode Pengadaan</td>
                    <td>:</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $pelaksana->pekerjaan->metode->nama }}</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">Jenis Kontruksi</td>
                    <td>:</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $pelaksana->pekerjaan->jenis_kontruksi }}</td>
                </tr>
            </table>
        </div>
    </div>
</div>

<div class="card mt-6">
    <div class="card-header">
        <div class="flex justify-between items-center">
            <h4 class="card-title">Tenaga Ahli</h4>
            <button type="button" class="btn bg-primary text-white rounded-full" data-hs-overlay="#add-tenaga-ahli">
                <i class="uil uil-plus"></i>
            </button>
        </div>
    </div>

    <div id="add-tenaga-ahli" class="hs-overlay hidden w-full h-full fixed top-1/3 left-0 z-[60] overflow-x-hidden overflow-y-auto">
        <div class="hs-overlay-open:opacity-100 hs-overlay-open:duration-500 opacity-0 transition-all sm:max-w-lg sm:w-full m-3 sm:mx-auto">
            <div class="flex flex-col bg-white border shadow-sm rounded dark:bg-gray-800 dark:border-gray-700 dark:shadow-slate-700/[.7]">
                <div class="flex justify-between items-center pt-3 px-4">
                    <h3 class="font-bold text-gray-800 dark:text-white">
                        Tambah Tenaga Ahli Pelaksana
                    </h3>
                    <button type="button" class="hs-dropdown-toggle inline-flex flex-shrink-0 justify-center items-center h-8 w-8 rounded text-gray-500 hover:text-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2 focus:ring-offset-white transition-all text-sm dark:focus:ring-gray-700 dark:focus:ring-offset-gray-800" data-hs-overlay="#add-tenaga-ahli">
                        <span class="sr-only">Tutup</span>
                        <i class="uil uil-times text-2xl"></i>
                    </button>
                </div>
                <div class="p-4 overflow-y-auto">
                    <div class="text-center">
                        <h3 class="text-gray-800 dark:text-white font-bold mb-3">
                            Tenaga Ahli
                        </h3>

                        <form method="POST" action="{{ route('pelaksana.add-tenaga-ahli', $pelaksana->slug) }}">
                            @method('put')
                            @csrf

                            <div class="w-full mb-3">
                                <select id="tenaga_ahli_id" name="tenaga_ahli_id[]" class="form-select w-96 select2" multiple="multiple" required>
                                    @foreach ($add_tenaga_ahlis as $add_tenaga_ahli)
                                    <option value="{{ $add_tenaga_ahli->id }}">
                                        {{ $add_tenaga_ahli->nama }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" class="btn bg-primary text-white hover:bg-primary">
                                Tambah Tenaga Ahli
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="p-6">
        <div id="table-gridjs"></div>
    </div>
</div>

@endsection

@section('js')

<!-- Gridjs Plugin js -->
<script src="/assets/libs/gridjs/gridjs.umd.js"></script>

<script>
    class GridDatatable {
        init(tenaga_ahlis) {
            this.basicTableInit(tenaga_ahlis);
        }

        basicTableInit(tenaga_ahlis) {
            if (document.getElementById("table-gridjs")) {
                new gridjs.Grid({
                    columns: [
                    { name: "ID", formatter: function (e) { return gridjs.html('<span class="font-semibold">' + e + "</span>") } },
                    "Tenaga Ahli",
                    "Jabatan Projek",
                    {
                        name: "Status",
                        formatter: function (e) {
                            let status;
                            if (e == 'Aktif') {
                                status = 'bg-success/10 text-success'
                            } else {
                                status = 'bg-danger/10 text-danger'
                            }
                            return gridjs.html('<span class="inline-flex items-center gap-1.5 py-0.5 px-1.5 rounded text-xs font-medium ' + status + '">' + e + '</span>')
                        }
                    },
                    {
                        name: "Aksi",
                        formatter: (cell, row) => {
                            return gridjs.html(`<div class="flex flex-wrap items-center gap-1">
                                <a class="inline-flex items-center gap-1.5 py-0.5 px-1.5 rounded text-xs font-medium bg-primary text-white" href="/dashboard/tenaga-ahli/${cell}">
                                    <i class="uil uil-eye"></i>
                                </a>
                                <a class="inline-flex items-center gap-1.5 py-0.5 px-1.5 rounded text-xs font-medium bg-info text-white" href="/dashboard/tenaga-ahli/${cell}/edit">
                                    <i class="uil uil-pen"></i>
                                </a>
                                <form action="/dashboard/pelaksana-tenaga-ahli/${ {{ Js::from($pelaksana->slug) }} }/${cell}" method="post" class="d-inline">
                                    @csrf
                                    <button type="button" class="inline-flex items-center gap-1.5 py-0.5 px-1.5 rounded text-xs font-medium bg-danger text-white" id="deleteData" data-title="${row.cells[1].data}">
                                        <i class="uil uil-trash-alt"></i>
                                    </button>
                                </form>
                            </div>`);
                        }
                    }
                    ],
                    pagination: { limit: 5 },
                    sort: true,
                    search: true,
                    data: tenaga_ahlis.map((tenaga_ahli, index) => [
                    index + 1,
                    tenaga_ahli.nama,
                    tenaga_ahli.jabatan,
                    tenaga_ahli.status_f,
                    tenaga_ahli.slug,
                    ]),
                }).render(document.getElementById("table-gridjs"));
            }
        }
    }

    document.addEventListener("DOMContentLoaded", function (e) {
        const tenaga_ahlis = {{ Js::from($tenaga_ahlis) }};

        new GridDatatable().init(tenaga_ahlis);
    });
</script>

<!-- Select2 js -->
<script src="/assets/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        $('.select2').select2();

        let selectedOptions = {{ Js::from(old('tenaga_ahli_id')) }};
        $('.select2').val(selectedOptions).trigger('change');
    });
</script>

<!-- Sweet-alert js  -->
<script src="/assets/js/sweetalert2.all.min.js"></script>

@if(session()->has('success'))
<script>
    $(document).ready(function() {
        let Toast = Swal.mixin({
            toast: true,
            position: 'top',
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        Toast.fire({
            icon: 'success',
            title: '{{ session('success') }}'
        });
    });
</script>
@endif

<script>
    $(document).on('click', '#deleteData', function() {
        let title = $(this).data('title');

        Swal.fire({
            title: 'Hapus ' + title + '?',
            html: "Apakah kamu yakin ingin menghapus <b>" + title + "</b> dari tenaga ahli pelaksana?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $(this).closest('form').submit();
            }
        });
    });
</script>

@endsection