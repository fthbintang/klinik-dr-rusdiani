<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Struk Penjualan Obat</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 13px;
            margin: 20px;
            color: #333;
        }

        h2 {
            text-align: center;
            margin-bottom: 10px;
        }

        p {
            margin: 4px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        thead {
            background-color: #f0f0f0;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 6px 8px;
        }

        th {
            text-align: center;
        }

        td {
            vertical-align: top;
        }

        .text-end {
            text-align: right;
        }

        tfoot th {
            background-color: #f9f9f9;
            font-weight: bold;
        }

        .total-row {
            font-size: 14px;
            background-color: #e0f7e0;
            color: #1a4d1a;
        }

        .section-info {
            margin-bottom: 15px;
            border: 1px dashed #ccc;
            padding: 10px;
        }
    </style>
</head>

<body>
    <h2>Struk Penjualan Obat</h2>

    <div class="section-info">
        <p><strong>Kode Transaksi:</strong> {{ $penjualan_obat->kode_transaksi ?? '-' }}</p>
        <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($penjualan_obat->tanggal_transaksi)->format('d-m-Y') }}
        </p>
        <p><strong>Pasien:</strong> {{ $penjualan_obat->pasien->nama ?? 'Tanpa Nama' }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Nama Obat</th>
                <th style="width: 15%;">Kuantitas</th>
                <th style="width: 20%;">Harga</th>
                <th style="width: 20%;">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @foreach ($penjualan_obat->penjualan_obat_detail as $detail)
                @php
                    $subtotal = $detail->harga_final * $detail->kuantitas;
                    $total += $subtotal;
                @endphp
                <tr>
                    <td>{{ $detail->obat->nama_obat ?? '-' }}</td>
                    <td class="text-end">{{ $detail->kuantitas }}</td>
                    <td class="text-end">Rp{{ number_format($detail->harga_final, 0, ',', '.') }}</td>
                    <td class="text-end">Rp{{ number_format($subtotal, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-row">
                <th colspan="3" class="text-end">Total</th>
                <th class="text-end">Rp{{ number_format($total, 0, ',', '.') }}</th>
            </tr>
        </tfoot>
    </table>
</body>

</html>
