@extends('layouts.main')

@section('css')

<!-- Gridjs Plugin css -->
<link href="/assets/libs/gridjs/theme/mermaid.min.css" rel="stylesheet" type="text/css" >

<!-- Select2 CSS -->
<link rel="stylesheet" href="/assets/css/select2.min.css">

@endsection

@section('container')

<div class="flex flex-auto flex-col">
    <div class="grid xl:grid-cols-3 gap-6">
        <div class="xl:col-span-2 space-y-5">

            <div class="card">
                <div class="border-b p-4 dark:border-gray-600">
                    <h6 class="uppercase dark:text-gray-300">Ulasan Pekerjaan/Kontrak</h6>
                </div>

                <div class="p-6">
                    <div class="grid xl:grid-cols-4 md:grid-cols-2 gap-6">
                        <div class="flex items-center gap-5">
                            <i data-lucide="calendar-check" class="w-10 h-10 fill-secondary/20 stroke-secondary"></i>
                            <div>
                                <h4 class="text-lg text-gray-700 dark:text-gray-300 font-semibold">{{ $pekerjaan->tgl_kontrak_f }}</h4>
                                <span class="text-sm dark:text-gray-400">Tanggal Kontrak</span>
                            </div>
                        </div>

                        <div class="flex items-center gap-5">
                            <i data-lucide="calendar-x" class="w-10 h-10 fill-secondary/20 stroke-secondary"></i>
                            <div>
                                <h4 class="text-lg text-gray-700 dark:text-gray-300 font-semibold">{{ $pekerjaan->tgl_selesai_f }}</h4>
                                <span class="text-sm dark:text-gray-400">Tanggal Berakhir</span>
                            </div>
                        </div>

                        <div class="flex items-center gap-5">
                            <i data-lucide="users" class="w-10 h-10 fill-secondary/20 stroke-secondary"></i>
                            <div>
                                <h4 class="text-lg text-gray-700 dark:text-gray-300 font-semibold">{{ $pekerjaan->tenaga_ahlis->count() }}</h4>
                                <span class="text-sm dark:text-gray-400">Tenaga Ahli</span>
                            </div>
                        </div>

                        <div class="flex items-center gap-5">
                            <i data-lucide="clock-5" class="w-10 h-10 fill-secondary/20 stroke-secondary"></i>
                            <div>
                                <h4 class="text-lg text-gray-700 dark:text-gray-300 font-semibold">{{ now()->diffForHumans(Carbon\Carbon::parse($pekerjaan->tgl_kontrak)) }}</h4>
                                <span class="text-sm dark:text-gray-400">Waktu telah berlalu</span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="card">
                <div class="p-5 pb-0">
                    <h4 class="uppercase dark:text-gray-300">Persentase Proses Pekerjaan</h4>
                </div>

                <div class="p-6">
                    <p class="mb-2 dark:text-gray-400">{{ $pekerjaan->progress_pekerjaan['desc'] }}</p>
                    <div class="flex w-full h-6 bg-gray-200 rounded-full overflow-hidden dark:bg-gray-700 mb-5">
                        <div class="flex flex-col justify-center overflow-hidden bg-{{ $pekerjaan->progress_pekerjaan['color'] }} text-xs text-white text-center" role="progressbar" style="width: {{ $pekerjaan->progress_pekerjaan['percent'] }}%" aria-valuenow="{{ $pekerjaan->progress_pekerjaan['percent'] }}" aria-valuemin="0" aria-valuemax="100">
                            {{ $pekerjaan->progress_pekerjaan['color'] == 'secondary' ? 'Gagal menyelesaika dengan tepat waktu' : $pekerjaan->progress_pekerjaan['percent'] . '%' }}
                        </div>
                    </div>

                    <button type="button" data-hs-overlay="#update-status" class="w-full border border-{{ $pekerjaan->status_pekerjaan->color }}/20 btn bg-{{ $pekerjaan->status_pekerjaan->color }}/20 text-{{ $pekerjaan->status_pekerjaan->color }} hover:bg-{{ $pekerjaan->status_pekerjaan->color }} hover:text-white py-2 px-3 rounded">
                        <i class="uil uil-{{ $pekerjaan->status_pekerjaan->icon }} me-1"></i>
                        {{ $pekerjaan->status_pekerjaan->nama }}
                    </button>
                    <div id="update-status" class="hs-overlay hidden w-full h-full fixed top-1/3 left-0 z-[60] overflow-x-hidden overflow-y-auto">
                        <div class="hs-overlay-open:opacity-100 hs-overlay-open:duration-500 opacity-0 transition-all sm:max-w-lg sm:w-full m-3 sm:mx-auto">
                            <div class="flex flex-col bg-white border shadow-sm rounded dark:bg-gray-800 dark:border-gray-700 dark:shadow-slate-700/[.7]">
                                <div class="flex justify-between items-center pt-3 px-4">
                                    <h3 class="font-bold text-gray-800 dark:text-white">
                                        Status Pekerjaan
                                    </h3>
                                    <button type="button" class="hs-dropdown-toggle inline-flex flex-shrink-0 justify-center items-center h-8 w-8 rounded text-gray-500 hover:text-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2 focus:ring-offset-white transition-all text-sm dark:focus:ring-gray-700 dark:focus:ring-offset-gray-800" data-hs-overlay="#update-status">
                                        <span class="sr-only">Tutup</span>
                                        <i class="uil uil-times text-2xl"></i>
                                    </button>
                                </div>
                                <div class="p-4 overflow-y-auto">
                                    <form method="POST" action="{{ route('pekerjaan.change-status', $pekerjaan->slug) }}">
                                        @method('put')
                                        @csrf

                                        <div class="mb-3">
                                            <label class="mb-2" for="status_pekerjaan_id">Status <span class="text-danger">*</span></label>
                                            <div class="mb-3">
                                                <select id="status_pekerjaan_id" name="status_pekerjaan_id" class="form-select">
                                                    <option value=""></option>
                                                    @foreach ($status_pekerjaans as $status_pekerjaan)
                                                    <option value="{{ $status_pekerjaan->id }}" @selected(old('status_pekerjaan_id') == $status_pekerjaan->id)>
                                                        {{ $status_pekerjaan->nama }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                @error('status_pekerjaan_id')
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

        <div class="col-span-1">
            <div class="card">
                <div class="p-5 pb-3">
                    <h6 class="uppercase dark:text-gray-300">Aktifitas Status Pekerjaan</h6>
                </div>

                <div class="p-6 pt-0 pb-3">
                    <div id="data-container" class="divide-y divide-gray-100 dark:divide-gray-600">
                        <div>
                            <div class="flex items-start gap-5 py-3">
                                <div class="text-center">
                                    <h2 class="h-9 w-9 rounded-full text-base flex items-center justify-center text-{{ $pekerjaan->status_pekerjaan->color }} bg-{{ $pekerjaan->status_pekerjaan->color }}/20">{{ $pekerjaan->status_pekerjaan->created_at->format('d') }}</h2>
                                    <small>{{ $pekerjaan->status_pekerjaan->created_at->format('M') }}</small>
                                </div>
                                <div>
                                    <p class="text-gray-700 block font-semibold dark:text-gray-300 mb-1">{{ $pekerjaan->status_pekerjaan->nama }}</p>
                                    <p class="text-gray-400">{{ $pekerjaan->status_pekerjaan->author->name }} telah memperbarui status</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-center">
                        <button id="muat-lagi" class="btn border border-gray-200 hover:bg-light mb-3 transition-all duration-500 dark:border-gray-600 dark:hover:bg-gray-600/20">
                            <i data-lucide="loader" class="w-4 h-4 me-2"></i>
                            Muat lagi
                        </button>
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
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">Dinas</td>
                    <td>:</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $pekerjaan->bidang->dinasan->nama }}</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">Bidang</td>
                    <td>:</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $pekerjaan->bidang->nama }}</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">Nama Pekerjaan</td>
                    <td>:</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $pekerjaan->nama }}</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">Perusahaan</td>
                    <td>:</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $pekerjaan->perusahaan->nama }}</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">Pekerjaan</td>
                    <td>:</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $pekerjaan->nama }}</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">No Kontrak</td>
                    <td>:</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $pekerjaan->no_kontrak }}</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">Tanggal Kontrak</td>
                    <td>:</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $pekerjaan->tgl_kontrak_f }}</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">Status</td>
                    <td>:</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                        <span class="inline-flex items-center gap-1.5 py-0.5 px-1.5 rounded text-xs font-medium bg-{{ $pekerjaan->status_pekerjaan->color }}/10 text-{{ $pekerjaan->status_pekerjaan->color }}">
                            <i class="uil uil-{{ $pekerjaan->status_pekerjaan->icon }}"></i>
                            {{ $pekerjaan->status_pekerjaan->nama }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">Jenis Pekerjaan</td>
                    <td>:</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $pekerjaan->jenis_pekerjaan->nama }}</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">Nilai Pagu</td>
                    <td>:</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $pekerjaan->nilai_pagu_f }}</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">Nilai Kontrak</td>
                    <td>:</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $pekerjaan->nilai_kontrak_f }}</td>
                </tr>
            </table>
            <table class="min-w-full">
                <tr>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">Tanggal Mulai</td>
                    <td>:</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $pekerjaan->tgl_mulai_f }}</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">Tanggal Selesai</td>
                    <td>:</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $pekerjaan->tgl_selesai_f }}</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">PPK</td>
                    <td>:</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $pekerjaan->ppk }}</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">PPTK</td>
                    <td>:</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $pekerjaan->pptk }}</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">Lokasi</td>
                    <td>:</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $pekerjaan->lokasi }}</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">Sumber Dana</td>
                    <td>:</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $pekerjaan->sumber_dana }}</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">Tahun Anggaran</td>
                    <td>:</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $pekerjaan->thn_anggaran }}</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">Metode Pengadaan</td>
                    <td>:</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $pekerjaan->metode->nama }}</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">Jenis Kontruksi</td>
                    <td>:</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $pekerjaan->jenis_kontruksi }}</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">Deskripsi</td>
                    <td>:</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $pekerjaan->deskripsi }}</td>
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
                        Tambah Tenaga Ahli Pekerjaan
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

                        <form method="POST" action="{{ route('pekerjaan.add-tenaga-ahli', $pekerjaan->slug) }}">
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

