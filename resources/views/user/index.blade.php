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
                        <a href="{{ route('user.create') }}" class="btn btn-success">Tambah Data</a>
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
                                <th>Jenis Kelamin</th>
                                <th>Role</th>
                                <th>Foto</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($user as $row)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $row->nama_lengkap }}</td>
                                    <td>{{ $row->jenis_kelamin }}</td>
                                    <td>{{ $row->role }}</td>
                                    <td>
                                        @if ($row->foto)
                                            <img src="{{ asset('storage/foto/' . $row->foto) }}" alt="Foto"
                                                class="img-thumbnail rounded previewable-foto"
                                                style="width: 150px; height: 180px; object-fit: cover; object-position: center; cursor: pointer;"
                                                data-src-full="{{ asset('storage/foto/' . $row->foto) }}"
                                                data-bs-toggle="modal" data-bs-target="#fotoModal">
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>

                                    <td>
                                        <a href="{{ route('user.edit', $row->id) }}" class="btn icon btn-warning">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('user.destroy', $row->id) }}" method="POST"
                                            class="d-inline form-delete-user">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn icon btn-danger btn-delete-user">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    {{-- Modal Preview Gambar --}}
    <div class="modal fade" id="fotoModal" tabindex="-1" aria-labelledby="fotoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <img id="previewFoto" src="" alt="Preview Foto" class="img-fluid rounded">
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const previewableImages = document.querySelectorAll('.previewable-foto');
            const previewModalImage = document.getElementById('previewFoto');

            previewableImages.forEach(img => {
                img.addEventListener('click', function() {
                    const fullSrc = this.getAttribute('data-src-full');
                    previewModalImage.src = fullSrc;
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
                        text: "Data pengguna akan dihapus secara permanen.",
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
