<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Pasien</title>
</head>

<body>
    <p>
        Yth. {{ $pasien->nama_lengkap }},

        <br>
        Terima kasih telah melakukan pendaftaran rekam medis di Klinik Dr. Rusdiani. Proses pendaftaran Anda telah
        berhasil kami terima pada tanggal {{ $rekam_medis['tanggal_kunjungan'] }}.
        <br>
        Berikut adalah data pendaftaran Anda:
        <br>
        Nama Lengkap: <b>{{ $pasien->nama_lengkap }}</b><br>
        Nomor Rekam Medis: <b>{{ $rekam_medis['no_antrean'] }}</b><br>
        Keluhan : <b>{{ $rekam_medis['keluhan'] }}</b>

        <br><br>
        Mohon simpan Nomor Rekam Medis ini dengan baik. Nomor ini akan digunakan untuk semua kunjungan dan keperluan
        administrasi Anda di masa mendatang untuk mempercepat proses layanan.

        <br><br>
        Langkah Selanjutnya: <br>
        Untuk kunjungan pertama Anda, harap membawa kartu identitas asli <b>(KTP/SIM/Paspor)</b> untuk keperluan
        verifikasi
        data di bagian pendaftaran.
        <br><br>
        Salam sehat,
        <br>
        Tim Klinik Dr. Rusdiani
    </p>
</body>

</html>