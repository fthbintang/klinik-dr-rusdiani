<?php

namespace Database\Factories;

use App\Models\Poli;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Dokter>
 */
class DokterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama_dokter'    => $this->faker->name(),
            'poli_id'        => Poli::inRandomOrder()->first()->id ?? 1, // Ambil random poli, fallback 1
            'no_str'         => 'STR-' . $this->faker->unique()->numerify('######'),
            'no_sip'         => 'SIP-' . $this->faker->unique()->numerify('######'),
            'jenis_kelamin'  => $this->faker->randomElement(['Laki-laki', 'Perempuan']),
            'tanggal_lahir'  => $this->faker->date('Y-m-d'), // bisa juga diconvert ke string
            'alamat'         => $this->faker->address(),
            'created_at'     => now(),
            'updated_at'     => now(),
        ];
    }
}