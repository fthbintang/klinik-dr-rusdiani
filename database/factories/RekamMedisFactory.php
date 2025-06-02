<?php

namespace Database\Factories;

use App\Models\Pasien;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RekamMedis>
 */
class RekamMedisFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'pasien_id' => $this->faker->randomElement(Pasien::pluck('id')->toArray()),
            'tanggal_kunjungan' => $this->faker->date(),
            'status_kedatangan' => $this->faker->randomElement(['Booking', 'Datang', 'Tidak Datang', 'Diperiksa', 'Selesai', 'Beli Obat']),
            'jam_datang' => $this->faker->time(),
            'jam_diperiksa' => $this->faker->time(),
            'jam_selesai' => $this->faker->time(),
            'keluhan' => $this->faker->sentence(6),
            'diagnosis' => $this->faker->sentence(8),
            'tindakan' => $this->faker->sentence(5),
            'catatan' => $this->faker->paragraph(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}