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
                            <li class="breadcrumb-item"><a href="{{ route('pendaftaran_pasien.index') }}">Pendaftaran
                                    Pasien</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="text-end mb-3">
        <a href="{{ route('pendaftaran_pasien.index') }}" class="btn btn-info">Kembali</a>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Form {{ $title }}</h5>
        </div>

        <div class="card-body">
            <form action="{{ route('pendaftaran_pasien.store') }}" method="POST">
                @csrf

                <input type="hidden" name="pasien_id" value="{{ $pasien->id }}" readonly>

                <div class="form-group mb-3">
                    <label for="nama" class="form-label"><b>Nama</b></label>
                    <input type="text" id="nama" class="form-control" value="{{ $pasien->nama_lengkap }}"
                        readonly>
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="tanggal_kunjungan" class="form-label"><b>Tanggal Kunjungan</b><span
                            class="text-danger">*</span></label>
                    <select name="tanggal_kunjungan" id="tanggal_kunjungan"
                        class="form-control @error('tanggal_kunjungan') is-invalid @enderror">

                        @forelse ($opsiTanggal as $item)
                            <option value="{{ $item['tanggal'] }}"
                                {{ old('tanggal_kunjungan') == $item['tanggal'] ? 'selected' : '' }}>
                                {{ $item['label'] }}
                            </option>
                        @empty
                            <option disabled>Jadwal belum tersedia</option>
                        @endforelse

                    </select>
                    @error('tanggal_kunjungan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="keluhan" class="form-label"><b>Keluhan</b><span class="text-danger">*</span></label>
                    <textarea name="keluhan" id="keluhan" class="form-control @error('keluhan') is-invalid @enderror" rows="3"
                        placeholder="Keluhan...">{{ old('keluhan') }}</textarea>
                    @error('keluhan')
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
