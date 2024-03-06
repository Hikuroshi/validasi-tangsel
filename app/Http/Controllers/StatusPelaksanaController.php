<?php

namespace App\Http\Controllers;

use App\Models\Pelaksana;
use App\Models\StatusPelaksana;
use App\Models\TenagaAhli;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatusPelaksanaController extends Controller
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
    public function store(Request $request, Pelaksana $pelaksana)
    {
        $validatedData =  $request->validate([
            'status_pelaksana' => 'required',
            'keterangan'=> 'required|string',
        ]);

        $validatedData[$request->status_pelaksana] = true;
        $validatedData['pelaksana_id'] = $pelaksana->id;
        $validatedData['author_id'] = $request->user()->id;

        $latestStatusKey = collect($pelaksana->status_pelaksanas()->latest()->first()->toArray())
                ->only(['request', 'on_progress', 'reporting', 'done', 'pending', 'cancelled'])
                ->filter(fn ($value, $key) => $value == true)
                ->keys()
                ->last();

        DB::transaction(function () use ($request, $validatedData, $pelaksana, $latestStatusKey) {
            if ($request->status_pelaksana == 'done' || $request->status_pelaksana == 'cancelled') {
                TenagaAhli::whereIn('id', $pelaksana->tenaga_ahlis->pluck('id'))->update(['status_pekerjaan' => 1]);

                if ($latestStatusKey != 'done' && $latestStatusKey != 'cancelled') {
                    $pelaksana->badan_usaha->decrement('jumlah_pekerjaan');
                }
            } else {
                TenagaAhli::whereIn('id', $pelaksana->tenaga_ahlis->pluck('id'))->update(['status_pekerjaan' => 0]);

                if ($latestStatusKey == 'done' || $latestStatusKey == 'cancelled') {
                    $pelaksana->badan_usaha->increment('jumlah_pekerjaan');
                }
            }

            StatusPelaksana::create($validatedData);
        });

        return redirect()->back()->with('success', 'Status Pelaksana berhasil diperbarui!');
    }

    /**
     * Display the specified resource.
     */
    public function show(StatusPelaksana $statusPelaksana)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StatusPelaksana $statusPelaksana)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StatusPelaksana $statusPelaksana)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StatusPelaksana $statusPelaksana)
    {
        //
    }
}
