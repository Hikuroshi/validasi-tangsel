@extends('layouts.main')

@section('css')

<!-- Gridjs Plugin css -->
<link href="/assets/libs/gridjs/theme/mermaid.min.css" rel="stylesheet" type="text/css" >

@endsection

@section('container')

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
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">No KTP</td>
                    <td>:</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $tenaga_ahli->nik }}</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">NPWP</td>
                    <td>:</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $tenaga_ahli->npwp }}</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">Nama</td>
                    <td>:</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $tenaga_ahli->nama }}</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">Badan Usaha</td>
                    <td>:</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $tenaga_ahli->badan_usaha->nama }}</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">Tempat Lahir</td>
                    <td>:</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $tenaga_ahli->tempat_lahir }}</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">Tanggal Lahir</td>
                    <td>:</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $tenaga_ahli->tgl_lahir }}</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">Alamat</td>
                    <td>:</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $tenaga_ahli->alamat }}</td>
                </tr>
            </table>
            <table class="min-w-full">
                <tr>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">Jabatan</td>
                    <td>:</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $tenaga_ahli->jabatan }}</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">Keahlian</td>
                    <td>:</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $tenaga_ahli->keahlian }}</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">Email</td>
                    <td>:</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $tenaga_ahli->email }}</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">No Telp</td>
                    <td>:</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $tenaga_ahli->telepon }}</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">Jenis Kelamin</td>
                    <td>:</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $tenaga_ahli->kelamin }}</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">Status</td>
                    <td>:</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                        <span class="inline-flex items-center gap-1.5 py-0.5 px-1.5 rounded text-xs font-medium {{ $tenaga_ahli->status ? 'bg-success/10 text-success' : 'bg-danger/10 text-danger' }}">{{ $tenaga_ahli->status_f }}</span>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div> <!-- end card -->

<div class="card mt-6">
    <div class="card-header">
        <div class="flex justify-between items-center">
            <h4 class="card-title">Riwayat Pendidikan {{ $tenaga_ahli->nama }}</h4>
            <a href="{{ route('riwayat-pendidikan.create', ['tenaga_ahli_id' => $tenaga_ahli->id, 'tenaga_ahli_nama' => $tenaga_ahli->nama]) }}" class="btn bg-primary text-white rounded-full">
                <i class="uil uil-plus"></i>
            </a>
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
        init(riwayat_pendidikans) {
            this.basicTableInit(riwayat_pendidikans);
        }

        basicTableInit(riwayat_pendidikans) {
            if (document.getElementById("table-gridjs")) {
                new gridjs.Grid({
                    columns: [
                    { name: "ID", formatter: function (e) { return gridjs.html('<span class="font-semibold">' + e + "</span>") } },
                    "Nama Lembaga",
                    "Jurusan",
                    "Gelar",
                    "Tahun Masuk",
                    "Tahun Lulus",
                    "Ijazah",
                    {
                        name: "Aksi",
                        formatter: (cell, row) => {
                            return gridjs.html(`<div class="flex flex-wrap items-center gap-1">
                                <a class="inline-flex items-center gap-1.5 py-0.5 px-1.5 rounded text-xs font-medium bg-info text-white" href="/dashboard/riwayat-pendidikan/${cell}/edit">
                                    <i class="uil uil-pen"></i>
                                </a>
                                <form action="/dashboard/riwayat-pendidikan/${cell}" method="post" class="d-inline">
                                    @method('delete')
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
                    data: riwayat_pendidikans.map((riwayat_pendidikan, index) => [
                    index + 1,
                    riwayat_pendidikan.nama,
                    riwayat_pendidikan.jurusan,
                    riwayat_pendidikan.gelar,
                    riwayat_pendidikan.thn_masuk_f,
                    riwayat_pendidikan.thn_lulus_f,
                    riwayat_pendidikan.ijazah,
                    riwayat_pendidikan.slug,
                    ]),
                }).render(document.getElementById("table-gridjs"));
            }
        }
    }

    document.addEventListener("DOMContentLoaded", function (e) {
        const riwayat_pendidikans = {{ Js::from($riwayat_pendidikans) }};
        new GridDatatable().init(riwayat_pendidikans);
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
			html: "Apakah kamu yakin ingin menghapus <b>" + title + "</b>? Data yang sudah dihapus tidak bisa dikembalikan!",
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