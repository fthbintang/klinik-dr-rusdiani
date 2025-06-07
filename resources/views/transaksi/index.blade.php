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

    <div class="text-end mb-3">
        <a href="{{ route('pasien.index') }}" class="btn btn-info">Kembali</a>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col-sm-8">
                        <h5 class="card-title">Data {{ $title }}</h5>
                    </div>
                    <div class="col-sm-4 d-flex justify-content-end">
                        <form action="#" method="GET" class="d-flex">
                            <input type="date" name="tanggal_kunjungan" id="tanggal_kunjungan"
                                class="form-control me-2">
                            <button type="submit" class="btn btn-primary me-2">Cari</button>
                        </form>
                        <a href="#" class="btn btn-success">Tambah Data</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr style="white-space: nowrap;">
                                <th class="text-center align-middle">Tanggal</th>
                                <th class="text-center align-middle">No Antrean</th>
                                <th class="text-center align-middle">No RM</th>
                                <th class="text-center align-middle">Pasien</th>
                                <th class="text-center align-middle">Status</th>
                                <th class="text-center align-middle">Resep Dokter</th>
                                <th class="text-center align-middle">Biaya</th>
                                <th class="text-center align-middle">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $previousStatus = null;
                            @endphp

                            @foreach ($rekam_medis as $row)
                                @if ($previousStatus !== $row->status_kedatangan)
                                    <tr class="table-light">
                                        <td colspan="8"
                                            class="fw-bold text-start py-2 px-3 border-top border-secondary">
                                            <i class="bi bi-arrow-right-circle-fill me-1 text-primary"></i>
                                            Status: {{ $row->status_kedatangan }}
                                        </td>
                                    </tr>
                                @endif

                                <tr>
                                    <td class="text-center align-middle" style="white-space: nowrap;">
                                        {{ $row->tanggal_kunjungan ? \Carbon\Carbon::parse($row->tanggal_kunjungan)->translatedFormat('l, d F Y') : '-' }}
                                    </td>
                                    <td class="text-center align-middle">{{ $row->no_antrean ?? '-' }}</td>
                                    <td class="text-center align-middle">{{ $row->pasien->no_rm ?? '-' }}</td>
                                    <td class="text-center align-middle">{{ $row->pasien->nama_lengkap ?? '-' }}</td>
                                    <td class="text-center align-middle">
                                        @php
                                            $status = $row->status_kedatangan;
                                            $badgeClass = match ($status) {
                                                'Booking' => 'bg-info',
                                                'Datang' => 'bg-primary',
                                                'Diperiksa' => 'bg-warning',
                                                'Selesai' => 'bg-success',
                                                'Tidak Datang' => 'bg-danger',
                                                'Beli Obat' => 'bg-secondary',
                                                'Pengambilan Obat' => 'bg-dark',
                                                default => 'bg-secondary',
                                            };
                                        @endphp
                                        <span class="badge {{ $badgeClass }}">{{ $status ?? '-' }}</span>
                                    </td>
                                    <td class="text-center">
                                        @if ($row->disetujui_dokter == 1)
                                            <i class="bi bi-check-circle-fill text-success"></i>
                                        @else
                                            <i class="bi bi-x-circle-fill text-danger"></i>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($row->biaya_total)
                                            {{ 'Rp' . number_format($row->biaya_total, 0, ',', '.') }}
                                        @else
                                            <span class="badge bg-danger">Belum Bayar</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex gap-1 justify-content-center">
                                            <a href="#" class="btn icon btn-info"><i
                                                    class="bi bi-capsule"></i></a>
                                            <form action="#" method="POST" class="d-inline form-delete-user">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn icon btn-danger btn-delete-user">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>

                                @php
                                    $previousStatus = $row->status_kedatangan;
                                @endphp
                            @endforeach


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

</x-layout>
