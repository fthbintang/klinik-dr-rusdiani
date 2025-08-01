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
                <div class="row">
                    <div class="col-sm-8">
                        <h5 class="card-title">Data {{ $title }} per Hari ini</h5>
                    </div>
                    <div class="col-sm-4 d-flex justify-content-end">
                        <form action="#" method="GET" class="d-flex">
                            <input type="date" name="tanggal_transaksi" id="tanggal_transaksi"
                                class="form-control me-2"
                                value="{{ request('tanggal_transaksi', $tanggal_transaksi ?? now()->toDateString()) }}">
                            <button type="submit" class="btn btn-primary me-2">Cari</button>
                        </form>
                        <a href="{{ route('penjualan_obat.create') }}" class="btn btn-success">Tambah Data</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="table1">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Kode Transaksi</th>
                                <th class="text-center">Tanggal Transaksi</th>
                                <th class="text-center">Pasien</th>
                                <th class="text-center">Total Harga</th>
                                <th class="text-center">Catatan</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($penjualan_obat as $row)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td class="text-center">{{ $row->kode_transaksi }}</td>
                                    <td class="text-center" style="white-space: nowrap;">
                                        {{ \Carbon\Carbon::parse($row->tanggal_transaksi)->format('d-m-Y') }}</td>
                                    <td class="text-center">{{ $row->pasien->nama_lengkap ?? '-- Tanpa Nama --' }}</td>
                                    <td class="text-center">
                                        @if ($row->total_harga)
                                            <b>{{ 'Rp' . number_format($row->total_harga, 0, ',', '.') }}</b>
                                        @else
                                            <p><b>-</b></p>
                                        @endif
                                    </td>
                                    <td>{{ $row->catatan ?? '-' }}</td>
                                    <td class="text-center">
                                        <div class="d-flex gap-1">
                                            <a href="{{ route('penjualan_obat.detail', $row->id) }}"
                                                class="btn icon btn-info">
                                                <i class="bi bi-cart4"></i>
                                            </a>
                                            @if (!$row->total_harga)
                                                <form action="{{ route('penjualan_obat.destroy', $row->id) }}"
                                                    method="POST" class="d-inline form-delete-user">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn icon btn-danger btn-delete-user">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            @endif
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
