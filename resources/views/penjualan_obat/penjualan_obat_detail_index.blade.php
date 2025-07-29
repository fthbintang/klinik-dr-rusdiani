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

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('penjualan_obat_detail.store') }}" method="POST" id="form-penjualan-obat">
        @csrf
        <input type="hidden" name="penjualan_obat_id" value="{{ $penjualan_obat->id }}">

        <div class="card">
            <div class="card-header">
                <h5>Tambah Transaksi</h5>
            </div>
            @if (!$penjualan_obat->total_harga)
                <div class="card-body">
                    <table class="table table-bordered" id="tabel-obat">
                        <thead>
                            <tr>
                                <th>Obat</th>
                                <th>Kuantitas</th>
                                <th>Harga</th>
                                <th>Subtotal</th>
                                <th><button type="button" class="btn btn-sm btn-success" id="tambah-baris">+</button>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (old('obat_id'))
                                {{-- Menampilkan data jika validasi gagal --}}
                                @foreach (old('obat_id') as $index => $obatId)
                                    @php
                                        $harga = \App\Models\Obat::find($obatId)?->harga ?? 0;
                                        $qty = old('kuantitas')[$index] ?? 1;
                                        $subtotal = $harga * $qty;
                                    @endphp
                                    <tr>
                                        <td>
                                            <select name="obat_id[]" class="form-select select-obat" required>
                                                <option value="">-- Pilih Obat --</option>
                                                @foreach ($obat as $item)
                                                    <option value="{{ $item->id }}" data-harga="{{ $item->harga }}"
                                                        {{ $obatId == $item->id ? 'selected' : '' }}>
                                                        {{ $item->nama_obat }} - Stok: {{ $item->stok }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td><input type="number" name="kuantitas[]" class="form-control kuantitas"
                                                value="{{ $qty }}" required></td>
                                        <td><input type="text" class="form-control harga"
                                                value="Rp{{ number_format($harga, 0, ',', '.') }}" readonly></td>
                                        <td>
                                            <input type="hidden" name="harga_final[]" class="harga-final-hidden"
                                                value="{{ $subtotal }}">
                                            <input type="text" class="form-control subtotal"
                                                value="Rp{{ number_format($subtotal, 0, ',', '.') }}" readonly>
                                        </td>
                                        <td><button type="button" class="btn btn-sm btn-danger hapus-baris">x</button>
                                        </td>
                                    </tr>
                                @endforeach
                            @elseif(isset($detail) && $detail->count())
                                {{-- Menampilkan data dari database --}}
                                @foreach ($penjualan_obat->detail as $row)
                                    <tr>
                                        <td>
                                            <select name="obat_id[]" class="form-select select-obat" required>
                                                <option value="">-- Pilih Obat --</option>
                                                @foreach ($obat as $item)
                                                    <option value="{{ $item->id }}"
                                                        data-harga="{{ $item->harga }}"
                                                        {{ $row->obat_id == $item->id ? 'selected' : '' }}>
                                                        {{ $item->nama_obat }} - Stok: {{ $item->stok }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td><input type="number" name="kuantitas[]" class="form-control kuantitas"
                                                value="{{ $row->kuantitas }}" required></td>
                                        <td><input type="text" class="form-control harga"
                                                value="Rp{{ number_format($row->obat->harga, 0, ',', '.') }}" readonly>
                                        </td>
                                        <td>
                                            <input type="hidden" name="harga_final[]" class="harga-final-hidden"
                                                value="{{ $row->harga_final }}">
                                            <input type="text" class="form-control subtotal"
                                                value="Rp{{ number_format($row->harga_final, 0, ',', '.') }}" readonly>
                                        </td>
                                        <td><button type="button" class="btn btn-sm btn-danger hapus-baris">x</button>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                {{-- Default satu baris kosong --}}
                                <tr>
                                    <td>
                                        <select name="obat_id[]" class="form-select select-obat" required>
                                            <option value="">-- Pilih Obat --</option>
                                            @foreach ($obat as $item)
                                                <option value="{{ $item->id }}" data-harga="{{ $item->harga }}">
                                                    {{ $item->nama_obat }} - {{ $item->satuan }} - Stok:
                                                    {{ $item->stok }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td><input type="number" name="kuantitas[]" class="form-control kuantitas"
                                            value="1" required></td>
                                    <td><input type="text" class="form-control harga" readonly></td>
                                    <td>
                                        <input type="hidden" name="harga_final[]" class="harga-final-hidden">
                                        <input type="text" class="form-control subtotal" readonly>
                                    </td>
                                    <td><button type="button" class="btn btn-sm btn-danger hapus-baris">x</button></td>
                                </tr>
                            @endif
                        </tbody>

                    </table>

                    <div class="text-end mt-3">
                        <h3><b>Grand Total: <span id="grand-total">Rp0</span></b></h3>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary mt-2">Simpan</button>
                    </div>
                </div>
            @endif

            @if ($penjualan_obat->total_harga)
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Obat</th>
                                    <th>Kuantitas</th>
                                    <th>Harga</th>
                                    <th>Total</th> <!-- Kolom baru -->
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($penjualan_obat_detail as $row)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $row->obat->nama_obat }}</td>
                                        <td>{{ $row->kuantitas }}</td>
                                        <td>{{ 'Rp' . number_format($row->harga_final, 0, ',', '.') }}</td>
                                        <td><b>{{ 'Rp' . number_format($row->harga_final * $row->kuantitas, 0, ',', '.') }}</b>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <hr>
                    <div class="text-end mt-3">
                        <p style="font-size: 30px">
                            <b>Grand Total:
                                {{ 'Rp' . number_format($penjualan_obat->total_harga, 0, ',', '.') }}
                            </b>
                        </p>

                        @if ($penjualan_obat->total_harga)
                            <a href="{{ route('penjualan-obat.cetak', $penjualan_obat->id) }}" target="_blank"
                                class="btn btn-outline-secondary">
                                🖨️ Cetak
                            </a>
                        @endif
                    </div>
                </div>
            @endif

        </div>
    </form>

    <script>
        $(document).ready(function() {
            function formatRupiah(angka) {
                return 'Rp' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            }

            function initSelect2(context) {
                context.find('.select-obat').select2({
                    placeholder: "-- Pilih Obat --",
                    width: '100%',
                    allowClear: true
                });
            }

            function hitungSubtotal(tr) {
                let harga = parseInt(tr.find('select option:selected').data('harga') || 0);
                let qty = parseInt(tr.find('.kuantitas').val() || 0);
                let subtotal = harga * qty;

                tr.find('.harga').val(formatRupiah(harga));
                tr.find('.subtotal').val(formatRupiah(subtotal));
                tr.find('.harga-final-hidden').val(subtotal);

                hitungGrandTotal();
            }

            function hitungGrandTotal() {
                let grandTotal = 0;
                $('.harga-final-hidden').each(function() {
                    grandTotal += parseInt($(this).val() || 0);
                });
                $('#grand-total').text(formatRupiah(grandTotal));
            }

            // Inisialisasi awal select2 dan perhitungan
            $('#tabel-obat tbody tr').each(function() {
                initSelect2($(this));
                hitungSubtotal($(this));
            });

            $('#tabel-obat').on('change', 'select, .kuantitas', function() {
                let tr = $(this).closest('tr');

                if ($(this).hasClass('select-obat')) {
                    let selectedValue = $(this).val();
                    let duplicate = false;

                    $('.select-obat').each(function() {
                        if ($(this).val() === selectedValue && $(this)[0] !== tr.find('select')[
                                0]) {
                            duplicate = true;
                            return false;
                        }
                    });

                    if (duplicate) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Obat Duplikat!',
                            text: 'Obat yang sama tidak boleh dipilih lebih dari 1 kali.',
                            confirmButtonColor: '#3085d6'
                        });

                        tr.find('select').val('').trigger('change');
                        tr.find('.harga').val('');
                        tr.find('.subtotal').val('');
                        tr.find('.harga-final-hidden').val('');
                        hitungGrandTotal();
                        return;
                    }
                }

                hitungSubtotal(tr);
            });

            $('#tambah-baris').click(function() {
                let row = $('#tabel-obat tbody tr:first');
                row.find('.select-obat').select2('destroy');

                let clonedRow = row.clone();
                clonedRow.find('input').val('');
                clonedRow.find('.kuantitas').val(1);
                clonedRow.find('select').val('');
                clonedRow.find('.harga').val('');
                clonedRow.find('.subtotal').val('');
                clonedRow.find('.harga-final-hidden').val('');

                $('#tabel-obat tbody').append(clonedRow);
                initSelect2(row);
                initSelect2(clonedRow);
            });

            $('#tabel-obat').on('click', '.hapus-baris', function() {
                if ($('#tabel-obat tbody tr').length > 1) {
                    $(this).closest('tr').remove();
                    hitungGrandTotal();
                }
            });
        });

        $('#form-penjualan-obat').on('submit', function(e) {
            e.preventDefault(); // cegah submit langsung

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data yang disimpan tidak bisa diubah kembali!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, simpan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit(); // submit form jika dikonfirmasi
                }
            });
        });
    </script>
</x-layout>
