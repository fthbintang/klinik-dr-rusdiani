<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use Illuminate\Http\Request;

class DokterController extends Controller
{
    public function index()
    {
        return view('dokter.index', [
            'title' => 'Dokter',
            'dokter' => Dokter::with('poli')->get()
        ]);
    }
}