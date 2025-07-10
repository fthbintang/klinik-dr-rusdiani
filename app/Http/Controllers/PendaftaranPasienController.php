<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Obat;
use App\Models\Pasien;
use App\Models\ResepObat;
use App\Models\RekamMedis;
use App\Models\JadwalDokter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class PendaftaranPasienController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Cek apakah user memiliki relasi pasien
        if (!$user->pasien) {
            abort(403, 'Halaman ini hanya untuk pasien.');
        }
        
        $pasien = $user->pasien;
        $rekam_medis = RekamMedis::with('pasien')->where('pasien_id', $pasien->id)->latest()->get();
        
        return view('role_pasien_layout.pendaftaran.index', [
            'title' => 'Pendaftaran Pasien',
            'rekam_medis' => $rekam_medis,
            'pasien' => $pasien
        ]);
    }

    public function create()
    {
        $pasien = Auth::user()->pasien;

        // Ambil daftar hari yang tersedia dari tabel jadwal_dokter
        $hariTersedia = JadwalDokter::pluck('hari')->toArray(); // Contoh: ['Senin', 'Rabu', 'Jumat']

        // Ambil 7 hari ke depan yang cocok dengan hari tersedia
        $opsiTanggal = [];

        for ($i = 0; $i < 7; $i++) {
            $tanggal = Carbon::now()->addDays($i);
            $namaHari = $tanggal->translatedFormat('l');

            if (in_array($namaHari, $hariTersedia)) {
                $opsiTanggal[] = [
                    'tanggal' => $tanggal->toDateString(),
                    'label' => $namaHari . ', ' . $tanggal->translatedFormat('d F Y'),
                ];
            }
        }

        return view('role_pasien_layout.pendaftaran.create', [
            'title' => 'Pendaftaran',
            'pasien' => $pasien,
            'opsiTanggal' => $opsiTanggal
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'pasien_id'         => 'required|exists:pasien,id',
            'tanggal_kunjungan' => 'required|date|after_or_equal:today',
            'keluhan'           => 'required|string|max:255',
        ]);
    
        try {
            $tanggalKunjungan = $validatedData['tanggal_kunjungan'];
    
            // Hitung jumlah antrean untuk tanggal tersebut
            $jumlahAntrean = RekamMedis::whereDate('tanggal_kunjungan', $tanggalKunjungan)->count();
            $nomorAntrean = str_pad($jumlahAntrean + 1, 2, '0', STR_PAD_LEFT);
            $noAntrean = 'UM-' . $nomorAntrean;
    
            // Tambahkan ke data validasi
            $validatedData['no_antrean'] = $noAntrean;
            $validatedData['status_kedatangan'] = 'Booking';
    
            RekamMedis::create($validatedData);
    
            Alert::success('Sukses!', 'Pendaftaran Berhasil Ditambah');
            return redirect()->route('pendaftaran_pasien.index');
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan pendaftaran: ' . $e->getMessage());
            Alert::error('Error', 'Terjadi kesalahan saat menyimpan data');
            return back()->withInput();
        }
    }

    public function detail_resep_obat($pasien, RekamMedis $rekam_medis)
    {
        $resep_obat = ResepObat::with('rekam_medis.pasien')
            ->where('rekam_medis_id', $rekam_medis->id)
            ->get();

        $pasien = Pasien::with('user')->findOrFail($pasien);
        $obat_tidak_bebas = Obat::where('obat_bebas', 1)->get();
        $obat_bebas_dan_tidak_bebas = Obat::all();

        $obatTersimpan = ResepObat::where('rekam_medis_id', $rekam_medis->id)
            ->pluck('obat_id')
            ->toArray();

        return view('resep_obat.index', [
            'title' => 'Detail Pemeriksaan dan Resep Obat',
            'daftar_obat_tidak_bebas' => $obat_tidak_bebas,
            'obat_bebas_dan_tidak_bebas' => $obat_bebas_dan_tidak_bebas,
            'pasien' => $pasien,
            'resep_obat' => $resep_obat,
            'rekam_medis' => $rekam_medis,
            'obatTersimpan' => $obatTersimpan,
            'from' => 'pendaftaran_pasien'
        ]);
    }
    
}