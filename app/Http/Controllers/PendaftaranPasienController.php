<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Obat;
use App\Models\Dokter;
use App\Models\Pasien;
use App\Models\ResepObat;
use App\Models\RekamMedis;
use App\Models\JadwalDokter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Mail\SendEmailDaftarPasien;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
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

        // Ambil semua dokter
        $dokter = Dokter::with('poli')->get();

        return view('role_pasien_layout.pendaftaran.create', [
            'title' => 'Pendaftaran',
            'pasien' => $pasien,
            'dokter' => $dokter
        ]);
    }

    public function getJadwalDokter(Dokter $dokter)
    {
        $hariTersedia = JadwalDokter::where('dokter_id', $dokter->id)
            ->pluck('hari')
            ->toArray();

        $opsiTanggal = [];
        for ($i = 0; $i < 7; $i++) {
            $tanggal = Carbon::now()->addDays($i);
            $namaHari = $tanggal->translatedFormat('l');

            if (in_array($namaHari, $hariTersedia)) {
                $opsiTanggal[] = [
                    'tanggal' => $tanggal->toDateString(),
                    'label' => $namaHari . ', ' . $tanggal->translatedFormat('d F Y')
                ];
            }
        }

        return response()->json($opsiTanggal);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'pasien_id'         => 'required|exists:pasien,id',
            'dokter_id'         => 'required|exists:dokter,id',
            'tanggal_kunjungan' => 'required|date|after_or_equal:today',
            'keluhan'           => 'required|string|max:255',
            'alergi_obat'       => 'nullable|string|max:255',
        ]);

        try {
            $tanggalKunjungan = $validatedData['tanggal_kunjungan'];

            // Ambil dokter beserta poli
            $dokter = Dokter::with('poli')->findOrFail($validatedData['dokter_id']);
            $namaPoli = $dokter->poli->nama_poli ?? 'UM';

            // Hitung jumlah antrean untuk dokter tersebut pada tanggal yang sama
            $jumlahAntrean = RekamMedis::whereDate('tanggal_kunjungan', $tanggalKunjungan)
                ->where('dokter_id', $dokter->id)
                ->count();
            $nomorAntrean = str_pad($jumlahAntrean + 1, 2, '0', STR_PAD_LEFT);

            // Ambil inisial nama dokter dari 2 huruf terakhir nama belakang
            $namaParts = explode(' ', $dokter->nama_dokter);
            $namaBelakang = end($namaParts);
            $inisialDokter = strtoupper(substr($namaBelakang, -2));

            // Ambil inisial poli lebih deskriptif
            $words = explode(' ', $namaPoli);
            if (count($words) > 1) {
                $inisialPoli = strtoupper(substr($words[1], 0, 4)); // kata kedua, 4 huruf
            } else {
                $inisialPoli = strtoupper(substr($words[0], 0, 3)); // kata pertama, 3 huruf
            }

            // Format no_antrean: <inisial_dokter>-<inisial_poli>-<nomor>
            $noAntrean = $inisialDokter . '-' . $inisialPoli . '-' . $nomorAntrean;

            // Tambahkan field otomatis
            $validatedData['no_antrean'] = $noAntrean;
            $validatedData['status_kedatangan'] = 'Booking'; // selalu Booking
            $validatedData['jam_datang'] = null; // kosong karena status Booking

            RekamMedis::create($validatedData);

            Alert::success('Sukses!', 'Pendaftaran Berhasil Ditambah');

            $pasien = Pasien::where('id', $validatedData['pasien_id'])->first();

            // dd($validatedData);

            Mail::to('arianur098@gmail.com')->send(new SendEmailDaftarPasien($pasien, $validatedData));

            return redirect()->route('pendaftaran_pasien.index');
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan pendaftaran: ' . $e->getMessage());
            Alert::error('Error', $e->getMessage());
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
