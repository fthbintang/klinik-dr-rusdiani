<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class DetailPenjualanObatExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize, WithColumnFormatting
{
    protected $dataDetailTransaksiObat;

    public function __construct(Collection $dataDetailTransaksiObat)
    {
        $this->dataDetailTransaksiObat = $dataDetailTransaksiObat;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->dataDetailTransaksiObat;
    }

    public function headings(): array
    {
        return [
            'Nama Obat',
            'Kuantitas',
            'Total Harga',
            'Tanggal Transaksi',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'C' => 'Rp #,##0',
        ];
    }

    public function map($transaksi): array
    {
        return [
            $transaksi->obat->nama_obat,
            $transaksi->kuantitas,
            $transaksi->harga_final,
            \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->format('d-m-Y'),
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
