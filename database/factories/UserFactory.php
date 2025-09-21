<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = \Faker\Factory::create('id_ID');
        $gender = $this->faker->randomElement(['Laki-laki', 'Perempuan']);
        
        return [
            'nama_lengkap' => $faker->name(),
            'nama_panggilan' => $faker->firstName(),
            'jenis_kelamin' => $gender,
            'tanggal_lahir' => $this->faker->date('Y-m-d', '2005-12-31'),
            'no_hp' => $this->faker->phoneNumber(),
            'alamat' => $this->faker->address(),
            'foto' => null,
            'role' => $this->faker->randomElement(['Dokter', 'Admin', 'Apotek', 'Pasien']),
            'username' => $this->faker->unique()->userName(),
            'email'          => $this->faker->unique()->safeEmail(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}