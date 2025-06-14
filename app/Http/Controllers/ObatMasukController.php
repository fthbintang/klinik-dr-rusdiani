<?php

namespace App\Http\Controllers;

use App\Models\ObatMasuk;
use Illuminate\Http\Request;

class ObatMasukController extends Controller
{
    public function index(Request $request)
    {
        $query = ObatMasuk::with(['obat.supplier'])
            ->latest();
    
        if ($request->filled('tanggal_obat_masuk')) {
            $query->whereDate('tanggal_obat_masuk', $request->tanggal_obat_masuk);
        }
    
        return view('obat_masuk.index', [
            'title' => 'Obat Masuk',
            'obat_masuk' => $query->get()
        ]);
    }
    
}