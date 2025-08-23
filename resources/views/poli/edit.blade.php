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
                            <li class="breadcrumb-item"><a href="{{ route('poli.index') }}">Poli</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="text-end mb-3">
        <a href="{{ route('poli.index') }}" class="btn btn-info">Kembali</a>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Form {{ $title }}</h5>
        </div>

        <div class="card-body">
            <form action="{{ route('poli.update', $poli->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                {{-- Nama Poli --}}
                <div class="form-group mb-3">
                    <label for="nama_poli" class="form-label"><b>Nama Poli</b><span class="text-danger">*</span></label>
                    <input type="text" name="nama_poli" id="nama_poli"
                        class="form-control @error('nama_poli') is-invalid @enderror"
                        value="{{ old('nama_poli', $poli->nama_poli) }}">
                    @error('nama_poli')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Tombol Update --}}
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>

            </form>
        </div>
    </div>
</x-layout>
