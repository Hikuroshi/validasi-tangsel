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
            <a href="{{ route('kontrak.create') }}" class="btn bg-primary text-white rounded-full">
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
        init(kontraks) {
            this.basicTableInit(kontraks);
        }

        basicTableInit(kontraks) {
            if (document.getElementById("table-gridjs")) {
                new gridjs.Grid({
                    columns: [
                    { name: "ID", formatter: function (e) { return gridjs.html('<span class="font-semibold">' + e + "</span>") } },
                    "Nama",
                    "Tanggal Mulai",
                    "Tanggal Batas",
                    "Tanggal Selesai",
                    "Perusahaan",
                    {
                        name: "Tenaga Ahli",
                        formatter: function (e) {
                            const tenagaAhliList = e.map(tenaga => `<li>${tenaga.nama}</li>`).join('');
                            return gridjs.html(`<ul class="ps-6 list-disc">${tenagaAhliList}</ul>`);
                        }
                    },
                    {
                        name: "Status Pekerjaan/Kontrak",
                        formatter: function (e) {
                            let status;

                            if (e == 'Direncanakan') {
                                status = 'bg-primary/10 text-primary';
                            } else if (e == 'Proses') {
                                status = 'bg-info/10 text-info';
                            } else if (e == 'Selesai') {
                                status = 'bg-success/10 text-success';
                            } else if (e == 'Selesai, Melewati batas waktu') {
                                status = 'bg-danger/10 text-danger'
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
                                <a class="inline-flex items-center gap-1.5 py-0.5 px-1.5 rounded text-xs font-medium bg-primary text-white" href="/dashboard/kontrak/${cell}">
                                    <i class="uil uil-eye"></i>
                                </a>
                                <a class="inline-flex items-center gap-1.5 py-0.5 px-1.5 rounded text-xs font-medium bg-info text-white" href="/dashboard/kontrak/${cell}/edit">
                                    <i class="uil uil-pen"></i>
                                </a>
                                <form action="/dashboard/kontrak/${cell}" method="post" class="d-inline">
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
                    pagination: { limit: 10 },
                    sort: true,
                    search: true,
                    data: kontraks.map((kontrak, index) => [
                    index + 1,
                    kontrak.nama,
                    kontrak.tgl_mulai_f,
                    kontrak.tgl_batas_f,
                    kontrak.tgl_selesai_f,
                    kontrak.perusahaan.nama,
                    kontrak.tenaga_ahlis,
                    kontrak.status_kontrak,
                    kontrak.slug,
                    ]),
                }).render(document.getElementById("table-gridjs"));
            }
        }
    }

    document.addEventListener("DOMContentLoaded", function (e) {
        const kontraks = {{ Js::from($kontraks) }};
        new GridDatatable().init(kontraks);
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