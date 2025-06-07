<?php

namespace Database\Factories;

use App\Models\Pasien;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RekamMedis>
 */
class RekamMedisFactory extends Factory
{
    private static int $counter = 1;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $noAntrean = 'UM-' . str_pad(self::$counter++, 2, '0', STR_PAD_LEFT);
        
        return [
            'pasien_id' => $this->faker->randomElement(Pasien::pluck('id')->toArray()),
            // 'tanggal_kunjungan' => $this->faker->date(),
            'tanggal_kunjungan' => now()->toDateString(),
            'no_antrean' => $noAntrean,
            'status_kedatangan' => $this->faker->randomElement(['Booking', 'Datang', 'Tidak Datang', 'Diperiksa', 'Selesai', 'Beli Obat']),
            'jam_datang' => $this->faker->time(),
            'jam_diperiksa' => $this->faker->time(),
            'jam_selesai' => $this->faker->time(),
            'keluhan' => $this->faker->sentence(6),
            'diagnosis' => $this->faker->sentence(8),
            'tindakan' => $this->faker->sentence(5),
            'catatan' => $this->faker->paragraph(),
            'biaya_total' => $this->faker->numberBetween(10000, 500000),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}