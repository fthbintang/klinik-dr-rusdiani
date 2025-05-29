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
                            <li class="breadcrumb-item"><a href="{{ route('obat.index') }}">Obat</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('obat.supplier.index') }}">Supplier</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="text-end mb-3">
        <a href="{{ route('obat.supplier.index') }}" class="btn btn-info">Kembali</a>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Form {{ $title }}</h5>
        </div>

        <div class="card-body">
            <form action="{{ route('obat.supplier.update', $supplier->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Nama Supplier --}}
                <div class="form-group mb-3">
                    <label for="nama_supplier" class="form-label"><b>Nama Supplier</b><span
                            class="text-danger">*</span></label>
                    <input type="text" name="nama_supplier" id="nama_supplier"
                        class="form-control @error('nama_supplier') is-invalid @enderror" placeholder="Nama Supplier..."
                        value="{{ old('nama_supplier', $supplier->nama_supplier) }}">
                    @error('nama_supplier')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Nama Telp --}}
                <div class="form-group mb-3">
                    <label for="telepon" class="form-label"><b>Telepon</b></label>
                    <input type="text" name="telepon" id="telepon"
                        class="form-control @error('telepon') is-invalid @enderror" placeholder="08xxxxxxxxxx"
                        value="{{ old('telepon', $supplier->telepon) }}">
                    @error('telepon')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Alamat --}}
                <div class="form-group">
                    <label for="alamat"><b>Alamat</b></label>
                    <textarea class="form-control @error('alamat') is-invalid @enderror" name="alamat" id="alamat"
                        placeholder="Alamat...">{{ old('alamat', $supplier->alamat) }}</textarea>
                    @error('alamat')
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
</x-layout>
