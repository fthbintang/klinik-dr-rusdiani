<?php

namespace Database\Factories;

use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Obat>
 */
class ObatFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama_obat' => $this->faker->word(),
            'kategori' => $this->faker->randomElement(['Tablet', 'Kapsul', 'Sirup', 'Salep', 'Injeksi']),
            'satuan' => $this->faker->randomElement(['pcs', 'strip', 'botol', 'tube']),
            'stok' => $this->faker->numberBetween(10, 200),
            'harga' => $this->faker->numberBetween(1000, 50000),
            'expired_date' => $this->faker->dateTimeBetween('+1 month', '+2 years')->format('Y-m-d'),
            'supplier_id' => Supplier::factory(), // Membuat supplier otomatis
            'keterangan' => $this->faker->sentence(),
        ];
    }
}