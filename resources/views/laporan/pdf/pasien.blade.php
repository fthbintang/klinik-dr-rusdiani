<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Data Pasien</title>
    <style>
        body {
            font-family: 'sans-serif';
            font-size: 9px;
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
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            font-size: 10px;
            text-align: center;
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
        <h1>Laporan Data Semua Pasien</h1>
        <p>Klinik dr. Rusdiani</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Lengkap</th>
                <th>NIK</th>
                <th>Jenis Kelamin</th>
                <th>No. HP</th>
                <th>Tempat / Tanggal Lahir</th>
                <th>Alamat</th>
                <th>Pekerjaan</th>
                <th>Status Perkawinan</th>
                <th>Golongan Darah</th>
                <th>Agama</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($dataPasien as $pasien)
            <tr>
                <td style="text-align: center;">{{ $loop->iteration }}</td>
                <td>{{ $pasien->nama_lengkap }}</td>
                <td>{{ $pasien->nik }}</td>
                <td>{{ $pasien->jenis_kelamin }}</td>
                <td>{{ $pasien->no_hp }}</td>
                <td>{{ $pasien->tempat_lahir }}, {{ $pasien->tanggal_lahir }}</td>
                <td>{{ $pasien->alamat }}</td>
                <td>{{ $pasien->pekerjaan }}</td>
                <td>{{ $pasien->status_perkawinan }}</td>
                <td>{{ $pasien->golongan_darah }}</td>
                <td>{{ $pasien->agama }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align: center;">Tidak ada data pasien.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak pada: {{ now()->format('d F Y, H:i') }}</p>
    </div>
</body>

</html>