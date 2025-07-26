<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Data Detail Transaksi Obat</title>
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
        <h1>Laporan Detail Transaksi Obat</h1>
        <p>Klinik dr. Rusdiani</p>
        <p>{{ $kodeTransaksi }} - {{ $namaPasien }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th class="text-center">No</th>
                <th>Nama Obat</th>
                <th>Kuantitas</th>
                <th>Tanggal Transaksi</th>
                <th>Total Harga</th>
            </tr>
        </thead>
        <tbody>
            <?php $grandTotal = 0 ?>
            @forelse ($dataDetailPenjualanObat as $detailPenjualanObat)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $detailPenjualanObat->obat->nama_obat }}</td>
                <td>{{ $detailPenjualanObat->kuantitas }}</td>
                <td>{{ $detailPenjualanObat->penjualan_obat->tanggal_transaksi }}</td>
                <td>Rp {{ number_format($detailPenjualanObat->harga_final, 0, ',', '.') }}</td>
                <?php $grandTotal += $detailPenjualanObat->harga_final ?>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">Data Tidak Ada.</td>
            </tr>
            @endforelse
            <tr>
                <td colspan="4" class="text-center"><b>Total Harga :</b></td>
                <td>
                    Rp.
                    <?= number_format($grandTotal, 0, ',', '.'); ?>
                </td>
            </tr>
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