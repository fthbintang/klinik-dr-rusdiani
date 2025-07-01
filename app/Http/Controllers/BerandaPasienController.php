<?php

namespace App\Http\Controllers;

use App\Models\RekamMedis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BerandaPasienController extends Controller
{
    public function index()
    {
        $user = Auth::user();
    
        // Cek apakah user memiliki relasi pasien
        if (!$user->pasien) {
            abort(403, 'Halaman ini hanya untuk pasien.');
        }
    
        $pasien = $user->pasien;
    
        $totalPendaftaran = RekamMedis::where('pasien_id', $pasien->id)->count();
    
        $antreanAktif = RekamMedis::where('pasien_id', $pasien->id)
                            ->where('status_kedatangan', 'Booking')
                            ->latest('tanggal_kunjungan')
                            ->first()?->no_antrean;
    
        $terakhirKunjungan = RekamMedis::where('pasien_id', $pasien->id)
                            ->whereNotNull('tanggal_kunjungan')
                            ->whereNotNull('biaya_total')
                            ->latest('tanggal_kunjungan')
                            ->first()?->tanggal_kunjungan;
    
        return view('role_pasien_layout.beranda', [
            'title' => 'Beranda',
            'totalPendaftaran' => $totalPendaftaran,
            'antreanAktif' => $antreanAktif,
            'terakhirKunjungan' => $terakhirKunjungan,
        ]);
    }
    
    
    public function antreanTerdepanPasien()
    {
        $todayAntrean = RekamMedis::whereDate('tanggal_kunjungan', now()->toDateString())
            ->whereIn('status_kedatangan', ['Booking', 'Datang', 'Diperiksa'])
            ->orderByRaw("CAST(SUBSTRING_INDEX(no_antrean, '-', -1) AS UNSIGNED)")
            ->get();

        // Ambil maksimal 3 antrean
        $filtered = $todayAntrean->take(3);

        // Jika ada yang Diperiksa, pindahkan ke akhir
        $index = $filtered->search(fn ($item) => $item->status_kedatangan === 'Diperiksa');

        if ($index !== false) {
            $diperiksa = $filtered->splice($index, 1);
            $filtered = $filtered->push($diperiksa->first());
        }

        return response()->json($filtered->values());
    }
}