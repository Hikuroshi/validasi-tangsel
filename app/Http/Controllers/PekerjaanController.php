<?php

namespace App\Http\Controllers;

use App\Models\Bidang;
use App\Models\Metode;
use App\Models\Perusahaan;
use App\Models\JenisPekerjaan;
use App\Models\Pekerjaan;
use App\Models\StatusPekerjaan;
use App\Models\TenagaAhli;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PekerjaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pekerjaans = Pekerjaan::latest()->with(['perusahaan:id,nama', 'status_pekerjaan:id,nama', 'bidang:id,nama'])
                                    ->get(['id', 'slug', 'nama', 'no_kontrak', 'tgl_kontrak', 'perusahaan_id', 'status_pekerjaan_id', 'bidang_id']);

        return view('dashboard.pekerjaan.index', [
            'title' => 'Daftar Pekerjaan',
            'pekerjaans' => $pekerjaans,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sumber_dana = ['APBD', 'APBD-P', 'APBN'];

        $bidangs = auth()->user()->dinasan_id
        ? Bidang::where('dinasan_id', auth()->user()->dinasan_id)->get(['id', 'nama'])
        : Bidang::get(['id', 'nama']);

        return view('dashboard.pekerjaan.create', [
            'title' => 'Tambah Pekerjaan',
            'perusahaans' => Perusahaan::get(['id', 'nama']),
            'tenaga_ahlis' => TenagaAhli::where('perusahaan_id', null)->get(['id', 'nama']),
            'jenis_pekerjaans' => JenisPekerjaan::get(['id', 'nama']),
            'status_pekerjaans' => StatusPekerjaan::get(['id', 'nama']),
            'metodes' => Metode::get(['id', 'nama']),
            'bidangs' => $bidangs,
            'sumber_danas' => $sumber_dana,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData =  $request->validate([
            'nama' => 'required|string|max:255',
            'bidang_id' => 'required|exists:bidangs,id',
            'perusahaan_id' => 'required|exists:perusahaans,id',
            'tenaga_ahli_id' => 'required|array|exists:tenaga_ahlis,id',
            'no_kontrak' => 'required|max:255',
            'tgl_kontrak' => 'required|date',
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'required|date',
            'ppk' => 'required|string|max:255',
            'pptk' => 'required|string|max:255',
            'jenis_pekerjaan_id' => 'required|exists:jenis_pekerjaans,id',
            'deskripsi' => 'required|string',
            'nilai_pagu' => 'required|string|max:255',
            'nilai_kontrak' => 'required|string|max:255',
            'lokasi' => 'required|string',
            'sumber_dana' => 'required|string|max:255',
            'thn_anggaran' => 'required|integer|between:1901,' . date('Y'),
            'metode_id' => 'required|exists:metodes,id',
            'jenis_kontruksi' => 'required|string|max:255',
            'status_pekerjaan_id' => 'required|exists:status_pekerjaans,id',
        ]);

        $validatedData['author_id'] = $request->user()->id;

        $perusahaan = Perusahaan::where('id', $request->perusahaan_id)->first();
        $tenaga_ahlis = TenagaAhli::whereIn('id', $request->tenaga_ahli_id)->where('status_pekerjaan', 0)->pluck('nama')->toArray();

        if ($perusahaan->pekerjaan_this_year->count() >= 5) {
            return redirect()->back()->withInput()->with('perusahaan_full', $perusahaan->nama . ' sudah mencapai batas maksimal 5 pekerjaan.');
        }
        if ($tenaga_ahlis) {
            return redirect()->back()->withInput()->with('tenaga_ahli_full', implode(', ', $tenaga_ahlis) . ' sedang melakukan pekerjaan.');
        }

        DB::transaction(function () use ($validatedData) {
            TenagaAhli::whereIn('id', $validatedData['tenaga_ahli_id'])->update(['status_pekerjaan' => 0]);

            $pekerjaan = Pekerjaan::create($validatedData);
            $pekerjaan->tenaga_ahlis()->attach($validatedData['tenaga_ahli_id']);
        });

        return redirect()->route('pekerjaan.index')->with('success', 'Pekerjaan berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pekerjaan $pekerjaan)
    {
        $pekerjaan->load(['perusahaan:id,nama', 'status_pekerjaan', 'status_pekerjaan.author:id,name'])
        ->append(['tgl_kontrak_f', 'tgl_mulai_f', 'tgl_selesai_f', 'progress_pekerjaan']);

        return view('dashboard.pekerjaan.show', [
            'title' => 'Detail Pekerjaan',
            'pekerjaan' => $pekerjaan,
            'tenaga_ahlis' => $pekerjaan->tenaga_ahlis()->get(['slug', 'nama', 'jabatan', 'status'])->append(['status_f']),
            'status_pekerjaans' => StatusPekerjaan::get(['id', 'nama']),
            'add_tenaga_ahlis' => TenagaAhli::get(['id', 'nama']),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pekerjaan $pekerjaan)
    {
        $sumber_dana = ['APBD', 'APBD-P', 'APBN'];

        $bidangs = auth()->user()->dinasan_id
        ? Bidang::where('dinasan_id', auth()->user()->dinasan_id)->get(['id', 'nama'])
        : Bidang::get(['id', 'nama']);

        $selected_tenaga_ahlis = $pekerjaan->tenaga_ahlis->pluck('id');

        return view('dashboard.pekerjaan.edit', [
            'title' => 'Perbarui Pekerjaan',
            'pekerjaan' => $pekerjaan->load(['perusahaan:id,nama', 'tenaga_ahlis:id,nama']),
            'perusahaans' => Perusahaan::get(['id', 'nama']),
            'tenaga_ahlis' => TenagaAhli::get(['id', 'nama']),
            'jenis_pekerjaans' => JenisPekerjaan::get(['id', 'nama']),
            'status_pekerjaans' => StatusPekerjaan::get(['id', 'nama']),
            'metodes' => Metode::get(['id', 'nama']),
            'bidangs' => $bidangs,
            'selected_tenaga_ahlis' => $selected_tenaga_ahlis,
            'sumber_danas' => $sumber_dana,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pekerjaan $pekerjaan)
    {
        if ($pekerjaan->pekerjaan_selesai == true){
            return redirect()->route('pekerjaan.show', $pekerjaan->slug)->with('dataSelesai', 'Data yang sudah ditandai Selesai tidak dapat diubah.');
        }

        $validatedData =  $request->validate([
            'nama' => 'required|string|max:255',
            'bidang_id' => 'required|exists:bidangs,id',
            'perusahaan_id' => 'required|exists:perusahaans,id',
            'tenaga_ahli_id' => 'required|array|exists:tenaga_ahlis,id',
            'no_kontrak' => 'required|max:255',
            'tgl_kontrak' => 'required|date',
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'required|date',
            'ppk' => 'required|string|max:255',
            'pptk' => 'required|string|max:255',
            'jenis_pekerjaan_id' => 'required|exists:jenis_pekerjaans,id',
            'deskripsi' => 'required|string',
            'nilai_pagu' => 'required|string|max:255',
            'nilai_kontrak' => 'required|string|max:255',
            'lokasi' => 'required|string',
            'sumber_dana' => 'required|string|max:255',
            'thn_anggaran' => 'required|integer|between:1901,' . date('Y'),
            'metode_id' => 'required|exists:metodes,id',
            'jenis_kontruksi' => 'required|string|max:255',
            'status_pekerjaan_id' => 'required|exists:status_pekerjaans,id',
        ]);

        $validatedData['author_id'] = $request->user()->id;

        $perusahaan = Perusahaan::where('id', $request->perusahaan_id)->first();
        $tenaga_ahlis = TenagaAhli::whereIn('id', $request->tenaga_ahli_id)
            ->where('status_pekerjaan', 0)
            ->whereNotIn('id', $pekerjaan->tenaga_ahlis->pluck('id')->toArray())
            ->pluck('nama')
            ->toArray();

        if ($perusahaan && $perusahaan->pekerjaan_this_year->whereNotIn('id', [$pekerjaan->perusahaan_id])->count() >= 5) {
            return redirect()->back()->withInput()->with('perusahaan_full', $perusahaan->nama . ' sudah mencapai batas maksimal 5 pekerjaan.');
        }
        if ($tenaga_ahlis) {
            return redirect()->back()->withInput()->with('tenaga_ahli_full', implode(', ', $tenaga_ahlis) . ' sedang melakukan pekerjaan.');
        }

        DB::transaction(function () use ($validatedData, $pekerjaan) {
            TenagaAhli::whereIn('id', $pekerjaan->tenaga_ahlis->pluck('id'))->update(['status_pekerjaan' => 1]);
            TenagaAhli::whereIn('id', $validatedData['tenaga_ahli_id'])->update(['status_pekerjaan' => 0]);

            $pekerjaan->update($validatedData);
            $pekerjaan->tenaga_ahlis()->sync($validatedData['tenaga_ahli_id']);
        });

        return redirect()->route('pekerjaan.index')->with('success', 'Pekerjaan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pekerjaan $pekerjaan)
    {
        DB::transaction(function () use ($pekerjaan) {
            TenagaAhli::whereIn('id', $pekerjaan->tenaga_ahlis->pluck('id'))->update(['status_pekerjaan' => 1]);

            $pekerjaan->tenaga_ahlis()->detach();
            $pekerjaan->delete();
        });

        return redirect()->route('pekerjaan.index')->with('success', 'Pekerjaan berhasil dihapus!');
    }

    public function getTenagaAhli($perusahaanId = null)
    {
        if ($perusahaanId) {
            $tenagaAhlis = TenagaAhli::where('perusahaan_id', $perusahaanId)->get(['id', 'nama']);
        } else {
            $tenagaAhlis = TenagaAhli::whereNull('perusahaan_id')->get(['id', 'nama']);
        }

        return response()->json($tenagaAhlis);
    }

    public function addTenagaAhli(Request $request, Pekerjaan $pekerjaan)
    {
        if ($pekerjaan->pekerjaan_selesai == true){
            return redirect()->back()->with('dataSelesai', 'Data yang sudah ditandai Selesai tidak dapat diubah.');
        }

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

        DB::transaction(function () use ($validatedData, $pekerjaan) {
            TenagaAhli::whereIn('id', $validatedData['tenaga_ahli_id'])->update(['status_pekerjaan' => 0]);
            $pekerjaan->tenaga_ahlis()->attach($validatedData['tenaga_ahli_id']);
        });

        return redirect()->back()->with('success', 'Tenaga ahli berhasil ditambahkan ke pekerjaan pekerjaan!');
    }

    public function deleteTenagaAhli(Pekerjaan $pekerjaan, TenagaAhli $tenagaAhli)
    {
        if ($pekerjaan->pekerjaan_selesai == true){
            return redirect()->back()->with('dataSelesai', 'Data yang sudah ditandai Selesai tidak dapat diubah.');
        }

        DB::transaction(function () use ($pekerjaan, $tenagaAhli) {
            TenagaAhli::where('id', $tenagaAhli->id)->update(['status_pekerjaan' => 1]);
            $pekerjaan->tenaga_ahlis()->detach($tenagaAhli->id);
        });
        return redirect()->back()->with('success', 'Tenaga ahli berhasil dihapus dari pekerjaan pekerjaan!');
    }

    public function changeStatus(Request $request, Pekerjaan $pekerjaan)
    {
        if ($pekerjaan->pekerjaan_selesai == true){
            return redirect()->back()->with('dataSelesai', 'Data yang sudah ditandai Selesai tidak dapat diubah.');
        }

        $validatedData = $request->validate([
            'status_pekerjaan_id' => 'required|exists:status_pekerjaans,id',
            'pekerjaan_selesai' => 'required|boolean'
        ]);

        DB::transaction(function () use ($request, $validatedData, $pekerjaan) {
            if ($request->pekerjaan_selesai == true) {
                TenagaAhli::whereIn('id', $pekerjaan->tenaga_ahlis->pluck('id'))->update(['status_pekerjaan' => 1]);
            }
            $pekerjaan->update($validatedData);
        });

        return redirect()->back()->with('success', 'Status berhasil diperbarui');
    }
}
