<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ResepObatExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize, WithColumnFormatting
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
            'Tanggal Kunjungan',
            'Nama Obat',
            'Kuantitas',
            'Kategori Obat',
            'Harga Satuan',
            'Harga Final',
            'Catatan',
        ];
    }

    public function map($resep): array
    {
        return [
            \Carbon\Carbon::parse($resep->rekam_medis->tanggal_kunjungan)->format('d-m-Y'),
            $resep->obat->nama_obat ?? $resep->nama_obat, // Menangani obat custom
            $resep->kuantitas,
            $resep->kategori,
            $resep->harga_per_obat,
            $resep->harga_final,
            $resep->catatan,
        ];
    }

    public function columnFormats(): array
    {
        return [
            'E' => 'Rp #,##0', // Format Harga Satuan
            'F' => 'Rp #,##0', // Format Harga Final
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Membuat baris header menjadi bold
        $sheet->getStyle('1:1')->getFont()->setBold(true);
    }
}
