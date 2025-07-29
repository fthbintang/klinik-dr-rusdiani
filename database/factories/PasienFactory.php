<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Pasien;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pasien>
 */
class PasienFactory extends Factory
{
    protected static int $increment = 1;

    public function definition(): array
    {
        $faker = \Faker\Factory::create('id_ID'); // Lokalisasi ke bahasa Indonesia

        $noRm = 'RM-' . str_pad(self::$increment, 2, '0', STR_PAD_LEFT);
        self::$increment++;

        return [
            'user_id' => User::factory(),
            'no_rm' => $noRm,
            'nama_lengkap' => $faker->name(),
            'nama_panggilan' => $faker->firstName(),
            'nik' => $faker->unique()->numerify('################'),
            'jenis_kelamin' => $faker->randomElement(['Laki-laki', 'Perempuan']),
            'no_hp' => '08' . $this->faker->numerify('##########'),
            'tempat_lahir' => $faker->city(),
            'tanggal_lahir' => $faker->date('Y-m-d'),
            'alamat' => $faker->address(),
            'pekerjaan' => $faker->jobTitle(),
            'status_perkawinan' => $faker->randomElement(['Belum Menikah', 'Menikah', 'Cerai']),
            'golongan_darah' => $faker->randomElement(['A', 'B', 'AB', 'O']),
            'agama' => $faker->randomElement(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}