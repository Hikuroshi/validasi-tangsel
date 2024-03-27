<?php

namespace App\Http\Controllers;

use App\Models\Perusahaan;
use App\Models\TenagaAhli;
use Illuminate\Http\Request;

class ProsesController extends Controller
{
    public function perusahaan() {
        $query = Perusahaan::has('pekerjaans');

        if (request()->has('search')) {
            $query->where('nama', 'like', '%' . request()->search . '%');
        }

        $prosess = $query->with([
            'pekerjaans:id,slug,nama,tgl_kontrak,tgl_selesai,deskripsi,thn_anggaran,perusahaan_id,status_pekerjaan_id',
            'pekerjaans.status_pekerjaan:id,nama',
            'pekerjaans.perusahaan:id,nama',
            'pekerjaans.tenaga_ahlis:id,nama'
        ])->latest()->get(['id', 'nama']);

        return view('dashboard.proses.perusahaan', [
            'title' => 'Proses Pekerjaan',
            'prosess' => $prosess,
        ]);
    }

    public function tenagaAhli() {
        $query = TenagaAhli::where('status_pekerjaan', false);

        if (request()->has('search')) {
            $query->where('nama', 'like', '%' . request()->search . '%');
        }

        $prosess = $query->with([
            'pekerjaans:id,slug,nama,tgl_kontrak,tgl_selesai,deskripsi,thn_anggaran,perusahaan_id,status_pekerjaan_id',
            'pekerjaans.status_pekerjaan:id,nama',
            'pekerjaans.perusahaan:id,nama',
        ])->latest()->get(['id', 'nama']);

        return view('dashboard.proses.tenaga-ahli', [
            'title' => 'Proses Pekerjaan',
            'prosess' => $prosess,
        ]);
    }
}
