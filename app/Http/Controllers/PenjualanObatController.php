<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Pasien;
use Illuminate\Http\Request;
use App\Models\PenjualanObat;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class PenjualanObatController extends Controller
{
    public function index(Request $request)
    {
        $tanggal = $request->input('tanggal_transaksi', today());
    
        return view('penjualan_obat.index', [
            'title' => 'Penjualan Obat',
            'penjualan_obat' => PenjualanObat::with('pasien')
                ->whereDate('tanggal_transaksi', $tanggal)
                ->latest()
                ->get(),
            'tanggal_terpilih' => $tanggal,
        ]);
    }

    public function create()
    {
        return view('penjualan_obat.create', [
            'title' => 'Tambah Penjualan Obat',
            'pasien' => Pasien::all()
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'pasien_id' => 'nullable|exists:pasien,id',
            'catatan'   => 'nullable|string',
        ]);

        try {
            // Tanggal hari ini
            $tanggalHariIni = Carbon::today()->toDateString();

            // Hitung jumlah transaksi di hari ini untuk menentukan urutan
            $jumlahHariIni = PenjualanObat::whereDate('tanggal_transaksi', $tanggalHariIni)->count();

            // Format kode transaksi, reset per tanggal
            $urutan = str_pad($jumlahHariIni + 1, 2, '0', STR_PAD_LEFT); // 01, 02, dst
            $kodeTransaksi = 'OBT-' . $urutan;

            // Tambahkan data yang di-generate otomatis
            $validatedData['kode_transaksi'] = $kodeTransaksi;
            $validatedData['tanggal_transaksi'] = $tanggalHariIni;
            $validatedData['total_harga'] = 0; // default 0, karena belum input detail obat

            PenjualanObat::create($validatedData);

            Alert::success('Sukses!', 'Data Penjualan Obat berhasil ditambah');
            return redirect()->route('penjualan_obat.index');
        } catch (\Exception $e) {
            Alert::error('Error', 'Terjadi kesalahan saat menyimpan data');
            return back()->withInput();
        }
    }
    

}