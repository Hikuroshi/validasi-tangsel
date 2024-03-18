<?php

namespace App\Http\Controllers;

use App\Models\BadanUsaha;
use App\Models\Pekerjaan;
use App\Models\Pelaksana;
use App\Models\StatusPelaksana;
use App\Models\TenagaAhli;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PelaksanaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pelaksanas = Pelaksana::latest()->with(['badan_usaha:id,nama', 'pekerjaan:id,nama', 'status_pelaksanas'])
                                    ->get(['id', 'slug', 'badan_usaha_id', 'pekerjaan_id', 'no_kontrak', 'tgl_kontrak'])
                                    ->append(['status_pelaksana_f']);

        return view('dashboard.pelaksana.index', [
            'title' => 'Daftar Pelaksana',
            'pelaksanas' => $pelaksanas,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $status = [
            'request' => 'Request',
            'on_progress' => 'On Progress',
            'reporting' => 'Reporting',
            'done' => 'Done',
            'pending' => 'Pending',
            'cancelled' => 'Cancelled'
        ];

        return view('dashboard.pelaksana.create', [
            'title' => 'Tambah Pelaksana',
            'pekerjaans' => Pekerjaan::get(['id', 'nama']),
            'badan_usahas' => BadanUsaha::get(['id', 'nama']),
            'tenaga_ahlis' => TenagaAhli::get(['id', 'nama']),
            'status_pelaksanas' => $status,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData =  $request->validate([
            'badan_usaha_id' => 'required|exists:badan_usahas,id',
            'tenaga_ahli_id' => 'required|array|exists:tenaga_ahlis,id',
            'pekerjaan_id' => 'required|exists:pekerjaans,id',
            'no_kontrak' => 'required|max:255',
            'tgl_kontrak' => 'required|date',
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'required|date',
            'ppk' => 'required|string|max:255',
            'pptk' => 'required|string|max:255',
            'pho' => 'required|string|max:255',
            'status_pelaksana' => 'required',
        ]);

        $validatedData['author_id'] = $request->user()->id;

        $badan_usaha = BadanUsaha::where('id', $request->badan_usaha_id)->where('jumlah_pekerjaan', '>', '5')->first(['nama']);
        $tenaga_ahlis = TenagaAhli::whereIn('id', $request->tenaga_ahli_id)->where('status_pekerjaan', 0)->pluck('nama')->toArray();

        if ($badan_usaha) {
            return redirect()->back()->withInput()->with('badan_usaha_full', $badan_usaha->nama . ' sudah mencapai batas maksimal pekerjaan.');
        }
        if ($tenaga_ahlis) {
            return redirect()->back()->withInput()->with('tenaga_ahli_full', implode(', ', $tenaga_ahlis) . ' sedang melakukan pekerjaan.');
        }

        DB::transaction(function () use ($request, $validatedData) {
            BadanUsaha::find($validatedData['badan_usaha_id'])->increment('jumlah_pekerjaan');
            TenagaAhli::whereIn('id', $validatedData['tenaga_ahli_id'])->update(['status_pekerjaan' => 0]);

            $pelaksana = Pelaksana::create($validatedData);

            StatusPelaksana::create([
                'pelaksana_id' => $pelaksana->id,
                $validatedData['status_pelaksana'] => true,
                'author_id' => $request->user()->id,
            ]);
            $pelaksana->tenaga_ahlis()->attach($validatedData['tenaga_ahli_id']);
        });

        return redirect()->route('pelaksana.index')->with('success', 'Pelaksana berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pelaksana $pelaksana)
    {
        $status = [
            'request' => 'Request',
            'on_progress' => 'On Progress',
            'reporting' => 'Reporting',
            'done' => 'Done',
            'pending' => 'Pending',
            'cancelled' => 'Cancelled'
        ];

        $pelaksana->load(['badan_usaha:id,nama', 'pekerjaan', 'status_pelaksanas', 'status_pelaksanas.author'])->append(['tgl_kontrak_f', 'tgl_mulai_f', 'tgl_selesai_f', 'status_pelaksana_f', 'progress_pelaksana']);

        return view('dashboard.pelaksana.show', [
            'title' => 'Detail Pelaksana',
            'pelaksana' => $pelaksana,
            'tenaga_ahlis' => $pelaksana->tenaga_ahlis()->get(['slug', 'nama', 'jabatan', 'status'])->append(['status_f']),
            'add_tenaga_ahlis' => TenagaAhli::get(['id', 'nama']),
            'status_pelaksanas' => $status,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pelaksana $pelaksana)
    {
        $status = [
            'request' => 'Request',
            'on_progress' => 'On Progress',
            'reporting' => 'Reporting',
            'done' => 'Done',
            'pending' => 'Pending',
            'cancelled' => 'Cancelled'
        ];

        $selected_tenaga_ahlis = $pelaksana->tenaga_ahlis->pluck('id');

        return view('dashboard.pelaksana.edit', [
            'title' => 'Perbarui Pelaksana',
            'pelaksana' => $pelaksana->load(['badan_usaha:id,nama', 'tenaga_ahlis:id,nama', 'pekerjaan:id,nama']),
            'badan_usahas' => BadanUsaha::get(['id', 'nama']),
            'tenaga_ahlis' => TenagaAhli::get(['id', 'nama']),
            'selected_tenaga_ahlis' => $selected_tenaga_ahlis,
            'status_pelaksanas' => $status,
            'pekerjaans' => Pekerjaan::get(['id', 'nama']),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pelaksana $pelaksana)
    {
        $validatedData =  $request->validate([
            'badan_usaha_id' => 'required|exists:badan_usahas,id',
            'tenaga_ahli_id' => 'required|array|exists:tenaga_ahlis,id',
            'pekerjaan_id' => 'required|exists:pekerjaans,id',
            'no_kontrak' => 'required|max:255',
            'tgl_kontrak' => 'required|date',
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'required|date',
            'ppk' => 'required|string|max:255',
            'pptk' => 'required|string|max:255',
            'pho' => 'required|string|max:255',
            'status_pelaksana' => 'required',
        ]);

        $validatedData['author_id'] = $request->user()->id;

        $badan_usaha = BadanUsaha::where('id', $request->badan_usaha_id)
            ->where('jumlah_pekerjaan', '>', 5)
            ->whereNotIn('id', [$pelaksana->badan_usaha_id])
            ->first(['nama']);

        $tenaga_ahlis = TenagaAhli::whereIn('id', $request->tenaga_ahli_id)
            ->where('status_pekerjaan', 0)
            ->whereNotIn('id', $pelaksana->tenaga_ahlis->pluck('id')->toArray())
            ->pluck('nama')
            ->toArray();

        if ($badan_usaha) {
            return redirect()->back()->withInput()->with('badan_usaha_full', $badan_usaha->nama . ' sudah mencapai batas maksimal pekerjaan.');
        }
        if ($tenaga_ahlis) {
            return redirect()->back()->withInput()->with('tenaga_ahli_full', implode(', ', $tenaga_ahlis) . ' sedang melakukan pekerjaan.');
        }

        DB::transaction(function () use ($request, $validatedData, $pelaksana) {
            $pelaksana->badan_usaha->decrement('jumlah_pekerjaan');
            BadanUsaha::find($validatedData['badan_usaha_id'])->increment('jumlah_pekerjaan');

            TenagaAhli::whereIn('id', $pelaksana->tenaga_ahlis->pluck('id'))->update(['status_pekerjaan' => 1]);
            TenagaAhli::whereIn('id', $validatedData['tenaga_ahli_id'])->update(['status_pekerjaan' => 0]);

            $pelaksana->update($validatedData);

            StatusPelaksana::create([
                'pelaksana_id' => $pelaksana->id,
                $validatedData['status_pelaksana'] => true,
                'author_id' => $request->user()->id,
            ]);

            $pelaksana->tenaga_ahlis()->sync($validatedData['tenaga_ahli_id']);
        });

        return redirect()->route('pelaksana.index')->with('success', 'Pelaksana berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pelaksana $pelaksana)
    {
        $pelaksana->badan_usaha->decrement('jumlah_pekerjaan');
        TenagaAhli::whereIn('id', $pelaksana->tenaga_ahlis->pluck('id'))->update(['status_pekerjaan' => 1]);

        $pelaksana->tenaga_ahlis()->detach();
        $pelaksana->delete();

        return redirect()->route('pelaksana.index')->with('success', 'Pelaksana berhasil dihapus!');
    }

    public function addTenagaAhli(Request $request, Pelaksana $pelaksana)
    {
        $validatedData =  $request->validate([
            'tenaga_ahli_id' => 'required|array|exists:tenaga_ahlis,id',
        ]);

        $tenaga_ahlis = TenagaAhli::whereIn('id', $request->tenaga_ahli_id)
            ->where('status_pekerjaan', 0)
            ->pluck('nama')
            ->toArray();

        if ($tenaga_ahlis) {
            return redirect()->back()->with('tenaga_ahli_full', implode(', ', $tenaga_ahlis) . ' sedang melakukan pekerjaan.');
        }

        $pelaksana->tenaga_ahlis()->attach($validatedData['tenaga_ahli_id']);
        return redirect()->back()->with('success', 'Tenaga ahli berhasil ditambahkan ke pelaksana pekerjaan!');
    }

    public function deleteTenagaAhli(Pelaksana $pelaksana, TenagaAhli $tenagaAhli)
    {
        TenagaAhli::where('id', $tenagaAhli->id)->update(['status_pekerjaan' => 1]);
        $pelaksana->tenaga_ahlis()->detach($tenagaAhli->id);
        return redirect()->back()->with('success', 'Tenaga ahli berhasil dihapus dari pelaksana pekerjaan!');
    }

    // public function pekerjaanSelesai(Pelaksana $pelaksana)
    // {
    //     $pelaksana->badan_usaha->decrement('jumlah_pekerjaan');
    //     TenagaAhli::whereIn('id', $pelaksana->tenaga_ahlis->pluck('id'))->update(['status_pekerjaan' => 1]);

    //     $pelaksana->update(['tgl_selesai' => now()->toDateString()]);
    //     return redirect()->route('pelaksana.show', $pelaksana->slug)->with('success', 'Pelaksana berhasil ditandai selesai!');
    // }
}
