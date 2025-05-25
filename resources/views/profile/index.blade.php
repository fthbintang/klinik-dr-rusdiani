<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>E-Clinic | dr. Rusdiani</title>

    <link rel="shortcut icon" href="/assets/gambar/logo.png" type="image/x-icon" />

    <link rel="stylesheet" href="/assets/compiled/css/app.css" />
    <link rel="stylesheet" href="/assets/compiled/css/app-dark.css" />

    {{-- SWEET ALERT --}}
    <link rel="stylesheet" href="assets/extensions/sweetalert2/sweetalert2.min.css">
</head>

<body>
    <script src="assets/static/js/initTheme.js"></script>
    <nav class="navbar navbar-light">
        <div class="container d-block">
            <a href="{{ route('index') }}"><i class="bi bi-chevron-left"></i></a>
            <a class="navbar-brand ms-4" href="{{ route('index') }}">
                <img src="/assets/gambar/logo.png" />
            </a>
        </div>
    </nav>

    <div class="container">
        <div class="row">
            <h2>{{ $title }}</h2>
            <div class="card mt-2">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <h3 class="card-title">Data Diri</h3>
                            </div>
                            <form action="{{ route('profile.update', auth()->user()->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @method('put')
                                @csrf
                                <div class="form-group">
                                    <label for="nama_lengkap">Nama Lengkap</label>
                                    <input type="text"
                                        class="form-control @error('nama_lengkap') is-invalid @enderror"
                                        name="nama_lengkap" id="nama_lengkap"
                                        value="{{ auth()->user()->nama_lengkap }}">
                                    @error('nama_lengkap')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="nama_panggilan">Nama Panggilan</label>
                                    <input type="text"
                                        class="form-control @error('nama_panggilan') is-invalid @enderror"
                                        name="nama_panggilan" id="nama_panggilan"
                                        value="{{ auth()->user()->nama_panggilan }}">
                                    @error('nama_panggilan')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="role">Role</label>
                                    <input type="text" class="form-control @error('role') is-invalid @enderror"
                                        id="role" name="role" value={{ auth()->user()->role }} readonly>
                                    @error('role')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="alamat">Alamat</label>
                                    <textarea class="form-control @error('alamat') is-invalid @enderror" name="alamat" id="alamat">{{ auth()->user()->alamat }}</textarea>
                                    @error('alamat')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="jenis_kelamin">Jenis Kelamin</label>
                                    <input type="text"
                                        class="form-control @error('jenis_kelamin') is-invalid @enderror"
                                        name="jenis_kelamin" id="jenis_kelamin"
                                        value="{{ auth()->user()->jenis_kelamin }}" readonly>
                                    @error('jenis_kelamin')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="tanggal_lahir">Tanggal Lahir</label>
                                    <input type="date"
                                        class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                        name="tanggal_lahir" id="tanggal_lahir"
                                        value="{{ auth()->user()->tanggal_lahir }}">
                                    @error('tanggal_lahir')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" class="form-control @error('username') is-invalid @enderror"
                                        name="username" id="username" value="{{ auth()->user()->username }}">
                                    <small>Tidak boleh ada spasi & wajib huruf kecil semua!</small>
                                    @error('username')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        id="password" name="password">
                                    <small>Silakan isi jika ingin mengubah password!</small>
                                    @error('password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Ubah</button>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-4">
                                <h3 class="card-title">Foto Profile</h3>
                                <div class="mb-3">
                                    <label for="foto" class="form-label">Foto Profil</label>
                                    <input class="form-control @error('foto') is-invalid @enderror" type="file"
                                        id="foto" name="foto">
                                    <small>Maksimal file gambar 1 MB</small>
                                    @error('foto')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    @if (auth()->user()->foto)
                                        <img id="previewImage" class="img-preview img-fluid mb-3 col-sm-5"
                                            src="{{ asset('storage/foto/' . auth()->user()->foto) }}"
                                            alt="Foto Profil">
                                    @else
                                        <div class="alert alert-warning" role="alert">
                                            Anda belum mengunggah foto profil.
                                        </div>
                                    @endif
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>
                                        Simpan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('sweetalert::alert')

    <script src="assets/compiled/js/app.js"></script>
    <script>
        // Fungsi untuk menampilkan gambar saat file dipilih
        function previewImage() {
            var input = document.getElementById('foto');
            var preview = document.getElementById('previewImage');

            input.addEventListener('change', function() {
                var file = input.files[0];
                var reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block'; // Menampilkan gambar saat file dipilih
                };

                reader.readAsDataURL(file);
            });
        }

        // Panggil fungsi previewImage saat dokumen siap
        document.addEventListener('DOMContentLoaded', function() {
            previewImage();
        });
    </script>

    {{-- SWEET ALERT --}}
    <script src="assets/extensions/sweetalert2/sweetalert2.min.js"></script>
    <script src="assets/static/js/pages/sweetalert2.js"></script>
</body>

</html>
