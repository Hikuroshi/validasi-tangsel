
@extends('layouts.main')

@section('container')

<div class="card mt-6">
    <div class="card-header">
        <div class="flex justify-between items-center">
            <h4 class="card-title">{{ $title }}</h4>
        </div>
    </div>

    <div class="p-3">
        <div>
            <table class="table-auto">
                <tr>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">Jenis Jasa</td>
                    <td>:</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $pekerjaan->sub_pekerjaan->jenis_pekerjaan->jenis_jasa->nama }}</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">Jenis Pekerjaan</td>
                    <td>:</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $pekerjaan->sub_pekerjaan->jenis_pekerjaan->nama }}</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">Sub Pekerjaan</td>
                    <td>:</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $pekerjaan->sub_pekerjaan->nama }}</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">Nama Pekerjaan</td>
                    <td>:</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $pekerjaan->nama }}</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">Deskripsi</td>
                    <td>:</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $pekerjaan->deskripsi }}</td>
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
                <tr>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">Kecamatan</td>
                    <td>:</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $pekerjaan->kecamatan->nama }}</td>
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
            </table>
        </div>
    </div>
</div> <!-- end card -->

@endsection