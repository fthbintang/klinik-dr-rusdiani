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
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-sm-8">
                        <h5 class="card-title">Data {{ $title }}</h5>
                    </div>
                    <div class="col-sm-4 d-flex justify-content-end">
                        <form action="{{ route('obat_masuk.index') }}" method="GET" class="d-flex">
                            <input type="date" name="tanggal_obat_masuk" id="tanggal_obat_masuk"
                                class="form-control me-2" value="{{ request('tanggal_obat_masuk') }}">
                            <button type="submit" class="btn btn-primary me-2">Cari</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="table1">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Obat</th>
                                <th>Stok Awal</th>
                                <th>Stok Masuk</th>
                                <th>Stok Final</th>
                                <th>Supplier</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($obat_masuk as $row)
                                <tr>
                                    <td>
                                        {{ \Carbon\Carbon::parse($row->tanggal_obat_masuk)->format('d-m-Y') }}</td>
                                    <td>{{ $row->obat->nama_obat }}</td>
                                    <td>{{ $row->stok_awal }}</td>
                                    <td>+{{ $row->stok_masuk }}</td>
                                    <td>{{ $row->stok_final }}</td>
                                    <td>{{ $row->obat->supplier->nama_supplier }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

</x-layout>
