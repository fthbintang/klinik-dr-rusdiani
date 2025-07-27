<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PasienExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $data;

    public function __construct(Collection $data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data;
    }

    public function headings(): array
    {
        return [
            'Nama Lengkap',
            'NIK',
            'Jenis Kelamin',
            'No. HP',
            'Tempat / Tanggal Lahir',
            'Alamat',
            'Pekerjaan',
            'Status Perkawinan',
            'Golongan Darah',
            'Agama'
        ];
    }

    public function map($pasien): array
    {
        return [
            $pasien->nama_lengkap,
            "'" . $pasien->nik,
            $pasien->jenis_kelamin,
            $pasien->no_hp,
            $pasien->tempat_lahir . ', ' . $pasien->tanggal_lahir,
            $pasien->alamat,
            $pasien->pekerjaan,
            $pasien->status_perkawinan,
            $pasien->golongan_darah,
            $pasien->agama
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Membuat baris header menjadi bold
        $sheet->getStyle('1:1')->getFont()->setBold(true);
    }
}
