<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Poli>
 */
class PoliFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $namaPoli = $this->faker->randomElement([
            'Poli Umum',
            'Poli Gigi',
            'Poli Anak',
            'Poli Kandungan',
            'Poli Kulit & Kelamin',
            'Poli THT'
        ]);

        return [
            'nama_poli' => $namaPoli
        ];
    }
}