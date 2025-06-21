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
        $namaObatList = [
            'Paracetamol', 'Amoxicillin', 'Ibuprofen', 'Cetirizine', 'Loperamide',
            'Antasida Doen', 'Metronidazole', 'Salbutamol', 'Amlodipine', 'Simvastatin',
            'Omeprazole', 'Dextromethorphan', 'Betadine', 'Kalpanax', 'Bodrex',
            'Promag', 'Sanmol', 'Neurobion', 'Antimo', 'Diapet'
        ];
    
        $keteranganList = [
            'Obat ini digunakan untuk meredakan demam dan nyeri ringan.',
            'Digunakan untuk mengatasi infeksi bakteri.',
            'Efektif untuk mengurangi peradangan dan nyeri.',
            'Membantu meredakan alergi dan gatal-gatal.',
            'Digunakan untuk mengatasi diare akut.',
            'Obat ini berfungsi sebagai penurun asam lambung.',
            'Membantu mengatasi infeksi saluran pernapasan.',
            'Digunakan sebagai bronkodilator untuk asma.',
            'Obat untuk menurunkan tekanan darah tinggi.',
            'Digunakan untuk menurunkan kadar kolesterol dalam darah.',
            'Obat ini membantu mengatasi gangguan pencernaan.',
            'Efektif meredakan batuk kering.',
            'Digunakan sebagai antiseptik untuk luka luar.',
            'Obat ini membantu mengurangi rasa sakit ringan hingga sedang.',
            'Digunakan untuk meredakan sakit kepala dan demam.',
            'Obat ini berfungsi sebagai penetral asam lambung.',
            'Digunakan untuk mengatasi kekurangan vitamin B kompleks.',
            'Efektif untuk mencegah mual dan muntah.',
            'Obat ini digunakan untuk mengatasi diare ringan.'
        ];
    
        return [
            'nama_obat' => $this->faker->randomElement($namaObatList),
            'kategori' => $this->faker->randomElement(['Tablet', 'Kapsul', 'Sirup', 'Salep', 'Injeksi']),
            'satuan' => $this->faker->randomElement(['pcs', 'strip', 'botol', 'tube']),
            'stok' => $this->faker->numberBetween(10, 200),
            'harga' => $this->faker->numberBetween(1000, 50000),
            'expired_date' => $this->faker->dateTimeBetween('+1 month', '+2 years')->format('Y-m-d'),
            'supplier_id' => Supplier::factory(),
            'keterangan' => $this->faker->randomElement($keteranganList),
            'obat_bebas' => $this->faker->numberBetween(0, 1),
        ];
    }
    
    
}