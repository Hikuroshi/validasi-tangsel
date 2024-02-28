<?php

namespace App\Http\Controllers;

use App\Models\JenisPekerjaan;
use App\Models\SubPekerjaan;
use Illuminate\Http\Request;

class SubPekerjaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sub_pekerjaans = SubPekerjaan::latest()->with(['jenis_pekerjaan:id,nama'])->get(['slug', 'nama', 'jenis_pekerjaan_id']);

        return view('dashboard.sub-pekerjaan.index', [
            'title' => 'Daftar Sub Pekerjaan',
            'sub_pekerjaans' => $sub_pekerjaans,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.sub-pekerjaan.create', [
            'title' => 'Tambah Sub Pekerjaan',
            'jenis_pekerjaans' => JenisPekerjaan::get(['id', 'nama']),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData =  $request->validate([
            'nama' => 'required|string|max:255',
            'jenis_pekerjaan_id' => 'required',
        ]);

        $validatedData['author_id'] = $request->user()->id;

        SubPekerjaan::create($validatedData);
        return redirect()->route('sub-pekerjaan.index')->with('success', 'Sub Pekerjaan berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(SubPekerjaan $subPekerjaan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SubPekerjaan $subPekerjaan)
    {
        return view('dashboard.sub-pekerjaan.edit', [
            'title' => 'Perbarui Sub Pekerjaan',
            'sub_pekerjaan' => $subPekerjaan->load(['jenis_pekerjaan:id,nama']),
            'jenis_pekerjaans' => JenisPekerjaan::get(['id', 'nama']),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SubPekerjaan $subPekerjaan)
    {
        $rules = [
            'nama' => 'required|string|max:255',
            'jenis_pekerjaan_id' => 'required',
        ];

        $validatedData =  $request->validate($rules);

        $validatedData['author_id'] = $request->user()->id;

        $subPekerjaan->update($validatedData);
        return redirect()->route('sub-pekerjaan.index')->with('success', 'Sub Pekerjaan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubPekerjaan $subPekerjaan)
    {
        $subPekerjaan->delete();
        return redirect()->route('sub-pekerjaan.index')->with('success', 'Sub Pekerjaan berhasil dihapus!');
    }
}
