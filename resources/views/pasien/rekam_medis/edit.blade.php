<x-layout>
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>{{ $title }}</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header d-flex justify-content-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('index') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('pasien.index') }}">Pasien</a></li>
                            <li class="breadcrumb-item"><a
                                    href="{{ route('pasien.rekam_medis.index', $rekam_medis->id) }}">Rekam
                                    Medis ({{ $rekam_medis->pasien->nama_lengkap }})</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="text-end mb-3">
        <a href="{{ route('pasien.rekam_medis.index', $rekam_medis->pasien->id) }}" class="btn btn-info">Kembali</a>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Form {{ $title }}</h5>
        </div>

        <div class="card-body">
            <form action="{{ route('pasien.rekam_medis.update', $rekam_medis->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Keluhan --}}
                <div class="form-group mb-3">
                    <label for="keluhan" class="form-label"><b>Keluhan</b></label>
                    <textarea name="keluhan" id="keluhan" class="form-control @error('keluhan') is-invalid @enderror" rows="3"
                        placeholder="Keluhan...">{{ old('keluhan', $rekam_medis->keluhan) }}</textarea>
                    @error('keluhan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Diagnosis --}}
                <div class="form-group mb-3">
                    <label for="diagnosis" class="form-label"><b>Diagnosis</b></label>
                    <textarea name="diagnosis" id="diagnosis" class="form-control @error('diagnosis') is-invalid @enderror" rows="3"
                        placeholder="Diagnosis...">{{ old('diagnosis', $rekam_medis->diagnosis) }}</textarea>
                    @error('diagnosis')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Tindakan --}}
                <div class="form-group mb-3">
                    <label for="tindakan" class="form-label"><b>Tindakan</b></label>
                    <textarea name="tindakan" id="tindakan" class="form-control @error('tindakan') is-invalid @enderror" rows="3"
                        placeholder="Tindakan...">{{ old('tindakan', $rekam_medis->tindakan) }}</textarea>
                    @error('tindakan')
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
