<?php

namespace Database\Seeders;

use App\Models\Obat;
use App\Models\Pasien;
use App\Models\RekamMedis;
use App\Models\ResepObat;
use App\Models\Supplier;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(5)->create();
        Supplier::factory(5)->create();
        Obat::factory(10)->create();
        Pasien::factory(30)->create();
        // RekamMedis::factory(30)->create();
        // ResepObat::factory(30)->create();

        User::create([
            'nama_lengkap' => 'Muhammad Bintang Fathehah',
            'nama_panggilan' => 'Bintang',
            'jenis_kelamin' => 'Laki-laki',
            'role' => 'Admin',
            'alamat' => 'Banjarmasin',
            'username' => 'bintang',
            'password' => bcrypt('bintang')
        ]);
    }
}