<?php

namespace App\Http\Controllers;

use App\Models\BadanUsaha;
use App\Models\TenagaAhli;
use Illuminate\Http\Request;

class TenagaAhliController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tenaga_ahlis = TenagaAhli::latest()
                                    ->with(['badan_usaha:id,nama'])
                                    ->get(['slug', 'nama', 'jabatan', 'email', 'telepon', 'status', 'badan_usaha_id'])
                                    ->append(['status_f', 'kelamin_f']);

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
        session()->reflash();
        session()->keep(['flash_badan_usaha_id', 'flash_badan_usaha_nama']);

        return view('dashboard.tenaga-ahli.create', [
            'title' => 'Tambah Tenaga Ahli',
            'badan_usahas' => BadanUsaha::get(['id', 'nama']),
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
            'npwp' => 'required|numeric|max_digits:16|unique:tenaga_ahlis',
            'badan_usaha_id' => 'required|exists:badan_usahas,id',
            'jabatan' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tgl_lahir' => 'required|date',
            'alamat' => 'required|string',
            'kelamin' => 'required|boolean',
            'email' => 'required|string|email|max:255|unique:tenaga_ahlis',
            'telepon' => 'required|numeric|max_digits:13|unique:tenaga_ahlis',
            'keahlian' => 'required|string',
            'status' => 'required|boolean',
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
        $tenaga_ahli = $tenagaAhli->load(['badan_usaha:id,nama']);

        $riwayat_pendidikan = $tenagaAhli->riwayat_pendidikans()->get(['slug', 'nama', 'jurusan', 'gelar', 'thn_masuk', 'thn_lulus', 'ijazah']);
        $keahlian = $tenagaAhli->keahlians()->get(['slug', 'nama', 'no_sertifikat', 'thn_sertifikat']);

        return view('dashboard.tenaga-ahli.show', [
            'title' => 'Detail Tenaga Ahli',
            'tenaga_ahli' => $tenaga_ahli,
            'riwayat_pendidikans' => $riwayat_pendidikan,
            'keahlians' => $keahlian,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TenagaAhli $tenagaAhli)
    {
        $tenaga_ahli = $tenagaAhli->load(['badan_usaha:id,nama']);

        return view('dashboard.tenaga-ahli.edit', [
            'title' => 'Perbarui Tenaga Ahli',
            'badan_usahas' => BadanUsaha::get(['id', 'nama']),
            'tenaga_ahli' => $tenaga_ahli,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TenagaAhli $tenagaAhli)
    {
        $rules = [
            'nama' => 'required|string|max:255',
            'badan_usaha_id' => 'required|exists:badan_usahas,id',
            'jabatan' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tgl_lahir' => 'required|date',
            'alamat' => 'required|string',
            'kelamin' => 'required|boolean',
            'keahlian' => 'required|string',
            'status' => 'required|boolean',
        ];

        if ($request->nik != $tenagaAhli->nik) {
            $rules['nik'] = 'required|numeric|max_digits:16|unique:tenaga_ahlis';
        }
        if ($request->npwp != $tenagaAhli->npwp) {
            $rules['npwp'] = 'required|numeric|max_digits:16|unique:tenaga_ahlis,badan_ahlis';
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
        $tenagaAhli->pekerjaans()->detach();
        $tenagaAhli->delete();
        return redirect()->route('tenaga-ahli.index')->with('success', 'Tenaga Ahli berhasil dihapus!');
    }
}
