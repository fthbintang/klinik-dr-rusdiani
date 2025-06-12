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
                        <h5 class="card-title">Data {{ $title }}</h5>
                    </div>
                    <div class="col-sm-4 d-flex justify-content-end">
                        <a href="{{ route('obat.supplier.index') }}" class="btn btn-light me-2">Supplier</a>
                        <a href="{{ route('obat.create') }}" class="btn btn-success">Tambah Obat</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="table1">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Kategori</th>
                                <th>Satuan</th>
                                <th>Stok</th>
                                <th>Harga</th>
                                <th>Expired</th>
                                <th>Supplier</th>
                                <th>Keterangan</th>
                                <th>Obat Bebas</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($obat as $row)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $row->nama_obat }}</td>
                                    <td>{{ $row->kategori }}</td>
                                    <td>{{ $row->satuan }}</td>
                                    <td>{{ $row->stok }}</td>
                                    <td>{{ 'Rp' . number_format($row->harga, 0, ',', '.') }}</td>
                                    <td style="white-space: nowrap;">
                                        {{ \Carbon\Carbon::parse($row->expired_date)->format('d-m-Y') }}</td>
                                    <td>{{ $row->supplier->nama_supplier ?? '-' }}</td>
                                    <td>{{ $row->keterangan ?? '-' }}</td>
                                    <td>
                                        @if ($row->obat_bebas == 1)
                                            <i class="bi bi-check-circle-fill text-success"></i>
                                        @else
                                            <i class="bi bi-x-circle-fill text-danger"></i>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <a href="#" class="btn icon btn-info btn-tambah-stok"
                                                data-obat-id="{{ $row->id }}"
                                                data-nama-obat="{{ $row->nama_obat }}">
                                                <i class="bi bi-plus"></i>
                                            </a>
                                            <a href="{{ route('obat.edit', $row->id) }}" class="btn icon btn-warning">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('obat.destroy', $row->id) }}" method="POST"
                                                class="d-inline form-delete-user">
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

    {{-- MODAL TAMBAH STOK --}}
    <div class="modal fade" id="modalTambahStok" tabindex="-1" aria-labelledby="modalTambahStokLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form id="formTambahStok" method="POST" action="">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Stok Obat</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="obat_id" id="modal-obat-id">

                        <div class="mb-3">
                            <label for="nama_obat" class="form-label"><b>Nama Obat</b></label>
                            <input type="text" class="form-control" id="modal-nama-obat" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="stok_masuk" class="form-label"><b>Jumlah Stok Masuk</b></label>
                            <input type="number" class="form-control" name="stok_masuk" id="stok_masuk" min="1"
                                placeholder="Stok Masuk..." required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modalTambahStok = new bootstrap.Modal(document.getElementById('modalTambahStok'));

            document.querySelectorAll('.btn-tambah-stok').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();

                    const obatId = this.dataset.obatId;
                    const namaObat = this.dataset.namaObat;

                    document.getElementById('modal-obat-id').value = obatId;
                    document.getElementById('modal-nama-obat').value = namaObat;

                    // Gunakan route helper Laravel dan ganti :id dengan obatId
                    const actionUrl = `{{ route('obat.tambah_stok', ':id') }}`.replace(':id',
                        obatId);
                    document.getElementById('formTambahStok').action = actionUrl;

                    modalTambahStok.show();
                });
            });
        });
    </script>

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