<div class="card mt-6">
    <div class="p-6">
        <h4 class="uppercase dark:text-gray-300 mb-3">Zona Tindakan</h4>
        <p class="mb-3">
            Perbarui Data memungkinkan pengguna untuk memperbarui informasi terkai yang sedang dilakukan atau sudah selesai dilakukan. Dengan menggunakan fitur ini, pengguna dapat mengubah atau memperbaiki detail-detail tertentu seperti status progres, tanggal mulai dan selesai, deskrips, dan informasi lainnya yang terkait denga tersebut. Fitur ini memberikan fleksibilitas bagi pengguna untuk memastikan bahwa informasi yang tercatat tetap akurat dan terkini sepanjang perjalanan proyek atau tugas yang sedang dikerjakan.
        </p>
        <p class="mb-3">
            Hapus Data memungkinkan pengguna untuk menghapus seluruh informasi atau data terkai yang sudah selesai atau tidak diperlukan lagi. Saat menggunakan fitur ini, penting untuk diingat bahwa semua data yang terkait denga tersebut akan dihapus secara permanen dari sistem. Sebelum menghapus dat, sangat disarankan untuk mencadangkan semua informasi yang dianggap penting atau perlu disimpan sebagai referensi di masa depan. Proses penghapusan dat harus dilakukan dengan hati-hati dan pertimbangkan untuk memastikan tidak ada informasi penting yang hilang atau terhapus tanpa disengaja.
        </p>

        <div class="grid xl:grid-cols-2 gap-6">
            <div>
                <a href="{{ route('pekerjaan.edit', $pekerjaan->slug) }}" class="btn bg-primary text-white hover:bg-primary me-2">
                    Perbarui Data
                </a>
                <button type="button" data-hs-overlay="#deleteDataPekerjaan" class="btn bg-danger text-white hover:bg-danger">
                    Hapus Data
                </button>

                <div id="deleteDataPekerjaan" class="hs-overlay hidden w-full h-full fixed top-1/3 left-0 z-[60] overflow-x-hidden overflow-y-auto">
                    <div class="hs-overlay-open:opacity-100 hs-overlay-open:duration-500 opacity-0 transition-all sm:max-w-lg sm:w-full m-3 sm:mx-auto">
                        <div class="flex flex-col bg-white border shadow-sm rounded dark:bg-gray-800 dark:border-gray-700 dark:shadow-slate-700/[.7]">
                            <div class="flex justify-between items-center pt-3 px-4">
                                <h3 class="font-bold text-gray-800 dark:text-white">
                                    Apakah kamu yakin ingin menghapus data?
                                </h3>
                                <button type="button" class="hs-dropdown-toggle inline-flex flex-shrink-0 justify-center items-center h-8 w-8 rounded text-gray-500 hover:text-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2 focus:ring-offset-white transition-all text-sm dark:focus:ring-gray-700 dark:focus:ring-offset-gray-800" data-hs-overlay="#deleteDataPekerjaan">
                                    <span class="sr-only">Tutup</span>
                                    <i class="uil uil-times text-2xl"></i>
                                </button>
                            </div>
                            <div class="p-4 overflow-y-auto">
                                <p class="dark:text-gray-400 mb-3">
                                    Ketika data <b>Pekerjaan dengan Pekerjaan {{ $pekerjaan->nama }} Perusahaan {{ $pekerjaan->perusahaan->nama }}</b> telah dihapus, semua data akan otomatis terhapus secara permanen. Sebelum menghapus pastikan untuk mencadangkan semua data data.
                                </p>
                                <div class="text-center">
                                    <form method="post" action="{{ route('pekerjaan.destroy', $pekerjaan->slug) }}">
                                        @csrf
                                        @method('delete')

                                        <button type="submit" class="btn bg-danger text-white hover:bg-danger">
                                            Hapus data
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
                    { name: "No", formatter: function (e) { return gridjs.html('<span class="font-semibold">' + e + "</span>") } },
                    {
                        name: "Aksi",
                        formatter: (cell, row) => {
                            return gridjs.html(`<div class="flex flex-wrap items-center gap-1">
                                <a class="inline-flex items-center gap-1.5 py-0.5 px-1.5 rounded text-xs font-medium bg-primary text-white" href="/tenaga-ahli/${cell}">
                                    <i class="uil uil-eye"></i>
                                </a>
                                <a class="inline-flex items-center gap-1.5 py-0.5 px-1.5 rounded text-xs font-medium bg-info text-white" href="/tenaga-ahli/${cell}/edit">
                                    <i class="uil uil-pen"></i>
                                </a>
                                <form action="/pekerjaan-tenaga-ahli/${ {{ Js::from($pekerjaan->slug) }} }/${cell}" method="post" class="d-inline">
                                    @csrf
                                    <button type="button" class="inline-flex items-center gap-1.5 py-0.5 px-1.5 rounded text-xs font-medium bg-danger text-white" id="deleteData" data-title="${row.cells[2].data}">
                                        <i class="uil uil-trash-alt"></i>
                                    </button>
                                </form>
                            </div>`);
                        }
                    },
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
                    ],
                    pagination: { limit: 5 },
                    sort: true,
                    search: true,
                    data: tenaga_ahlis.map((tenaga_ahli, index) => [
                    index + 1,
                    tenaga_ahli.slug,
                    tenaga_ahli.nama,
                    tenaga_ahli.jabatan,
                    tenaga_ahli.status_f,
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

<script>
    $(document).ready(function() {
        const dataContainer = $('#data-container');
        const loadDataButton = $('#muat-lagi');
        const initialItemCount = 3;
        let itemCount = initialItemCount;

        hideExcessData();

        loadDataButton.on('click', function() {
            itemCount = dataContainer.children().length;
            showAllData();
            hideLoadButton();
        });

        function hideExcessData() {
            dataContainer.children().slice(initialItemCount).hide();
        }

        function showAllData() {
            dataContainer.children().show();
        }

        function hideLoadButton() {
            loadDataButton.hide();
        }
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

@if(session()->has('tenaga_ahli_full'))
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
            icon: 'error',
            text: 'Gagal Menambahkan, {{ session('tenaga_ahli_full') }}'
        });
    });
</script>
@enderror

@if(session()->has('dataSelesai'))
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
            icon: 'error',
            title: '{{ session('dataSelesai') }}'
        });
    });
</script>
@endif

<script>
    $(document).on('click', '#deleteData', function() {
        let title = $(this).data('title');

        Swal.fire({
            title: 'Hapus ' + title + '?',
            html: "Apakah kamu yakin ingin menghapus <b>" + title + "</b> dari tenaga ahli pekerjaan?",
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