<?php

namespace App\Http\Controllers;

use App\Models\Pelaksana;
use App\Models\StatusPelaksana;
use Illuminate\Http\Request;

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

        StatusPelaksana::create($validatedData);
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
