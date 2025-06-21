<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Obat;
use App\Models\Pasien;
use App\Models\ObatKeluar;
use Illuminate\Http\Request;
use App\Models\PenjualanObat;
use Illuminate\Support\Facades\DB;
use App\Models\PenjualanObatDetail;
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

    public function penjualan_obat_detail_index(PenjualanObat $penjualan_obat)
    {
        $obat_bebas = Obat::where('obat_bebas', 1)->get();
        $penjualan_obat_detail = PenjualanObatDetail::where('penjualan_obat_id', $penjualan_obat->id)->get();

        return view('penjualan_obat.penjualan_obat_detail_index', [
            'title' => 'Penjualan Obat Detail',
            'obat' => $obat_bebas,
            'penjualan_obat' => $penjualan_obat,
            'penjualan_obat_detail' => $penjualan_obat_detail
        ]);
    }

    public function store_penjualan_obat_detail(Request $request)
    {
        $validated = $request->validate([
            'penjualan_obat_id' => 'required|exists:penjualan_obat,id',
            'obat_id' => 'required|array',
            'obat_id.*' => 'required|exists:obat,id',
            'kuantitas' => 'required|array',
            'kuantitas.*' => 'required|integer|min:1',
            'harga_final' => 'required|array',
            'harga_final.*' => 'required|integer|min:0',
        ]);

        DB::beginTransaction();
        try {
            $totalHarga = 0;

            $penjualan = PenjualanObat::findOrFail($validated['penjualan_obat_id']);
            $tanggal = $penjualan->tanggal_transaksi;
            $pasienId = $penjualan->pasien_id; // Bisa null

            foreach ($validated['obat_id'] as $index => $obatId) {
                $kuantitas = $validated['kuantitas'][$index];
                $hargaFinal = $validated['harga_final'][$index];

                $obat = Obat::findOrFail($obatId);
                $stokAwal = $obat->stok;
                $stokAkhir = $stokAwal - $kuantitas;

                // Validasi stok cukup
                if ($stokAkhir < 0) {
                    throw new \Exception("Stok obat {$obat->nama_obat} tidak mencukupi.");
                }

                // Kurangi stok
                $obat->update([
                    'stok' => $stokAkhir,
                ]);

                // Simpan detail penjualan
                PenjualanObatDetail::create([
                    'penjualan_obat_id' => $penjualan->id,
                    'obat_id'           => $obatId,
                    'kuantitas'         => $kuantitas,
                    'harga_final'       => $hargaFinal,
                ]);

                // Simpan data obat keluar
                ObatKeluar::create([
                    'tanggal_obat_keluar' => $tanggal,
                    'pasien_id'           => $pasienId,
                    'obat_id'             => $obatId,
                    'stok_awal'           => $stokAwal,
                    'stok_keluar'         => $kuantitas,
                    'stok_final'          => $stokAkhir,
                    'supplier_id'         => $obat->supplier_id,
                ]);

                // Akumulasi total harga
                $totalHarga += $kuantitas * $hargaFinal;
            }

            // Update total harga ke penjualan_obat
            $penjualan->update([
                'total_harga' => $totalHarga,
            ]);

            DB::commit();

            Alert::success('Berhasil', 'Data penjualan obat berhasil disimpan');
            return redirect()->route('penjualan_obat.index');
        } catch (\Exception $e) {
            DB::rollBack();
            Alert::error('Gagal', $e->getMessage());
            return back()->withInput();
        }
    }
}