<?php

namespace App\Http\Controllers;

use App\Models\StatusPekerjaan;
use Illuminate\Http\Request;

class StatusPekerjaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jenis_pekerjaans = StatusPekerjaan::latest()->get(['slug', 'nama']);

        return view('dashboard.status-pekerjaan.index', [
            'title' => 'Daftar Jenis Pekerjaan',
            'status_pekerjaans' => $jenis_pekerjaans,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.status-pekerjaan.create', [
            'title' => 'Tambah Jenis Pekerjaan',
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

        StatusPekerjaan::create($validatedData);
        return redirect()->route('status-pekerjaan.index')->with('success', 'Jenis Pekerjaan berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(StatusPekerjaan $statusPekerjaan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StatusPekerjaan $statusPekerjaan)
    {
        return view('dashboard.status-pekerjaan.edit', [
            'title' => 'Perbarui Jenis Pekerjaan',
            'status_pekerjaan' => $statusPekerjaan,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StatusPekerjaan $statusPekerjaan)
    {
        $rules = [
            'nama' => 'required|string|max:255',
        ];

        $validatedData =  $request->validate($rules);

        $validatedData['author_id'] = $request->user()->id;

        $statusPekerjaan->update($validatedData);
        return redirect()->route('status-pekerjaan.index')->with('success', 'Jenis Pekerjaan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StatusPekerjaan $statusPekerjaan)
    {
        $statusPekerjaan->delete();
        return redirect()->route('status-pekerjaan.index')->with('success', 'Jenis Pekerjaan berhasil dihapus!');
    }
}
