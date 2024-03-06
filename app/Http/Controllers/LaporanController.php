<?php

namespace App\Http\Controllers;

use App\Models\BadanUsaha;
use App\Models\JenisJasa;
use App\Models\Pelaksana;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index() {
        return view('dashboard.laporan.index', [
            'title'=> 'Laporan',
            'jenis_jasas' => JenisJasa::get(['id', 'nama']),
            'badan_usahas' => BadanUsaha::get(['id', 'nama']),
        ]);
    }

    public function search(Request $request) {
        $request->validate([
            'thn_anggaran' => 'required|integer|between:1901,' . date('Y'),
            'no_kontrak' => 'required|max:255',
            'sub_pekerjaan_id' => 'required|exists:sub_pekerjaans,id',
            'badan_usaha_id' => 'required|exists:badan_usahas,id',
        ]);

        $laporan = Pelaksana::whereHas('pekerjaan', function ($query) use ($request) {
            $query->where('thn_anggaran', $request->thn_anggaran)
                ->where('sub_pekerjaan_id', $request->sub_pekerjaan_id);
        })->where('no_kontrak', $request->no_kontrak)
        ->where('badan_usaha_id', $request->badan_usaha_id)->first();

        $pdf = Pdf::loadView('dashboard.laporan.laporan', [
            'laporan' => $laporan,
        ]);

        $pdf->setPaper(array(0,0,609.4488,935.433), 'landscape');

        return $pdf->stream();
    }
}
