<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Transaksi</title>
    <style>
        body {
            font-family: 'sans-serif';
            font-size: 9px;
            /* Ukuran font sedikit diperkecil agar muat */
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
            padding: 5px;
            /* Padding sedikit diperkecil */
            text-align: left;
            word-wrap: break-word;
            /* Memastikan teks panjang tidak meluber */
        }

        th {
            background-color: #f2f2f2;
            font-size: 10px;
            text-align: center;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 10px;
        }
    </style>
</head>

<body>

    <div class="header">
        <h1>Laporan Transaksi Kunjungan</h1>
        <p>Klinik dr. Rusdiani</p>
        @if(isset($awal) && isset($akhir))
        <p>Periode Kunjungan: {{ \Carbon\Carbon::parse($awal)->format('d F Y') }} s/d {{
            \Carbon\Carbon::parse($akhir)->format('d F Y') }}</p>
        @else
        <p>Semua Periode</p>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Antrean</th>
                <th>Nama Pasien</th>
                <th>Keluhan</th>
                <th>Status</th>
                <th>Jam Datang</th>
                <th>Jam Diperiksa</th>
                <th>Jam Selesai</th>
                <th>Diagnosis</th>
                <th>Tindakan</th>
                <th class="text-right">Biaya Jasa</th>
                <th class="text-right">Total Biaya</th>
                <th>Disetujui</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($dataTransaksi as $transaksi)
            <tr>
                <td class="text-center">{{ \Carbon\Carbon::parse($transaksi->tanggal_kunjungan)->format('d-m-Y') }}</td>
                <td class="text-center">{{ $transaksi->no_antrean }}</td>
                <td>{{ $transaksi->pasien->nama_lengkap ?? 'N/A' }}</td>
                <td>{{ $transaksi->keluhan ?? '-' }}</td>
                <td class="text-center">{{ $transaksi->status_kedatangan }}</td>
                <td class="text-center">{{ $transaksi->jam_datang ?
                    \Carbon\Carbon::parse($transaksi->jam_datang)->format('H:i') : '-' }}</td>
                <td class="text-center">{{ $transaksi->jam_diperiksa ?
                    \Carbon\Carbon::parse($transaksi->jam_diperiksa)->format('H:i') : '-' }}</td>
                <td class="text-center">{{ $transaksi->jam_selesai ?
                    \Carbon\Carbon::parse($transaksi->jam_selesai)->format('H:i') : '-' }}</td>
                <td>{{ $transaksi->diagnosis ?? '-' }}</td>
                <td>{{ $transaksi->tindakan ?? '-' }}</td>
                <td class="text-right">Rp {{ number_format($transaksi->biaya_jasa ?? 0, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($transaksi->biaya_total ?? 0, 0, ',', '.') }}</td>
                <td class="text-center">{{ $transaksi->disetujui_dokter ? 'Ya' : 'Belum' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="13" class="text-center">Tidak ada data transaksi yang ditemukan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak pada: {{ now()->format('d F Y, H:i') }}</p>
    </div>

</body>

</html>