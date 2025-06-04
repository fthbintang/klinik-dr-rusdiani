<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\Pasien;
use App\Models\ResepObat;
use App\Models\RekamMedis;
use Illuminate\Http\Request;

class ResepObatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($pasien, RekamMedis $rekam_medis)
    {
        $resep_obat = ResepObat::with('rekam_medis.pasien')->where('rekam_medis_id', $rekam_medis->id)->get();
        $pasien = Pasien::with('user')->findOrFail($pasien);

        return view('resep_obat.index', [
            'title' => 'Resep Obat',
            'daftar_obat' => Obat::latest()->get(),
            'pasien' => $pasien,
            'resep_obat' => $resep_obat
        ]);
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ResepObat $resepObat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ResepObat $resepObat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ResepObat $resepObat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ResepObat $resepObat)
    {
        //
    }
}