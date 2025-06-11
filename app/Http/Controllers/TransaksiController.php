<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\Pasien;
use App\Models\ResepObat;
use App\Models\RekamMedis;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TransaksiController extends Controller
{
    public function index()
    {
        $rekam_medis = RekamMedis::with('pasien')
            ->whereDate('tanggal_kunjungan', now())
            ->orderByRaw("FIELD(status_kedatangan, 'Booking', 'Datang', 'Diperiksa', 'Menunggu Obat', 'Selesai', 'Beli Obat', 'Tidak Datang')")
            ->orderBy('jam_datang', 'asc')
            ->get();
    
        return view('transaksi.index', [
            'title' => 'Transaksi',
            'rekam_medis' => $rekam_medis
        ]);
    }

    public function transaksi_resep_obat($pasien, RekamMedis $rekam_medis)
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
            'from' => 'transaksi'
        ]);
    }
    
}