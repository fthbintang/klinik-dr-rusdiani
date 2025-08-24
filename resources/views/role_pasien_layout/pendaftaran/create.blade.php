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

                {{-- Dokter --}}
                <div class="form-group mb-3">
                    <label for="dokter_id" class="form-label"><b>Dokter</b><span class="text-danger">*</span></label>
                    <select name="dokter_id" id="dokter_id" class="form-control" required>
                        <option value="">-- Pilih Dokter --</option>
                        @foreach ($dokter as $item)
                            <option value="{{ $item->id }}">{{ $item->nama_dokter }} -
                                {{ $item->poli->nama_poli }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Jadwal Dokter --}}
                <div class="form-group mb-3">
                    <label for="tanggal_kunjungan" class="form-label"><b>Tanggal Kunjungan</b><span
                            class="text-danger">*</span></label>
                    <select name="tanggal_kunjungan" id="tanggal_kunjungan" class="form-control" required>
                        <option value="">-- Pilih Tanggal --</option>
                    </select>
                </div>

                <div class="form-group mb-3">
                    <label for="keluhan" class="form-label"><b>Keluhan</b><span class="text-danger">*</span></label>
                    <textarea name="keluhan" id="keluhan" class="form-control @error('keluhan') is-invalid @enderror" rows="3"
                        placeholder="Keluhan...">{{ old('keluhan') }}</textarea>
                    @error('keluhan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Alergi Obat --}}
                <div class="form-group mb-3">
                    <label for="alergi_obat" class="form-label"><b>Alergi Obat</b></label>
                    <textarea name="alergi_obat" id="alergi_obat" class="form-control @error('alergi_obat') is-invalid @enderror"
                        rows="2" placeholder="Alergi obat...">{{ old('alergi_obat') }}</textarea>
                    @error('alergi_obat')
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
        document.addEventListener('DOMContentLoaded', function() {
            const dokterSelect = document.getElementById('dokter_id');
            const tanggalSelect = document.getElementById('tanggal_kunjungan');

            dokterSelect.addEventListener('change', function() {
                const dokterId = this.value;

                if (!dokterId) {
                    tanggalSelect.innerHTML = '<option value="">-- Pilih Tanggal --</option>';
                    return;
                }

                // SweetAlert loading
                Swal.fire({
                    title: 'Memuat jadwal dokter...',
                    allowOutsideClick: false,
                    didOpen: () => Swal.showLoading()
                });

                // Fetch jadwal dokter sesuai route prefix 'pasien'
                fetch("{{ url('pasien/dokter') }}/" + dokterId + "/jadwal")
                    .then(res => res.json())
                    .then(data => {
                        tanggalSelect.innerHTML = '';
                        if (data.length > 0) {
                            data.forEach(item => {
                                const opt = document.createElement('option');
                                opt.value = item.tanggal;
                                opt.textContent = item.label; // bisa 'Hari, dd M Y'
                                tanggalSelect.appendChild(opt);
                            });
                        } else {
                            const opt = document.createElement('option');
                            opt.value = '';
                            opt.textContent = 'Jadwal belum tersedia';
                            opt.disabled = true;
                            tanggalSelect.appendChild(opt);
                        }
                    })
                    .catch(err => {
                        Swal.fire('Error', 'Gagal mengambil jadwal dokter', 'error');
                    })
                    .finally(() => {
                        Swal.close(); // Tutup loading
                    });
            });
        });
    </script>


</x-layout>
