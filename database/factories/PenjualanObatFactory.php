<?php

namespace Database\Factories;

use Carbon\Carbon;
use App\Models\Pasien;
use App\Models\PenjualanObat;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PenjualanObat>
 */
class PenjualanObatFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Tanggal hari ini
        $tanggalHariIni = Carbon::today()->toDateString();

        // Hitung jumlah penjualan yang sudah ada di tanggal hari ini
        $jumlahHariIni = PenjualanObat::whereDate('tanggal_transaksi', $tanggalHariIni)->count();

        // Nomor urut berikutnya
        $nomorUrut = $jumlahHariIni + 1;

        // Format kode transaksi, misal OBT-01, OBT-02
        $kodeTransaksi = 'OBT-' . str_pad($nomorUrut, 2, '0', STR_PAD_LEFT);

        return [
            'kode_transaksi' => $kodeTransaksi,
            'pasien_id' => $this->faker->optional()->randomElement(Pasien::pluck('id')->toArray()),
            'tanggal_transaksi' => $tanggalHariIni,
            'total_harga' => $this->faker->numberBetween(10000, 300000),
            'catatan' => $this->faker->optional()->sentence(),
        ];
    }
}