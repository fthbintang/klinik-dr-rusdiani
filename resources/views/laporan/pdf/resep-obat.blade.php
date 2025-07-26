<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Resep Obat Pasien</title>
    <style>
        body {
            font-family: 'sans-serif';
            font-size: 10px;
        }

        .header {
            text-align: center;
            margin-bottom: 25px;
        }

        .header h1 {
            margin: 0;
            font-size: 18px;
            text-transform: uppercase;
        }

        .header p {
            margin: 5px 0;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 7px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            font-size: 11px;
            text-align: center;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .footer {
            margin-top: 40px;
            text-align: right;
            font-size: 10px;
        }

        .total-row td {
            font-weight: bold;
        }
    </style>
</head>

<body>

    <div class="header">
        <h1>Laporan Resep Obat</h1>
        <p>Klinik dr. Rusdiani</p>
        @if($pasien)
        <p>Pasien: <strong>{{ $pasien->nama_lengkap }}</strong> (No Antrean: {{ $rekamMedis->no_antrean }})</p>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th>Tanggal Kunjungan</th>
                <th>Nama Obat</th>
                <th class="text-center">Kuantitas</th>
                <th class="text-center">Kategori Obat</th>
                <th class="text-right">Harga Satuan</th>
                <th class="text-right">Harga Final</th>
                <th>Catatan</th>
            </tr>
        </thead>
        <tbody>
            @php $grandTotal = 0; @endphp
            @forelse ($dataResepObat as $resep)
            <tr>
                <td class="text-center">{{
                    \Carbon\Carbon::parse($resep->rekam_medis->tanggal_kunjungan)->format('d-m-Y') }}</td>
                <td>{{ $resep->obat->nama_obat ?? $resep->nama_obat }}</td>
                <td class="text-center">{{ $resep->kuantitas }}</td>
                <td class="text-center">{{ $resep->kategori }}</td>
                <td class="text-right">Rp {{ number_format($resep->harga_per_obat, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($resep->harga_final, 0, ',', '.') }}</td>
                <td>{{ $resep->catatan ?? '-' }}</td>
            </tr>
            @php $grandTotal += $resep->harga_final; @endphp
            @empty
            <tr>
                <td colspan="6" class="text-center">Tidak ada data resep obat untuk pasien ini.</td>
            </tr>
            @endforelse
            @if(!$dataResepObat->isEmpty())
            <tr class="total-row">
                <td colspan="5" class="text-right"><strong>GRAND TOTAL</strong></td>
                <td class="text-right"><strong>Rp {{ number_format($grandTotal, 0, ',', '.') }}</strong></td>
                <td></td>
            </tr>
            @endif
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak pada: {{ now()->format('d F Y, H:i') }}</p>
    </div>

</body>

</html>