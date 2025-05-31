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
                            <li class="breadcrumb-item"><a href="{{ route('pasien.index') }}">Pasien</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="text-end mb-3">
        <a href="{{ route('pasien.index') }}" class="btn btn-info">Kembali</a>
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
                    class="form-control @error('nama_lengkap') is-invalid @enderror"
                    value="{{ old('nama_lengkap', $pasien->nama_lengkap) }}" placeholder="Nama Lengkap..." readonly>
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
                    value="{{ old('nama_panggilan', $pasien->nama_panggilan) }}" placeholder="Nama Panggilan..."
                    readonly>
                @error('nama_panggilan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- NIK --}}
            <div class="form-group mb-3">
                <label for="nik" class="form-label"><b>NIK</b><span class="text-danger">*</span></label>
                <input type="text" name="nik" id="nik"
                    class="form-control @error('nik') is-invalid @enderror" value="{{ old('nik', $pasien->nik) }}"
                    placeholder="NIK..." readonly>
                @error('nik')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Jenis Kelamin --}}
            <div class="form-group mb-3">
                <label for="jenis_kelamin" class="form-label"><b>Jenis Kelamin</b><span
                        class="text-danger">*</span></label>
                <select name="jenis_kelamin" id="jenis_kelamin"
                    class="form-select @error('jenis_kelamin') is-invalid @enderror" disabled>
                    <option value="">-- Pilih Jenis Kelamin --</option>
                    <option value="Laki-laki"
                        {{ old('jenis_kelamin', $pasien->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>
                        Laki-laki</option>
                    <option value="Perempuan"
                        {{ old('jenis_kelamin', $pasien->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>
                        Perempuan</option>
                </select>
                @error('jenis_kelamin')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- No HP --}}
            <div class="form-group mb-3">
                <label for="no_hp" class="form-label"><b>No HP</b><span class="text-danger">*</span></label>
                <input type="text" name="no_hp" id="no_hp"
                    class="form-control @error('no_hp') is-invalid @enderror"
                    value="{{ old('no_hp', $pasien->no_hp) }}" placeholder="08xxxx" readonly>
                @error('no_hp')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Tempat Lahir --}}
            <div class="form-group mb-3">
                <label for="tempat_lahir" class="form-label"><b>Tempat Lahir</b></label>
                <input type="text" name="tempat_lahir" id="tempat_lahir"
                    class="form-control @error('tempat_lahir') is-invalid @enderror"
                    value="{{ old('tempat_lahir', $pasien->tempat_lahir) }}" placeholder="Tempat Lahir..." readonly>
                @error('tempat_lahir')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Tanggal Lahir --}}
            <div class="form-group mb-3">
                <label for="tanggal_lahir" class="form-label"><b>Tanggal Lahir</b></label>
                <input type="date" name="tanggal_lahir" id="tanggal_lahir"
                    class="form-control @error('tanggal_lahir') is-invalid @enderror readonly"
                    value="{{ old('tanggal_lahir', $pasien->tanggal_lahir) }}">
                @error('tanggal_lahir')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Alamat --}}
            <div class="form-group mb-3">
                <label for="alamat" class="form-label"><b>Alamat</b></label>
                <textarea name="alamat" id="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="3"
                    placeholder="Alamat lengkap..." readonly>{{ old('alamat', $pasien->alamat) }}</textarea>
                @error('alamat')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Pekerjaan --}}
            <div class="form-group mb-3">
                <label for="pekerjaan" class="form-label"><b>Pekerjaan</b></label>
                <input type="text" name="pekerjaan" id="pekerjaan"
                    class="form-control @error('pekerjaan') is-invalid @enderror"
                    value="{{ old('pekerjaan', $pasien->pekerjaan) }}" placeholder="Pekerjaan..." readonly>
                @error('pekerjaan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Status Perkawinan --}}
            <div class="form-group mb-3">
                <label for="status_perkawinan" class="form-label"><b>Status Perkawinan</b></label>
                <select name="status_perkawinan" id="status_perkawinan"
                    class="form-select @error('status_perkawinan') is-invalid @enderror" disabled>
                    <option value="">-- Pilih Status --</option>
                    <option value="Belum Menikah"
                        {{ old('status_perkawinan', $pasien->status_perkawinan) == 'Belum Menikah' ? 'selected' : '' }}>
                        Belum Menikah</option>
                    <option value="Menikah"
                        {{ old('status_perkawinan', $pasien->status_perkawinan) == 'Menikah' ? 'selected' : '' }}>
                        Menikah</option>
                    <option value="Cerai"
                        {{ old('status_perkawinan', $pasien->status_perkawinan) == 'Cerai' ? 'selected' : '' }}>
                        Cerai</option>
                </select>
                @error('status_perkawinan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Golongan Darah --}}
            <div class="form-group mb-3">
                <label for="golongan_darah" class="form-label"><b>Golongan Darah</b></label>
                <select name="golongan_darah" id="golongan_darah"
                    class="form-select @error('golongan_darah') is-invalid @enderror" disabled>
                    <option value="">-- Pilih Golongan Darah --</option>
                    <option value="A"
                        {{ old('golongan_darah', $pasien->golongan_darah) == 'A' ? 'selected' : '' }}>A</option>
                    <option value="B"
                        {{ old('golongan_darah', $pasien->golongan_darah) == 'B' ? 'selected' : '' }}>B</option>
                    <option value="AB"
                        {{ old('golongan_darah', $pasien->golongan_darah) == 'AB' ? 'selected' : '' }}>AB</option>
                    <option value="O"
                        {{ old('golongan_darah', $pasien->golongan_darah) == 'O' ? 'selected' : '' }}>O</option>
                </select>
                @error('golongan_darah')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Agama --}}
            <div class="form-group mb-3">
                <label for="agama" class="form-label"><b>Agama</b></label>
                <select name="agama" id="agama" class="form-select @error('agama') is-invalid @enderror"
                    disabled>
                    <option value="">-- Pilih Agama --</option>
                    <option value="Islam" {{ old('agama', $pasien->agama) == 'Islam' ? 'selected' : '' }}>Islam
                    </option>
                    <option value="Kristen" {{ old('agama', $pasien->agama) == 'Kristen' ? 'selected' : '' }}>
                        Kristen</option>
                    <option value="Katolik" {{ old('agama', $pasien->agama) == 'Katolik' ? 'selected' : '' }}>
                        Katolik</option>
                    <option value="Hindu" {{ old('agama', $pasien->agama) == 'Hindu' ? 'selected' : '' }}>Hindu
                    </option>
                    <option value="Buddha" {{ old('agama', $pasien->agama) == 'Buddha' ? 'selected' : '' }}>Buddha
                    </option>
                    <option value="Konghucu" {{ old('agama', $pasien->agama) == 'Konghucu' ? 'selected' : '' }}>
                        Konghucu</option>
                </select>
                @error('agama')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Foto Profil --}}
            <div class="form-group mb-3">
                <label for="foto" class="form-label"><b>Foto Profil</b></label>
                @if ($pasien->user->foto)
                    <small class="form-text text-muted">Foto saat ini: <br>
                        <img src="{{ asset('/storage/foto/' . $pasien->user->foto) }}" alt="Foto Profil"
                            style="max-width: 120px; margin-top: 5px;">
                    </small>
                @else
                    <p class="text-3xl">Tidak ada foto profil</p>
                @endif
                @error('foto')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
</x-layout>
