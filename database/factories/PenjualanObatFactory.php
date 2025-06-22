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
        // Ambil tanggal random dari 30 hari terakhir sampai hari ini
        $tanggalTransaksi = $this->faker->dateTimeBetween('-30 days', 'now')->format('Y-m-d');
    
        // Hitung jumlah penjualan yang sudah ada di tanggal tersebut
        $jumlahPadaTanggal = PenjualanObat::whereDate('tanggal_transaksi', $tanggalTransaksi)->count();
    
        // Nomor urut berikutnya di tanggal tersebut
        $nomorUrut = $jumlahPadaTanggal + 1;
    
        // Format kode transaksi, misal OBT-01, OBT-02
        $kodeTransaksi = 'OBT-' . str_pad($nomorUrut, 2, '0', STR_PAD_LEFT);
    
        return [
            'kode_transaksi' => $kodeTransaksi,
            'pasien_id' => $this->faker->optional()->randomElement(Pasien::pluck('id')->toArray()),
            'tanggal_transaksi' => $tanggalTransaksi,
            'total_harga' => $this->faker->numberBetween(10000, 300000),
            'catatan' => $this->faker->optional()->sentence(),
        ];
    }
    
}