<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\RekamMedis;
use Illuminate\Http\Request;

class RekamMedisController extends Controller
{
    public function index(Pasien $pasien)
    {
        $rekam_medis = RekamMedis::with('pasien.user')
            ->where('pasien_id', $pasien->id)
            ->orderBy('tanggal_kunjungan', 'desc')
            ->get();
        
        return view('pasien.rekam_medis.index', [
            'title' => 'Rekam Medis',
            'pasien' => $pasien,
            'rekam_medis' => $rekam_medis
        ]);
    }
}