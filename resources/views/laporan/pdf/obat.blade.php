<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Data Obat</title>
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
        <h1>Laporan Stok Obat</h1>
        <p>Klinik dr. Rusdiani</p>
        @if(isset($awal) && isset($akhir))
        <p>Periode Expired: {{ \Carbon\Carbon::parse($awal)->format('d F Y') }} s/d {{
            \Carbon\Carbon::parse($akhir)->format('d F Y') }}</p>
        @else
        <p>Semua Periode</p>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th class="text-center">No</th>
                <th>Nama Obat</th>
                <th>Kategori</th>
                <th>Supplier</th>
                <th class="text-center">Stok</th>
                <th class="text-right">Harga</th>
                <th class="text-center">Expired Date</th>
            </tr>
        </thead>
        <tbody>
            {{-- Loop data obat dari controller --}}
            @forelse ($dataObat as $obat)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $obat->nama_obat }}</td>
                <td>{{ $obat->kategori }}</td>
                {{-- Asumsi ada relasi ke supplier --}}
                <td>{{ $obat->supplier->nama_supplier ?? 'N/A' }}</td>
                <td class="text-center">{{ $obat->stok }} {{ $obat->satuan }}</td>
                <td class="text-right">Rp {{ number_format($obat->harga, 0, ',', '.') }}</td>
                <td class="text-center">{{ \Carbon\Carbon::parse($obat->expired_date)->format('d-m-Y') }}</td>
            </tr>
            @empty
            {{-- Tampilkan ini jika tidak ada data --}}
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