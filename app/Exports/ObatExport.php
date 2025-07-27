<?php

namespace App\Exports;

use App\Models\Obat;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class ObatExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize, WithColumnFormatting
{
    protected $dataObat;

    public function __construct(Collection $dataObat)
    {
        $this->dataObat = $dataObat;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->dataObat;
    }

    public function headings(): array
    {
        return [
            'Nama Obat',
            'Kategori',
            'Supplier',
            'Stok',
            'Satuan',
            'Harga',
            'Expired Date',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'F' => 'Rp #,##0',
        ];
    }

    public function map($obat): array
    {
        return [
            $obat->nama_obat,
            $obat->kategori,
            $obat->supplier->nama_supplier ?? 'N/A',
            $obat->stok,
            $obat->satuan,
            $obat->harga,
            \Carbon\Carbon::parse($obat->expired_date)->format('d-m-Y'),
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
