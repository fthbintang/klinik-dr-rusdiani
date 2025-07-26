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

class PenjualanObatExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize, WithColumnFormatting
{
    protected $dataTransaksiObat;

    public function __construct(Collection $dataTransaksiObat)
    {
        $this->dataTransaksiObat = $dataTransaksiObat;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->dataTransaksiObat;
    }

    public function headings(): array
    {
        return [
            'Kode Transaksi',
            'Nama Pasien',
            'Tanggal Transaksi',
            'Total Harga',
            'Catatan',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'D' => 'Rp #,##0',
        ];
    }

    public function map($transaksi): array
    {
        return [
            $transaksi->kode_transaksi,
            $transaksi->pasien->nama_lengkap == 'Pasien' ? 'N/A' : $transaksi->pasien->nama_lengkap,
            \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->format('d-m-Y'),
            $transaksi->total_harga == 0 ? 'Belum Bayar' : $transaksi->total_harga,
            $transaksi->catatan ?? 'N/A',
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
