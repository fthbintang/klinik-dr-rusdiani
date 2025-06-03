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
                        <a href="{{ route('pasien.create') }}" class="btn btn-success">Tambah Data</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="table1">
                        <thead>
                            <tr>
                                <th>No.RM</th>
                                <th>Nama</th>
                                <th>Jenis Kelamin</th>
                                <th>No HP</th>
                                <th>Golongan Darah</th>
                                <th>Foto</th>
                                <th>Akun</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pasien as $row)
                                <tr>
                                    <td>{{ $row->no_rm }}</td>
                                    <td>{{ $row->nama_lengkap }}</td>
                                    <td>{{ $row->jenis_kelamin }}</td>
                                    <td>{{ $row->no_hp }}</td>
                                    <td class="text-center align-middle">{{ $row->golongan_darah ?? '-' }}</td>
                                    <td>
                                        @if ($row->user && $row->user->foto)
                                            <img src="{{ asset('storage/foto/' . $row->user->foto) }}" alt="Foto"
                                                class="img-thumbnail rounded previewable-foto"
                                                style="width: 150px; height: 180px; object-fit: cover; object-position: center; cursor: pointer;"
                                                data-src-full="{{ asset('storage/foto/' . $row->user->foto) }}"
                                                data-bs-toggle="modal" data-bs-target="#fotoModal">
                                        @else
                                            <p class="text-center align-middle">-</p>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            @if ($row->user_id)
                                                <a href="{{ route('user.show', $row->user_id) }}">
                                                    <i class="bi bi-check-circle-fill text-success"
                                                        title="Sudah punya akun"></i>
                                                </a>
                                            @else
                                                <a href="{{ route('pasien.hubungkan-akun', $row->id) }}"
                                                    class="text-danger" title="Hubungkan akun">
                                                    <i class="bi bi-x-circle-fill"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <a href="{{ route('pasien.rekam_medis.index', $row->id) }}"
                                                class="btn icon btn-primary"><i class="bi bi-clipboard2-pulse"></i></a>
                                            <a href="{{ route('pasien.show', $row->id) }}" class="btn icon btn-info">
                                                <i class="bi bi-eye-fill"></i>
                                            </a>
                                            <a href="{{ route('pasien.edit', $row->id) }}"
                                                class="btn icon btn-warning">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('pasien.destroy', $row->id) }}" method="POST"
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

    {{-- DELETE --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.btn-delete-user');

            deleteButtons.forEach(function(btn) {
                btn.addEventListener('click', function(e) {
                    const form = this.closest('form');

                    Swal.fire({
                        title: 'Yakin ingin menghapus?',
                        text: "Jika data ini dihapus, pasien tidak akan bisa login kembali karena seluruh data akun akan ikut terhapus secara permanen. Selain itu, seluruh data rekam medis yang berkaitan dengan pasien ini juga akan ikut terhapus dari sistem.",
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

    {{-- MENAMPILKAN FOTO --}}
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

</x-layout>
