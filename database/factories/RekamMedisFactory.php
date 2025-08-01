<?php

namespace Database\Factories;

use App\Models\Pasien;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RekamMedis>
 */
class RekamMedisFactory extends Factory
{
    private static int $counter = 1;

    public function definition(): array
    {
        $noAntrean = 'UM-' . str_pad(self::$counter++, 2, '0', STR_PAD_LEFT);

        $tanggal = $this->faker->boolean(70)
            ? now()->toDateString()
            : now()->subDays(rand(1, 10))->toDateString();

        $status = $tanggal === now()->toDateString()
            ? $this->faker->randomElement([
                'Booking', 'Datang', 'Diperiksa', 'Selesai', 'Pengambilan Obat'
            ])
            : $this->faker->randomElement(['Selesai', 'Beli Obat']);

        // Inisialisasi jam
        $jamDatang = null;
        $jamDiperiksa = null;
        $jamSelesai = null;

        if (in_array($status, ['Datang', 'Diperiksa', 'Selesai'])) {
            $jamDatang = $this->faker->time();
        }
        if (in_array($status, ['Diperiksa', 'Selesai'])) {
            $jamDiperiksa = $this->faker->time();
        }
        if ($status === 'Selesai') {
            $jamSelesai = $this->faker->time();
        }

        // Ambil pasien yang belum dipakai hari ini
        $pasienId = $this->faker->randomElement(Pasien::pluck('id')->toArray());

        if ($tanggal === now()->toDateString()) {
            $usedIds = DB::table('rekam_medis')
                ->whereDate('tanggal_kunjungan', $tanggal)
                ->pluck('pasien_id')
                ->toArray();

            $availablePasien = Pasien::whereNotIn('id', $usedIds)->inRandomOrder()->first();
            $pasienId = $availablePasien ? $availablePasien->id : $pasienId;
        }

        // disetujui_dokter logika final
        $disetujuiDokter = null;
        if ($status === 'Beli Obat') {
            $disetujuiDokter = null;
        } elseif ($status === 'Pengambilan Obat') {
            $disetujuiDokter = true;
        } else {
            $disetujuiDokter = $jamDiperiksa ? true : false;
        }

        return [
            'pasien_id'         => $pasienId,
            'tanggal_kunjungan' => $tanggal,
            'no_antrean'        => $noAntrean,
            'status_kedatangan' => $status,
            'jam_datang'        => $jamDatang,
            'jam_diperiksa'     => $jamDiperiksa,
            'jam_selesai'       => $jamSelesai,
            'keluhan'           => $this->faker->sentence(6),
            'diagnosis'         => $this->faker->sentence(8),
            'tindakan'          => $this->faker->sentence(5),
            'disetujui_dokter'  => $disetujuiDokter,
            'biaya_total'       => $jamSelesai ? $this->faker->numberBetween(10000, 500000) : null,
            'created_at'        => now(),
            'updated_at'        => now(),
        ];
    }
}