<?php

namespace App\Http\Controllers;

use App\Models\Pekerjaan;
use App\Models\StatusPekerjaan;
use App\Models\TenagaAhli;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatusPekerjaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Pekerjaan $pekerjaan)
    {
        $validatedData =  $request->validate([
            'status_pekerjaan' => 'required',
            'keterangan'=> 'required|string',
        ]);

        $validatedData[$request->status_pekerjaan] = true;
        $validatedData['pekerjaan_id'] = $pekerjaan->id;
        $validatedData['author_id'] = $request->user()->id;

        $latestStatusKey = collect($pekerjaan->status_pekerjaans()->latest()->first()->toArray())
                ->only(['request', 'on_progress', 'reporting', 'done', 'pending', 'cancelled'])
                ->filter(fn ($value, $key) => $value == true)
                ->keys()
                ->last();

        DB::transaction(function () use ($request, $validatedData, $pekerjaan, $latestStatusKey) {
            if ($request->status_pekerjaan == 'done' || $request->status_pekerjaan == 'cancelled') {
                TenagaAhli::whereIn('id', $pekerjaan->tenaga_ahlis->pluck('id'))->update(['status_pekerjaan' => 1]);

                if ($latestStatusKey != 'done' && $latestStatusKey != 'cancelled') {
                    $pekerjaan->perusahaan->decrement('jumlah_pekerjaan');
                }
            } else {
                TenagaAhli::whereIn('id', $pekerjaan->tenaga_ahlis->pluck('id'))->update(['status_pekerjaan' => 0]);

                if ($latestStatusKey == 'done' || $latestStatusKey == 'cancelled') {
                    $pekerjaan->perusahaan->increment('jumlah_pekerjaan');
                }
            }

            StatusPekerjaan::create($validatedData);
        });

        return redirect()->back()->with('success', 'Status Pekerjaan berhasil diperbarui!');
    }

    /**
     * Display the specified resource.
     */
    public function show(StatusPekerjaan $statusPekerjaan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StatusPekerjaan $statusPekerjaan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StatusPekerjaan $statusPekerjaan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StatusPekerjaan $statusPekerjaan)
    {
        //
    }
}
