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
                            <li class="breadcrumb-item"><a href="{{ route('transaksi.index') }}">Transaksi</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="text-end mb-3">
        <a href="{{ route('transaksi.index') }}" class="btn btn-info">Kembali</a>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Form {{ $title }}</h5>
        </div>

        <div class="card-body">
            <form action="{{ route('transaksi.store') }}" method="POST">
                @csrf

                <div class="form-group mb-3">
                    <label for="tanggal_kunjungan" class="form-label"><b>Tanggal Kunjungan</b><span
                            class="text-danger">*</span></label>
                    <input type="date" name="tanggal_kunjungan" id="tanggal_kunjungan"
                        value="{{ old('tanggal_kunjungan', now()->toDateString()) }}"
                        class="form-control @error('tanggal_kunjungan') is-invalid @enderror">
                    @error('tanggal_kunjungan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="biaya_jasa" class="form-label"><b>Biaya Jasa</b><span
                            class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="text" name="biaya_jasa" id="biaya_jasa" value="{{ old('biaya_jasa') }}"
                            class="form-control @error('biaya_jasa') is-invalid @enderror"
                            placeholder="Masukkan Biaya Jasa">
                    </div>
                    @error('biaya_jasa')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="pasien_id" class="form-label"><b>Pilih Pasien</b><span
                            class="text-danger">*</span></label>
                    <select name="pasien_id" id="pasien_id"
                        class="form-select select2 @error('pasien_id') is-invalid @enderror">
                        <option value="">-- Pilih Pasien --</option>
                        @foreach ($pasien as $item)
                            <option value="{{ $item->id }}" {{ old('pasien_id') == $item->id ? 'selected' : '' }}>
                                {{ $item->no_rm }} - {{ $item->nama_lengkap }}
                            </option>
                        @endforeach
                    </select>
                    @error('pasien_id')
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

    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "-- Pilih Pasien --",
                allowClear: true
            });

            $('#biaya_jasa').on('input', function() {
                let value = $(this).val().replace(/\./g, '');
                if (!isNaN(value)) {
                    $(this).val(Number(value).toLocaleString('id-ID'));
                }
            });

            // Hapus titik sebelum submit
            $('form').on('submit', function() {
                let raw = $('#biaya_jasa').val().replace(/\./g, '');
                $('#biaya_jasa').val(raw);
            });
        });
    </script>

</x-layout>
