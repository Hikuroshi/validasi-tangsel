<?php

namespace App\Http\Controllers;

use App\Models\Perusahaan;
use App\Models\TenagaAhli;
use Illuminate\Http\Request;

class TenagaAhliController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tenaga_ahlis = TenagaAhli::latest()->get(['slug', 'nama', 'nik', 'telepon', 'email', 'alamat', 'status_kontrak'])->append('status_kontrak_f');

        return view('dashboard.tenaga-ahli.index', [
            'title' => 'Daftar Tenaga Ahli',
            'tenaga_ahlis' => $tenaga_ahlis,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.tenaga-ahli.create', [
            'title' => 'Tambah Tenaga Ahli',
            'perusahaans' => Perusahaan::get(['id', 'nama']),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData =  $request->validate([
            'nama' => 'required|string|max:255',
            'nik' => 'required|numeric|max_digits:16|unique:tenaga_ahlis',
            'telepon' => 'required|numeric|max_digits:13|unique:tenaga_ahlis',
            'email' => 'required|string|email|max:255|unique:tenaga_ahlis',
            'alamat' => 'required|string',
            'perusahaan_id' => 'required',
        ]);

        $validatedData['author_id'] = $request->user()->id;

        TenagaAhli::create($validatedData);
        return redirect()->route('tenaga-ahli.index')->with('success', 'Tenaga Ahli berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(TenagaAhli $tenagaAhli)
    {
        return view('dashboard.tenaga-ahli.show', [
            'title' => 'Detail Tenaga Ahli',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TenagaAhli $tenagaAhli)
    {
        return view('dashboard.tenaga-ahli.edit', [
            'title' => 'Perbarui Tenaga Ahli',
            'perusahaans' => Perusahaan::get(['id', 'nama']),
            'tenaga_ahli' => $tenagaAhli->get(['slug', 'nama', 'alamat', 'nik', 'telepon', 'email', 'perusahaan_id'])->first(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TenagaAhli $tenagaAhli)
    {
        $rules = [
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'perusahaan_id' => 'required',
        ];

        if ($request->nik != $tenagaAhli->nik) {
            $rules['nik'] = 'required|numeric|max_digits:16|unique:tenaga_ahlis';
        }
        if ($request->telepon != $tenagaAhli->telepon) {
            $rules['telepon'] = 'required|numeric|max_digits:13|unique:tenaga_ahlis';
        }
        if ($request->email != $tenagaAhli->email) {
            $rules['email'] = 'required|string|email|max:255|unique:tenaga_ahlis';
        }

        $validatedData =  $request->validate($rules);

        $validatedData['author_id'] = $request->user()->id;

        $tenagaAhli->update($validatedData);
        return redirect()->route('tenaga-ahli.index')->with('success', 'Tenaga Ahli berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TenagaAhli $tenagaAhli)
    {
        $tenagaAhli->kontraks()->detach();
        $tenagaAhli->delete();
        return redirect()->route('tenaga-ahli.index')->with('success', 'Tenaga Ahli berhasil dihapus!');
    }
}
