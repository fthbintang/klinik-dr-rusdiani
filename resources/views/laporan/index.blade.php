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
                            <li class="breadcrumb-item">
                                <a href="{{ route('index') }}">Home</a>
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

    <section class="section">
        {{-- Laporan Data Obat --}}
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-sm-8">
                                <h5 class="card-title">Data {{ $titleLaporanObat }}</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('laporan.export-obat') }}" method="get" target="_blank">
                            <div class="row">
                                <div class="col-12">
                                    {{-- Based Tanggal Expired Akhir --}}
                                    <div class="form-group">
                                        <label for="expired_date" class="form-label"><b>Range Tanggal
                                                Expired</b></label>

                                        <div class="input-group">
                                            <input id="expired_date" name="expired_date" class="form-control"
                                                type="text" placeholder="Pilih Periode...">
                                            <button class="btn btn-danger" type="button" id="resetExpired">
                                                <i class="fa-solid fa-sync"></i> Reset
                                            </button>

                                            <input type="hidden" name="awal" id="awal">
                                            <input type="hidden" name="akhir" id="akhir">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">

                                <div class="col-6">
                                    {{-- Based on Kategori Obat --}}
                                    <div class="form-group">
                                        <label for="kategori" class="form-label"><b>Kategori</b>
                                        </label>
                                        <select name="kategori" id="kategori" class="choices form-select">
                                            <option value="" selected>Semua</option>
                                            <option value="Tablet">Tablet</option>
                                            <option value="Kapsul">Kapsul</option>
                                            <option value="Cair">Cair</option>
                                            <option value="Salep">Salep</option>
                                            <option value="Suntik">Suntik</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-6">
                                    {{-- Based Jumlah Stok --}}
                                    <div class="form-group">
                                        <label for="stok" class="form-label"><b>Jumlah Stok</b>
                                        </label>
                                        <select name="stok" id="stok" class="choices form-select">
                                            <option value="" selected>Semua</option>
                                            <option value="25">
                                                Kurang dari 25</option>
                                            <option value="50">
                                                Kurang dari 50</option>
                                            <option value="70">
                                                Kurang dari 70</option>
                                            <option value="100">
                                                Kurang dari 100</option>
                                        </select>
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-6">
                                    {{-- Based on Supplier --}}
                                    <div class="form-group">
                                        <label for="supplier_id" class="form-label"><b>Supplier</b></label>
                                        <select name="supplier_id" id="supplier_id" class="choices form-select">
                                            <option value="" selected>Semua</option>
                                            @foreach ($supplier as $row)
                                            <option value="{{ $row->id }}">
                                                {{ $row->nama_supplier }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-6">
                                    {{-- Based on Kategori Obat Bebas / Tidak --}}
                                    <div class="form-group">
                                        <label for="obat_bebas" class="form-label"><b>Obat Bebas</b></label>
                                        <select name="obat_bebas" id="obat_bebas" class="choices form-select">
                                            <option value="" selected>Semua</option>
                                            <option value="0">Tidak</option>
                                            <option value="1">Bebas</option>
                                        </select>
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-6">
                                    {{-- Export to --}}
                                    <div class="form-group">
                                        <label for="ekstensiObat" class="form-label"><b>Pilih Ekstensi</b></label>
                                        <span class="text-danger">*</span>
                                        <select name="ekstensiObat" id="ekstensiObat" class="choices form-select">
                                            <option value="" selected>-- Pilih Ekstensi --</option>
                                            <option value="pdf">Pdf</option>
                                            <option value="excel">Excel</option>
                                        </select>
                                        @error('ekstensiObat')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-6">
                                    <label for="" class="form-label">&nbsp;</label>
                                    <button type="submit" class="btn btn-primary form-control"><i
                                            class="fa-solid fa-print"></i> Generate</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- Laporan Data Obat Masuk --}}
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-sm-8">
                                <h5 class="card-title">Data {{ $titleLaporanObatMasuk }}</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('laporan.export-obat-masuk') }}" method="get" target="_blank">
                            <div class="row">
                                <div class="col-12">
                                    {{-- Based Tanggal Obat Masuk --}}
                                    <div class="form-group">
                                        <label for="tanggal_obat_masuk" class="form-label"><b>Range Tanggal Obat
                                                Masuk</b></label>

                                        <div class="input-group">
                                            <input id="tanggal_obat_masuk" name="tanggal_obat_masuk"
                                                class="form-control" type="text" placeholder="Pilih Periode...">
                                            <button class="btn btn-danger" type="button" id="resetTanggalObatMasuk">
                                                <i class="fa-solid fa-sync"></i> Reset
                                            </button>

                                            <input type="hidden" name="awalObatMasuk" id="awalObatMasuk">
                                            <input type="hidden" name="akhirObatMasuk" id="akhirObatMasuk">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">

                                <div class="col-6">
                                    {{-- Based on Obat --}}
                                    <div class="form-group">
                                        <label for="nama_obat" class="form-label"><b>Nama Obat</b>
                                        </label>
                                        <select name="nama_obat" id="nama_obat" class="choices form-select">
                                            <option value="" selected>Semua</option>
                                            @foreach ($obat as $row)
                                            <option value="{{ $row->id }}">{{ $row->nama_obat }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-6">
                                    {{-- Based on Supplier --}}
                                    <div class="form-group">
                                        <label for="supplier_id" class="form-label"><b>Supplier</b></label>
                                        <select name="supplier_id" id="supplier_id" class="choices form-select">
                                            <option value="" selected>Semua</option>
                                            @foreach ($supplier as $row)
                                            <option value="{{ $row->id }}">
                                                {{ $row->nama_supplier }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-6">
                                    {{-- Export to --}}
                                    <div class="form-group">
                                        <label for="ekstensiObatMasuk" class="form-label"><b>Pilih Ekstensi</b></label>
                                        <span class="text-danger">*</span>
                                        <select name="ekstensiObatMasuk" id="ekstensiObatMasuk"
                                            class="choices form-select">
                                            <option value="" selected>-- Pilih Ekstensi --</option>
                                            <option value="pdf">Pdf</option>
                                            <option value="excel">Excel</option>
                                        </select>
                                        @error('ekstensiObatMasuk')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-6">
                                    <label for="" class="form-label">&nbsp;</label>
                                    <button type="submit" class="btn btn-primary form-control"><i
                                            class="fa-solid fa-print"></i> Generate</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- Laporan Data Obat Keluar --}}
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-sm-8">
                                <h5 class="card-title">Data {{ $titleLaporanObatKeluar }}</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('laporan.export-obat-keluar') }}" method="get" target="_blank">
                            <div class="row">
                                <div class="col-12">
                                    {{-- Based Tanggal Obat Keluar --}}
                                    <div class="form-group">
                                        <label for="tanggal_obat_keluar" class="form-label"><b>Range Tanggal Obat
                                                Keluar</b></label>

                                        <div class="input-group">
                                            <input id="tanggal_obat_keluar" name="tanggal_obat_keluar"
                                                class="form-control" type="text" placeholder="Pilih Periode...">
                                            <button class="btn btn-danger" type="button" id="resetTanggalObatKeluar">
                                                <i class="fa-solid fa-sync"></i> Reset
                                            </button>

                                            <input type="hidden" name="awalObatKeluar" id="awalObatKeluar">
                                            <input type="hidden" name="akhirObatKeluar" id="akhirObatKeluar">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">

                                <div class="col-6">
                                    {{-- Based on Obat --}}
                                    <div class="form-group">
                                        <label for="nama_obat" class="form-label"><b>Nama Obat</b>
                                        </label>
                                        <select name="nama_obat" id="nama_obat" class="choices form-select">
                                            <option value="" selected>Semua</option>
                                            @foreach ($obat as $row)
                                            <option value="{{ $row->id }}">{{ $row->nama_obat }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-6">
                                    {{-- Based on Supplier --}}
                                    <div class="form-group">
                                        <label for="supplier_id" class="form-label"><b>Supplier</b></label>
                                        <select name="supplier_id" id="supplier_id" class="choices form-select">
                                            <option value="" selected>Semua</option>
                                            @foreach ($supplier as $row)
                                            <option value="{{ $row->id }}">
                                                {{ $row->nama_supplier }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    {{-- Based on Pasien --}}
                                    <div class="form-group">
                                        <label for="pasien_id" class="form-label"><b>Pasien</b></label>
                                        <select name="pasien_id" id="pasien_id" class="choices form-select">
                                            <option value="" selected>Semua</option>
                                            @foreach ($pasien as $row)
                                            <option value="{{ $row->id }}">
                                                {{ $row->nama_lengkap }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    {{-- Export to --}}
                                    <div class="form-group">
                                        <label for="ekstensiObatKeluar" class="form-label"><b>Pilih Ekstensi</b></label>
                                        <span class="text-danger">*</span>
                                        <select name="ekstensiObatKeluar" id="ekstensiObatKeluar"
                                            class="choices form-select">
                                            <option value="" selected>-- Pilih Ekstensi --</option>
                                            <option value="pdf">Pdf</option>
                                            <option value="excel">Excel</option>
                                        </select>
                                        @error('ekstensiObatKeluar')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-6">
                                    <label for="" class="form-label">&nbsp;</label>
                                    <button type="submit" class="btn btn-primary form-control"><i
                                            class="fa-solid fa-print"></i> Generate</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- Laporan Data Transaksi Obat (Semua - No Detail) --}}
        <div class="row">
            <div class="col-6">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-sm-8">
                                        <h5 class="card-title">Data {{ $titleLaporanListTransaksiObat }}</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('laporan.export-transaksi-obat') }}" method="get"
                                    target="_blank">
                                    <div class="row">
                                        <div class="col-12">
                                            {{-- Based Tanggal Transaksi --}}
                                            <div class="form-group">
                                                <label for="tanggal_transaksi_obat" class="form-label"><b>Range Tanggal
                                                        Transaksi</b></label>

                                                <div class="input-group">
                                                    <input id="tanggal_transaksi_obat" name="tanggal_transaksi_obat"
                                                        class="form-control" type="text" placeholder="Pilih Periode...">
                                                    <button class="btn btn-danger" type="button"
                                                        id="resetTanggalTransaksiObat">
                                                        <i class="fa-solid fa-sync"></i> Reset
                                                    </button>

                                                    <input type="hidden" name="awalTransaksiObat"
                                                        id="awalTransaksiObat">
                                                    <input type="hidden" name="akhirTransaksiObat"
                                                        id="akhirTransaksiObat">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-6">
                                            {{-- Export to --}}
                                            <div class="form-group">
                                                <label for="ekstensiPenjualanObat" class="form-label"><b>Pilih
                                                        Ekstensi</b></label>
                                                <span class="text-danger">*</span>
                                                <select name="ekstensiPenjualanObat" id="ekstensiPenjualanObat"
                                                    class="choices form-select">
                                                    <option value="" selected>-- Pilih Ekstensi --</option>
                                                    <option value="pdf">Pdf</option>
                                                    <option value="excel">Excel</option>
                                                </select>
                                                @error('ekstensiPenjualanObat')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <label for="" class="form-label">&nbsp;</label>
                                            <button type="submit" class="btn btn-primary form-control"><i
                                                    class="fa-solid fa-print"></i> Generate</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6">
                {{-- Laporan Data Detail Transaksi Obat --}}
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-sm-8">
                                        <h5 class="card-title">Data {{ $titleLaporanDetailTransaksiObat }}</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('laporan.export-detail-transaksi-obat') }}" method="get"
                                    target="_blank">
                                    <div class="row">
                                        <div class="col-12">
                                            {{-- Based Transaksi Kode Transaksi --}}
                                            <div class="form-group">
                                                <label for="penjualan_obat_id" class="form-label"><b>Pilih
                                                        Transaksi</b></label>
                                                <span class="text-danger">*</span>
                                                <select name="penjualan_obat_id" id="penjualan_obat_id"
                                                    class="choices form-select">
                                                    <option value="" selected>-- Pilih Kode Transaksi --</option>
                                                    @foreach ($penjualan_obat as $row)
                                                    <option value="{{ $row->id }}">{{ $row->kode_transaksi }}</option>
                                                    @endforeach
                                                </select>
                                                @error('penjualan_obat_id')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-6">
                                            {{-- Export to --}}
                                            <div class="form-group">
                                                <label for="ekstensiDetailTransaksiObat" class="form-label"><b>Pilih
                                                        Ekstensi</b></label>
                                                <span class="text-danger">*</span>
                                                <select name="ekstensiDetailTransaksiObat"
                                                    id="ekstensiDetailTransaksiObat" class="choices form-select">
                                                    <option value="" selected>-- Pilih Ekstensi --</option>
                                                    <option value="pdf">Pdf</option>
                                                    <option value="excel">Excel</option>
                                                </select>
                                                @error('ekstensiDetailTransaksiObat')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <label for="" class="form-label">&nbsp;</label>
                                            <button type="submit" class="btn btn-primary form-control"><i
                                                    class="fa-solid fa-print"></i> Generate</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



    </section>

    @push('scripts')
    <script>
        const expiredDatePicker = flatpickr("#expired_date", {
            mode: 'range',
            minDate: 'today',

            onChange: function(selectedDates, dateStr, instance) {
                if (selectedDates.length === 2) {
                    const awal = selectedDates[0];
                    const akhir = selectedDates[1];

                    document.getElementById('awal').value = flatpickr.formatDate(awal, "Y-m-d");
                    document.getElementById('akhir').value = flatpickr.formatDate(akhir, "Y-m-d");
                }
            }
        });

        const tanggalObatMasuk = flatpickr("#tanggal_obat_masuk", {
            mode: 'range',

            onChange: function(selectedDates, dateStr, instance) {
                if (selectedDates.length === 2) {
                    const awalObatMasuk = selectedDates[0];
                    const akhirObatMasuk = selectedDates[1];

                    document.getElementById('awalObatMasuk').value = flatpickr.formatDate(awalObatMasuk, "Y-m-d");
                    document.getElementById('akhirObatMasuk').value = flatpickr.formatDate(akhirObatMasuk, "Y-m-d");
                }
            }
        });

        const tanggalObatKeluar = flatpickr("#tanggal_obat_keluar", {
            mode: 'range',

            onChange: function(selectedDates, dateStr, instance) {
                if (selectedDates.length === 2) {
                    const awalObatKeluar = selectedDates[0];
                    const akhirObatKeluar = selectedDates[1];

                    document.getElementById('awalObatKeluar').value = flatpickr.formatDate(awalObatKeluar, "Y-m-d");
                    document.getElementById('akhirObatKeluar').value = flatpickr.formatDate(akhirObatKeluar, "Y-m-d");
                }
            }
        });

        const tanggalTransaksiObat = flatpickr("#tanggal_transaksi_obat", {
            mode: 'range',

            onChange: function(selectedDates, dateStr, instance) {
                if (selectedDates.length === 2) {
                    const awalTransaksiObat = selectedDates[0];
                    const akhirTransaksiObat = selectedDates[1];

                    document.getElementById('awalTransaksiObat').value = flatpickr.formatDate(awalTransaksiObat, "Y-m-d");
                    document.getElementById('akhirTransaksiObat').value = flatpickr.formatDate(akhirTransaksiObat, "Y-m-d");
                }
            }
        });

        // Reset Button
        document.getElementById('resetExpired').addEventListener('click', function () {
            expiredDatePicker.clear();
            document.getElementById('awal').value = '';
            document.getElementById('akhir').value = '';
        });

        document.getElementById('resetTanggalObatMasuk').addEventListener('click', function () {
            tanggalObatMasuk.clear();
            document.getElementById('awalObatMasuk').value = '';
            document.getElementById('akhirObatMasuk').value = '';
        });

        document.getElementById('resetTanggalObatKeluar').addEventListener('click', function () {
            tanggalObatKeluar.clear();
            document.getElementById('awalObatKeluar').value = '';
            document.getElementById('akhirObatKeluar').value = '';
        });

        document.getElementById('resetTanggalTransaksiObat').addEventListener('click', function () {
            tanggalTransaksiObat.clear();
            document.getElementById('awalTransaksiObat').value = '';
            document.getElementById('akhirTransaksiObat').value = '';
        });
    </script>
    @endpush
</x-layout>