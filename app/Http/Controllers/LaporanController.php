<?php

namespace App\Http\Controllers;

use App\Models\Pekerjaan;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index() {
        return view('dashboard.laporan.index', [
            'title'=> 'Laporan Pekerjaan',
            'laporans' => Pekerjaan::with(['perusahaan:id,nama'])->get(['slug', 'nama', 'tgl_kontrak', 'perusahaan_id'])->append(['tgl_kontrak_f']),
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
}
