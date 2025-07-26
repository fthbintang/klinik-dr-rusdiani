<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ObatMasukExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
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
            'Nama Obat',
            'Tanggal Masuk Obat',
            'Supplier',
            'Stok Awal',
            'Stok Masuk',
            'Stok Final',
        ];
    }

    public function map($item): array
    {
        return [
            $item->obat->nama_obat ?? 'N/A',
            \Carbon\Carbon::parse($item->tanggal_obat_masuk)->format('d-m-Y'),
            $item->obat->supplier->nama_supplier ?? 'N/A',
            $item->stok_awal,
            $item->stok_masuk,
            $item->stok_final,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Membuat baris header menjadi bold
        $sheet->getStyle('1:1')->getFont()->setBold(true);

        // Membuat semua data di sel menjadi rata tengah
        // Anda bisa menyesuaikan range jika perlu
        $sheet->getStyle('A1:' . $sheet->getHighestColumn() . $sheet->getHighestRow())
            ->getAlignment()
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    }
}
