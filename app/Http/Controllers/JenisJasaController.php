<?php

namespace App\Http\Controllers;

use App\Models\JenisJasa;
use Illuminate\Http\Request;

class JenisJasaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jenis_jasas = JenisJasa::latest()->get(['slug', 'nama']);

        return view('dashboard.jenis-jasa.index', [
            'title' => 'Daftar Jenis Jasa',
            'jenis_jasas' => $jenis_jasas,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.jenis-jasa.create', [
            'title' => 'Tambah Jenis Jasa',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData =  $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        $validatedData['author_id'] = $request->user()->id;

        JenisJasa::create($validatedData);
        return redirect()->route('jenis-jasa.index')->with('success', 'Jenis Jasa berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(JenisJasa $jenisJasa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JenisJasa $jenisJasa)
    {
        return view('dashboard.jenis-jasa.edit', [
            'title' => 'Perbarui Jenis Jasa',
            'jenis_jasa' => $jenisJasa,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JenisJasa $jenisJasa)
    {
        $rules = [
            'nama' => 'required|string|max:255',
        ];

        $validatedData =  $request->validate($rules);

        $validatedData['author_id'] = $request->user()->id;

        $jenisJasa->update($validatedData);
        return redirect()->route('jenis-jasa.index')->with('success', 'Jenis Jasa berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JenisJasa $jenisJasa)
    {
        $jenisJasa->delete();
        return redirect()->route('jenis-jasa.index')->with('success', 'Jenis Jasa berhasil dihapus!');
    }
}
