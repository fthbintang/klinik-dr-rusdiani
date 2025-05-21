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
                            <li class="breadcrumb-item"><a href="{{ route('index') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('user.index') }}">Pengguna</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="text-end mb-3">
        <a href="{{ route('user.index') }}" class="btn btn-info">Kembali</a>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Form {{ $title }}</h5>
        </div>

        <div class="card-body">
            <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Nama Lengkap --}}
                <div class="form-group mb-3">
                    <label for="nama_lengkap" class="form-label"><b>Nama Lengkap</b><span
                            class="text-danger">*</span></label>
                    <input type="text" name="nama_lengkap" id="nama_lengkap"
                        class="form-control @error('nama_lengkap') is-invalid @enderror" placeholder="Nama Lengkap..."
                        value="{{ old('nama_lengkap') }}">
                    @error('nama_lengkap')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Nama Panggilan --}}
                <div class="form-group mb-3">
                    <label for="nama_panggilan" class="form-label"><b>Nama Panggilan</b><span
                            class="text-danger">*</span></label>
                    <input type="text" name="nama_panggilan" id="nama_panggilan"
                        class="form-control @error('nama_panggilan') is-invalid @enderror"
                        placeholder="Nama Panggilan..." value="{{ old('nama_panggilan') }}">
                    @error('nama_panggilan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Jenis Kelamin --}}
                <div class="form-group mb-3">
                    <label for="jenis_kelamin" class="form-label"><b>Jenis Kelamin</b><span
                            class="text-danger">*</span></label>
                    <select name="jenis_kelamin" id="jenis_kelamin"
                        class="form-select @error('jenis_kelamin') is-invalid @enderror">
                        <option value="">-- Pilih Jenis Kelamin --</option>
                        <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki
                        </option>
                        <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan
                        </option>
                    </select>
                    @error('jenis_kelamin')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Tanggal Lahir --}}
                <div class="form-group mb-3">
                    <label for="tanggal_lahir" class="form-label"><b>Tanggal Lahir</b></label>
                    <input type="date" name="tanggal_lahir" id="tanggal_lahir"
                        class="form-control @error('tanggal_lahir') is-invalid @enderror"
                        value="{{ old('tanggal_lahir') }}">
                    @error('tanggal_lahir')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- No HP --}}
                <div class="form-group mb-3">
                    <label for="no_hp" class="form-label"><b>No HP</b></label>
                    <input type="text" name="no_hp" id="no_hp"
                        class="form-control @error('no_hp') is-invalid @enderror" placeholder="08xxxxxxxxxx"
                        value="{{ old('no_hp') }}">
                    @error('no_hp')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Foto --}}
                <div class="form-group mb-3">
                    <label for="foto" class="form-label"><b>Foto</b></label>
                    <input type="file" name="foto" id="foto" class="image-preview-filepond">
                    <small class="text-muted">Ukuran maksimal 500 KB.</small>
                    @error('foto')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Role --}}
                <div class="form-group mb-3">
                    <label for="role" class="form-label"><b>Role</b><span class="text-danger">*</span></label>
                    <select name="role" id="role" class="form-select @error('role') is-invalid @enderror">
                        <option value="">-- Pilih Role --</option>
                        <option value="Admin" {{ old('role') == 'Admin' ? 'selected' : '' }}>Admin</option>
                        <option value="Dokter" {{ old('role') == 'Dokter' ? 'selected' : '' }}>Dokter</option>
                        <option value="Pasien" {{ old('role') == 'Pasien' ? 'selected' : '' }}>Pasien</option>
                        <option value="Apotek" {{ old('role') == 'Apotek' ? 'selected' : '' }}>Apotek</option>
                    </select>
                    @error('role')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Username --}}
                <div class="form-group mb-3">
                    <label for="username" class="form-label"><b>Username</b><span class="text-danger">*</span></label>
                    <input type="text" name="username" id="username"
                        class="form-control @error('username') is-invalid @enderror" placeholder="Username..."
                        value="{{ old('username') }}">
                    @error('username')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="form-group mb-4">
                    <label for="password" class="form-label"><b>Password</b><span
                            class="text-danger">*</span></label>
                    <input type="password" name="password" id="password"
                        class="form-control @error('password') is-invalid @enderror" placeholder="Password...">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Tombol Submit --}}
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>

            </form>
        </div>
    </div>
</x-layout>
