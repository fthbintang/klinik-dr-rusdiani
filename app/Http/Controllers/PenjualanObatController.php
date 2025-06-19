<?php

namespace App\Http\Controllers;

use App\Models\PenjualanObat;
use Illuminate\Http\Request;

class PenjualanObatController extends Controller
{
    public function index()
    {
        return view('penjualan_obat.index', [
            'title' => 'Penjualan Obat',
            'penjualan_obat' => PenjualanObat::latest()->get()
        ]);
    }
}