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
                            <li class="breadcrumb-item">
                                <a href="{{ route('pasien.index') }}">Pasien</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                {{ $title }} ({{ $pasien->nama_lengkap }})
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
                <h3 class="text-center">Data {{ $title }}</h3>
                <h4 class="card-title text-center">a.n {{ $pasien->nama_lengkap }} ({{ $pasien->no_rm }})</h4>
                @if ($pasien->user->foto)
                    <div class="text-center mt-2">
                        <img src="{{ asset('storage/foto/' . $pasien->user->foto) }}" alt="Foto Pasien"
                            class="img-fluid" style="max-width: 100px; border-radius: 10px" data-bs-toggle="modal"
                            data-bs-target="#fotoModal">
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="fotoModal" tabindex="-1" aria-labelledby="fotoModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="fotoModalLabel">Foto Pasien</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body text-center">
                                    <img src="{{ asset('storage/foto/' . $pasien->user->foto) }}" alt="Foto Pasien"
                                        class="img-fluid" style="max-width: 100%;">
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="table1">
                        <thead>
                            <tr style="white-space: nowrap;">
                                <th class="text-center align-middle">Tanggal</th>
                                <th class="text-center align-middle">Status</th>
                                <th class="text-center align-middle">Jam Datang</th>
                                <th class="text-center align-middle">Jam Diperiksa</th>
                                <th class="text-center align-middle">Jam Selesai</th>
                                <th class="text-center align-middle">Keluhan</th>
                                <th class="text-center align-middle">Diagnosis</th>
                                <th class="text-center align-middle">Tindakan</th>
                                <th class="text-center align-middle">Biaya</th>
                                <th class="text-center align-middle">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rekam_medis as $row)
                                <tr>
                                    <td style="white-space: nowrap;">
                                        {{ $row->tanggal_kunjungan ? \Carbon\Carbon::parse($row->tanggal_kunjungan)->format('j-n-Y') : '-' }}
                                    </td>
                                    <td class="text-center align-middle">
                                        @php
                                            $status = $row->status_kedatangan;
                                            $badgeClass = '';

                                            switch ($status) {
                                                case 'Booking':
                                                    $badgeClass = 'bg-info';
                                                    break;

                                                case 'Datang':
                                                    $badgeClass = 'bg-primary';
                                                    break;

                                                case 'Diperiksa':
                                                    $badgeClass = 'bg-warning';
                                                    break;

                                                case 'Selesai':
                                                    $badgeClass = 'bg-success';
                                                    break;

                                                case 'Tidak Datang':
                                                    $badgeClass = 'bg-danger';
                                                    break;

                                                case 'Beli Obat':
                                                    $badgeClass = 'bg-secondary';
                                                    break;

                                                default:
                                                    $badgeClass = 'bg-secondary';
                                                    break;
                                            }
                                        @endphp

                                        <span class="badge {{ $badgeClass }}">
                                            {{ $status ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="text-center align-middle">
                                        {{ $row->jam_datang ? \Carbon\Carbon::parse($row->jam_datang)->format('H.i') : '-' }}
                                    </td>
                                    <td class="text-center align-middle">
                                        {{ $row->jam_diperiksa ? \Carbon\Carbon::parse($row->jam_diperiksa)->format('H.i') : '-' }}
                                    </td>
                                    <td class="text-center align-middle">
                                        {{ $row->jam_selesai ? \Carbon\Carbon::parse($row->jam_selesai)->format('H.i') : '-' }}
                                    </td>
                                    <td>{{ $row->keluhan ?? '-' }}</td>
                                    <td>{{ $row->diagnosis ?? '-' }}</td>
                                    <td>{{ $row->tindakan ?? '-' }}</td>
                                    <td>
                                        @if ($row->biaya_total)
                                            {{ 'Rp' . number_format($row->biaya_total, 0, ',', '.') }}
                                        @else
                                            <span class="badge bg-danger">Belum Bayar</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <a href="{{ route('resep_obat.index', ['pasien' => $row->pasien->id, 'rekam_medis' => $row->id]) }}"
                                                class="btn icon btn-info">
                                                <i class="bi bi-capsule"></i>
                                            </a>
                                            <a href="{{ route('pasien.rekam_medis.edit', ['pasien' => $row->pasien->id, 'rekam_medis' => $row->id]) }}"
                                                class="btn icon btn-warning">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('pasien.rekam_medis.destroy', $row->id) }}"
                                                method="POST" class="d-inline form-delete-user">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn icon btn-danger btn-delete-user">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    {{-- DELETE --}}
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
