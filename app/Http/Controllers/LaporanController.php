<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\Supplier;
use App\Models\ObatMasuk;
use App\Models\ObatKeluar;
use App\Exports\ObatExport;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\ObatMasukExport;
use App\Exports\ObatKeluarExport;
use App\Models\Pasien;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;

class LaporanController extends Controller
{
    public function index()
    {
        return view('laporan.index', [
            'title' => 'Laporan',
            'titleLaporanObat'          => 'Laporan Obat',
            'titleLaporanObatMasuk'     => 'Laporan Obat Masuk',
            'titleLaporanObatKeluar'    => 'Laporan Obat Keluar',
            'titleLaporanPenjualanObat' => 'Laporan Penjualan Obat',
            'titleLaporanTransaksi'     => 'Laporan Transaksi',

            'supplier'                  => Supplier::latest()->get(),
            'obat'                      => Obat::latest()->get(),
            'pasien'                    => Pasien::latest()->get(),
        ]);
    }

    public function exportObat(Request $request)
    {
        $validatedEkstensi = $request->validate([
            'ekstensiObat' => 'required'
        ]);

        try {
            $query = Obat::query();

            $query->when($request->filled('awal') && $request->filled('akhir'), function ($q) use ($request) {
                return $q->whereBetween('expired_date', [$request->awal, $request->akhir]);
            });

            $query->when($request->filled('kategori'), function ($q) use ($request) {
                return $q->where('kategori', $request->kategori);
            });

            $query->when($request->filled('stok'), function ($q) use ($request) {
                return $q->where('stok', '<=', $request->stok);
            });

            $query->when($request->filled('supplier_id'), function ($q) use ($request) {
                return $q->where('supplier_id', $request->supplier_id);
            });

            $query->when($request->filled('obat_bebas'), function ($q) use ($request) {
                return $q->where('obat_bebas', $request->obat_bebas);
            });

            $dataObat = $query->get();

            if ($validatedEkstensi['ekstensiObat'] == 'pdf') {
                $pdf = PDF::loadView('laporan.pdf.obat', [
                    'dataObat' => $dataObat,
                    'awal' => $request->awal,
                    'akhir' => $request->akhir,
                ]);
                return $pdf->stream('laporan-obat.pdf');
            } else if ($validatedEkstensi['ekstensiObat'] == 'excel') {
                return Excel::download(new ObatExport($dataObat), 'laporan-obat-' . now()->format('Y-m-d') . '.xlsx');
            }
        } catch (\Exception $e) {
            Alert::error('Error', 'Terjadi kesalahan saat export data');
            Log::error('Gagal Export Data', ['error' => $e->getMessage()]);
            return back()->withInput();
        }
    }

    public function exportObatMasuk(Request $request)
    {
        $validatedEkstensi = $request->validate([
            'ekstensiObatMasuk' => 'required'
        ]);

        try {
            $query = ObatMasuk::with(['obat.supplier']);

            $query->when($request->filled('awalObatMasuk') && $request->filled('akhirObatMasuk'), function ($q) use ($request) {
                return $q->whereBetween('tanggal_obat_masuk', [$request->awalObatMasuk, $request->akhirObatMasuk]);
            });

            $query->when($request->filled('nama_obat'), function ($q) use ($request) {
                return $q->where('obat_id', $request->nama_obat);
            });

            $query->when($request->filled('supplier_id'), function ($q) use ($request) {
                return $q->where('supplier_id', $request->supplier_id);
            });

            $dataObatMasuk = $query->latest()->get();

            if ($validatedEkstensi['ekstensiObatMasuk'] == 'pdf') {
                $pdf = PDF::loadView('laporan.pdf.obat-masuk', [
                    'dataObatMasuk' => $dataObatMasuk,
                    'awal' => $request->awalObatMasuk,
                    'akhir' => $request->akhirObatMasuk,
                ]);
                return $pdf->stream('laporan-obat-masuk.pdf');
            } else if ($validatedEkstensi['ekstensiObatMasuk'] == 'excel') {
                return Excel::download(new ObatMasukExport($dataObatMasuk), 'laporan-obat-masuk-' . now()->format('Y-m-d') . '.xlsx');
            }
        } catch (\Exception $e) {
            Alert::error('Error', 'Terjadi kesalahan saat export data');
            Log::error('Gagal Export Data', ['error' => $e->getMessage()]);
            return back()->withInput();
        }
    }

    public function exportObatKeluar(Request $request)
    {
        $validatedEkstensi = $request->validate([
            'ekstensiObatKeluar' => 'required'
        ]);

        try {
            $query = ObatKeluar::with(['obat.supplier', 'pasien', 'obat']);

            $query->when($request->filled('awalObatKeluar') && $request->filled('akhirObatKeluar'), function ($q) use ($request) {
                return $q->whereBetween('tanggal_obat_keluar', [$request->awalObatKeluar, $request->akhirObatKeluar]);
            });

            $query->when($request->filled('nama_obat'), function ($q) use ($request) {
                return $q->where('obat_id', $request->nama_obat);
            });

            $query->when($request->filled('pasien_id'), function ($q) use ($request) {
                return $q->where('pasien_id', $request->pasien_id);
            });

            $query->when($request->filled('supplier_id'), function ($q) use ($request) {
                return $q->where('supplier_id', $request->supplier_id);
            });

            $dataObatKeluar = $query->latest()->get();

            if ($validatedEkstensi['ekstensiObatKeluar'] == 'pdf') {
                $pdf = PDF::loadView('laporan.pdf.obat-keluar', [
                    'dataObatKeluar' => $dataObatKeluar,
                    'awal' => $request->awalObatKeluar,
                    'akhir' => $request->akhirObatKeluar,
                ]);
                return $pdf->stream('laporan-obat-keluar.pdf');
            } else if ($validatedEkstensi['ekstensiObatKeluar'] == 'excel') {
                return Excel::download(new ObatKeluarExport($dataObatKeluar), 'laporan-obat-keluar-' . now()->format('Y-m-d') . '.xlsx');
            }
        } catch (\Exception $e) {
            Alert::error('Error', 'Terjadi kesalahan saat export data');
            Log::error('Gagal Export Data', ['error' => $e->getMessage()]);
            return back()->withInput();
        }
    }
}
