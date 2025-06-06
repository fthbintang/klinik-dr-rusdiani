<?php

namespace App\Http\Controllers;

use App\Models\RekamMedis;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index()
    {
        $rekam_medis = RekamMedis::whereDate('tanggal_kunjungan', now())->get();

        return view('transaksi.index', [
            'title' => 'Transaksi',
            'rekam_medis' => $rekam_medis
        ]);
    }
}