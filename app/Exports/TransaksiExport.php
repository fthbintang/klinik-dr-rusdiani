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

class TransaksiExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize, WithColumnFormatting
{
    protected $dataTransaksi;

    public function __construct(Collection $dataTransaksi)
    {
        $this->dataTransaksi = $dataTransaksi;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->dataTransaksi;
    }

    /**
     * Menentukan header untuk setiap kolom.
     */
    public function headings(): array
    {
        return [
            'Tanggal Kunjungan',
            'No. Antrean',
            'Nama Pasien',
            'Keluhan',
            'Status',
            'Jam Datang',
            'Jam Diperiksa',
            'Jam Selesai',
            'Diagnosis',
            'Tindakan',
            'Biaya Jasa',
            'Total Biaya',
            'Disetujui Dokter',
        ];
    }

    /**
     * Memetakan data yang akan ditampilkan di setiap baris.
     */
    public function map($transaksi): array
    {
        return [
            \Carbon\Carbon::parse($transaksi->tanggal_kunjungan)->format('d-m-Y'),
            $transaksi->no_antrean,
            $transaksi->pasien->nama_lengkap ?? 'N/A',
            $transaksi->keluhan,
            $transaksi->status_kedatangan,
            $transaksi->jam_datang ? $transaksi->jam_datang : 'N/A',
            $transaksi->jam_diperiksa ? $transaksi->jam_diperiksa : 'N/A',
            $transaksi->jam_selesai ? $transaksi->jam_selesai : 'N/A',
            $transaksi->diagnosis ? $transaksi->diagnosis : 'N/A',
            $transaksi->tindakan ? $transaksi->tindakan : 'N/A',
            $transaksi->biaya_jasa ? $transaksi->biaya_jasa : 'N/A',
            $transaksi->biaya_total ? $transaksi->biaya_total : 'N/A',
            $transaksi->disetujui_dokter ? 'Ya' : 'Belum',
        ];
    }

    /**
     * Menerapkan format Rupiah pada kolom Total Biaya.
     */
    public function columnFormats(): array
    {
        return [
            // Kolom F adalah Total Biaya
            'K' => 'Rp #,##0',
            'L' => 'Rp #,##0',
        ];
    }

    /**
     * Menerapkan styling (bold header dan rata tengah).
     */
    public function styles(Worksheet $sheet)
    {
        // Membuat baris header (baris 1) menjadi bold
        $sheet->getStyle('1:1')->getFont()->setBold(true);

        // Membuat semua data di sel menjadi rata tengah
        $sheet->getStyle('A1:' . $sheet->getHighestColumn() . $sheet->getHighestRow())
            ->getAlignment()
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    }
}
