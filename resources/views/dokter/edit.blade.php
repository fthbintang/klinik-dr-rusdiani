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
                            <li class="breadcrumb-item"><a href="{{ route('dokter.index') }}">Dokter</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="text-end mb-3">
        <a href="{{ route('dokter.index') }}" class="btn btn-info">Kembali</a>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Form {{ $title }}</h5>
        </div>

        <div class="card-body">
            <form action="{{ route('dokter.update', $dokter->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Nama Dokter --}}
                <div class="form-group mb-3">
                    <label for="nama_dokter" class="form-label"><b>Nama Dokter</b><span
                            class="text-danger">*</span></label>
                    <input type="text" name="nama_dokter" id="nama_dokter"
                        class="form-control @error('nama_dokter') is-invalid @enderror" placeholder="Nama Dokter..."
                        value="{{ old('nama_dokter', $dokter->nama_dokter) }}" required>
                    @error('nama_dokter')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Poli --}}
                <div class="form-group mb-3">
                    <label for="poli_id" class="form-label"><b>Poli</b><span class="text-danger">*</span></label>
                    <select name="poli_id" id="poli_id" class="form-select @error('poli_id') is-invalid @enderror"
                        required>
                        <option value="">-- Pilih Poli --</option>
                        @foreach ($poli as $item)
                            <option value="{{ $item->id }}"
                                {{ old('poli_id', $dokter->poli_id) == $item->id ? 'selected' : '' }}>
                                {{ $item->nama_poli }}
                            </option>
                        @endforeach
                    </select>
                    @error('poli_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- No STR --}}
                <div class="form-group mb-3">
                    <label for="no_str" class="form-label"><b>No STR</b></label>
                    <input type="text" name="no_str" id="no_str"
                        class="form-control @error('no_str') is-invalid @enderror" placeholder="Nomor STR..."
                        value="{{ old('no_str', $dokter->no_str) }}">
                    @error('no_str')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- No SIP --}}
                <div class="form-group mb-3">
                    <label for="no_sip" class="form-label"><b>No SIP</b></label>
                    <input type="text" name="no_sip" id="no_sip"
                        class="form-control @error('no_sip') is-invalid @enderror" placeholder="Nomor SIP..."
                        value="{{ old('no_sip', $dokter->no_sip) }}">
                    @error('no_sip')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Jenis Kelamin --}}
                <div class="form-group mb-3">
                    <label for="jenis_kelamin" class="form-label"><b>Jenis Kelamin</b><span
                            class="text-danger">*</span></label>
                    <select name="jenis_kelamin" id="jenis_kelamin"
                        class="form-select @error('jenis_kelamin') is-invalid @enderror" required>
                        <option value="">-- Pilih Jenis Kelamin --</option>
                        <option value="Laki-laki"
                            {{ old('jenis_kelamin', $dokter->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>
                            Laki-laki</option>
                        <option value="Perempuan"
                            {{ old('jenis_kelamin', $dokter->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>
                            Perempuan</option>
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
                        value="{{ old('tanggal_lahir', $dokter->tanggal_lahir) }}">
                    @error('tanggal_lahir')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Alamat --}}
                <div class="form-group mb-3">
                    <label for="alamat" class="form-label"><b>Alamat</b></label>
                    <textarea name="alamat" id="alamat" rows="3" class="form-control @error('alamat') is-invalid @enderror"
                        placeholder="Alamat...">{{ old('alamat', $dokter->alamat) }}</textarea>
                    @error('alamat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Tombol Submit --}}
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>

            </form>
        </div>
    </div>
</x-layout>
