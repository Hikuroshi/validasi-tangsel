<?php

namespace App\Http\Controllers;

use App\Models\Pelaksana;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index() {
        return view('dashboard.laporan.index', [
            'title'=> 'Laporan Pekerjaan',
            'laporans' => Pelaksana::get(['slug', 'nama', 'tgl_kontrak'])->append(['tgl_kontrak_f']),
        ]);
    }

    public function search(Pelaksana $pelaksana) {
        $pelaksana->load(['perusahaan:id,nama']);

        $pdf = Pdf::loadView('dashboard.laporan.laporan', [
            'laporan' => $pelaksana,
        ]);

        $pdf->setPaper(array(0,0,609.4488,935.433), 'landscape');

        return $pdf->stream();
    }
}
