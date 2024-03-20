<?php

namespace App\Http\Controllers;

use App\Models\Pekerjaan;
use App\Models\Perusahaan;
use App\Models\TenagaAhli;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        return view('dashboard.index', [
            'title' => 'Dashboard',
            'perusahaan' => Perusahaan::count(),
            'tenaga_ahli' => TenagaAhli::count(),
            'pekerjaan' => Pekerjaan::count(),
            'pekerjaan_berlangsung' => Pekerjaan::where('pekerjaan_selesai', false)->count(),
        ]);
    }
}
