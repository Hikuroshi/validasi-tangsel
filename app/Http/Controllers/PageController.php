<?php

namespace App\Http\Controllers;

use App\Models\Pekerjaan;
use App\Models\Perusahaan;
use App\Models\StatusPekerjaan;
use App\Models\TenagaAhli;

class PageController extends Controller
{
    public function index()
    {
        $pekerjaan_bulan = [];
        $realisasi_bulan = [];
        $bulan_default = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Oct', 'Nov', 'Des'];

        $pekerjaan_perbulan = Pekerjaan::selectRaw('MONTH(created_at) as bulan, COUNT(*) as jumlah')
            ->groupBy('bulan')
            ->get();

        foreach ($bulan_default as $index => $bulan) {
            $pekerjaan_bulan[$bulan] = 0;
        }

        foreach ($pekerjaan_perbulan as $pekerjaan) {
            $index = $pekerjaan->bulan;
            $nama_bulan = $bulan_default[$index - 1];
            $pekerjaan_bulan[$nama_bulan] = $pekerjaan->jumlah;
        }

        $realisasi_perbulan = Pekerjaan::selectRaw('MONTH(created_at) as bulan, COUNT(*) as jumlah')
            ->where('pekerjaan_selesai', true)
            ->whereIn('status_pekerjaan_id', function ($query) {
                $query->select('id')
                    ->from('status_pekerjaans')
                    ->whereIn('nama', ['done', 'cancelled']);
            })
            ->groupBy('bulan')
            ->get();

        foreach ($bulan_default as $index => $bulan) {
            $realisasi_bulan[$bulan] = 0;
        }

        foreach ($realisasi_perbulan as $realisasi) {
            $index = $realisasi->bulan;
            $nama_bulan = $bulan_default[$index - 1];
            $realisasi_bulan[$nama_bulan] = $realisasi->jumlah;
        }

        $perusahaans = Perusahaan::all();
        $perusahaans->map(function ($perusahaan) {
            $perusahaan->jumlah = $perusahaan->pekerjaan_this_year->count();
            $perusahaan->sisa = 5 - $perusahaan->jumlah;
            return $perusahaan;
        });

        return view('dashboard.index', [
            'title' => 'Dashboard',
            'perusahaan' => Perusahaan::count(),
            'tenaga_ahli' => TenagaAhli::count(),
            'pekerjaan' => Pekerjaan::count(),
            'pekerjaan_berlangsung' => Pekerjaan::where('pekerjaan_selesai', false)->count(),
            'status_pekerjaans' => StatusPekerjaan::with(['pekerjaans:id,status_pekerjaan_id'])->get(['id', 'nama'])->append('status'),
            'pekerjaan_bulan' => array_values($pekerjaan_bulan),
            'realisasi_bulan' => array_values($realisasi_bulan),
            'perusahaans' => $perusahaans,
        ]);
    }
}
