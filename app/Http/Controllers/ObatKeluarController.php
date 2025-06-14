<?php

namespace App\Http\Controllers;

use App\Models\ObatKeluar;
use Illuminate\Http\Request;

class ObatKeluarController extends Controller
{
    public function index()
    {
        $query = ObatKeluar::with(['pasien', 'obat', 'obat.supplier']);
    
        // Filter jika ada input tanggal
        if (request('tanggal_obat_keluar')) {
            $query->whereDate('tanggal_obat_keluar', request('tanggal_obat_keluar'));
        }
    
        // Ambil data dan urutkan terbaru berdasarkan tanggal_obat_keluar
        $obat_keluar = $query->latest()->get();
    
        return view('obat_keluar.index', [
            'title' => 'Obat Keluar',
            'obat_keluar' => $obat_keluar
        ]);
    }    
    
}