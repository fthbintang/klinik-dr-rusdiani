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
                            <li class="breadcrumb-item"><a href="{{ route('penjualan_obat.index') }}">Penjualan Obat</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="text-end mb-3">
        <a href="{{ route('penjualan_obat.index') }}" class="btn btn-info">Kembali</a>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Form {{ $title }}</h5>
        </div>

        <div class="card-body">
            <form action="{{ route('penjualan_obat.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="form-group mb-3">
                        <label for="pasien_id" class="form-label"><b>Pilih Pasien</b></label>
                        <select name="pasien_id" id="pasien_id"
                            class="form-select select2 @error('pasien_id') is-invalid @enderror">
                            <option value="">-- Pilih Pasien --</option>
                            @foreach ($pasien as $item)
                                <option value="{{ $item->id }}"
                                    {{ old('pasien_id') == $item->id ? 'selected' : '' }}>
                                    {{ $item->no_rm }} - {{ $item->nama_lengkap }}
                                </option>
                            @endforeach
                        </select>
                        <small>Jika Pasien Belum Pernah Berobat di Klinik, kosongkan saja</small>
                        @error('pasien_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="catatan"><b>Catatan</b></label>
                    <textarea class="form-control @error('catatan') is-invalid @enderror" name="catatan" id="catatan"
                        placeholder="Catatan..."></textarea>
                    @error('catatan')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Tombol Submit --}}
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "-- Pilih Pasien --",
                allowClear: true
            });
        });
    </script>
</x-layout>
