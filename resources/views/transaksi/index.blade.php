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

    <section class="section">
        <div class="card">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col-sm-8">
                        <h5 class="card-title">Data {{ $title }}</h5>
                    </div>
                    <div class="col-sm-4 d-flex justify-content-end">
                        <form action="{{ route('transaksi.index') }}" method="GET" class="d-flex">
                            <input type="date" name="tanggal_kunjungan" id="tanggal_kunjungan"
                                class="form-control me-2"
                                value="{{ request('tanggal_kunjungan', $tanggal_kunjungan ?? now()->toDateString()) }}">
                            <button type="submit" class="btn btn-primary me-2">Cari</button>
                        </form>
                        @can('admin')
                            <a href="{{ route('transaksi.create') }}" class="btn btn-success">Tambah Data</a>
                        @endcan
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
                                <th class="text-center align-middle">Kategori Usia</th>
                                <th class="text-center align-middle">Status</th>
                                {{-- <th class="text-center align-middle">Resep Dokter</th> --}}
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
                                            $usia = \Carbon\Carbon::parse($row->pasien->tanggal_lahir)->age;
                                        @endphp
                                        {{ $usia > 17 ? 'Dewasa' : 'Anak-Anak' }}
                                    </td>
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
                                                'Menunggu Obat' => 'bg-dark',
                                                default => 'bg-secondary',
                                            };
                                        @endphp
                                        <span class="badge {{ $badgeClass }}">{{ $status ?? '-' }}</span>
                                    </td>
                                    {{-- <td class="text-center">
                                        @if ($row->disetujui_dokter === 1)
                                            <span class="badge bg-success">Sudah Diberi</span>
                                        @elseif ($row->disetujui_dokter === 0)
                                            <span class="badge bg-danger">Belum Diberi</span>
                                        @else
                                            <span class="badge bg-secondary">Tanpa Resep</span>
                                        @endif
                                    </td> --}}
                                    <td class="text-center">
                                        @if ($row->biaya_total)
                                            <b>{{ 'Rp' . number_format($row->biaya_total, 0, ',', '.') }}</b>
                                        @else
                                            <p><b>-</b></p>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex gap-1 justify-content-center">
                                            @can('admin')
                                                @if ($row->status_kedatangan == 'Datang')
                                                    <a href="#" class="btn icon btn-info btn-call-pasien"
                                                        data-id="{{ $row->id }}">
                                                        <i class="bi bi-forward-fill"></i>
                                                    </a>
                                                @elseif ($row->status_kedatangan == 'Booking')
                                                    <a href="#" class="btn icon btn-info btn-konfirmasi-kedatangan"
                                                        data-id="{{ $row->id }}">
                                                        <i class="bi bi-forward-fill"></i>
                                                    </a>
                                                @endif
                                            @endcan
                                            @canany(['admin', 'dokter', 'apotek'])
                                                @if (
                                                    $row->status_kedatangan == 'Diperiksa' ||
                                                        $row->status_kedatangan == 'Beli Obat' ||
                                                        $row->status_kedatangan == 'Pengambilan Obat' ||
                                                        $row->status_kedatangan == 'Selesai')
                                                    <a href="{{ route('transaksi.resep_obat', ['pasien' => $row->pasien->id, 'rekam_medis' => $row->id]) }}"
                                                        class="btn icon btn-info">
                                                        <i class="bi bi-clipboard2"></i>
                                                    </a>
                                                @endif
                                            @endcanany
                                            @can('admin')
                                                @if ($row->status_kedatangan != 'Selesai')
                                                    <form action="{{ route('transaksi.destroy', $row->id) }}"
                                                        method="POST" class="d-inline form-delete-user">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="btn icon btn-danger btn-delete-user">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            @endcan
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

    {{-- UPDATE STATUS KEDATANGAN MENJADI DATANG --}}
    <script>
        $(document).ready(function() {
            $('.btn-konfirmasi-kedatangan').click(function(e) {
                e.preventDefault();
                const rekamMedisId = $(this).data('id');

                let urlTemplate = "{{ route('transaksi.update_status_booking', ['id' => ':id']) }}";
                let url = urlTemplate.replace(':id', rekamMedisId);

                Swal.fire({
                    title: 'Konfirmasi Kedatangan',
                    html: `
                    <p>Apakah pasien sudah datang?</p>
                    <div style="display: flex; align-items: center; justify-content: center;">
                        <span style="margin-right: 5px;">Rp</span>
                        <input type="text" id="biayaJasaInput" class="swal2-input" placeholder="Masukkan biaya jasa" style="width: 200px; text-align: right;">
                    </div>
                `,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Simpan',
                    cancelButtonText: 'Batal',
                    didOpen: () => {
                        const input = document.getElementById('biayaJasaInput');

                        // Format angka dengan titik saat diketik
                        input.addEventListener('input', function() {
                            // Hapus semua karakter non-angka
                            let rawValue = this.value.replace(/\D/g, '');

                            // Format ulang dengan titik ribuan
                            let formatted = new Intl.NumberFormat('id-ID').format(
                                rawValue);
                            this.value = formatted;
                        });
                    },
                    preConfirm: () => {
                        // Ambil nilai dan hilangkan titik sebelum dikirim
                        const formattedValue = document.getElementById('biayaJasaInput').value;
                        const rawValue = formattedValue.replace(/\./g, '');

                        if (!rawValue || isNaN(rawValue) || parseInt(rawValue) <= 0) {
                            Swal.showValidationMessage(
                                'Biaya jasa harus diisi dan lebih dari 0');
                        }
                        return parseInt(rawValue);
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        const biayaJasa = result.value;

                        $.ajax({
                            url: url,
                            type: 'PUT',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            data: {
                                status_kedatangan: 'Datang',
                                biaya_jasa: biayaJasa
                            },
                            success: function(response) {
                                Swal.fire('Sukses', 'Status pasien sudah diperbarui',
                                        'success')
                                    .then(() => {
                                        location.reload();
                                    });
                            },
                            error: function(xhr) {
                                Swal.fire('Error', 'Gagal memperbarui status', 'error');
                            }
                        });
                    }
                });
            });
        });
    </script>

    {{-- UPDATE STATUS KEDATANGAN MENJADI DIPERIKSA --}}
    <script>
        $(document).ready(function() {
            $('.btn-call-pasien').click(function(e) {
                e.preventDefault();
                const rekamMedisId = $(this).data('id');

                // Ambil route dengan placeholder dan ganti placeholder dengan ID sesungguhnya
                let urlTemplate = "{{ route('transaksi.update_status', ['id' => ':id']) }}";
                let url = urlTemplate.replace(':id', rekamMedisId);

                Swal.fire({
                    title: 'Konfirmasi',
                    text: 'Apakah yakin akan memanggil pasien ini?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, panggil',
                    cancelButtonText: 'Batal',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            type: 'PUT',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            data: {
                                status_kedatangan: 'Diperiksa',
                            },
                            success: function(response) {
                                Swal.fire('Sukses', 'Status pasien sudah diperbarui',
                                        'success')
                                    .then(() => {
                                        location.reload();
                                    });
                            },
                            error: function(xhr) {
                                Swal.fire('Error', 'Gagal memperbarui status', 'error');
                            }
                        });
                    }
                });
            });
        });
    </script>

    {{-- DELETE TRANSAKSI --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.btn-delete-user');

            deleteButtons.forEach(function(btn) {
                btn.addEventListener('click', function(e) {
                    const form = this.closest('form');

                    Swal.fire({
                        title: 'Yakin ingin menghapus?',
                        text: "Data ini akan dihapus secara permanen.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>



</x-layout>
