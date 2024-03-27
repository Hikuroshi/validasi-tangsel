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
            <a href="{{ route('bidang.create') }}" class="btn bg-primary text-white rounded-full">
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

<script src="/assets/js/jquery-3.7.1.min.js"></script>

<!-- Gridjs Plugin js -->
<script src="/assets/libs/gridjs/gridjs.umd.js"></script>

<script>
    class GridDatatable {
        init(bidangs) {
            this.basicTableInit(bidangs);
        }

        basicTableInit(bidangs) {
            if (document.getElementById("table-gridjs")) {
                new gridjs.Grid({
                    columns: [
                    { name: "No", formatter: function (e) { return gridjs.html('<span class="font-semibold">' + e + "</span>") } },
                    {
                        name: "Aksi",
                        formatter: (cell, row) => {
                            return gridjs.html(`<div class="flex flex-wrap items-center gap-1">
                                <a class="inline-flex items-center gap-1.5 py-0.5 px-1.5 rounded text-xs font-medium bg-info text-white" href="/bidang/${cell}/edit">
                                    <i class="uil uil-pen"></i>
                                </a>
                                <form action="/bidang/${cell}" method="post" class="d-inline">
                                    @method('delete')
                                    @csrf
                                    <button type="button" class="inline-flex items-center gap-1.5 py-0.5 px-1.5 rounded text-xs font-medium bg-danger text-white" id="deleteData" data-title="${row.cells[2].data}">
                                        <i class="uil uil-trash-alt"></i>
                                    </button>
                                </form>
                            </div>`);
                        }
                    },
                    "Bidang",
                    "Dinas",
                    ],
                    pagination: { limit: 10 },
                    sort: true,
                    search: true,
                    data: bidangs.map((bidang, index) => [
                    index + 1,
                    bidang.slug,
                    bidang.nama,
                    bidang.dinasan.nama,
                    ]),
                }).render(document.getElementById("table-gridjs"));
            }
        }
    }

    document.addEventListener("DOMContentLoaded", function (e) {
        const bidangs = {{ Js::from($bidangs) }};
        new GridDatatable().init(bidangs);
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