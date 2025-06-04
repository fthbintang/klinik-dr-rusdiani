<x-layout>
    <style>
        .select2-container--default .select2-selection--single {
            height: 40px !important;
            padding: 10px 12px !important;
            border-radius: 0.375rem;
            font-size: 1rem;
            line-height: 1.5;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 18px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 35px !important;
        }
    </style>

    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Halaman {{ $title }}</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header d-flex justify-content-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('index') }}">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('pasien.index') }}">Pasien</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('pasien.rekam_medis.index', $pasien->id) }}">
                                    Rekam Medis ({{ $pasien->nama_lengkap }})
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                {{ $title }}
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="text-end mb-3">
        <a href="{{ route('pasien.rekam_medis.index', $pasien->id) }}" class="btn btn-info">Kembali</a>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-header text-center">
                <h3>{{ $title }}</h3>
                <h4 class="card-title">a.n {{ $pasien->nama_lengkap }} ({{ $pasien->no_rm }})</h4>

                @if ($pasien->user->foto)
                    <div class="text-center mt-2">
                        <img src="{{ asset('storage/foto/' . $pasien->user->foto) }}" alt="Foto Pasien"
                            class="img-fluid" style="max-width: 100px; border-radius: 10px" data-bs-toggle="modal"
                            data-bs-target="#fotoModal">
                    </div>

                    <div class="modal fade" id="fotoModal" tabindex="-1" aria-labelledby="fotoModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="fotoModalLabel">Foto Pasien</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body text-center">
                                    <img src="{{ asset('storage/foto/' . $pasien->user->foto) }}" alt="Foto Pasien"
                                        class="img-fluid" style="max-width: 100%;">
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <div class="card-body">
                <div class="row align-items-end g-2">
                    <div class="col-md-4">
                        <label for="nama_obat" class="form-label"><b>Obat</b><span class="text-danger">*</span></label>
                        <select id="nama_obat" class="form-select">
                            <option value="">-- Pilih Obat --</option>
                            @foreach ($daftar_obat as $obat)
                                <option value="{{ $obat->id }}" data-nama="{{ $obat->nama_obat }}"
                                    data-kategori="{{ $obat->kategori }}" data-satuan="{{ $obat->satuan }}"
                                    data-expired="{{ $obat->expired_date }}" data-harga="{{ $obat->harga }}">
                                    {{ $obat->nama_obat }} - {{ $obat->kategori }} - {{ $obat->satuan }} - stok:
                                    {{ $obat->stok }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-1">
                        <label for="kuantitas" class="form-label"><b>Qty</b><span class="text-danger">*</span></label>
                        <input type="number" id="kuantitas" class="form-control" min="1" value="1">
                    </div>
                    <div class="col-md-4">
                        <label for="catatan" class="form-label"><b>Catatan / Petunjuk Konsumsi</b></label>
                        <input type="text" id="catatan" class="form-control"
                            placeholder="cth: 3x sehari setelah makan">
                    </div>
                    <div class="col-md-2">
                        <button type="button" id="btn-tambah-obat" class="btn btn-primary w-100">
                            Tambah
                        </button>
                    </div>
                </div>

                <hr>

                <div class="table-responsive mt-3">
                    <table class="table table-bordered" id="tabel-obat-terpilih">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Obat</th>
                                <th>Kategori</th>
                                <th>Satuan</th>
                                <th>Expired</th>
                                <th>Harga</th>
                                <th>Qty</th>
                                <th>Total</th>
                                <th>Catatan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                        <tfoot>
                            <tr>
                                <th colspan="7" class="text-end">Grand Total</th>
                                <th id="total-semua">Rp0</th>
                                <th colspan="2"></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="mt-4 float-end">
                    <button id="btn-simpan-dokter" class="btn btn-success">✅ Disetujui Dokter</button>
                    <button id="btn-simpan-apotek" class="btn btn-primary">💊 Diproses Apotek</button>
                </div>
            </div>
        </div>
    </section>

    {{-- <script>
        $(document).ready(function() {
            $('#nama_obat').select2({
                placeholder: "-- Pilih Obat --",
                width: '100%'
            });
        });

        let no = 1;
        let totalSemua = 0;

        document.getElementById('btn-tambah-obat').addEventListener('click', function() {
            const select = document.getElementById('nama_obat');
            const selected = select.options[select.selectedIndex];
            const qty = parseInt(document.getElementById('kuantitas').value) || 1;
            const catatan = document.getElementById('catatan').value.trim();

            if (!selected.value) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Obat belum dipilih!',
                    text: 'Silakan pilih obat sebelum menambahkan.',
                    confirmButtonColor: '#3085d6'
                });
                return;
            }

            const nama = selected.dataset.nama;
            const kategori = selected.dataset.kategori;
            const satuan = selected.dataset.satuan;
            const expired = selected.dataset.expired;
            const harga = parseInt(selected.dataset.harga);
            const total = harga * qty;
            totalSemua += total;

            const tbody = document.querySelector('#tabel-obat-terpilih tbody');
            const tr = document.createElement('tr');

            tr.innerHTML = `
                    <td>${no++}</td>
                    <td>${nama}</td>
                    <td>${kategori}</td>
                    <td>${satuan}</td>
                    <td>${expired}</td>
                    <td>Rp${harga.toLocaleString('id-ID')}</td>
                    <td>${qty}</td>
                    <td>Rp${total.toLocaleString('id-ID')}</td>
                    <td>${catatan || '-'}</td>
                    <td><button class="btn btn-danger btn-sm btn-hapus">Hapus</button></td>
                `;

            tbody.appendChild(tr);
            document.getElementById('total-semua').textContent = 'Rp' + totalSemua.toLocaleString('id-ID');

            // Reset input
            document.getElementById('kuantitas').value = 1;
            document.getElementById('catatan').value = '';
            $('#nama_obat').val(null).trigger('change');
        });

        document.querySelector('#tabel-obat-terpilih tbody').addEventListener('click', function(e) {
            if (e.target.classList.contains('btn-hapus')) {
                const row = e.target.closest('tr');
                const total = row.children[7].textContent.replace(/[^\d]/g, '');

                Swal.fire({
                    title: 'Yakin ingin menghapus?',
                    text: "Data obat ini akan dihapus dari daftar.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, hapus',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        totalSemua -= parseInt(total);
                        document.getElementById('total-semua').textContent = 'Rp' + totalSemua
                            .toLocaleString('id-ID');
                        row.remove();

                        Swal.fire({
                            icon: 'success',
                            title: 'Dihapus!',
                            text: 'Data obat telah dihapus.',
                            timer: 1000,
                            showConfirmButton: false
                        });
                    }
                });
            }
        });
    </script> --}}

    <script>
        $(document).ready(function() {
            $('#nama_obat').select2({
                placeholder: "-- Pilih Obat --",
                width: '100%'
            });
        });

        function formatDateToDMY(dateString) {
            if (!dateString) return '-';
            const parts = dateString.split('-');
            if (parts.length !== 3) return dateString;
            return `${parts[2]}-${parts[1]}-${parts[0]}`;
        }

        let no = 1;
        let totalSemua = 0;

        document.getElementById('btn-tambah-obat').addEventListener('click', function() {
            const select = document.getElementById('nama_obat');
            const selected = select.options[select.selectedIndex];
            const qty = parseInt(document.getElementById('kuantitas').value) || 1;
            const catatan = document.getElementById('catatan').value.trim();

            if (!selected.value) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Obat belum dipilih!',
                    text: 'Silakan pilih obat sebelum menambahkan.',
                    confirmButtonColor: '#3085d6'
                });
                return;
            }

            const nama = selected.dataset.nama;
            const kategori = selected.dataset.kategori;
            const satuan = selected.dataset.satuan;
            const expired = formatDateToDMY(selected.dataset.expired);
            const harga = parseInt(selected.dataset.harga);
            const total = harga * qty;
            totalSemua += total;

            const tbody = document.querySelector('#tabel-obat-terpilih tbody');
            const tr = document.createElement('tr');

            tr.innerHTML = `
            <td>${no++}</td>
            <td>${nama}</td>
            <td>${kategori}</td>
            <td>${satuan}</td>
            <td>${expired}</td>
            <td>Rp${harga.toLocaleString('id-ID')}</td>
            <td>${qty}</td>
            <td>Rp${total.toLocaleString('id-ID')}</td>
            <td>${catatan || '-'}</td>
            <td><button class="btn btn-danger btn-sm btn-hapus">Hapus</button></td>
        `;

            tbody.appendChild(tr);
            document.getElementById('total-semua').textContent = 'Rp' + totalSemua.toLocaleString('id-ID');

            // Reset input
            document.getElementById('kuantitas').value = 1;
            document.getElementById('catatan').value = '';
            $('#nama_obat').val(null).trigger('change');
        });
    </script>
</x-layout>
