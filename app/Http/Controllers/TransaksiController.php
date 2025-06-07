<?php

namespace App\Http\Controllers;

use App\Models\RekamMedis;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index()
    {
        $rekam_medis = RekamMedis::with('pasien')
            ->whereDate('tanggal_kunjungan', now())
            ->orderByRaw("FIELD(status_kedatangan, 'Booking', 'Datang', 'Diperiksa', 'Selesai', 'Beli Obat', 'Tidak Datang')")
            ->orderBy('jam_datang', 'asc')
            ->get();
    
        return view('transaksi.index', [
            'title' => 'Transaksi',
            'rekam_medis' => $rekam_medis
        ]);
    }
    
}