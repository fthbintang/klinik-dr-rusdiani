<?php

namespace App\Http\Controllers;

use App\Models\PenjualanObat;
use Illuminate\Http\Request;

class PenjualanObatController extends Controller
{
    public function index(Request $request)
    {
        $tanggal = $request->input('tanggal_transaksi', today());
    
        return view('penjualan_obat.index', [
            'title' => 'Penjualan Obat',
            'penjualan_obat' => PenjualanObat::with('pasien')
                ->whereDate('tanggal_transaksi', $tanggal)
                ->latest()
                ->get(),
            'tanggal_terpilih' => $tanggal,
        ]);
    }
    

}