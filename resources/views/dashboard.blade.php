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
                            <h6 class="font-extrabold mb-0">{{ $jumlah_pasien }}</h6>
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
                            <h6 class="text-muted font-semibold">Kunjungan Berobat Hari ini</h6>
                            <h6 class="font-extrabold mb-0">{{ $kunjungan_berobat_hari_ini }}</h6>
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
                            <h6 class="text-muted font-semibold">Kunjungan Membeli Obat Hari ini</h6>
                            <h6 class="font-extrabold mb-0">{{ $kunjungan_membeli_obat_hari_ini }}</h6>
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
                            <h6 class="font-extrabold mb-0">Rp{{ number_format($pendapatan_bulan_ini, 0, ',', '.') }}
                            </h6>
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
                            <h6 class="font-extrabold mb-0">Rp{{ number_format($pendapatan_hari_ini, 0, ',', '.') }}
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="row justify-content-between align-items-center">
                <div class="col-sm-8">
                    <h5 class="card-title mb-0">Pendapatan per Bulan ini</h5>
                </div>
                <div class="col-sm-4">
                    <form method="GET" action="{{ route('index') }}" class="d-flex align-items-center gap-2">
                        <select name="month" class="form-control" style="max-width: 120px">
                            @foreach (range(1, 12) as $m)
                                <option value="{{ $m }}" {{ $selected_month == $m ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                                </option>
                            @endforeach
                        </select>

                        <select name="year" class="form-control" style="max-width: 100px">
                            @foreach (range(2024, date('Y')) as $y)
                                <option value="{{ $y }}" {{ $selected_year == $y ? 'selected' : '' }}>
                                    {{ $y }}
                                </option>
                            @endforeach
                        </select>

                        <button type="submit" class="btn btn-primary">Tampilkan</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div id="chart-pendapatan-30-hari"></div>
        </div>
    </div>

</x-layout>

<script>
    var optionsPendapatan30Hari = {
        chart: {
            type: 'bar',
            height: 300
        },
        dataLabels: {
            enabled: false
        },
        series: [{
            name: 'Pendapatan',
            data: @json($chart_totals)
        }],
        xaxis: {
            categories: @json($chart_dates),
            labels: {
                rotate: -45
            }
        },
        yaxis: {
            labels: {
                formatter: function(value) {
                    return 'Rp' + new Intl.NumberFormat('id-ID').format(value);
                }
            }
        },
        tooltip: {
            y: {
                formatter: function(value) {
                    return 'Rp' + new Intl.NumberFormat('id-ID').format(value);
                }
            }
        },
        colors: ['#6a11cb'], // warna pertama gradasi (ungu gelap)
        gradient: {
            shade: 'light',
            type: 'vertical',
            shadeIntensity: 0.5,
            gradientToColors: ['#2575fc'], // warna ke-2 gradasi (biru terang)
            inverseColors: true,
            opacityFrom: 0.9,
            opacityTo: 0.7,
            stops: [0, 100]
        }


    };

    var chartPendapatan = new ApexCharts(document.querySelector("#chart-pendapatan-30-hari"), optionsPendapatan30Hari);
    chartPendapatan.render();
</script>
