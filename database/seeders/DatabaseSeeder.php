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
        Pasien::factory(10)->create();
        // RekamMedis::factory(30)->create();
        // ResepObat::factory(30)->create();
        // PenjualanObat::factory(50)->create();

        User::create([
            'nama_lengkap' => 'Muhammad Bintang Fathehah',
            'nama_panggilan' => 'Bintang',
            'jenis_kelamin' => 'Laki-laki',
            'role' => 'Admin',
            'alamat' => 'Banjarmasin',
            'username' => 'admin',
            'password' => bcrypt('admin')
        ]);

        // User::create([
        //     'nama_lengkap' => 'Pasien',
        //     'nama_panggilan' => 'pasien',
        //     'jenis_kelamin' => 'Laki-laki',
        //     'role' => 'Pasien',
        //     'alamat' => 'Banjarmasin',
        //     'username' => 'pasien',
        //     'password' => bcrypt('pasien')
        // ]);

        // Buat user terlebih dahulu
        $user = User::create([
            'nama_lengkap'   => 'Pasien',
            'nama_panggilan' => 'pasien',
            'jenis_kelamin'  => 'Laki-laki',
            'role'           => 'Pasien',
            'alamat'         => 'Banjarmasin',
            'username'       => 'pasien',
            'password'       => bcrypt('pasien')
        ]);

        // Hitung jumlah pasien yang sudah ada untuk menentukan nomor urut selanjutnya
        $jumlahPasien = Pasien::count() + 1;

        // Format nomor rekam medis menjadi RM-01, RM-02, dst.
        $no_rm = 'RM-' . str_pad($jumlahPasien, 2, '0', STR_PAD_LEFT);

        // Buat NIK random 16 digit
        $nik = '';
        for ($i = 0; $i < 4; $i++) {
            $nik .= str_pad(mt_rand(0, 9999), 4, '0', STR_PAD_LEFT);
        }

        // Setelah user dibuat, langsung buat data pasien
        Pasien::create([
            'user_id'           => $user->id,
            'no_rm'             => $no_rm,
            'nama_lengkap'      => $user->nama_lengkap,
            'nama_panggilan'    => $user->nama_panggilan,
            'nik'               => $nik,
            'jenis_kelamin'     => $user->jenis_kelamin,
            'no_hp'             => fake()->phoneNumber(),
            'tempat_lahir'      => 'Banjarmasin',
            'tanggal_lahir'     => fake()->date('Y-m-d', '-25 years'),
            'alamat'            => $user->alamat,
            'pekerjaan'         => 'Karyawan',
            'status_perkawinan' => 'Belum Kawin',
            'golongan_darah'    => 'O',
            'agama'             => 'Islam',
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