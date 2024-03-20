<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan</title>

    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
            font-family: 'Times New Roman', Times, serif;
        }

        th, td {
            border: 1px solid black;
            padding: 5px
        }
    </style>
</head>
<body>
    <div style="margin: 30px">

        <div style="text-align: center; text-transform: uppercase; margin-bottom: 10px">
            <h3>Rekapitulasi Kegiatan Pembangunan</h3>
            <h4>Seksi Pembangunan Jalan Dan Jembatan Kota</h4>
            <h5>Bidang Bina Marga</h5>
            <h5>Dinas Sumber Daya Air, Bina Marga dan Bina Kontruksi KotaTangerang Selatan</h5>
            <h5>Tahun Anggaran {{ $laporan->thn_anggaran }}</h5>
        </div>

        <table style="border: 1px solid black; border-collapse: collapse; width: 100%;">
            <tr style="background-color: rgba(0, 0, 0, 0.1)">
                <th>No</th>
                <th>Nama Pekerjaan</th>
                <th>Nilai Pagu</th>
                <th>Nilai Kontrak</th>
                <th>Metode Pengadaan</th>
                <th>Nama Perusahaan</th>
                <th>No Kontrak</th>
                <th>Tanggal Kontrak</th>
                <th>Waktu Pelaksanaan (Hari Kalender)</th>
                <th>Jenis Kontruksi</th>
            </tr>
            <tr style="background-color: rgba(0, 0, 0, 0.2)">
                <td colspan="10" style="font-weight: bold;">{{ $laporan->jenis_pekerjaan->nama }}</td>
            </tr>
            <tr>
                <td>1.</td>
                <td>{{ $laporan->nama }}</td>
                <td>{{ $laporan->nilai_pagu_f }}</td>
                <td>{{ $laporan->nilai_kontrak_f }}</td>
                <td>{{ $laporan->metode->nama }}</td>
                <td>{{ $laporan->perusahaan->nama }}</td>
                <td>{{ $laporan->no_kontrak }}</td>
                <td>{{ $laporan->tgl_kontrak_f }}</td>
                <td>{{ $laporan->tgl_mulai_f }}</td>
                <td>{{ $laporan->jenis_pekerjaan->nama }}</td>
            </tr>
        </table>
    </div>
</body>
</html>