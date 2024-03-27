<?php

namespace App\Http\Controllers;

use App\Models\Dinasan;
use Illuminate\Http\Request;

class DinasanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dinasans = Dinasan::latest()->get(['slug', 'nama']);

        return view('dashboard.dinasan.index', [
            'title' => 'Daftar Dinas',
            'dinasans' => $dinasans,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.dinasan.create', [
            'title' => 'Tambah Dinas',
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

        if (str_contains(ucwords($request->nama), 'Dinas')) {
            $validatedData['nama'] = str_replace('Dinas', '', ucwords($request->nama));
        }

        $validatedData['author_id'] = $request->user()->id;

        Dinasan::create($validatedData);
        return redirect()->route('dinasan.index')->with('success', 'Dinas berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Dinasan $dinasan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dinasan $dinasan)
    {
        return view('dashboard.dinasan.edit', [
            'title' => 'Perbarui Dinas',
            'dinasan' => $dinasan,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Dinasan $dinasan)
    {
        $rules = [
            'nama' => 'required|string|max:255',
        ];

        $validatedData =  $request->validate($rules);

        if (str_contains(ucwords($request->nama), 'Dinas')) {
            $validatedData['nama'] = str_replace('Dinas', '', ucwords($request->nama));
        }

        $validatedData['author_id'] = $request->user()->id;

        $dinasan->update($validatedData);
        return redirect()->route('dinasan.index')->with('success', 'Dinas berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dinasan $dinasan)
    {
        $dinasan->delete();
        return redirect()->route('dinasan.index')->with('success', 'Dinas berhasil dihapus!');
    }
}
