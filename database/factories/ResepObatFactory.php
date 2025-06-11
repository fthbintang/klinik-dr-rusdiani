<?php

namespace Database\Factories;

use App\Models\Obat;
use App\Models\RekamMedis;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ResepObat>
 */
class ResepObatFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $obat = Obat::inRandomOrder()->first();

        $harga = $obat?->harga ?? $this->faker->numberBetween(10000, 50000);
        $kuantitas = $this->faker->numberBetween(1, 5);

        return [
            'rekam_medis_id' => $this->faker->randomElement(RekamMedis::pluck('id')->toArray()),
            'obat_id' => $obat?->id,
            'nama_obat' => $obat?->nama ?? $this->faker->word(),
            'kategori' => $obat?->kategori ?? $this->faker->randomElement(['Tablet', 'Kapsul', 'Sirup']),
            'satuan' => $obat?->satuan ?? 'Strip',
            'expired_date' => $this->faker->dateTimeBetween('+1 month', '+2 years')->format('Y-m-d'),
            'harga_per_obat' => $harga,
            'kuantitas' => $kuantitas,
            'harga_final' => $harga * $kuantitas,
        ];
    }
}