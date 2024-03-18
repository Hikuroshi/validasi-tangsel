<?php

namespace App\Http\Controllers;

use App\Models\BadanUsaha;
use Illuminate\Http\Request;

class BadanUsahaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $badan_usahas = BadanUsaha::latest()->get(['slug', 'nama', 'sertifikat', 'direktur', 'email', 'telepon', 'status'])->append(['status_f']);

        return view('dashboard.badan-usaha.index', [
            'title' => 'Daftar Badan Usaha',
            'badan_usahas' => $badan_usahas,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.badan-usaha.create', [
            'title' => 'Tambah Badan Usaha'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData =  $request->validate([
            'nama' => 'required|string|max:255',
            'npwp' => 'required|max:21|unique:badan_usahas',
            'sertifikat' => 'required|max:21',
            'registrasi' => 'required|max:24',
            'direktur' => 'required|string|max:255',
            'alamat' => 'required|string',
            'email' => 'required|string|email|max:255|unique:badan_usahas',
            'telepon' => 'required|max:15|unique:badan_usahas',
            'no_akta' => 'required|max:24',
            'tgl_akta' => 'required|date',
            'klasifikasi' => 'required|string',
            'status' => 'required|boolean',
        ]);

        $validatedData['author_id'] = $request->user()->id;

        BadanUsaha::create($validatedData);
        return redirect()->route('badan-usaha.index')->with('success', 'Badan Usaha berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(BadanUsaha $badanUsaha)
    {
        $tenaga_ahlis = $badanUsaha->tenaga_ahlis()->get(['slug', 'nama', 'jabatan', 'email', 'telepon', 'kelamin', 'status'])->append(['kelamin_f', 'status_f']);

        session()->flash('flash_badan_usaha_id', $badanUsaha->id);
        session()->flash('flash_badan_usaha_nama', $badanUsaha->nama);

        return view('dashboard.badan-usaha.show', [
            'title' => 'Detail Badan Usaha',
            'badan_usaha' => $badanUsaha,
            'tenaga_ahlis' => $tenaga_ahlis,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BadanUsaha $badanUsaha)
    {
        return view('dashboard.badan-usaha.edit', [
            'title' => 'Perbarui Badan Usaha',
            'badan_usaha' => $badanUsaha,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BadanUsaha $badanUsaha)
    {
        $rules = [
            'nama' => 'required|string|max:255',
            'sertifikat' => 'required|max:21',
            'registrasi' => 'required|max:24',
            'direktur' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_akta' => 'required|max:24',
            'tgl_akta' => 'required|date',
            'klasifikasi' => 'required|string',
            'status' => 'required|boolean',
        ];

        if ($request->npwp != $badanUsaha->npwp) {
            $rules['npwp'] = 'required|max:16|unique:badan_usahas';
        }
        if ($request->telepon != $badanUsaha->telepon) {
            $rules['telepon'] = 'required|max:15|unique:badan_usahas';
        }
        if ($request->email != $badanUsaha->email) {
            $rules['email'] = 'required|string|email|max:255|unique:badan_usahas';
        }

        $validatedData =  $request->validate($rules);

        $validatedData['author_id'] = $request->user()->id;

        $badanUsaha->update($validatedData);
        return redirect()->route('badan-usaha.index')->with('success', 'Badan Usaha berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BadanUsaha $badanUsaha)
    {
        $badanUsaha->delete();
        return redirect()->route('badan-usaha.index')->with('success', 'Badan Usaha berhasil dihapus!');
    }
}
