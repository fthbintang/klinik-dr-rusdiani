<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Surat Rujukan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            line-height: 1.6;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h2 {
            margin: 0;
            text-transform: uppercase;
        }

        .content {
            margin: 0 30px;
        }

        .content table {
            width: 100%;
        }

        .content td {
            padding: 4px 0;
        }

        .signature {
            margin-top: 40px;
            text-align: right;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>KLINIK dr Rusdiani</h2>
        <p style="font-size: 12px">Jl. Sultan Adam No.56, RT.36/RW.3, Surgi Mufti, Kec. Banjarmasin Utara, Kota
            Banjarmasin,
            Kalimantan Selatan 70122</p>
        <hr>
        <h3>SURAT RUJUKAN</h3>
    </div>

    <div class="content">
        <p>Nomor: {{ $nomorSurat }}</p>
        <p>Yth.<br>{!! nl2br(e($tujuan)) !!}</p>

        <p>Dengan hormat,</p>
        <p>Bersama ini kami rujuk pasien berikut untuk mendapatkan pemeriksaan dan penanganan lebih lanjut:</p>

        <table>
            <tr>
                <td style="width: 150px;">Nama Pasien</td>
                <td>: {{ $rekam_medis->pasien->nama_lengkap ?? '-' }}</td>
            </tr>
            <tr>
                <td>Umur</td>
                <td>:
                    @if ($rekam_medis->pasien->tanggal_lahir)
                        {{ \Carbon\Carbon::parse($rekam_medis->pasien->tanggal_lahir)->age }} Tahun
                    @else
                        -
                    @endif
                </td>
            </tr>
            <tr>
                <td>Jenis Kelamin</td>
                <td>: {{ $rekam_medis->pasien->jenis_kelamin ?? '-' }}</td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>: {{ $rekam_medis->pasien->alamat ?? '-' }}</td>
            </tr>
            <tr>
                <td>Diagnosis Sementara</td>
                <td>: {{ $rekam_medis->diagnosis ?? '-' }}</td>
            </tr>
            <tr>
                <td>Tindakan yang sudah diberikan</td>
                <td>: {{ $rekam_medis->tindakan ?? '-' }}</td>
            </tr>
        </table>

        <p>Demikian surat rujukan ini kami buat, atas perhatian dan kerjasamanya kami ucapkan terima kasih.</p>

        <div class="signature">
            <p>{{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
            <p>Dokter Pemeriksa,</p>
            <br><br><br>
            <p><b>{{ $rekam_medis->dokter->nama_dokter ?? '__________________' }}</b></p>
            <p>No. SIP: {{ $rekam_medis->dokter->no_sip ?? '-' }}</p>
        </div>
    </div>
</body>

</html>
