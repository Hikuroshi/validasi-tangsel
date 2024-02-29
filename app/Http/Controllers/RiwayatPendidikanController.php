<?php

namespace App\Http\Controllers;

use App\Models\RiwayatPendidikan;
use App\Models\TenagaAhli;
use Illuminate\Http\Request;

class RiwayatPendidikanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($tenaga_ahli_id, $tenaga_ahli_nama)
    {
        return view('dashboard.riwayat-pendidikan.create', [
            'title' => 'Tambah Riwayat Pendidikan',
            'tenaga_ahli_id' => $tenaga_ahli_id,
            'tenaga_ahli_nama' => $tenaga_ahli_nama,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData =  $request->validate([
            'nama' => 'required|string|max:255',
            'jurusan' => 'required|string|max:255',
            'gelar' => 'required|string|max:255',
            'thn_masuk' => 'required|integer|between:1901,' . date('Y'),
            'thn_lulus' => 'required|integer|between:1901,' . date('Y'),
            'ijazah' => 'required|string|max:255',
            'tenaga_ahli_id' => 'required',
        ]);

        $validatedData['author_id'] = $request->user()->id;

        $tenaga_ahli_slug = TenagaAhli::select('slug')->find($request->tenaga_ahli_id);

        RiwayatPendidikan::create($validatedData);
        return redirect()->route('tenaga-ahli.show', $tenaga_ahli_slug)->with('success', 'Riwayat Pendidikan berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(RiwayatPendidikan $riwayatPendidikan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RiwayatPendidikan $riwayatPendidikan)
    {
        return view('dashboard.riwayat-pendidikan.edit', [
            'title' => 'Perbarui Riwayat Pendidikan',
            'riwayat_pendidikan' => $riwayatPendidikan,
            'tenaga_ahli_nama' => $riwayatPendidikan->tenaga_ahli->nama,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RiwayatPendidikan $riwayatPendidikan)
    {
        $rules = [
            'nama' => 'required|string|max:255',
            'jurusan' => 'required|string|max:255',
            'gelar' => 'required|string|max:255',
            'thn_masuk' => 'required|integer|between:1901,' . date('Y'),
            'thn_lulus' => 'required|integer|between:1901,' . date('Y'),
            'ijazah' => 'required|string|max:255',
        ];

        $validatedData =  $request->validate($rules);

        $validatedData['author_id'] = $request->user()->id;

        $riwayatPendidikan->update($validatedData);
        return redirect()->route('tenaga-ahli.show', $riwayatPendidikan->tenaga_ahli->slug)->with('success', 'Riwayat Pendidikan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RiwayatPendidikan $riwayatPendidikan)
    {
        $riwayatPendidikan->delete();
        return redirect()->route('tenaga-ahli.show', $riwayatPendidikan->tenaga_ahli->slug)->with('success', 'Riwayat Pendidikan berhasil dihapus!');
    }
}
