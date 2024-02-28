<?php

namespace App\Http\Controllers;

use App\Models\Kontrak;
use App\Models\BadanUsaha;
use App\Models\TenagaAhli;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KontrakController extends Controller
{
    /**
    * Display a listing of the resource.
    */
    public function index()
    {
        $kontraks = Kontrak::latest()->with(['badan_usaha:id,nama', 'tenaga_ahlis:id,nama'])
        ->get(['id', 'slug', 'nama', 'tgl_mulai', 'tgl_selesai', 'lama', 'badan_usaha_id']);

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
        $badan_usahas = BadanUsaha::where('jumlah_kontrak', '<', '5')->get(['id', 'nama']);
        $tenaga_ahlis = TenagaAhli::where('status_kontrak', '1')->get(['id', 'nama']);

        return view('dashboard.kontrak.create', [
            'title' => 'Tambah Pekerjaan/Kontrak',
            'badan_usahas' => $badan_usahas,
            'tenaga_ahlis' => $tenaga_ahlis,
        ]);
    }

    /**
    * Store a newly created resource in storage.
    */
    public function store(Request $request)
    {
        $validatedData =  $request->validate([
            'nama' => 'required|string|max:255',
            'badan_usaha_id' => 'required',
            'tenaga_ahli_id' => 'required|array',
            'tgl_mulai' => 'required|date',
            'lama' => 'required|numeric|min:1',
        ]);

        $validatedData['author_id'] = $request->user()->id;

        DB::transaction(function () use ($validatedData) {
            BadanUsaha::find($validatedData['badan_usaha_id'])->increment('jumlah_kontrak');
            TenagaAhli::whereIn('id', $validatedData['tenaga_ahli_id'])->update(['status_kontrak' => 0]);

            $kontrak = Kontrak::create($validatedData);
            $kontrak->tenaga_ahlis()->attach($validatedData['tenaga_ahli_id']);
        });

        return redirect()->route('kontrak.index')->with('success', 'Pekerjaan/Kontrak berhasil disimpan');
    }

    /**
    * Display the specified resource.
    */
    public function show(Kontrak $kontrak)
    {
        $kontrak->load(['badan_usaha:id,nama', 'tenaga_ahlis:id,nama']);

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
        $badan_usahas = BadanUsaha::where('jumlah_kontrak', '<', '5')->get(['id', 'nama'])->merge([$kontrak->badan_usaha])->unique();
        $tenaga_ahlis = TenagaAhli::where('status_kontrak', '1')->get(['id', 'nama'])->merge($kontrak->tenaga_ahlis)->unique();

        return view('dashboard.kontrak.edit', [
            'title' => 'Perbarui Pekerjaan/Kontrak',
            'badan_usahas' => $badan_usahas,
            'tenaga_ahlis' => $tenaga_ahlis,
            'kontrak' => $kontrak->load(['badan_usaha:id,nama', 'tenaga_ahlis:id,nama']),
        ]);
    }

    /**
    * Update the specified resource in storage.
    */
    public function update(Request $request, Kontrak $kontrak)
    {
        $validatedData =  $request->validate([
            'nama' => 'required|string|max:255',
            'badan_usaha_id' => 'required',
            'tenaga_ahli_id' => 'required',
            'tgl_mulai' => 'required|date',
            'lama' => 'required|numeric|min:1',
        ]);

        $validatedData['author_id'] = $request->user()->id;

        DB::transaction(function () use ($validatedData, $kontrak) {
            $kontrak->badan_usaha->decrement('jumlah_kontrak');
            BadanUsaha::find($validatedData['badan_usaha_id'])->increment('jumlah_kontrak');

            TenagaAhli::whereIn('id', $kontrak->tenaga_ahlis->pluck('id'))->update(['status_kontrak' => 1]);
            TenagaAhli::whereIn('id', $validatedData['tenaga_ahli_id'])->update(['status_kontrak' => 0]);

            $kontrak->update($validatedData);
            $kontrak->tenaga_ahlis()->sync($validatedData['tenaga_ahli_id']);
        });

        return redirect()->route('kontrak.index')->with('success', 'Pekerjaan/Kontrak berhasil diperbarui!');
    }

    /**
    * Remove the specified resource from storage.
    */
    public function destroy(Kontrak $kontrak)
    {
        $kontrak->badan_usaha->decrement('jumlah_kontrak');
        $kontrak->tenaga_ahlis->pluck('id')->update(['status_kontrak' => 1]);

        $kontrak->tenaga_ahlis()->detach();
        $kontrak->delete();

        return redirect()->route('kontrak.index')->with('success', 'Pekerjaan/Kontrak berhasil dihapus!');
    }

    public function kontrakSelesai(Kontrak $kontrak)
    {
        $kontrak->badan_usaha->decrement('jumlah_kontrak');
        TenagaAhli::whereIn('id', $kontrak->tenaga_ahlis->pluck('id'))->update(['status_kontrak' => 1]);

        $kontrak->update(['tgl_selesai' => now()->toDateString()]);
        return redirect()->route('kontrak.show', $kontrak->slug)->with('success', 'Pekerjaan/Kontrak berhasil ditandai selesai!');
    }
}
