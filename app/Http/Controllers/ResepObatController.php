<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\Pasien;
use App\Models\ResepObat;
use App\Models\RekamMedis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class ResepObatController extends Controller
{
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
            'title' => 'Detail Pemeriksaan dan Resep Obat',
            'daftar_obat_tidak_bebas' => $obat_tidak_bebas,
            'obat_bebas_dan_tidak_bebas' => $obat_bebas_dan_tidak_bebas,
            'pasien' => $pasien,
            'resep_obat' => $resep_obat,
            'rekam_medis' => $rekam_medis,
            'obatTersimpan' => $obatTersimpan,
            'from' => 'rekam_medis'
        ]);
    }

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

            // Update kolom disetujui_dokter menjadi true
            $rekam_medis->update([
                'disetujui_dokter' => true,
                'status_kedatangan' => 'Pengambilan Obat',
            ]);

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

    public function store_keluhan_diagnosis_tindakan(Request $request)
    {
        $validatedData = $request->validate([
            'rekam_medis_id' => 'required|exists:rekam_medis,id',
            'keluhan'        => 'nullable|string|max:255',
            'diagnosis'      => 'nullable|string|max:255',
            'tindakan'       => 'nullable|string|max:255',
        ]);
    
        try {
            RekamMedis::where('id', $validatedData['rekam_medis_id'])
                ->update([
                    'keluhan' => $validatedData['keluhan'],
                    'diagnosis' => $validatedData['diagnosis'],
                    'tindakan' => $validatedData['tindakan'],
                ]);
    
            Alert::success('Sukses!', 'Data Berhasil Disimpan');
            return redirect()->back();
        } catch (\Exception $e) {
            Alert::error('Error', 'Terjadi kesalahan saat menyimpan data');
            return back()->withInput();
        }
    }

    public function proses_apotek(RekamMedis $rekam_medis)
    {
        try {
            // Hitung total dari resep_obat
            $totalObat = ResepObat::where('rekam_medis_id', $rekam_medis->id)
                ->sum(DB::raw('harga_per_obat * kuantitas'));
    
            // Ambil biaya jasa dari rekam medis
            $biayaJasa = $rekam_medis->biaya_jasa ?? 0;
    
            // Total keseluruhan = total obat + biaya jasa
            $biayaTotal = $totalObat + $biayaJasa;
    
            // Update rekam_medis
            $rekam_medis->update([
                'biaya_total' => $biayaTotal,
                'status_kedatangan' => 'Selesai',
                'jam_selesai' => now()
            ]);
    
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Gagal memproses apotek: ' . $e->getMessage());
    
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memproses data'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ResepObat $resep_obat)
    {
        try { 
            $resep_obat->delete();
    
            Alert::success('Berhasil', 'Data berhasil dihapus');
            return redirect()->back();
        } catch (\Exception $e) {
            Alert::error('Gagal', 'Terjadi kesalahan saat menghapus data');
            return back();
        }
    }
}