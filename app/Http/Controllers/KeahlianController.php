<?php

namespace App\Http\Controllers;

use App\Models\Keahlian;
use App\Models\TenagaAhli;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KeahlianController extends Controller
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
        return view('dashboard.keahlian.create', [
            'title' => 'Tambah Keahlian',
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
            'no_sertifikat' => 'required|string|max:255',
            'thn_sertifikat' => 'required|integer|between:1901,' . date('Y'),
            'file_sertifikat' => 'required|mimes:pdf|file|max:5000',
            'tenaga_ahli_id' => 'required|exists:tenaga_ahlis,id',
        ]);

        if ($request->file('file_sertifikat')) {
            $validatedData['file_sertifikat'] = $request->file('file_sertifikat')->store('file-sertifikat');
        }

        $validatedData['author_id'] = $request->user()->id;

        $tenaga_ahli_slug = TenagaAhli::where('id', $request->tenaga_ahli_id)->value('slug');

        Keahlian::create($validatedData);
        return redirect()->route('tenaga-ahli.show', $tenaga_ahli_slug)->with('success', 'Keahlian berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Keahlian $keahlian)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Keahlian $keahlian)
    {
        return view('dashboard.keahlian.edit', [
            'title' => 'Perbarui Keahlian',
            'keahlian' => $keahlian,
            'tenaga_ahli_nama' => $keahlian->tenaga_ahli->nama,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Keahlian $keahlian)
    {
        $rules = [
            'nama' => 'required|string|max:255',
            'no_sertifikat' => 'required|string|max:255',
            'thn_sertifikat' => 'required|date',
            'file_sertifikat' => 'nullable|mimes:pdf|file|max:5000',
        ];

        $validatedData =  $request->validate($rules);

        if ($request->file('file_sertifikat')) {
            if($request->old_file_sertifikat){
                Storage::delete($request->old_file_sertifikat);
            }
            $validatedData['file_sertifikat'] = $request->file('file_sertifikat')->store('file-sertifikat');
        }

        $validatedData['author_id'] = $request->user()->id;

        $keahlian->update($validatedData);
        return redirect()->route('tenaga-ahli.show', $keahlian->tenaga_ahli->slug)->with('success', 'Keahlian berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Keahlian $keahlian)
    {
        if($keahlian->file_sertifikat){
            Storage::delete($keahlian->file_sertifikat);
        }

        $keahlian->delete();
        return redirect()->route('tenaga-ahli.show', $keahlian->tenaga_ahli->slug)->with('success', 'Keahlian berhasil dihapus!');
    }

    public function viewSertifikat($slug) {
        $keahlian = Keahlian::where('slug', $slug)->first(['file_sertifikat'])->append('file_sertifikat_f');

        return view('dashboard.keahlian.sertifikat', [
            'title' => 'Lihat Sertifikat',
            'sertifikat' => $keahlian->file_sertifikat_f,
        ]);
    }
}
