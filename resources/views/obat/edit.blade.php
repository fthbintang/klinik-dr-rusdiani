<x-layout>
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Edit Obat</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header d-flex justify-content-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('index') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('obat.index') }}">Obat</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="text-end mb-3">
        <a href="{{ route('obat.index') }}" class="btn btn-info">Kembali</a>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Form Edit Obat</h5>
        </div>

        <div class="card-body">
            <form action="{{ route('obat.update', $obat->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Nama Obat --}}
                <div class="form-group mb-3">
                    <label for="nama_obat" class="form-label"><b>Nama Obat</b><span class="text-danger">*</span></label>
                    <input type="text" name="nama_obat" id="nama_obat"
                        class="form-control @error('nama_obat') is-invalid @enderror"
                        value="{{ old('nama_obat', $obat->nama_obat) }}" placeholder="Nama Obat...">
                    @error('nama_obat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Kategori --}}
                <div class="form-group mb-3">
                    <label for="kategori" class="form-label"><b>Kategori</b><span class="text-danger">*</span></label>
                    <select name="kategori" id="kategori"
                        class="choices form-select @error('kategori') is-invalid @enderror">
                        <option value="" disabled>-- Pilih Kategori --</option>
                        @foreach (['Tablet', 'Kapsul', 'Cair', 'Salep', 'Suntik'] as $kategori)
                            <option value="{{ $kategori }}"
                                {{ old('kategori', $obat->kategori) == $kategori ? 'selected' : '' }}>
                                {{ $kategori }}
                            </option>
                        @endforeach
                    </select>
                    @error('kategori')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Satuan --}}
                <div class="form-group mb-3">
                    <label for="satuan" class="form-label"><b>Satuan</b><span class="text-danger">*</span></label>
                    <select name="satuan" id="satuan"
                        class="choices form-select @error('satuan') is-invalid @enderror">
                        <option value="" disabled>-- Pilih Satuan --</option>
                        @foreach (['Strip', 'Botol', 'Tablet', 'Tube', 'Ampul'] as $satuan)
                            <option value="{{ $satuan }}"
                                {{ old('satuan', $obat->satuan) == $satuan ? 'selected' : '' }}>
                                {{ $satuan }}
                            </option>
                        @endforeach
                    </select>
                    @error('satuan')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Stok --}}
                <div class="form-group mb-3">
                    <label for="stok" class="form-label"><b>Stok</b><span class="text-danger">*</span></label>
                    <input type="number" name="stok" id="stok"
                        class="form-control @error('stok') is-invalid @enderror" value="{{ old('stok', $obat->stok) }}"
                        placeholder="Stok...">
                    @error('stok')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Harga --}}
                <div class="form-group mb-3">
                    <label for="harga_display" class="form-label"><b>Harga</b><span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="text" id="harga_display"
                            class="form-control @error('harga') is-invalid @enderror"
                            value="{{ old('harga', $obat->harga) }}" placeholder="Harga...">
                        <input type="hidden" name="harga" id="harga" value="{{ old('harga', $obat->harga) }}">
                    </div>
                    @error('harga')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Tanggal Expired --}}
                <div class="form-group mb-3">
                    <label for="expired_date" class="form-label"><b>Tanggal Expired</b><span
                            class="text-danger">*</span></label>
                    <input type="date" name="expired_date" id="expired_date"
                        class="form-control @error('expired_date') is-invalid @enderror"
                        value="{{ old('expired_date', $obat->expired_date) }}">
                    @error('expired_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Supplier --}}
                <div class="form-group mb-3">
                    <label for="supplier_id" class="form-label"><b>Supplier</b></label>
                    <select name="supplier_id" id="supplier_id"
                        class="choices form-select @error('supplier_id') is-invalid @enderror">
                        <option value="" disabled>-- Pilih Supplier --</option>
                        @foreach ($supplier as $row)
                            <option value="{{ $row->id }}"
                                {{ old('supplier_id', $obat->supplier_id) == $row->id ? 'selected' : '' }}>
                                {{ $row->nama_supplier }}
                            </option>
                        @endforeach
                    </select>
                    @error('supplier_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Keterangan --}}
                <div class="form-group mb-3">
                    <label for="keterangan" class="form-label"><b>Keterangan</b></label>
                    <textarea name="keterangan" id="keterangan" class="form-control @error('keterangan') is-invalid @enderror"
                        rows="3" placeholder="Keterangan...">{{ old('keterangan', $obat->keterangan) }}</textarea>
                    @error('keterangan')
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

    <script>
        const hargaDisplay = document.getElementById('harga_display');
        const hargaHidden = document.getElementById('harga');

        function formatRupiah(angka) {
            return angka.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        function unformatRupiah(rupiah) {
            return rupiah.replace(/\./g, '');
        }

        hargaDisplay.addEventListener('input', function() {
            let raw = unformatRupiah(this.value.replace(/[^0-9]/g, ''));
            this.value = formatRupiah(raw);
            hargaHidden.value = raw;
        });

        // Set awal
        document.addEventListener('DOMContentLoaded', function() {
            if (hargaHidden.value) {
                hargaDisplay.value = formatRupiah(hargaHidden.value);
            }
        });
    </script>
</x-layout>
