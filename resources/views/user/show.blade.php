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
            {{-- Nama Lengkap --}}
            <div class="form-group mb-3">
                <label for="nama_lengkap" class="form-label"><b>Nama Lengkap</b><span
                        class="text-danger">*</span></label>
                <input type="text" name="nama_lengkap" id="nama_lengkap"
                    class="form-control @error('nama_lengkap') is-invalid @enderror" value="{{ $user->nama_lengkap }}"
                    readonly>
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
                    value="{{ $user->nama_panggilan }}" readonly>
                @error('nama_panggilan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Jenis Kelamin --}}
            <div class="form-group mb-3">
                <label for="jenis_kelamin" class="form-label"><b>Jenis Kelamin</b><span
                        class="text-danger">*</span></label>
                <input type="text" name="jenis_kelamin" id="jenis_kelamin"
                    class="form-control @error('jenis_kelamin') is-invalid @enderror"
                    value="{{ $user->jenis_kelamin }}" readonly>
                @error('jenis_kelamin')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Tanggal Lahir --}}
            <div class="form-group mb-3">
                <label for="tanggal_lahir" class="form-label"><b>Tanggal Lahir</b></label>
                <input type="date" name="tanggal_lahir" id="tanggal_lahir"
                    class="form-control @error('tanggal_lahir') is-invalid @enderror"
                    value="{{ $user->tanggal_lahir }}" readonly>
                @error('tanggal_lahir')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- No HP --}}
            <div class="form-group mb-3">
                <label for="no_hp" class="form-label"><b>No HP</b></label>
                <input type="text" name="no_hp" id="no_hp"
                    class="form-control @error('no_hp') is-invalid @enderror" value="{{ $user->no_hp }}" readonly>
                @error('no_hp')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Alamat --}}
            <div class="form-group">
                <label for="alamat">Alamat</label>
                <textarea class="form-control @error('alamat') is-invalid @enderror" name="alamat" id="alamat"
                    placeholder="Alamat..." readonly>{{ $user->alamat }}</textarea>
                @error('alamat')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- Foto --}}
            <div class="form-group mb-3">
                <label for="foto" class="form-label"><b>Foto</b></label>
                @if ($user->foto)
                    <img src="{{ asset('storage/foto/' . $user->foto) }}" alt="Foto"
                        style="height: 150px; width: auto;" class="img-thumbnail mt-1">
                @endif
                @error('foto')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            {{-- Role --}}
            <div class="form-group mb-3">
                <label for="role" class="form-label"><b>Role</b><span class="text-danger">*</span></label>
                <input type="text" name="role" id="role"
                    class="form-control @error('role') is-invalid @enderror" value="{{ $user->role }}" readonly>
                @error('role')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
</x-layout>
