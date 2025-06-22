<?php

namespace App\Http\Controllers;

use App\Models\RekamMedis;
use Illuminate\Http\Request;

class BerandaPasienController extends Controller
{
    public function index()
    {
        return view('role_pasien_layout.beranda', [
            'title' => 'Dashboard',
            'rekam_medis' => RekamMedis::all()
        ]);
    }
}