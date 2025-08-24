<?php

namespace Database\Factories;

use App\Models\Dokter;
use App\Models\Pasien;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RekamMedis>
 */
class RekamMedisFactory extends Factory
{
    // private static int $counter = 1;

    // public function definition(): array
    // {
    //     $noAntrean = 'UM-' . str_pad(self::$counter++, 2, '0', STR_PAD_LEFT);

    //     $tanggal = $this->faker->boolean(70)
    //         ? now()->toDateString()
    //         : now()->subDays(rand(1, 10))->toDateString();

    //     $status = $tanggal === now()->toDateString()
    //         ? $this->faker->randomElement([
    //             'Booking', 'Datang', 'Diperiksa', 'Selesai', 'Pengambilan Obat'
    //         ])
    //         : $this->faker->randomElement(['Selesai', 'Beli Obat']);

    //     // Inisialisasi jam
    //     $jamDatang = null;
    //     $jamDiperiksa = null;
    //     $jamSelesai = null;

    //     if (in_array($status, ['Datang', 'Diperiksa', 'Selesai'])) {
    //         $jamDatang = $this->faker->time();
    //     }
    //     if (in_array($status, ['Diperiksa', 'Selesai'])) {
    //         $jamDiperiksa = $this->faker->time();
    //     }
    //     if ($status === 'Selesai') {
    //         $jamSelesai = $this->faker->time();
    //     }

    //     // Ambil pasien yang belum dipakai hari ini
    //     $pasienId = $this->faker->randomElement(Pasien::pluck('id')->toArray());

    //     if ($tanggal === now()->toDateString()) {
    //         $usedIds = DB::table('rekam_medis')
    //             ->whereDate('tanggal_kunjungan', $tanggal)
    //             ->pluck('pasien_id')
    //             ->toArray();

    //         $availablePasien = Pasien::whereNotIn('id', $usedIds)->inRandomOrder()->first();
    //         $pasienId = $availablePasien ? $availablePasien->id : $pasienId;
    //     }

    //     // disetujui_dokter logika final
    //     $disetujuiDokter = null;
    //     if ($status === 'Beli Obat') {
    //         $disetujuiDokter = null;
    //     } elseif ($status === 'Pengambilan Obat') {
    //         $disetujuiDokter = true;
    //     } else {
    //         $disetujuiDokter = $jamDiperiksa ? true : false;
    //     }

    //     return [
    //         'pasien_id'         => $pasienId,
    //         'tanggal_kunjungan' => $tanggal,
    //         'no_antrean'        => $noAntrean,
    //         'status_kedatangan' => $status,
    //         'jam_datang'        => $jamDatang,
    //         'jam_diperiksa'     => $jamDiperiksa,
    //         'jam_selesai'       => $jamSelesai,
    //         'keluhan'           => $this->faker->sentence(6),
    //         'diagnosis'         => $this->faker->sentence(8),
    //         'tindakan'          => $this->faker->sentence(5),
    //         'disetujui_dokter'  => $disetujuiDokter,
    //         'biaya_total'       => $jamSelesai ? $this->faker->numberBetween(10000, 500000) : null,
    //         'created_at'        => now(),
    //         'updated_at'        => now(),
    //     ];
    // }

    public function definition(): array
    {
        $dokter = Dokter::inRandomOrder()->first();
        $pasien = Pasien::inRandomOrder()->first();

        // 50% tanggal hari ini, 50% random date
        $tanggal = $this->faker->boolean ? now()->toDateString() : $this->faker->date();

        $jamDatang = $this->faker->time('H:i:s', 'now');
        $jamDiperiksa = date('H:i:s', strtotime($jamDatang . ' +15 minutes'));
        $jamSelesai = date('H:i:s', strtotime($jamDiperiksa . ' +30 minutes'));

        return [
            'pasien_id'           => $pasien->id ?? 1,
            'dokter_id'           => $dokter->id ?? 1,
            'berat_badan'         => $this->faker->numberBetween(45, 100),
            'tensi'               => $this->faker->numberBetween(90, 140) . '/' . $this->faker->numberBetween(60, 90),
            'no_antrean'          => $this->faker->unique()->numerify('A###'),
            'tanggal_kunjungan'   => $tanggal,
            'status_kedatangan'   => $this->faker->randomElement(['Datang','Tidak Datang','Menunggu']),
            'jam_datang'          => $jamDatang,
            'jam_diperiksa'       => $jamDiperiksa,
            'jam_selesai'         => $jamSelesai,
            'keluhan'             => $this->faker->sentence(6),
            'alergi_obat'         => $this->faker->sentence(3),
            'diagnosis'           => $this->faker->sentence(5),
            'tindakan'            => $this->faker->sentence(4),
            'surat_rujukan'       => $this->faker->optional()->sentence(2),
            'disetujui_dokter'    => $this->faker->boolean(),
            'biaya_jasa'          => $this->faker->numberBetween(50000, 500000),
            'biaya_total'         => $this->faker->numberBetween(50000, 1000000),
            'created_at'          => now(),
            'updated_at'          => now(),
        ];
    }
}