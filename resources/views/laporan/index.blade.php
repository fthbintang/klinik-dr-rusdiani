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
                                        <label for="expired_date" class="form-label">Range Tanggal Expired</label>

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
                                        @error('supplier_id')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
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
                                        <label for="ekstensi" class="form-label"><b>Pilih Ekstensi</b></label>
                                        <span class="text-danger">*</span>
                                        <select name="ekstensi" id="ekstensi" class="choices form-select">
                                            <option value="" selected>-- Pilih Ekstensi --</option>
                                            <option value="pdf">Pdf</option>
                                            <option value="excel">Excel</option>
                                        </select>
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

        document.getElementById('resetExpired').addEventListener('click', function () {
            expiredDatePicker.clear();
            document.getElementById('awal').value = '';
            document.getElementById('akhir').value = '';
        });
    </script>
    @endpush
</x-layout>