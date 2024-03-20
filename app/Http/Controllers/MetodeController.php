<?php

namespace App\Http\Controllers;

use App\Models\Metode;
use Illuminate\Http\Request;

class MetodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $metodes = Metode::latest()->get(['slug', 'nama']);

        return view('dashboard.metode.index', [
            'title' => 'Daftar Metode',
            'metodes' => $metodes,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.metode.create', [
            'title' => 'Tambah Metode',
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

        Metode::create($validatedData);
        return redirect()->route('metode.index')->with('success', 'Metode berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Metode $metode)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Metode $metode)
    {
        return view('dashboard.metode.edit', [
            'title' => 'Perbarui Metode',
            'metode' => $metode,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Metode $metode)
    {
        $rules = [
            'nama' => 'required|string|max:255',
        ];

        $validatedData =  $request->validate($rules);

        $validatedData['author_id'] = $request->user()->id;

        $metode->update($validatedData);
        return redirect()->route('metode.index')->with('success', 'Metode berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Metode $metode)
    {
        $metode->delete();
        return redirect()->route('metode.index')->with('success', 'Metode berhasil dihapus!');
    }
}
