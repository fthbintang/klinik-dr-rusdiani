<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Data Transaksi Obat</title>
    <style>
        body {
            font-family: 'sans-serif';
            font-size: 10px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 18px;
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
            padding: 6px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            font-size: 11px;
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
    </style>
</head>

<body>

    <div class="header">
        <h1>Laporan Transaksi Obat</h1>
        <p>Klinik dr. Rusdiani</p>
        @if(isset($awal) && isset($akhir))
        <p>Periode : {{ \Carbon\Carbon::parse($awal)->format('d F Y') }} s/d {{
            \Carbon\Carbon::parse($akhir)->format('d F Y') }}</p>
        @else
        <p>Semua Periode</p>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th class="text-center">No</th>
                <th>Kode Transaksi</th>
                <th>Nama Pasien</th>
                <th>Tanggal Transaksi</th>
                <th>Total Harga</th>
                <th>Catatan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($dataPenjualanObat as $penjualanObat)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $penjualanObat->kode_transaksi }}</td>
                <td>{{ $penjualanObat->pasien->nama_lengkap == 'Pasien' ? 'N/A' : $penjualanObat->pasien->nama_lengkap
                    ; }}</td>
                <td>{{ $penjualanObat->tanggal_transaksi }}</td>
                <td>Rp {{ number_format($penjualanObat->total_harga, 0, ',', '.') }}</td>
                <td>{{ $penjualanObat->catatan }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">Data Tidak Ada.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <br>
        <br>
        <br>
        <p>Dicetak pada: {{ now()->format('d F Y') }}</p>
    </div>

</body>

</html>