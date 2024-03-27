<?php

namespace App\Http\Controllers;

use App\Models\Bidang;
use App\Models\Dinasan;
use Illuminate\Http\Request;

class BidangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bidangs = Bidang::latest()->with(['dinasan:id,nama'])->get(['slug', 'nama', 'dinasan_id']);

        return view('dashboard.bidang.index', [
            'title' => 'Daftar Bidang',
            'bidangs' => $bidangs,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.bidang.create', [
            'title' => 'Tambah Bidang',
            'dinasans' => Dinasan::get(['id', 'nama']),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData =  $request->validate([
            'nama' => 'required|string|max:255',
            'dinasan_id' => 'required|exists:dinasans,id'
        ]);

        if (str_contains(ucwords($request->nama), 'Bidang')) {
            $validatedData['nama'] = str_replace('Bidang', '', ucwords($request->nama));
        }

        $validatedData['author_id'] = $request->user()->id;

        Bidang::create($validatedData);
        return redirect()->route('bidang.index')->with('success', 'Bidang berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Bidang $bidang)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bidang $bidang)
    {
        return view('dashboard.bidang.edit', [
            'title' => 'Perbarui Bidang',
            'bidang' => $bidang,
            'dinasans' => Dinasan::get(['id', 'nama']),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bidang $bidang)
    {
        $rules = [
            'nama' => 'required|string|max:255',
            'dinasan_id' => 'required|exists:dinasans,id'
        ];

        $validatedData =  $request->validate($rules);

        if (str_contains(ucwords($request->nama), 'Bidang')) {
            $validatedData['nama'] = str_replace('Bidang', '', ucwords($request->nama));
        }

        $validatedData['author_id'] = $request->user()->id;

        $bidang->update($validatedData);
        return redirect()->route('bidang.index')->with('success', 'Bidang berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bidang $bidang)
    {
        $bidang->delete();
        return redirect()->route('bidang.index')->with('success', 'Bidang berhasil dihapus!');
    }
}
