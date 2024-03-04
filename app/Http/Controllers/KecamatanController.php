<?php

namespace App\Http\Controllers;

use App\Models\Kecamatan;
use Illuminate\Http\Request;

class KecamatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kecamatans = Kecamatan::latest()->get(['slug', 'nama']);

        return view('dashboard.kecamatan.index', [
            'title' => 'Daftar Kecamatan',
            'kecamatans' => $kecamatans,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.kecamatan.create', [
            'title' => 'Tambah Kecamatan',
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

        Kecamatan::create($validatedData);
        return redirect()->route('kecamatan.index')->with('success', 'Kecamatan berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kecamatan $kecamatan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kecamatan $kecamatan)
    {
        return view('dashboard.kecamatan.edit', [
            'title' => 'Perbarui Kecamatan',
            'kecamatan' => $kecamatan,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kecamatan $kecamatan)
    {
        $rules = [
            'nama' => 'required|string|max:255',
        ];

        $validatedData =  $request->validate($rules);

        $validatedData['author_id'] = $request->user()->id;

        $kecamatan->update($validatedData);
        return redirect()->route('kecamatan.index')->with('success', 'Kecamatan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kecamatan $kecamatan)
    {
        $kecamatan->delete();
        return redirect()->route('kecamatan.index')->with('success', 'Kecamatan berhasil dihapus!');
    }
}
