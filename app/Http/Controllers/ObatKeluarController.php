<?php

namespace App\Http\Controllers;

use App\Models\ObatKeluar;
use Illuminate\Http\Request;

class ObatKeluarController extends Controller
{
    public function index()
    {
        return view('obat_keluar.index', [
            'title' => 'Obat Keluar',
            'obat_keluar' => ObatKeluar::with('pasien.obat')->latest()->get()
        ]);
    }
}