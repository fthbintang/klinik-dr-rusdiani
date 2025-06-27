<x-layout>
    <div class="page-title mt-4">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h4>Halaman Beranda</h4>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header d-flex justify-content-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('beranda_pasien.index') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="page-heading text-center">
                <!-- Logo Klinik -->
                <img src="{{ asset('assets/gambar/logo.png') }}" alt="Logo Klinik" width="100"
                    class="mb-3 rounded shadow-sm">

                <h3>Selamat Datang, {{ Auth::user()->nama_panggilan ?? Auth::user()->nama_lengkap }}</h3>
                <p class="text-subtitle text-muted">Ini adalah halaman utama akun Anda sebagai pasien.</p>
            </div>
        </div>
    </div>

    <section class="section mt-3">
        <div class="row">
            <!-- Total Pendaftaran -->
            <div class="col-md-4 col-sm-6 mb-3">
                <div class="card text-white bg-primary">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-title mb-0">Total Pendaftaran</h6>
                                <h2 class="fw-bold">{{ $totalPendaftaran ?? 0 }}</h2>
                            </div>
                            <div>
                                <i class="bi bi-clipboard-check fs-1"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Nomor Antrean Aktif -->
            <div class="col-md-4 col-sm-6 mb-3">
                <div class="card text-white bg-success">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-title mb-0">Antrean Anda</h6>
                                <h2 class="fw-bold">
                                    {{ $antreanAktif ?? '-' }}
                                </h2>
                            </div>
                            <div>
                                <i class="bi bi-list-ol fs-1"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Riwayat Terakhir -->
            <div class="col-md-4 col-sm-6 mb-3">
                <div class="card text-white bg-warning">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-title mb-0">Terakhir Berobat</h6>
                                <h4 class="fw-bold">
                                    {{ $terakhirKunjungan ? \Carbon\Carbon::parse($terakhirKunjungan)->translatedFormat('d F Y') : 'Belum ada' }}
                                </h4>
                            </div>
                            <div>
                                <i class="bi bi-file-medical fs-1"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Nomor Antrean Terkini -->
            <div class="card mt-4">
                <div class="card-header bg-info text-white mb-2">
                    <h5 class="mb-0">Nomor Antrean Saat Ini</h5>
                </div>
                <div class="card-body">
                    <div class="row flex-row-reverse text-center" id="antrean-terkini">
                        <div class="col">Memuat antrean...</div>
                    </div>
                    <div class="text-center mt-2">
                        <small class="text-muted fst-italic">
                            Antrean paling kanan adalah pasien yang dipanggil lebih dulu.
                        </small>
                    </div>
                </div>
            </div>

        </div>
    </section>
</x-layout>

<script>
    function fetchAntrean() {
        fetch("{{ url('/pasien/beranda/antrean/terdepan') }}")
            .then(response => response.json())
            .then(data => {
                const wrapper = document.getElementById('antrean-terkini');
                wrapper.innerHTML = '';

                if (data.length === 0) {
                    wrapper.innerHTML = '<div class="col">Belum ada antrean hari ini.</div>';
                    return;
                }

                // Tetap urut dari no antrean kecil ke besar
                data.sort((a, b) => {
                    const numA = parseInt(a.no_antrean.split('-')[1]);
                    const numB = parseInt(b.no_antrean.split('-')[1]);
                    return numA - numB;
                });

                // Temukan antrean prioritas (Diperiksa, lalu Datang, lalu Booking)
                const statusPrioritas = ['Diperiksa', 'Datang', 'Booking'];
                let prioritasIndex = -1;

                for (let status of statusPrioritas) {
                    prioritasIndex = data.findIndex(item => item.status_kedatangan === status);
                    if (prioritasIndex !== -1) break;
                }

                data.forEach((item, index) => {
                    const isPrioritas = index === prioritasIndex;

                    const warnaBorder = isPrioritas ? 'danger' : 'primary';
                    const kelasCard = isPrioritas ? 'bg-light shadow' : 'bg-white';
                    const orderClass = isPrioritas ? 'order-0' : 'order-1';

                    const badgeStatus = item.status_kedatangan === 'Diperiksa' ?
                        '<span class="badge bg-success mt-2">Sedang Diperiksa</span>' :
                        `<span class="badge bg-secondary mt-2">${item.status_kedatangan}</span>`;

                    wrapper.innerHTML += `
                        <div class="col-md-4 mb-2 ${orderClass}">
                            <div class="card border-${warnaBorder} ${kelasCard}">
                                <div class="card-body text-center">
                                    <h6 class="text-muted mb-1">Antrean</h6>
                                    <h2 class="fw-bold">${item.no_antrean}</h2>
                                    ${badgeStatus}
                                </div>
                            </div>
                        </div>
                    `;
                });
            });
    }

    setInterval(fetchAntrean, 1000);
    fetchAntrean();
</script>
