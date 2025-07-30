<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Obat;
use App\Models\Pasien;
use App\Models\ResepObat;
use App\Models\RekamMedis;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $tanggal = $request->tanggal_kunjungan ?? now()->toDateString();
    
        $rekam_medis = RekamMedis::with('pasien')
            ->whereDate('tanggal_kunjungan', $tanggal)
            ->orderByRaw("FIELD(status_kedatangan, 'Booking', 'Datang', 'Diperiksa', 'Pengambilan Obat', 'Selesai', 'Beli Obat', 'Tidak Datang')")
            ->orderBy('jam_datang', 'asc')
            ->get();
    
        return view('transaksi.index', [
            'title' => 'Transaksi',
            'rekam_medis' => $rekam_medis,
            'tanggal_kunjungan' => $tanggal, // kirim tanggal ke view
        ]);
    }

    public function cetakResepObat(Pasien $pasien, RekamMedis $rekam_medis)
    {
        $rekam_medis->load('resep_obat'); // Pastikan relasi sudah didefinisikan

        $pdf = Pdf::loadView('pdf.resep_obat', [
            'pasien' => $pasien,
            'rekam_medis' => $rekam_medis,
            'resep_obat' => $rekam_medis->resep_obat,
        ]);

        return $pdf->stream('resep_obat_'.$pasien->nama.'.pdf');
    }

    public function create()
    {
        return view('transaksi.create', [
            'title' => 'Tambah Transaksi',
            'pasien' => Pasien::all()
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'tanggal_kunjungan'  => 'required|date|after_or_equal:today',
            'pasien_id'          => 'required|exists:pasien,id',
            'keluhan'            => 'required|string|max:255',
            'biaya_jasa'         => 'required|string',
            'berat_badan'        => 'nullable|numeric|min:0|max:300', // tambahkan validasi berat badan
            'tensi'              => 'nullable|string|max:20',         // tambahkan validasi tensi
        ]);

        try {
            // Konversi biaya_jasa dari format 10.000 menjadi 10000 (integer)
            $validatedData['biaya_jasa'] = (int) str_replace('.', '', $validatedData['biaya_jasa']);

            $tanggalKunjungan = $validatedData['tanggal_kunjungan'];
            $isToday = $tanggalKunjungan === now()->toDateString();

            // Hitung jumlah antrean berdasarkan tanggal kunjungan
            $jumlahAntrean = RekamMedis::whereDate('tanggal_kunjungan', $tanggalKunjungan)->count();
            $nomorAntrean = str_pad($jumlahAntrean + 1, 2, '0', STR_PAD_LEFT);
            $noAntrean = 'UM-' . $nomorAntrean;

            // Tambahan field otomatis
            $validatedData['no_antrean'] = $noAntrean;
            $validatedData['status_kedatangan'] = $isToday ? 'Datang' : 'Booking';
            $validatedData['jam_datang'] = $isToday ? now()->format('H:i:s') : null;

            RekamMedis::create($validatedData);

            Alert::success('Sukses!', 'Data Berhasil Ditambah');
            return redirect()->route('transaksi.index');
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan rekam medis: ' . $e->getMessage());
            Alert::error('Error', 'Terjadi kesalahan saat menyimpan data');
            return back()->withInput();
        }
    }

    public function updateStatusBooking(Request $request, $id)
    {
        $request->validate([
            'status_kedatangan' => 'required|string|in:Datang',
            'biaya_jasa' => 'required|numeric|min:0',
        ]);
    
        try {
            $rekamMedis = RekamMedis::findOrFail($id);
            $rekamMedis->status_kedatangan = 'Datang';
            $rekamMedis->jam_datang = now()->format('H:i:s');
            $rekamMedis->biaya_jasa = $request->biaya_jasa;
            $rekamMedis->save();
    
            return response()->json(['message' => 'Status berhasil diperbarui']);
        } catch (\Exception $e) {
            Log::error('Gagal update status_kedatangan rekam medis', [
                'rekam_medis_id' => $id,
                'error_message' => $e->getMessage(),
                'stack_trace' => $e->getTraceAsString(),
            ]);
    
            return response()->json(['message' => 'Gagal memperbarui status'], 500);
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status_kedatangan' => 'required|string|in:Diperiksa',
        ]);
    
        try {
            $rekamMedis = RekamMedis::findOrFail($id);
            $rekamMedis->status_kedatangan = $request->status_kedatangan;
            $rekamMedis->jam_diperiksa = now()->format('H:i:s');
            $rekamMedis->save();
    
            return response()->json(['message' => 'Status berhasil diperbarui']);
        } catch (\Exception $e) {
            // Catat error ke log Laravel
            Log::error('Gagal update status_kedatangan rekam medis', [
                'rekam_medis_id' => $id,
                'error_message' => $e->getMessage(),
                'stack_trace' => $e->getTraceAsString(),
            ]);

            return response()->json(['message' => 'Gagal memperbarui status'], 500);
        }
    }

    public function transaksi_resep_obat($pasien, RekamMedis $rekam_medis)
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
            'from' => 'transaksi'
        ]);
    }

    public function destroy(RekamMedis $rekam_medis)
    {
        try { 
            $rekam_medis->delete();
    
            Alert::success('Berhasil', 'Data berhasil dihapus');
            return redirect()->route('transaksi.index');
        } catch (\Exception $e) {
            Alert::error('Gagal', 'Terjadi kesalahan saat menghapus data');
            return back();
        }
    }
    
}