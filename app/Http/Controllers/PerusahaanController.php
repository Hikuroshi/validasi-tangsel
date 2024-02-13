<?php

namespace App\Http\Controllers;

use App\Models\Perusahaan;
use Illuminate\Http\Request;

class PerusahaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $perusahaans = Perusahaan::latest()->get(['slug', 'nama', 'npwp', 'telepon', 'email', 'alamat', 'jumlah_kontrak']);

        return view('dashboard.perusahaan.index', [
            'title' => 'Daftar Perusahaan',
            'perusahaans' => $perusahaans,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.perusahaan.create', [
            'title' => 'Tambah Perusahaan'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData =  $request->validate([
            'nama' => 'required|string|max:255',
            'npwp' => 'required|numeric|max_digits:16|unique:perusahaans',
            'telepon' => 'required|numeric|max_digits:13|unique:perusahaans',
            'email' => 'required|string|email|max:255|unique:perusahaans',
            'alamat' => 'required|string',
        ]);

        $validatedData['author_id'] = $request->user()->id;

        Perusahaan::create($validatedData);
        return redirect()->route('perusahaan.index')->with('success', 'Perusahaan berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Perusahaan $perusahaan)
    {
        return view('dashboard.perusahaan.show', [
            'title' => 'Detail Perusahaan'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Perusahaan $perusahaan)
    {
        return view('dashboard.perusahaan.edit', [
            'title' => 'Perbarui Perusahaan',
            'perusahaan' => $perusahaan->get(['slug', 'nama', 'alamat', 'npwp', 'telepon', 'email'])->first(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Perusahaan $perusahaan)
    {
        $rules = [
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
        ];

        if ($request->npwp != $perusahaan->npwp) {
            $rules['npwp'] = 'required|numeric|max_digits:16|unique:perusahaans';
        }
        if ($request->telepon != $perusahaan->telepon) {
            $rules['telepon'] = 'required|numeric|max_digits:13|unique:perusahaans';
        }
        if ($request->email != $perusahaan->email) {
            $rules['email'] = 'required|string|email|max:255|unique:perusahaans';
        }

        $validatedData =  $request->validate($rules);

        $validatedData['author_id'] = $request->user()->id;

        $perusahaan->update($validatedData);
        return redirect()->route('perusahaan.index')->with('success', 'Perusahaan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Perusahaan $perusahaan)
    {
        $perusahaan->delete();
        return redirect()->route('perusahaan.index')->with('success', 'Perusahaan berhasil dihapus!');
    }
}
