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

    @if ($from === 'rekam_medis')
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
    @endif

    @if ($from === 'transaksi')
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
                                    <a href="{{ route('transaksi.index') }}">Transaksi</a>
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
            <a href="{{ route('transaksi.index') }}" class="btn btn-info">Kembali</a>
        </div>
    @endif

    @if ($from === 'pendaftaran_pasien')
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
                                    <a href="{{ route('beranda_pasien.index') }}">Home</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="{{ route('pendaftaran_pasien.index') }}">Pendaftaran Pasien</a>
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
            <a href="{{ route('pendaftaran_pasien.index') }}" class="btn btn-info">Kembali</a>
        </div>
    @endif

    <section class="section">
        <div class="card">
            <div class="card-header text-center">
                {{-- <h3>{{ $title }}</h3> --}}
                <h3>Detail Pemeriksaan @if ($rekam_medis->keluhan && $rekam_medis->diagnosis && $rekam_medis->tindakan)
                        ✅
                    @endif
                </h3>
                <h4 class="card-title">a.n {{ $pasien->nama_lengkap }} ({{ $pasien->no_rm }})</h4>
                <b>Usia: {{ \Carbon\Carbon::parse($pasien->tanggal_lahir)->age }} tahun</b>

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
                <form action="{{ route('resep_obat.store_keluhan_diagnosis_tindakan', $rekam_medis->id) }}"
                    method="POST">
                    @csrf

                    <input type="hidden" name="rekam_medis_id" value="{{ $rekam_medis->id }}">

                    <div class="form-group">
                        <label for="keluhan" class="form-label"><b>Keluhan</b><span
                                class="text-danger">*</span></label>
                        <textarea class="form-control @error('keluhan') is-invalid @enderror" name="keluhan" id="keluhan"
                            @cannot('dokter') readonly @endcannot>{{ $rekam_medis->keluhan }}</textarea>
                        @error('keluhan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="diagnosis" class="form-label"><b>Diagnosis</b><span
                                class="text-danger">*</span></label>
                        <textarea class="form-control @error('diagnosis') is-invalid @enderror" name="diagnosis" id="diagnosis"
                            @cannot('dokter') readonly @endcannot>{{ $rekam_medis->diagnosis }}</textarea>
                        @error('diagnosis')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="tindakan" class="form-label"><b>Tindakan</b><span
                                class="text-danger">*</span></label>
                        <textarea class="form-control @error('tindakan') is-invalid @enderror" name="tindakan" id="tindakan"
                            @cannot('dokter') readonly @endcannot>{{ $rekam_medis->tindakan }}</textarea>
                        @error('tindakan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    @can('dokter')
                        {{-- Tombol Submit --}}
                        <div class="text-end mt-3">
                            <button type="submit" class="btn btn-success">Simpan</button>
                        </div>
                    @endcan

                </form>
            </div>
        </div>

        @if ($rekam_medis->keluhan && $rekam_medis->diagnosis && $rekam_medis->tindakan)
            <div class="card">
                <div class="card-header text-center">
                    <h3>Resep Obat</h3>
                    @if ($pasien->rekam_medis->disetujui_dokter == 1)
                        <span class="badge bg-success">
                            Resep Obat Telah Disetujui Dokter
                        </span>
                    @endif
                </div>

                <div class="card-body">
                    @if (!$rekam_medis->biaya_total)
                        @canany(['dokter', 'apotek'])
                            <div class="row align-items-end g-2">
                                <div class="col-md-4">
                                    <label for="nama_obat" class="form-label"><b>Obat</b><span
                                            class="text-danger">*</span></label>
                                    <select id="nama_obat" class="form-select">
                                        <option value="">-- Pilih Obat --</option>
                                        @if ($rekam_medis->disetujui_dokter == 0)
                                            @foreach ($obat_bebas_dan_tidak_bebas as $obat)
                                                <option value="{{ $obat->id }}" data-nama="{{ $obat->nama_obat }}"
                                                    data-kategori="{{ $obat->kategori }}"
                                                    data-satuan="{{ $obat->satuan }}"
                                                    data-expired="{{ $obat->expired_date }}"
                                                    data-harga="{{ $obat->harga }}">
                                                    {{ $obat->nama_obat }} - {{ $obat->kategori }} - {{ $obat->satuan }}
                                                    -
                                                    stok:
                                                    {{ $obat->stok }}
                                                </option>
                                            @endforeach
                                        @else
                                            @foreach ($daftar_obat_tidak_bebas as $obat)
                                                <option value="{{ $obat->id }}" data-nama="{{ $obat->nama_obat }}"
                                                    data-kategori="{{ $obat->kategori }}"
                                                    data-satuan="{{ $obat->satuan }}"
                                                    data-expired="{{ $obat->expired_date }}"
                                                    data-harga="{{ $obat->harga }}">
                                                    {{ $obat->nama_obat }} - {{ $obat->kategori }} - {{ $obat->satuan }}
                                                    -
                                                    stok:
                                                    {{ $obat->stok }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col-md-1">
                                    <label for="kuantitas" class="form-label"><b>Qty</b><span
                                            class="text-danger">*</span></label>
                                    <input type="number" id="kuantitas" class="form-control" min="1"
                                        value="1">
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
                        @endcanany
                    @endif

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
                                    @if (!$rekam_medis->biaya_total)
                                        <th>Aksi</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($resep_obat as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $item->nama_obat }}</td>
                                        <td>{{ $item->kategori ?? '-' }}</td>
                                        <td>{{ $item->satuan ?? '-' }}</td>
                                        <td>{{ $item->expired_date ? \Carbon\Carbon::parse($item->expired_date)->format('d-m-Y') : '-' }}
                                        </td>
                                        <td>Rp{{ number_format($item->harga_per_obat, 0, ',', '.') }}</td>
                                        <td>{{ $item->kuantitas }}</td>
                                        <td>Rp{{ number_format($item->harga_final, 0, ',', '.') }}</td>
                                        <td>{{ $item->catatan ?? '-' }}</td>
                                        @if (!$rekam_medis->biaya_total)
                                            <td>
                                                <form action="{{ route('resep_obat.destroy', $item->id) }}"
                                                    method="POST" class="d-inline form-delete-user">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button"
                                                        class="btn icon btn-danger btn-delete-user">
                                                        <i class="bi bi-trash"> (Sudah Tersimpan)</i>
                                                    </button>
                                                </form>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="7" class="text-end">Total Obat</th>
                                    <th id="total-semua">Rp0</th>
                                    <th colspan="2"></th>
                                </tr>
                            </tfoot>
                        </table>

                        <table class="table table-bordered mt-4">
                            <tr>
                                <th width="30%">Biaya Jasa</th>
                                <td id="biaya-jasa" class="text-end">
                                    Rp{{ number_format($rekam_medis->biaya_jasa, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <th>Total Obat</th>
                                <td id="biaya-obat" class="text-end">Rp0</td>
                            </tr>
                            <tr>
                                <th class="text-4xl">Grand Total</th>
                                <td id="grand-total" class="text-end fw-bold text-4xl">Rp0</td>
                            </tr>
                        </table>


                    </div>

                    <div class="mt-4 float-end">
                        <button id="btn-simpan-dokter"
                            class="btn btn-success
                            @if ($rekam_medis->biaya_total) disabled @endif">
                            ✅ Simpan
                        </button>

                        <button id="btn-simpan-apotek"
                            class="btn btn-primary
                            @if (!$rekam_medis->disetujui_dokter || $rekam_medis->biaya_total || Gate::denies('apotek')) disabled @endif"
                            @if (!$rekam_medis->disetujui_dokter || $rekam_medis->biaya_total) disabled @endif @cannot('apotek') disabled @endcannot>
                            💊 Diproses Apotek
                        </button>

                        @can('apotek')
                            @if ($rekam_medis->biaya_total)
                                <a href="{{ route('resep_obat.cetak', [$rekam_medis->pasien_id, $rekam_medis->id]) }}"
                                    target="_blank" class="btn btn-outline-secondary">
                                    🖨️ Cetak Resep
                                </a>
                            @endif
                        @endcan
                    </div>

                </div>
            </div>
        @endif
    </section>

    <script>
        const obatSudahTersimpan = @json($obatTersimpan);

        $(document).ready(function() {
            $('#nama_obat').select2({
                placeholder: "-- Pilih Obat --",
                width: '100%'
            });

            let no = document.querySelectorAll('#tabel-obat-terpilih tbody tr').length + 1;

            // Hitung ulang grand total dari tabel yang sudah ada
            function hitungGrandTotal() {
                let totalObat = 0;
                document.querySelectorAll('#tabel-obat-terpilih tbody tr').forEach(row => {
                    let hargaText = row.cells[7].textContent || 'Rp0';
                    let hargaNumber = parseInt(hargaText.replace(/[^0-9]/g, '')) || 0;
                    totalObat += hargaNumber;
                });

                // Tampilkan total obat
                document.getElementById('biaya-obat').textContent = 'Rp' + totalObat.toLocaleString('id-ID');

                // Ambil biaya jasa dari blade (sudah ditampilkan sebelumnya)
                let biayaJasaText = document.getElementById('biaya-jasa').textContent || 'Rp0';
                let biayaJasa = parseInt(biayaJasaText.replace(/[^0-9]/g, '')) || 0;

                let grandTotal = totalObat + biayaJasa;

                // Tampilkan grand total
                document.getElementById('grand-total').textContent = 'Rp' + grandTotal.toLocaleString('id-ID');

                // Update total semua lama (optional)
                document.getElementById('total-semua').textContent = 'Rp' + totalObat.toLocaleString('id-ID');

                return totalObat;
            }


            function formatDateToDMY(dateString) {
                if (!dateString) return '-';
                const parts = dateString.split('-');
                if (parts.length !== 3) return dateString;
                return `${parts[2]}-${parts[1]}-${parts[0]}`;
            }

            // Inisialisasi totalSemua dengan hitung ulang
            let totalSemua = hitungGrandTotal();

            // Tambah obat baru ke tabel
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

                const obatId = parseInt(selected.value);

                // ✅ Cek apakah obat sudah ada di tabel sementara
                const existingRow = document.querySelector(
                    `#tabel-obat-terpilih tbody tr[data-obat-id="${obatId}"]`
                );
                if (existingRow) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Obat sudah ditambahkan!',
                        text: 'Obat yang sama tidak boleh dimasukkan lebih dari satu kali.',
                        confirmButtonColor: '#3085d6'
                    });
                    return;
                }

                // ✅ Cek apakah obat sudah pernah disimpan sebelumnya
                if (obatSudahTersimpan.includes(obatId)) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Obat sudah disimpan sebelumnya!',
                        text: 'Obat yang sama tidak boleh dimasukkan lebih dari satu kali.',
                        confirmButtonColor: '#3085d6'
                    });
                    return;
                }

                // Tambah ke tabel
                const nama = selected.dataset.nama;
                const kategori = selected.dataset.kategori;
                const satuan = selected.dataset.satuan;
                const expiredRaw = selected.dataset.expired;
                const expiredFormatted = formatDateToDMY(expiredRaw);
                const harga = parseInt(selected.dataset.harga);
                const total = harga * qty;

                const tbody = document.querySelector('#tabel-obat-terpilih tbody');
                const tr = document.createElement('tr');

                tr.setAttribute('data-obat-id', obatId);
                tr.setAttribute('data-harga', harga);
                tr.setAttribute('data-kuantitas', qty);
                tr.setAttribute('data-catatan', catatan || '-');
                tr.setAttribute('data-expired', expiredRaw);

                let no = document.querySelectorAll('#tabel-obat-terpilih tbody tr').length + 1;

                tr.innerHTML = `
                    <td>${no}</td>
                    <td>${nama}</td>
                    <td>${kategori}</td>
                    <td>${satuan}</td>
                    <td>${expiredFormatted}</td>
                    <td>Rp${harga.toLocaleString('id-ID')}</td>
                    <td>${qty}</td>
                    <td>Rp${total.toLocaleString('id-ID')}</td>
                    <td>${catatan || '-'}</td>
                    <td><button class="btn btn-danger btn-sm btn-hapus"><i class="bi bi-trash"></i> (Belum Disimpan)</button></td>
                `;

                tbody.appendChild(tr);

                hitungGrandTotal();

                // Reset input
                document.getElementById('kuantitas').value = 1;
                document.getElementById('catatan').value = '';
                $('#nama_obat').val(null).trigger('change');
            });

            // Hapus baris obat
            document.querySelector('#tabel-obat-terpilih tbody').addEventListener('click', function(e) {
                if (e.target.classList.contains('btn-hapus')) {
                    const row = e.target.closest('tr');
                    row.remove();

                    // Update nomor urut setelah hapus
                    let rows = document.querySelectorAll('#tabel-obat-terpilih tbody tr');
                    no = 1;
                    rows.forEach(r => {
                        r.cells[0].textContent = no++;
                    });

                    // Hitung ulang total agar valid
                    totalSemua = hitungGrandTotal();
                }
            });

            // Simpan resep
            document.getElementById('btn-simpan-dokter').addEventListener('click', function() {
                const rows = document.querySelectorAll('#tabel-obat-terpilih tbody tr');
                if (rows.length === 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Belum ada obat yang ditambahkan!',
                        text: 'Silakan tambahkan obat terlebih dahulu.',
                        confirmButtonColor: '#3085d6'
                    });
                    return;
                }

                // Tambahkan konfirmasi SweetAlert di sini
                Swal.fire({
                    title: 'Apakah Anda sudah Yakin?',
                    text: "Apakah Anda sudah yakin ingin menyimpan resep ini?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, simpan!',
                    cancelButtonText: 'Batal',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33'
                }).then((result) => {
                    if (result.isConfirmed) {
                        let dataObat = [];
                        rows.forEach(row => {
                            const hargaPerObat = parseInt(row.getAttribute('data-harga')) ||
                                0;
                            const kuantitas = parseInt(row.getAttribute(
                                'data-kuantitas')) || 1;
                            const hargaFinal = hargaPerObat * kuantitas;

                            dataObat.push({
                                obat_id: row.getAttribute('data-obat-id'),
                                nama_obat: row.cells[1].textContent,
                                kategori: row.cells[2].textContent,
                                satuan: row.cells[3].textContent,
                                expired_date: row.getAttribute('data-expired'),
                                harga_per_obat: hargaPerObat,
                                kuantitas: kuantitas,
                                harga_final: hargaFinal,
                                catatan: row.getAttribute('data-catatan')
                            });
                        });

                        fetch("{{ route('resep_obat.store', $rekam_medis->id) }}", {
                                method: "POST",
                                headers: {
                                    "Content-Type": "application/json",
                                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                                    "Accept": "application/json"
                                },
                                body: JSON.stringify({
                                    resep: dataObat
                                })
                            })
                            .then(async response => {
                                const data = await response.json();

                                if (!response.ok) {
                                    throw new Error(data.message ||
                                        'Terjadi kesalahan jaringan.');
                                }

                                return data;
                            })
                            .then(data => {
                                if (data.success) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil!',
                                        text: 'Data resep telah disimpan.',
                                        confirmButtonColor: '#3085d6'
                                    }).then(() => {
                                        window.location.href =
                                            "{{ route('transaksi.resep_obat', ['pasien' => $pasien->id, 'rekam_medis' => $rekam_medis->id]) }}";
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Gagal!',
                                        text: data.message ||
                                            'Terjadi kesalahan saat menyimpan resep.',
                                        confirmButtonColor: '#3085d6'
                                    });
                                }
                            })
                            .catch(error => {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: error.message ||
                                        'Terjadi kesalahan jaringan.',
                                    confirmButtonColor: '#3085d6'
                                });
                            });
                    }
                });
            });

            // Simpan Apotek
            document.getElementById('btn-simpan-apotek').addEventListener('click', function() {
                Swal.fire({
                    title: 'Apakah pasien sudah ambil obat?',
                    text: "Data akan disimpan dan pasien dianggap selesai.",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, simpan!',
                    cancelButtonText: 'Batal',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch("{{ route('resep_obat.proses_apotek', $rekam_medis->id) }}", {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Accept': 'application/json'
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil!',
                                        text: 'Data pasien diperbarui.',
                                        confirmButtonColor: '#3085d6'
                                    }).then(() => location.reload());
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Gagal!',
                                        text: data.message || 'Terjadi kesalahan.',
                                        confirmButtonColor: '#3085d6'
                                    });
                                }
                            })
                            .catch(error => {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: error.message ||
                                        'Terjadi kesalahan jaringan.',
                                    confirmButtonColor: '#3085d6'
                                });
                            });
                    }
                });
            });
        });
    </script>

    {{-- DELETE --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.btn-delete-user');

            deleteButtons.forEach(function(btn) {
                btn.addEventListener('click', function(e) {
                    const form = this.closest('form');

                    Swal.fire({
                        title: 'Yakin ingin menghapus?',
                        text: "Data ini akan dihapus secara permanen.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
</x-layout>
