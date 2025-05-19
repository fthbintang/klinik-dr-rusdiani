<x-layout>
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Halaman {{ $title }}</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header d-flex justify-content-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('index') }}">Home</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                {{ $title }}
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body d-flex align-items-center">
            {{-- Logo --}}
            <img src="./assets/gambar/logo.png" width="10%" height="10%"
                style="border-radius: 10px; margin-left: 50px">

            {{-- Garis vertikal --}}
            <div style="width: 2px; height: 60px; background-color: #000; margin: 0 20px;"></div>

            {{-- Teks --}}
            <h4 class="mb-0">Selamat Datang, {{ Auth::user()->nama_panggilan }}</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-6 col-lg-3 col-md-6">
            <div class="card" style="min-height: 140px;">
                <div class="card-body px-4 py-4-5 h-100">
                    <div class="row h-100 align-items-center">
                        <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                            <div class="stats-icon purple mb-2">
                                <i class="bi-people-fill"></i>
                            </div>
                        </div>
                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                            <h6 class="text-muted font-semibold">Pasien</h6>
                            <h6 class="font-extrabold mb-0">50</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-lg-3 col-md-6">
            <div class="card" style="min-height: 140px;">
                <div class="card-body px-4 py-4-5 h-100">
                    <div class="row h-100 align-items-center">
                        <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                            <div class="stats-icon blue mb-2">
                                <i class="iconly-boldProfile"></i>
                            </div>
                        </div>
                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                            <h6 class="text-muted font-semibold">Pasien Hari ini</h6>
                            <h6 class="font-extrabold mb-0">100</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-lg-3 col-md-6">
            <div class="card" style="min-height: 140px;">
                <div class="card-body px-4 py-4-5 h-100">
                    <div class="row h-100 align-items-center">
                        <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                            <div class="stats-icon green mb-2">
                                <i class="bi-cash"></i>
                            </div>
                        </div>
                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                            <h6 class="text-muted font-semibold">Pendapatan Bulan ini</h6>
                            <h6 class="font-extrabold mb-0">Rp80.000</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-lg-3 col-md-6">
            <div class="card" style="min-height: 140px;">
                <div class="card-body px-4 py-4-5 h-100">
                    <div class="row h-100 align-items-center">
                        <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                            <div class="stats-icon red mb-2">
                                <i class="bi-cash-stack"></i>
                            </div>
                        </div>
                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                            <h6 class="text-muted font-semibold">Pendapatan Hari ini</h6>
                            <h6 class="font-extrabold mb-0">Rp50.000</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Kunjungan Pasien per 30 Hari</h5>
        </div>
        <div class="card-body">
            {{-- <div id="chart-profile-visit"></div> --}}
            <h3 class="text-center">Menampilkan Chart</h3>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Kunjungan Pasien per 30 Hari</h5>
        </div>
        <div class="card-body">
            {{-- <div id="chart-profile-visit"></div> --}}
            <h3 class="text-center">Menampilkan Chart</h3>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Kunjungan Pasien per Bulan dalam 1 Tahun</h5>
        </div>
        <div class="card-body">
            {{-- <div id="chart-profile-visit"></div> --}}
            <h3 class="text-center">Menampilkan Chart</h3>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Pendapatan per 30 Hari</h5>
        </div>
        <div class="card-body">
            {{-- <div id="chart-profile-visit"></div> --}}
            <h3 class="text-center">Menampilkan Chart</h3>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Pendapatan per Bulan dalam 1 Tahun</h5>
        </div>
        <div class="card-body">
            {{-- <div id="chart-profile-visit"></div> --}}
            <h3 class="text-center">Menampilkan Chart</h3>
        </div>
    </div>
</x-layout>
