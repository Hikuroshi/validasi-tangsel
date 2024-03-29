<?php

namespace App\Http\Controllers;

use App\Models\Pekerjaan;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index() {
        $query = Pekerjaan::with(['perusahaan:id,nama']);

        if (auth()->user()->dinasan_id !== null) {
            $query->whereHas('bidang', function ($query) {
                $query->where('dinasan_id', auth()->user()->dinasan_id);
            });
        }

        $laporans = $query->get(['slug', 'nama', 'tgl_kontrak', 'perusahaan_id'])->append(['tgl_kontrak_f']);

        return view('dashboard.laporan.index', [
            'title'=> 'Laporan Pekerjaan',
            'laporans' => $laporans,
        ]);
    }

    public function search(Pekerjaan $pekerjaan) {
        $pekerjaan->load(['perusahaan:id,nama']);

        $pdf = Pdf::loadView('dashboard.laporan.laporan', [
            'laporan' => $pekerjaan,
        ]);

        $pdf->setPaper(array(0,0,609.4488,935.433), 'landscape');

        return $pdf->stream();
    }

    public function printAll() {
        $pekerjaans = Pekerjaan::with(['metode:id,nama', 'perusahaan:id,nama', 'jenis_pekerjaan:id,nama', 'status_pekerjaan:id,nama'])
        ->get(['nama', 'nilai_pagu', 'nilai_kontrak', 'no_kontrak', 'tgl_kontrak', 'metode_id', 'perusahaan_id', 'jenis_pekerjaan_id', 'status_pekerjaan_id'])
        ->append(['nilai_pagu_f', 'nilai_kontrak_f', 'tgl_kontrak_f', 'lama_hari']);

        $pdf = Pdf::loadView('dashboard.laporan.laporans', [
            'laporans' => $pekerjaans,
        ]);

        $pdf->setPaper(array(0,0,609.4488,935.433), 'landscape');

        return $pdf->stream();
    }
}
