@extends('layouts.main')

@section('css')

<!-- Gridjs Plugin css -->
<link href="/assets/libs/gridjs/theme/mermaid.min.css" rel="stylesheet" type="text/css" >

@endsection

@section('container')

<div class="card">
    <div class="card-header">
        <div class="flex justify-between items-center">
            <h4 class="card-title">{{ $title }}</h4>
            <a href="{{ route('laporan.all') }}" target="_blank" class="btn bg-primary text-white rounded-full">
                <i class="uil uil-export"></i>
            </a>
        </div>
    </div>

    <div class="p-6">
        <div id="table-gridjs"></div>
    </div>
</div>


@endsection

@section('js')

<script src="/assets/js/jquery-3.7.1.min.js"></script>

<!-- Gridjs Plugin js -->
<script src="/assets/libs/gridjs/gridjs.umd.js"></script>

<script>
    class GridDatatable {
        init(laporans) {
            this.basicTableInit(laporans);
        }

        basicTableInit(laporans) {
            if (document.getElementById("table-gridjs")) {
                new gridjs.Grid({
                    columns: [
                    { name: "ID", formatter: function (e) { return gridjs.html('<span class="font-semibold">' + e + "</span>") } },
                    "Nama Pekerjaan",
                    "Nama Perusahaan",
                    "Tanggal Kontrak",
                    {
                        name: "Laporan",
                        formatter: function (e) {
                            return gridjs.html(`<a href="/laporan/${e}" target="_blank" class="btn bg-transparent text-primary py-0.5 px-1.5 rounded">
                                <i class="uil uil-search px-1"></i>
                                Lihat Laporan
                            </a>`);
                        }
                    },
                    ],
                    pagination: { limit: 10 },
                    sort: true,
                    search: true,
                    data: laporans.map((laporan, index) => [
                    index + 1,
                    laporan.nama,
                    laporan.perusahaan.nama,
                    laporan.tgl_kontrak_f,
                    laporan.slug,
                    ]),
                }).render(document.getElementById("table-gridjs"));
            }
        }
    }

    document.addEventListener("DOMContentLoaded", function (e) {
        const laporans = {{ Js::from($laporans) }};
        new GridDatatable().init(laporans);
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