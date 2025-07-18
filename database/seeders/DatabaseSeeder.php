<?php

namespace Database\Seeders;

use App\Models\Obat;
use App\Models\Pasien;
use App\Models\PenjualanObat;
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
        Pasien::factory(100)->create();
        RekamMedis::factory(30)->create();
        ResepObat::factory(30)->create();
        PenjualanObat::factory(50)->create();

        User::create([
            'nama_lengkap' => 'Muhammad Bintang Fathehah',
            'nama_panggilan' => 'Bintang',
            'jenis_kelamin' => 'Laki-laki',
            'role' => 'Admin',
            'alamat' => 'Banjarmasin',
            'username' => 'admin',
            'password' => bcrypt('admin')
        ]);

        User::create([
            'nama_lengkap' => 'Pasien',
            'nama_panggilan' => 'pasien',
            'jenis_kelamin' => 'Laki-laki',
            'role' => 'Pasien',
            'alamat' => 'Banjarmasin',
            'username' => 'pasien',
            'password' => bcrypt('pasien')
        ]);

        User::create([
            'nama_lengkap' => 'dokter',
            'nama_panggilan' => 'dokter',
            'jenis_kelamin' => 'Laki-laki',
            'role' => 'Dokter',
            'alamat' => 'Banjarmasin',
            'username' => 'dokter',
            'password' => bcrypt('dokter')
        ]);

        User::create([
            'nama_lengkap' => 'Apotek',
            'nama_panggilan' => 'Apotek',
            'jenis_kelamin' => 'Laki-laki',
            'role' => 'Apotek',
            'alamat' => 'Banjarmasin',
            'username' => 'apotek',
            'password' => bcrypt('apotek')
        ]);
    }
}