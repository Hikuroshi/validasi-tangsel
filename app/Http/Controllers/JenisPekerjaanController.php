<?php

namespace App\Http\Controllers;

use App\Models\JenisPekerjaan;
use Illuminate\Http\Request;

class JenisPekerjaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jenis_pekerjaans = JenisPekerjaan::latest()->get(['slug', 'nama', 'jenis']);

        return view('dashboard.jenis-pekerjaan.index', [
            'title' => 'Daftar Jenis Pekerjaan',
            'jenis_pekerjaans' => $jenis_pekerjaans,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jenis = ['Jasa Kontruksi', 'Jasa Konsultasi'];

        return view('dashboard.jenis-pekerjaan.create', [
            'title' => 'Tambah Jenis Pekerjaan',
            'jeniss' => $jenis,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData =  $request->validate([
            'nama' => 'required|string|max:255',
            'jenis' => 'required|string|max:255',
        ]);

        $validatedData['author_id'] = $request->user()->id;

        JenisPekerjaan::create($validatedData);
        return redirect()->route('jenis-pekerjaan.index')->with('success', 'Jenis Pekerjaan berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(JenisPekerjaan $jenisPekerjaan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JenisPekerjaan $jenisPekerjaan)
    {
        $jenis = ['Jasa Kontruksi', 'Jasa Konsultasi'];

        return view('dashboard.jenis-pekerjaan.edit', [
            'title' => 'Perbarui Jenis Pekerjaan',
            'jenis_pekerjaan' => $jenisPekerjaan->get(['slug', 'nama', 'jenis'])->first(),
            'jeniss' => $jenis,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JenisPekerjaan $jenisPekerjaan)
    {
        $rules = [
            'nama' => 'required|string|max:255',
            'jenis' => 'required|string|max:255',
        ];

        $validatedData =  $request->validate($rules);

        $validatedData['author_id'] = $request->user()->id;

        $jenisPekerjaan->update($validatedData);
        return redirect()->route('jenis-pekerjaan.index')->with('success', 'Jenis Pekerjaan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JenisPekerjaan $jenisPekerjaan)
    {
        $jenisPekerjaan->delete();
        return redirect()->route('jenis-pekerjaan.index')->with('success', 'Jenis Pekerjaan berhasil dihapus!');
    }
}
