<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Daftar Akun Pasien</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to right, #8EC5FC, #E0C3FC);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .form-card {
            background: #ffffff;
            border-radius: 15px;
            padding: 40px 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
        }

        .form-card h2 {
            font-weight: 600;
            margin-bottom: 25px;
            color: #512da8;
        }

        .form-label {
            font-weight: 500;
        }

        .form-control:focus {
            border-color: #512da8;
            box-shadow: 0 0 0 0.2rem rgba(81, 45, 168, 0.25);
        }

        .btn-primary {
            background-color: #512da8;
            border-color: #512da8;
            font-weight: 600;
        }

        .btn-primary:hover {
            background-color: #3e208c;
        }

        .text-error {
            font-size: 0.875em;
            color: #dc3545;
            margin-top: 0.25rem;
        }
    </style>
</head>

<body>

    <div class="form-card">
        <h2 class="text-center">Formulir Pendaftaran Pasien</h2>

        <form id="formDaftar" action="{{ route('pendaftaran_akun_pasien.register') }}" method="POST"
            enctype="multipart/form-data">
            @csrf

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Nama Lengkap<span class="text-danger">*</span></label>
                    <input type="text" name="nama_lengkap"
                        class="form-control @error('nama_lengkap') is-invalid @enderror" required
                        placeholder="Masukkan nama lengkap" value="{{ old('nama_lengkap') }}">
                    @error('nama_lengkap')
                        <div class="text-error">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Nama Panggilan<span class="text-danger">*</span></label>
                    <input type="text" name="nama_panggilan"
                        class="form-control @error('nama_panggilan') is-invalid @enderror" required
                        placeholder="Masukkan nama panggilan" value="{{ old('nama_panggilan') }}">
                    @error('nama_panggilan')
                        <div class="text-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Jenis Kelamin<span class="text-danger">*</span></label>
                    <select name="jenis_kelamin" class="form-select @error('jenis_kelamin') is-invalid @enderror"
                        required>
                        <option value="">-- Pilih Jenis Kelamin --</option>
                        <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki
                        </option>
                        <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan
                        </option>
                    </select>
                    @error('jenis_kelamin')
                        <div class="text-error">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir"
                        class="form-control @error('tanggal_lahir') is-invalid @enderror"
                        placeholder="Pilih tanggal lahir" value="{{ old('tanggal_lahir') }}">
                    @error('tanggal_lahir')
                        <div class="text-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">No. HP<span class="text-danger">*</span></label>
                <input type="text" name="no_hp" class="form-control @error('no_hp') is-invalid @enderror"
                    placeholder="Masukkan nomor HP aktif" value="{{ old('no_hp') }}">
                @error('no_hp')
                    <div class="text-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Alamat<span class="text-danger">*</span></label>
                <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="2"
                    placeholder="Masukkan alamat lengkap">{{ old('alamat') }}</textarea>
                @error('alamat')
                    <div class="text-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Foto (Opsional)</label>
                <input type="file" name="foto" class="form-control @error('foto') is-invalid @enderror"
                    accept="image/*">
                @error('foto')
                    <div class="text-error">{{ $message }}</div>
                @enderror
            </div>

            <hr class="my-4">

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Username<span class="text-danger">*</span></label>
                    <input type="text" name="username" class="form-control @error('username') is-invalid @enderror"
                        required placeholder="Buat username" value="{{ old('username') }}">
                    @error('username')
                        <div class="text-error">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Password<span class="text-danger">*</span></label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                        required placeholder="Buat password">
                    @error('password')
                        <div class="text-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <input type="hidden" name="role" value="Pasien">

            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('index') }}" class="btn btn-outline-secondary">
                    ← Kembali
                </a>
                <button type="button" class="btn btn-primary" id="btn-daftar">
                    Daftar Sekarang
                </button>
            </div>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.getElementById('btn-daftar').addEventListener('click', function() {
            Swal.fire({
                title: 'Konfirmasi Pendaftaran',
                text: 'Apakah Anda yakin data sudah benar dan ingin mendaftar?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#512da8',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Daftar Sekarang',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('formDaftar').submit();
                }
            });
        });
    </script>

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                timer: 2500,
                showConfirmButton: false
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ session('error') }}',
                timer: 3000,
                showConfirmButton: true
            });
        </script>
    @endif

</body>

</html>
