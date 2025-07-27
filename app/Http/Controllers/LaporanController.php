<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\Pasien;
use App\Models\Supplier;
use App\Models\ObatMasuk;
use App\Models\ResepObat;
use App\Models\ObatKeluar;
use App\Models\RekamMedis;
use App\Exports\ObatExport;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PenjualanObat;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\ObatMasukExport;
use App\Exports\ResepObatExport;
use App\Exports\TransaksiExport;
use App\Exports\ObatKeluarExport;
use App\Models\PenjualanObatDetail;
use Illuminate\Support\Facades\Log;
use App\Exports\PenjualanObatExport;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;
use App\Exports\DetailPenjualanObatExport;
use App\Exports\PasienExport;

class LaporanController extends Controller
{
    public function index()
    {
        return view('laporan.index', [
            'title' => 'Laporan',
            'titleLaporanObat'                  => 'Laporan Obat',
            'titleLaporanObatMasuk'             => 'Laporan Obat Masuk',
            'titleLaporanObatKeluar'            => 'Laporan Obat Keluar',
            'titleLaporanListTransaksiObat'     => 'Laporan Transaksi Obat',
            'titleLaporanDetailTransaksiObat'   => 'Laporan Detail Transaksi Obat',
            'titleLaporanTransaksi'             => 'Laporan Transaksi',
            'titleLaporanResepObatPasien'       => 'Laporan Resep Obat Pasien',
            'titleLaporanPasien'                => 'Laporan Pasien',

            'supplier'                          => Supplier::latest()->get(),
            'obat'                              => Obat::latest()->get(),
            'pasien'                            => Pasien::latest()->get(),
            'penjualan_obat'                    => PenjualanObat::latest()->get(),
            'rekam_medis'                       => RekamMedis::with('pasien')->latest()->get(),
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

    public function exportTransaksiObat(Request $request)
    {
        $validatedEkstensi = $request->validate([
            'ekstensiPenjualanObat' => 'required'
        ]);

        try {
            $query = PenjualanObat::with('pasien');

            $query->when($request->filled('awalTransaksiObat') && $request->filled('akhirTransaksiObat'), function ($q) use ($request) {
                return $q->whereBetween('tanggal_transaksi', [$request->awalTransaksiObat, $request->akhirTransaksiObat]);
            });

            $dataPenjualanObat = $query->get();

            if ($validatedEkstensi['ekstensiPenjualanObat'] == 'pdf') {
                $pdf = PDF::loadView('laporan.pdf.transaksi-obat', [
                    'dataPenjualanObat' => $dataPenjualanObat,
                    'awal' => $request->awalTransaksiObat,
                    'akhir' => $request->akhirTransaksiObat,
                ]);
                return $pdf->stream('laporan-transaksi-obat.pdf');
            } else if ($validatedEkstensi['ekstensiPenjualanObat'] == 'excel') {
                return Excel::download(new PenjualanObatExport($dataPenjualanObat), 'laporan-transaksi-obat-' . now()->format('Y-m-d') . '.xlsx');
            }
        } catch (\Exception $e) {
            Alert::error('Error', "Terjadi kesalahan saat export data");
            Log::error('Gagal Export Data', ['error' => $e->getMessage()]);
            return back()->withInput();
        }
    }

    public function exportDetailTransaksiObat(Request $request)
    {
        $validatedEkstensi = $request->validate([
            'ekstensiDetailTransaksiObat' => 'required',
            'penjualan_obat_id'           => 'required'
        ]);

        try {
            $query = PenjualanObatDetail::with('obat', 'penjualan_obat', 'penjualan_obat.pasien');

            $query->when($request->filled('penjualan_obat_id'), function ($q) use ($validatedEkstensi) {
                return $q->where('penjualan_obat_id', $validatedEkstensi['penjualan_obat_id']);
            });

            $dataDetailPenjualanObat = $query->get();

            $kodeTransaksi = null;
            $namaPasien = null;

            if (!$dataDetailPenjualanObat->isEmpty()) {
                $transaksi = $dataDetailPenjualanObat->first()->penjualan_obat;

                $kodeTransaksi = $transaksi->kode_transaksi;
            }

            if ($validatedEkstensi['ekstensiDetailTransaksiObat'] == 'pdf') {
                $pdf = PDF::loadView('laporan.pdf.detail-transaksi-obat', [
                    'dataDetailPenjualanObat' => $dataDetailPenjualanObat,
                    'kodeTransaksi' => $kodeTransaksi,
                    'namaPasien' => $namaPasien,
                    'awal' => $request->awalTransaksiObat,
                    'akhir' => $request->akhirTransaksiObat,
                ]);
                return $pdf->stream('laporan-detail-transaksi-obat.pdf');
            } else if ($validatedEkstensi['ekstensiDetailTransaksiObat'] == 'excel') {
                return Excel::download(new DetailPenjualanObatExport($dataDetailPenjualanObat), 'laporan-detail-transaksi-' . $kodeTransaksi . '-' . $namaPasien . '-' . now()->format('Y-m-d') . '.xlsx');
            }
        } catch (\Exception $e) {
            Alert::error('Error', "Terjadi kesalahan saat export data");
            Log::error('Gagal Export Data', ['error' => $e->getMessage()]);
            return back()->withInput();
        }
    }

    public function exportTransaksi(Request $request)
    {
        $validatedEkstensi = $request->validate([
            'ekstensiTransaksi' => 'required'
        ]);



        try {
            $query = RekamMedis::with('pasien');

            $query->when($request->filled('awalKunjungan') && $request->filled('akhirKunjungan'), function ($q) use ($request) {
                return $q->whereBetween('tanggal_kunjungan', [$request->awalKunjungan, $request->akhirKunjungan]);
            });


            $query->when($request->filled('status_kedatangan'), function ($q) use ($request) {
                return $q->where('status_kedatangan', $request->status_kedatangan);
            });

            $query->when($request->filled('disetujui_dokter'), function ($q) use ($request) {
                return $q->where('disetujui_dokter', $request->disetujui_dokter);
            });

            $query->when($request->filled('pasien_id'), function ($q) use ($request) {
                return $q->where('pasien_id', $request->pasien_id);
            });


            $dataTransaksi = $query->latest('tanggal_kunjungan')->get();

            if ($validatedEkstensi['ekstensiTransaksi'] == 'pdf') {
                $pdf = PDF::loadView('laporan.pdf.transaksi', [
                    'dataTransaksi' => $dataTransaksi,
                    'awal' => $request->awalKunjungan,
                    'akhir' => $request->akhirKunjungan,
                ])->setPaper('a4', 'landscape');;
                return $pdf->stream('laporan-transaksi.pdf');
            } else if ($validatedEkstensi['ekstensiTransaksi'] == 'excel') {
                return Excel::download(new TransaksiExport($dataTransaksi), 'laporan-transaksi-' . now()->format('Y-m-d') . '.xlsx');
            }
        } catch (\Exception $e) {
            Alert::error('Error', "Terjadi kesalahan saat mengekspor data");
            Log::error('Gagal Export Data', ['error' => $e->getMessage()]);
            return back()->withInput();
        }
    }

    public function exportResepObat(Request $request)
    {

        $validatedData = $request->validate(
            [
                'rekam_medis_id'      => 'required',
                'ekstensiResepObat' => 'required',
            ],
            [
                'rekam_medis_id.required' => 'Kolom Kunjungan Pasien Harus Diisi !'
            ]
        );

        try {

            $query = ResepObat::with(['obat', 'rekam_medis.pasien'])
                ->where('rekam_medis_id', $validatedData['rekam_medis_id']);

            $dataResepObat = $query->get();


            $rekamMedis = RekamMedis::with('pasien')->find($validatedData['rekam_medis_id']);
            $pasien = $rekamMedis->pasien;


            if ($validatedData['ekstensiResepObat'] == 'pdf') {
                $pdf = PDF::loadView('laporan.pdf.resep-obat', [
                    'dataResepObat' => $dataResepObat,
                    'pasien' => $pasien,
                    'rekamMedis' => $rekamMedis,
                ])->setPaper('a4', 'portrait');

                return $pdf->stream('laporan-resep-' . Str::slug($pasien->nama_lengkap) . '.pdf');
            } else if ($validatedData['ekstensiResepObat'] == 'excel') {
                return Excel::download(new ResepObatExport($dataResepObat), 'laporan-resep-' . Str::slug($pasien->nama_lengkap) . '.xlsx');
            }
        } catch (\Exception $e) {
            Alert::error('Error', "Terjadi kesalahan saat mengekspor data");
            Log::error('Gagal Export Data', ['error' => $e->getMessage()]);
            return back()->withInput();
        }
    }

    public function exportPasien(Request $request)
    {
        $validatedData = $request->validate(['ekstensiPasien' => 'required']);

        try {
            $dataPasien = Pasien::get();

            if ($validatedData['ekstensiPasien'] == 'pdf') {
                $pdf = PDF::loadView('laporan.pdf.pasien', [
                    'dataPasien' => $dataPasien,
                ]);

                return $pdf->stream('laporan-pasien.pdf');
            } else if ($validatedData['ekstensiPasien'] == 'excel') {
                return Excel::download(new PasienExport($dataPasien), 'laporan-pasien.xlsx');
            }
        } catch (\Exception $e) {
            Alert::error('Error', "Terjadi kesalahan saat mengekspor data");
            Log::error('Gagal Export Data', ['error' => $e->getMessage()]);
            return back()->withInput();
        }
    }


    public function getPenjualanObatByDate(Request $request)
    {
        $request->validate(['tanggal' => 'required|date']);

        $penjualanObat = PenjualanObat::with('pasien')
            ->whereDate('tanggal_transaksi', $request->tanggal)
            ->orderBy('kode_transaksi', 'asc')
            ->get();

        return response()->json($penjualanObat);
    }


    public function getRekamMedisByDate(Request $request)
    {
        $request->validate(['tanggal' => 'required|date']);

        $rekamMedis = RekamMedis::with('pasien')
            ->whereDate('tanggal_kunjungan', $request->tanggal)
            ->orderBy('no_antrean', 'asc')
            ->get();

        return response()->json($rekamMedis);
    }
}
