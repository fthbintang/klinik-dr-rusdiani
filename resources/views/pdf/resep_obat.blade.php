<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Resep Obat - {{ $pasien->nama_lengkap }}</title>
    <style>
        body {
            font-family: "DejaVu Sans", sans-serif;
            font-size: 12px;
            color: #333;
            padding: 30px;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .header h2 {
            margin: 0;
        }

        .section-title {
            font-weight: bold;
            margin-top: 25px;
            margin-bottom: 10px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 3px;
        }

        .info-left p,
        .info-right p {
            margin: 5px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #aaa;
            padding: 6px;
            text-align: left;
        }

        th {
            background-color: #eaeaea;
        }

        .footer {
            margin-top: 40px;
            text-align: right;
            font-size: 10px;
        }

        .signature {
            margin-top: 60px;
            text-align: right;
        }

        .signature p {
            margin-bottom: 60px;
        }

        .small {
            font-size: 10px;
            color: #777;
        }
    </style>
</head>

<body>

    <div class="header">
        <h2>Resep Obat</h2>
        <p class="small">Klinik Kesehatan - Sistem Informasi Rekam Medis</p>
    </div>

    {{-- Bagian Informasi --}}
    <div class="section-title">Informasi Pasien & Kunjungan</div>
    <table style="width: 100%; margin-bottom: 20px;">
        <tr>
            <td style="width: 50%; vertical-align: top;">
                <p><strong>Nama Pasien:</strong> {{ $pasien->nama_lengkap }}</p>
                <p><strong>No. Antrean:</strong> {{ $rekam_medis->no_antrean }}</p>
                <p><strong>Tanggal Kunjungan:</strong>
                    {{ \Carbon\Carbon::parse($rekam_medis->tanggal_kunjungan)->format('d-m-Y') }}</p>
            </td>
            <td style="width: 50%; vertical-align: top;">
                <p><strong>Jam Datang:</strong> {{ $rekam_medis->jam_datang ?? '-' }}</p>
                <p><strong>Jam Diperiksa:</strong> {{ $rekam_medis->jam_diperiksa ?? '-' }}</p>
                <p><strong>Jam Selesai:</strong> {{ $rekam_medis->jam_selesai ?? '-' }}</p>
            </td>

        </tr>
    </table>


    {{-- Bagian Medis --}}
    <div class="section-title">Detail Medis</div>
    <p><strong>Keluhan:</strong> {{ $rekam_medis->keluhan ?? '-' }}</p>
    <p><strong>Diagnosis:</strong> {{ $rekam_medis->diagnosis ?? '-' }}</p>
    <p><strong>Tindakan:</strong> {{ $rekam_medis->tindakan ?? '-' }}</p>

    {{-- Resep Obat --}}
    <div class="section-title">Daftar Resep Obat</div>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Obat</th>
                <th>Kategori</th>
                <th>Satuan</th>
                <th>Expired</th>
                <th>Harga/Obat</th>
                <th>Qty</th>
                <th>Total</th>
                <th>Catatan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($resep_obat as $index => $resep)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $resep->nama_obat }}</td>
                    <td>{{ $resep->kategori ?? '-' }}</td>
                    <td>{{ $resep->satuan ?? '-' }}</td>
                    <td>{{ $resep->expired_date ? \Carbon\Carbon::parse($resep->expired_date)->format('d-m-Y') : '-' }}
                    </td>
                    <td>Rp {{ number_format($resep->harga_per_obat, 0, ',', '.') }}</td>
                    <td>{{ $resep->kuantitas }}</td>
                    <td>Rp {{ number_format($resep->harga_final, 0, ',', '.') }}</td>
                    <td>{{ $resep->catatan ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="7" style="text-align: right;"><strong>Biaya Jasa</strong></td>
                <td colspan="2">Rp {{ number_format($rekam_medis->biaya_jasa, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td colspan="7" style="text-align: right;"><strong>Grand Total</strong></td>
                <td colspan="2"><strong>Rp {{ number_format($rekam_medis->biaya_total, 0, ',', '.') }}</strong></td>
            </tr>
        </tfoot>

    </table>

    {{-- Footer --}}
    <div class="footer">
        Dicetak pada {{ \Carbon\Carbon::now()->format('d-m-Y H:i') }}
    </div>

</body>

</html>
