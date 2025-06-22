<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Pasien;
use App\Models\RekamMedis;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PenjualanObat;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $jumlah_pasien = Pasien::count();

        $kunjungan_berobat_hari_ini = RekamMedis::whereDate('tanggal_kunjungan', Carbon::today())->count();
        $kunjungan_membeli_obat_hari_ini = PenjualanObat::whereDate('tanggal_transaksi', Carbon::today())->count();

        $awalBulan = Carbon::now()->startOfMonth();
        $akhirBulan = Carbon::now()->endOfMonth();

        $pendapatan_rekam_medis = RekamMedis::whereBetween('tanggal_kunjungan', [$awalBulan, $akhirBulan])->sum('biaya_total');
        $pendapatan_penjualan_obat = PenjualanObat::whereBetween('tanggal_transaksi', [$awalBulan, $akhirBulan])->sum('total_harga');
        $pendapatan_bulan_ini = $pendapatan_rekam_medis + $pendapatan_penjualan_obat;

        $pendapatan_hari_ini_rekam_medis = RekamMedis::whereDate('tanggal_kunjungan', Carbon::today())->sum('biaya_total');
        $pendapatan_hari_ini_penjualan_obat = PenjualanObat::whereDate('tanggal_transaksi', Carbon::today())->sum('total_harga');
        $pendapatan_hari_ini = $pendapatan_hari_ini_rekam_medis + $pendapatan_hari_ini_penjualan_obat;

        $selected_month = $request->input('month', now()->month);
        $selected_year = $request->input('year', now()->year);

        $pendapatanPerBulan = $this->getPendapatanPerBulan($selected_month, $selected_year);

        return view('dashboard', [
            'title' => 'Dashboard',
            'jumlah_pasien' => $jumlah_pasien,
            'kunjungan_berobat_hari_ini' => $kunjungan_berobat_hari_ini,
            'kunjungan_membeli_obat_hari_ini' => $kunjungan_membeli_obat_hari_ini,
            'pendapatan_bulan_ini' => $pendapatan_bulan_ini,
            'pendapatan_hari_ini' => $pendapatan_hari_ini,
            'chart_dates' => $pendapatanPerBulan['dates'],
            'chart_totals' => $pendapatanPerBulan['totals'],
            'selected_month' => $selected_month,
            'selected_year' => $selected_year,
        ]);
    }

    private function getPendapatanPerBulan($bulan, $tahun)
    {
        $data = [];
        $dates = [];

        Carbon::setLocale('id');

        $startOfMonth = Carbon::create($tahun, $bulan, 1)->startOfDay();
        $endOfMonth = $startOfMonth->copy()->endOfMonth();

        for ($date = $startOfMonth; $date->lte($endOfMonth); $date->addDay()) {
            $tanggal = $date->format('Y-m-d');
            $label = $date->translatedFormat('l, d F Y');

            $pendapatan_rekam_medis = RekamMedis::whereDate('tanggal_kunjungan', $tanggal)->sum('biaya_total');
            $pendapatan_obat = PenjualanObat::whereDate('tanggal_transaksi', $tanggal)->sum('total_harga');

            $dates[] = $label;
            $data[] = $pendapatan_rekam_medis + $pendapatan_obat;
        }

        return [
            'dates' => $dates,
            'totals' => $data,
        ];
    }

}