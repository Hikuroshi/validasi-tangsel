<?php

namespace App\Http\Controllers;

use App\Models\Kontrak;
use App\Models\Perusahaan;
use App\Models\TenagaAhli;
use Carbon\Carbon;
use Illuminate\Http\Request;

class KontrakController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kontraks = Kontrak::latest()->with(['perusahaan:id,nama', 'tenaga_ahlis:id,nama'])
        ->get(['id', 'slug', 'nama', 'tgl_mulai', 'tgl_selesai', 'perusahaan_id'])
        ->append(['tgl_batas', 'status_kontrak'])
        ->map(function ($kontrak) {
            $kontrak->tgl_selesai = $kontrak->tgl_selesai ?? 'Belum Selesai';
            return $kontrak;
        });

        return view('dashboard.kontrak.index', [
            'title' => 'Daftar Pekerjaan/Kontrak',
            'kontraks' => $kontraks,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.kontrak.create', [
            'title' => 'Tambah Pekerjaan/Kontrak',
            'perusahaans' => Perusahaan::get(['id', 'nama']),
            'tenaga_ahlis' => TenagaAhli::get(['id', 'nama']),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData =  $request->validate([
            'nama' => 'required|string|max:255',
            'perusahaan_id' => 'required',
            'tenaga_ahli_id' => 'required|array',
            'tgl_mulai' => 'required|date',
            'lama' => 'required|numeric|min:1',
        ]);

        $validatedData['author_id'] = $request->user()->id;

        $kontrak = Kontrak::create($validatedData);
        $kontrak->tenaga_ahlis()->attach($validatedData['tenaga_ahli_id']);

        return redirect()->route('kontrak.index')->with('success', 'Pekerjaan/Kontrak berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kontrak $kontrak)
    {
        $kontrak->with(['perusahaan:id,nama', 'tenaga_ahlis:id,nama'])
        ->get(['id', 'slug', 'nama', 'tgl_mulai', 'tgl_selesai', 'perusahaan_id'])
        ->append(['tgl_batas', 'status_kontrak'])->first();

        $kontrak->tgl_mulai = Carbon::parse($kontrak->tgl_mulai)->isoFormat('D MMMM YYYY');
        $kontrak->tgl_batas_f = Carbon::parse($kontrak->tgl_batas)->isoFormat('D MMMM YYYY');
        $kontrak->tgl_selesai = $kontrak->tgl_selesai ? Carbon::parse($kontrak->tgl_selesai) : now();

        if ($kontrak->status_kontrak == 'Direncanakan') {
            $status = 'bg-primary/10 text-primary';
        } else if ($kontrak->status_kontrak == 'Proses') {
            $status = 'bg-info/10 text-info';
        } else if ($kontrak->status_kontrak == 'Selesai') {
            $status = 'bg-success/10 text-success';
        } else if ($kontrak->status_kontrak == 'Selesai, Melewati batas waktu') {
            $status = 'bg-danger/10 text-danger';
        } else {
            $status = 'bg-danger/10 text-danger';
        }

        return view('dashboard.kontrak.show', [
            'title' => 'Detail Pekerjaan/Kontrak',
            'kontrak' => $kontrak,
            'status' => $status,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kontrak $kontrak)
    {
        return view('dashboard.kontrak.edit', [
            'title' => 'Perbarui Pekerjaan/Kontrak',
            'perusahaans' => Perusahaan::get(['id', 'nama']),
            'tenaga_ahlis' => TenagaAhli::get(['id', 'nama']),
            'kontrak' => $kontrak->with(['perusahaan:id,nama', 'tenaga_ahlis:id,nama'])->get(['id', 'slug', 'nama', 'tgl_mulai', 'lama', 'perusahaan_id'])->first(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kontrak $kontrak)
    {
        $validatedData =  $request->validate([
            'nama' => 'required|string|max:255',
            'perusahaan_id' => 'required',
            'tenaga_ahli_id' => 'required',
            'tgl_mulai' => 'required|date',
            'lama' => 'required|numeric|min:1',
        ]);

        $validatedData['author_id'] = $request->user()->id;

        $kontrak->update($validatedData);
        $kontrak->tenaga_ahlis()->sync($validatedData['tenaga_ahli_id']);

        return redirect()->route('kontrak.index')->with('success', 'Pekerjaan/Kontrak berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kontrak $kontrak)
    {
        $kontrak->tenaga_ahlis()->detach();
        $kontrak->delete();

        return redirect()->route('kontrak.index')->with('success', 'Pekerjaan/Kontrak berhasil dihapus!');
    }

    public function kontrakSelesai(Kontrak $kontrak)
    {
        $kontrak->update(['tgl_selesai' => now()->toDateString()]);
        return redirect()->route('kontrak.show', $kontrak->slug)->with('success', 'Pekerjaan/Kontrak berhasil ditandai selesai!');
    }
}
