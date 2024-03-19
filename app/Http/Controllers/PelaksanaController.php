<?php

namespace App\Http\Controllers;

use App\Models\Perusahaan;
use App\Models\JenisJasa;
use App\Models\JenisPekerjaan;
use App\Models\Pelaksana;
use App\Models\StatusPelaksana;
use App\Models\SubPekerjaan;
use App\Models\TenagaAhli;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PelaksanaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pelaksanas = Pelaksana::latest()->with(['perusahaan:id,nama', 'status_pelaksanas'])
                                    ->get(['id', 'slug', 'nama', 'perusahaan_id', 'no_kontrak', 'tgl_kontrak'])
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

        $metode = ['Tender', 'Penunjukan Langsung'];
        $sumber_dana = ['APBD', 'APBD-P', 'APBN'];

        return view('dashboard.pelaksana.create', [
            'title' => 'Tambah Pelaksana',
            'perusahaans' => Perusahaan::get(['id', 'nama']),
            'tenaga_ahlis' => TenagaAhli::get(['id', 'nama']),
            'jenis_jasas' => JenisJasa::get(['id', 'nama']),
            'status_pelaksanas' => $status,
            'metodes' => $metode,
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
            'perusahaan_id' => 'required|exists:perusahaans,id',
            'tenaga_ahli_id' => 'required|array|exists:tenaga_ahlis,id',
            'no_kontrak' => 'required|max:255',
            'tgl_kontrak' => 'required|date',
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'required|date',
            'ppk' => 'required|string|max:255',
            'pptk' => 'required|string|max:255',
            'pho' => 'required|string|max:255',
            'status_pelaksana' => 'required',
            'sub_pekerjaan_id' => 'required|exists:sub_pekerjaans,id',
            'deskripsi' => 'required|string',
            'nilai_pagu' => 'required|string|max:255',
            'nilai_kontrak' => 'required|string|max:255',
            'lokasi' => 'required|string',
            'sumber_dana' => 'required|string|max:255',
            'thn_anggaran' => 'required|integer|between:1901,' . date('Y'),
            'metode' => 'required|string|max:255',
            'jenis_kontruksi' => 'required|string|max:255',
        ]);

        $validatedData['author_id'] = $request->user()->id;

        $perusahaan = Perusahaan::where('id', $request->perusahaan_id)->where('jumlah_pekerjaan', '>', '5')->first(['nama']);
        $tenaga_ahlis = TenagaAhli::whereIn('id', $request->tenaga_ahli_id)->where('status_pekerjaan', 0)->pluck('nama')->toArray();

        if ($perusahaan) {
            return redirect()->back()->withInput()->with('perusahaan_full', $perusahaan->nama . ' sudah mencapai batas maksimal pekerjaan.');
        }
        if ($tenaga_ahlis) {
            return redirect()->back()->withInput()->with('tenaga_ahli_full', implode(', ', $tenaga_ahlis) . ' sedang melakukan pekerjaan.');
        }

        DB::transaction(function () use ($request, $validatedData) {
            Perusahaan::find($validatedData['perusahaan_id'])->increment('jumlah_pekerjaan');
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

        $pelaksana->load(['perusahaan:id,nama', 'pekerjaan', 'status_pelaksanas', 'status_pelaksanas.author'])->append(['tgl_kontrak_f', 'tgl_mulai_f', 'tgl_selesai_f', 'status_pelaksana_f', 'progress_pelaksana']);

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

        $metode = ['Tender', 'Penunjukan Langsung'];
        $sumber_dana = ['APBD', 'APBD-P', 'APBN'];

        $selected_tenaga_ahlis = $pelaksana->tenaga_ahlis->pluck('id');

        $jenis_pekerjaans = JenisPekerjaan::where('jenis_jasa_id', $pelaksana->sub_pekerjaan->jenis_pekerjaan->jenis_jasa_id)->get(['id', 'nama']);
        $sub_pekerjaans = SubPekerjaan::where('jenis_pekerjaan_id', $pelaksana->sub_pekerjaan->jenis_pekerjaan_id)->get(['id', 'nama']);

        return view('dashboard.pelaksana.edit', [
            'title' => 'Perbarui Pelaksana',
            'pelaksana' => $pelaksana->load(['perusahaan:id,nama', 'tenaga_ahlis:id,nama']),
            'perusahaans' => Perusahaan::get(['id', 'nama']),
            'tenaga_ahlis' => TenagaAhli::get(['id', 'nama']),
            'jenis_jasas' => JenisJasa::get(['id', 'nama']),
            'selected_tenaga_ahlis' => $selected_tenaga_ahlis,
            'status_pelaksanas' => $status,
            'metodes' => $metode,
            'sumber_danas' => $sumber_dana,
            'jenis_pekerjaans' => $jenis_pekerjaans,
            'sub_pekerjaans' => $sub_pekerjaans,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pelaksana $pelaksana)
    {
        $validatedData =  $request->validate([
            'nama' => 'required|string|max:255',
            'perusahaan_id' => 'required|exists:perusahaans,id',
            'tenaga_ahli_id' => 'required|array|exists:tenaga_ahlis,id',
            'no_kontrak' => 'required|max:255',
            'tgl_kontrak' => 'required|date',
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'required|date',
            'ppk' => 'required|string|max:255',
            'pptk' => 'required|string|max:255',
            'pho' => 'required|string|max:255',
            'status_pelaksana' => 'required',
            'sub_pekerjaan_id' => 'required|exists:sub_pekerjaans,id',
            'deskripsi' => 'required|string',
            'nilai_pagu' => 'required|string|max:255',
            'nilai_kontrak' => 'required|string|max:255',
            'lokasi' => 'required|string',
            'sumber_dana' => 'required|string|max:255',
            'thn_anggaran' => 'required|integer|between:1901,' . date('Y'),
            'metode' => 'required|string|max:255',
            'jenis_kontruksi' => 'required|string|max:255',
        ]);

        $validatedData['author_id'] = $request->user()->id;

        $perusahaan = Perusahaan::where('id', $request->perusahaan_id)
            ->where('jumlah_pekerjaan', '>', 5)
            ->whereNotIn('id', [$pelaksana->perusahaan_id])
            ->first(['nama']);

        $tenaga_ahlis = TenagaAhli::whereIn('id', $request->tenaga_ahli_id)
            ->where('status_pekerjaan', 0)
            ->whereNotIn('id', $pelaksana->tenaga_ahlis->pluck('id')->toArray())
            ->pluck('nama')
            ->toArray();

        if ($perusahaan) {
            return redirect()->back()->withInput()->with('perusahaan_full', $perusahaan->nama . ' sudah mencapai batas maksimal pekerjaan.');
        }
        if ($tenaga_ahlis) {
            return redirect()->back()->withInput()->with('tenaga_ahli_full', implode(', ', $tenaga_ahlis) . ' sedang melakukan pekerjaan.');
        }

        DB::transaction(function () use ($request, $validatedData, $pelaksana) {
            $pelaksana->perusahaan->decrement('jumlah_pekerjaan');
            Perusahaan::find($validatedData['perusahaan_id'])->increment('jumlah_pekerjaan');

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
        $pelaksana->perusahaan->decrement('jumlah_pekerjaan');
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

    public function getJenisPekerjaan($id)
    {
        $jenisPekerjaans = JenisJasa::where('id', $id)->with(['jenis_pekerjaans:id,nama,jenis_jasa_id'])->first()->jenis_pekerjaans;
        return response()->json($jenisPekerjaans);
    }

    public function getSubPekerjaan($id)
    {
        $subPekerjaans = JenisPekerjaan::where('id', $id)->with(['sub_pekerjaans:id,nama,jenis_pekerjaan_id'])->first()->sub_pekerjaans;
        return response()->json($subPekerjaans);
    }
}
