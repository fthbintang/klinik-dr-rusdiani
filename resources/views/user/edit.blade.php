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
            <form action="{{ route('user.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        {{-- Nama Lengkap --}}
                        <div class="form-group mb-3">
                            <label for="nama_lengkap" class="form-label"><b>Nama Lengkap</b><span
                                    class="text-danger">*</span></label>
                            <input type="text" name="nama_lengkap" id="nama_lengkap"
                                class="form-control @error('nama_lengkap') is-invalid @enderror"
                                value="{{ old('nama_lengkap', $user->nama_lengkap) }}">
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
                                value="{{ old('nama_panggilan', $user->nama_panggilan) }}">
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
                                <option value="Laki-laki"
                                    {{ old('jenis_kelamin', $user->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>
                                    Laki-laki
                                </option>
                                <option value="Perempuan"
                                    {{ old('jenis_kelamin', $user->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>
                                    Perempuan
                                </option>
                            </select>
                            @error('jenis_kelamin')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Tanggal Lahir --}}
                        <div class="form-group mb-3">
                            <label for="tanggal_lahir" class="form-label"><b>Tanggal Lahir</b><span
                                    class="text-danger">*</span></label>
                            <input type="date" name="tanggal_lahir" id="tanggal_lahir"
                                class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                value="{{ old('tanggal_lahir', $user->tanggal_lahir) }}">
                            @error('tanggal_lahir')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- No HP --}}
                        <div class="form-group mb-3">
                            <label for="no_hp" class="form-label"><b>No HP</b></label>
                            <input type="text" name="no_hp" id="no_hp"
                                class="form-control @error('no_hp') is-invalid @enderror"
                                value="{{ old('no_hp', $user->no_hp) }}">
                            @error('no_hp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Alamat --}}
                        <div class="form-group">
                            <label for="alamat"><b>Alamat</b></label>
                            <textarea class="form-control @error('alamat') is-invalid @enderror" name="alamat" id="alamat"
                                placeholder="Alamat...">{{ $user->alamat }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        {{-- No STR --}}
                        <div class="form-group mb-3">
                            <label for="email" class="form-label"><b>Email</b></label>
                            <input type="email" name="email" id="email"
                                class="form-control @error('email') is-invalid @enderror" placeholder="Email..."
                                value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Foto --}}
                        <div class="form-group mb-3">
                            <label for="foto" class="form-label"><b>Foto</b></label>
                            <input type="file" name="foto" id="foto" class="image-preview-filepond">
                            @if ($user->foto)
                                <small class="d-block mt-1">Foto saat ini:</small>
                                <img src="{{ asset('storage/foto/' . $user->foto) }}" alt="Foto"
                                    style="height: 150px; width: auto;" class="img-thumbnail mt-1">
                            @endif
                            @error('foto')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Role --}}
                        <div class="form-group mb-3">
                            <label for="role" class="form-label"><b>Role</b><span
                                    class="text-danger">*</span></label>
                            <select name="role" id="role"
                                class="form-select @error('role') is-invalid @enderror">
                                <option value="">-- Pilih Role --</option>
                                <option value="Admin" {{ old('role', $user->role) == 'Admin' ? 'selected' : '' }}>
                                    Admin
                                </option>
                                {{-- <option value="Pasien" {{ old('role', $user->role) == 'Pasien' ? 'selected' : '' }}>
                                    Pasien
                                </option> --}}
                                <option value="Dokter" {{ old('role', $user->role) == 'Dokter' ? 'selected' : '' }}>
                                    Dokter
                                </option>
                                <option value="Apotek" {{ old('role', $user->role) == 'Apotek' ? 'selected' : '' }}>
                                    Apotek
                                </option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Username --}}
                        <div class="form-group mb-3">
                            <label for="username" class="form-label"><b>Username</b><span
                                    class="text-danger">*</span></label>
                            <input type="text" name="username" id="username"
                                class="form-control @error('username') is-invalid @enderror"
                                value="{{ old('username', $user->username) }}">
                            @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div class="form-group mb-4">
                            <label for="password" class="form-label"><b>Password Baru</b> (kosongkan jika tidak
                                diubah)</label>
                            <input type="password" name="password" id="password"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="Password baru...">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Tombol Update --}}
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>

            </form>
        </div>
    </div>
</x-layout>
