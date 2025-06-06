<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\Pasien;
use App\Models\ResepObat;
use App\Models\RekamMedis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ResepObatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($pasien, RekamMedis $rekam_medis)
    {
        $resep_obat = ResepObat::with('rekam_medis.pasien')
            ->where('rekam_medis_id', $rekam_medis->id)
            ->get();

        $pasien = Pasien::with('user')->findOrFail($pasien);
        $obat_tidak_bebas = Obat::where('obat_bebas', 0)->get();
        $obat_bebas_dan_tidak_bebas = Obat::all();

        $obatTersimpan = ResepObat::where('rekam_medis_id', $rekam_medis->id)
            ->pluck('obat_id')
            ->toArray();

        return view('resep_obat.index', [
            'title' => 'Resep Obat',
            'daftar_obat_tidak_bebas' => $obat_tidak_bebas,
            'obat_bebas_dan_tidak_bebas' => $obat_bebas_dan_tidak_bebas,
            'pasien' => $pasien,
            'resep_obat' => $resep_obat,
            'rekam_medis' => $rekam_medis,
            'obatTersimpan' => $obatTersimpan
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
    public function store(Request $request, RekamMedis $rekam_medis)
    {
        $validated = $request->validate([
            'resep' => 'required|array',
            'resep.*.obat_id' => 'nullable|exists:obat,id',
            'resep.*.nama_obat' => 'required|string',
            'resep.*.kategori' => 'nullable|string',
            'resep.*.satuan' => 'nullable|string',
            'resep.*.expired_date' => 'nullable|date',
            'resep.*.harga_per_obat' => 'required|integer|min:0',
            'resep.*.kuantitas' => 'required|integer|min:1',
            'resep.*.harga_final' => 'required|integer|min:0',
            'resep.*.catatan' => 'nullable|string'
        ]);

        DB::beginTransaction();
        try {
            foreach ($validated['resep'] as $item) {
                // Lewati jika kosong atau default (hasil duplikat tak disengaja)
                if (
                    empty($item['nama_obat']) ||
                    (empty($item['obat_id']) && (empty($item['harga_per_obat']) || $item['harga_per_obat'] == 0))
                ) {
                    continue;
                }

                // Cek apakah obat_id sudah pernah dipakai untuk rekam_medis ini
                if (!empty($item['obat_id'])) {
                    $exists = ResepObat::where('rekam_medis_id', $rekam_medis->id)
                        ->where('obat_id', $item['obat_id'])
                        ->exists();

                    if ($exists) {
                        continue; // Lewati input ini, karena obat sudah pernah dicatat
                    }
                }

                ResepObat::create([
                    'rekam_medis_id' => $rekam_medis->id,
                    'obat_id'        => $item['obat_id'],
                    'nama_obat'      => $item['nama_obat'],
                    'kategori'       => $item['kategori'],
                    'satuan'         => $item['satuan'],
                    'expired_date'   => $item['expired_date'],
                    'harga_per_obat' => $item['harga_per_obat'],
                    'kuantitas'      => $item['kuantitas'],
                    'harga_final'    => $item['harga_final'],
                    'catatan'        => $item['catatan'],
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ]);
            }

            DB::commit();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
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