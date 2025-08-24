<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\RekamMedis;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class RekamMedisController extends Controller
{
    public function index(Pasien $pasien)
    {
        $rekam_medis = RekamMedis::with(['pasien.user', 'dokter.poli'])
            ->where('pasien_id', $pasien->id)
            ->orderBy('tanggal_kunjungan', 'desc')
            ->get();
        
        return view('pasien.rekam_medis.index', [
            'title' => 'Rekam Medis',
            'pasien' => $pasien,
            'rekam_medis' => $rekam_medis
        ]);
    }

    public function edit(Pasien $pasien, RekamMedis $rekam_medis)
    {        
        return view('pasien.rekam_medis.edit', [
            'title' => 'Edit Rekam Medis',
            'rekam_medis'=> $rekam_medis
        ]);
    }

    public function update(Request $request, RekamMedis $rekam_medis)
    {
        // return $request;
        $validatedData = $request->validate([
            'keluhan'     => 'nullable|string|max:255',
            'diagnosis'   => 'nullable|string|max:255',
            'tindakan'    => 'nullable|string|max:255',
        ]);
    
        try {
            $rekam_medis->update($validatedData);
    
            Alert::success('Sukses!', 'Data Berhasil Diupdate');
            return redirect()->route('pasien.rekam_medis.index', $rekam_medis->pasien->id);
        } catch (\Exception $e) {
            Alert::error('Error', 'Terjadi kesalahan saat mengupdate data');
            return back()->withInput();
        }
    }

    public function destroy(RekamMedis $rekam_medis)
    {
        try { 
            $rekam_medis->delete();
    
            Alert::success('Berhasil', 'Data berhasil dihapus');
            return redirect()->route('pasien.rekam_medis.index', $rekam_medis->pasien->id);
        } catch (\Exception $e) {
            Alert::error('Gagal', 'Terjadi kesalahan saat menghapus data');
            return back();
        }
    }
}