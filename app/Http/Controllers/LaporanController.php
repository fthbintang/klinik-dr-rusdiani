<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\Supplier;
use App\Exports\ObatExport;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    public function index()
    {
        return view('laporan.index', [
            'title' => 'Laporan',
            'titleLaporanObat' => 'Laporan Obat',
            'titleLaporanObat Masuk' => 'Laporan Obat Masuk',
            'titleLaporanObat Keluar' => 'Laporan Obat Keluar',
            'titleLaporanPenjualanObat' => 'Laporan Penjualan Obat',
            'titleLaporanTransaksi' => 'Laporan Transaksi',

            'supplier' => Supplier::latest()->get(),
        ]);
    }

    public function exportObat(Request $request)
    {
        $query = Obat::query();

        // Filter untuk rentang tanggal expired
        $query->when($request->filled('awal') && $request->filled('akhir'), function ($q) use ($request) {
            return $q->whereBetween('expired_date', [$request->awal, $request->akhir]);
        });

        // Filter untuk kategori
        $query->when($request->filled('kategori'), function ($q) use ($request) {
            return $q->where('kategori', $request->kategori);
        });

        // Filter untuk stok (kurang dari)
        $query->when($request->filled('stok'), function ($q) use ($request) {
            return $q->where('stok', '<=', $request->stok);
        });

        // Filter untuk supplier
        $query->when($request->filled('supplier_id'), function ($q) use ($request) {
            return $q->where('supplier_id', $request->supplier_id);
        });

        // Filter untuk obat bebas
        $query->when($request->filled('obat_bebas'), function ($q) use ($request) {
            return $q->where('obat_bebas', $request->obat_bebas);
        });

        // 3. Ambil data setelah semua filter diterapkan
        $dataObat = $query->get();

        // return $dataObat;
        // Data filter untuk ditampilkan di header PDF
        $filterDateHeader = [
            'awal' => $request->awal,
            'akhir' => $request->akhir,
        ];

        if ($request->ekstensi == 'pdf') {
            $pdf = PDF::loadView('laporan.pdf.obat', [
                'dataObat' => $dataObat,
                'awal' => $request->awal,
                'akhir' => $request->akhir,
            ]);
            return $pdf->stream('laporan-obat.pdf');
        } else if ($request->ekstensi == 'excel') {
            // Panggil class export dan download file excel
            return Excel::download(new ObatExport($dataObat), 'laporan-obat-' . now()->format('Y-m-d') . '.xlsx');
        }

        // Redirect kembali jika tidak ada ekstensi yang dipilih
        return redirect()->back()->with('error', 'Silakan pilih format ekspor terlebih dahulu.');
    }
}
