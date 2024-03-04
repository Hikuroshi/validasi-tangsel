<?php

namespace App\Http\Controllers;

use App\Models\BadanUsaha;
use App\Models\JenisJasa;
use App\Models\JenisPekerjaan;
use App\Models\Kecamatan;
use App\Models\Metode;
use App\Models\Pekerjaan;
use App\Models\SubPekerjaan;
use App\Models\TenagaAhli;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PekerjaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pekerjaans = Pekerjaan::latest()->with(['metode:id,nama'])->get(['slug', 'nama', 'nilai_kontrak', 'lokasi', 'sumber_dana', 'thn_anggaran', 'metode_id'])->append(['nilai_kontrak_f']);

        return view('dashboard.pekerjaan.index', [
            'title' => 'Daftar Pekerjaan',
            'pekerjaans' => $pekerjaans,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.pekerjaan.create', [
            'title' => 'Tambah Pekerjaan',
            'jenis_jasas' => JenisJasa::get(['id', 'nama']),
            'kecamatans' => Kecamatan::get(['id', 'nama']),
            'metodes' => Metode::get(['id', 'nama']),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData =  $request->validate([
            'nama' => 'required|string|max:255',
            'sub_pekerjaan_id' => 'required|exists:sub_pekerjaans,id',
            'deskripsi' => 'required|string',
            'nilai_pagu' => 'required|string|max:255',
            'nilai_kontrak' => 'required|string|max:255',
            'kecamatan_id' => 'required|exists:kecamatans,id',
            'lokasi' => 'required|string',
            'sumber_dana' => 'required|string|max:255',
            'thn_anggaran' => 'required|integer|between:1901,' . date('Y'),
            'metode_id' => 'required|exists:metodes,id',
            'jenis_kontruksi' => 'required|string',
        ]);

        $validatedData['author_id'] = $request->user()->id;

        Pekerjaan::create($validatedData);
        return redirect()->route('pekerjaan.index')->with('success', 'Pekerjaan berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pekerjaan $pekerjaan)
    {
        $pekerjaan->load([
            'kecamatan:id,nama',
            'metode:id,nama',
            'sub_pekerjaan:id,nama,jenis_pekerjaan_id',
            'sub_pekerjaan.jenis_pekerjaan:id,nama,jenis_jasa_id',
            'sub_pekerjaan.jenis_pekerjaan.jenis_jasa:id,nama',
        ]);

        return view('dashboard.pekerjaan.show', [
            'title' => 'Detail Pekerjaan',
            'pekerjaan' => $pekerjaan->append(['nilai_pagu_f', 'nilai_kontrak_f']),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pekerjaan $pekerjaan)
    {
        $pekerjaan->load([
            'kecamatan:id,nama',
            'metode:id,nama',
            'sub_pekerjaan:id,nama,jenis_pekerjaan_id',
            'sub_pekerjaan.jenis_pekerjaan:id,nama,jenis_jasa_id',
        ]);

        $jenis_pekerjaans = JenisPekerjaan::where('jenis_jasa_id', $pekerjaan->sub_pekerjaan->jenis_pekerjaan->jenis_jasa_id)->get(['id', 'nama']);
        $sub_pekerjaans = SubPekerjaan::where('jenis_pekerjaan_id', $pekerjaan->sub_pekerjaan->jenis_pekerjaan_id)->get(['id', 'nama']);

        return view('dashboard.pekerjaan.edit', [
            'title' => 'Perbarui Pekerjaan',
            'pekerjaan' => $pekerjaan,
            'jenis_jasas' => JenisJasa::get(['id', 'nama']),
            'jenis_pekerjaans' => $jenis_pekerjaans,
            'sub_pekerjaans' => $sub_pekerjaans,
            'kecamatans' => Kecamatan::get(['id', 'nama']),
            'metodes' => Metode::get(['id', 'nama']),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pekerjaan $pekerjaan)
    {
        $validatedData =  $request->validate([
            'nama' => 'required|string|max:255',
            'sub_pekerjaan_id' => 'required|exists:sub_pekerjaans,id',
            'deskripsi' => 'required|string',
            'nilai_pagu' => 'required|string|max:255',
            'nilai_kontrak' => 'required|string|max:255',
            'kecamatan_id' => 'required|exists:kecamatans,id',
            'lokasi' => 'required|string',
            'sumber_dana' => 'required|string|max:255',
            'thn_anggaran' => 'required|integer|between:1901,' . date('Y'),
            'metode_id' => 'required|exists:metodes,id',
            'jenis_kontruksi' => 'required|string',
        ]);

        $validatedData['author_id'] = $request->user()->id;

        $pekerjaan->update($validatedData);
        return redirect()->route('pekerjaan.index')->with('success', 'Pekerjaan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pekerjaan $pekerjaan)
    {
        $pekerjaan->delete();
        return redirect()->route('pekerjaan.index')->with('success', 'Pekerjaan berhasil dihapus!');
    }

    public function getJenisPekerjaan($id)
    {
        $jenisPekerjaans = JenisJasa::where('id', $id)->with(['jenis_pekerjaans:id,nama,jenis_jasa_id'])->first()->jenis_pekerjaans;
        return response()->json($jenisPekerjaans);
    }

    public function getSubPekerjaan($id)
    {
        $subPekerjaans = JenisPekerjaan::where('id', $id)->with(['sub_pekerjaans:id,nama,jenis_pekerjaan_id'])->first()->sub_pekerjaans;
        return response()->json($subPekerjaans);
    }
}
