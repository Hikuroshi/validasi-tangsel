<?php

namespace App\Http\Controllers;

use App\Imports\PerusahaansImport;
use App\Models\Perusahaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;

class PerusahaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $perusahaans = Perusahaan::latest()->get(['slug', 'nama', 'direktur', 'email', 'telepon', 'status'])->append(['status_f']);

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
            'npwp' => 'required|max:21|unique:perusahaans',
            'direktur' => 'required|string|max:255',
            'alamat' => 'required|string',
            'email' => 'nullable|string|email|max:255|unique:perusahaans',
            'telepon' => 'nullable|max:15|unique:perusahaans',
            'status' => 'required|boolean',
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
        $tenaga_ahlis = $perusahaan->tenaga_ahlis()->get(['slug', 'nama', 'jabatan', 'email', 'telepon', 'kelamin', 'status'])->append(['kelamin_f', 'status_f']);

        session()->flash('flash_perusahaan_id', $perusahaan->id);
        session()->flash('flash_perusahaan_nama', $perusahaan->nama);

        return view('dashboard.perusahaan.show', [
            'title' => 'Detail Perusahaan',
            'perusahaan' => $perusahaan,
            'tenaga_ahlis' => $tenaga_ahlis,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Perusahaan $perusahaan)
    {
        return view('dashboard.perusahaan.edit', [
            'title' => 'Perbarui Perusahaan',
            'perusahaan' => $perusahaan,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Perusahaan $perusahaan)
    {
        $rules = [
            'nama' => 'required|string|max:255',
            'direktur' => 'required|string|max:255',
            'alamat' => 'required|string',
            'status' => 'required|boolean',
        ];

        if ($request->npwp != $perusahaan->npwp) {
            $rules['npwp'] = 'required|max:16|unique:perusahaans';
        }
        if ($request->telepon != $perusahaan->telepon) {
            $rules['telepon'] = 'nullable|max:15|unique:perusahaans';
        }
        if ($request->email != $perusahaan->email) {
            $rules['email'] = 'nullable|string|email|max:255|unique:perusahaans';
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
        DB::transaction(function () use ($perusahaan) {
            $perusahaan->tenaga_ahlis()->update(['perusahaan_id' => null]);
            $perusahaan->delete();
        });

        return redirect()->route('perusahaan.index')->with('success', 'Perusahaan berhasil dihapus!');
    }

    public function import()
    {
        try {
            Excel::import(new PerusahaansImport, request()->file('perusahaan_import_file'));
            return redirect()->route('perusahaan.index')->with('success', 'Data Perusahaan berhasil diimpor!');

        } catch (ValidationException $error) {
            $failures = $error->failures();
            $errorMessages = [];

            foreach ($failures as $failure) {
                $errorMessages[] = "Baris {$failure->row()}: {$failure->errors()[0]}";
            }

            return back()->with('failedSave', implode('<br>', $errorMessages));
        }
    }
}
