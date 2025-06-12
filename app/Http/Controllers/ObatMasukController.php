<?php

namespace App\Http\Controllers;

use App\Models\ObatMasuk;
use Illuminate\Http\Request;

class ObatMasukController extends Controller
{
    public function index() 
    {
        return view('obat_masuk.index', [
            'title' => 'Obat Masuk',
            'obat_masuk' => ObatMasuk::all()
        ]);
    }
}