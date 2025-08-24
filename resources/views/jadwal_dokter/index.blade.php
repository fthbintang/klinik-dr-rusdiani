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
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h5 class="card-title">Jadwal Dokter:</h5>
                    </div>
                    <div class="col-md-6 text-end">
                        <form id="select-doctor-form" method="GET" action="{{ route('jadwal_dokter.index') }}">
                            <select name="dokter_id" class="form-select" onchange="this.form.submit()">
                                <option value="">-- Pilih Dokter --</option>
                                @foreach ($dokterList as $dok)
                                    <option value="{{ $dok->id }}"
                                        {{ request('dokter_id') == $dok->id ? 'selected' : '' }}>
                                        {{ $dok->nama_dokter }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                    </div>
                </div>
            </div>

            @if ($selectedDokter)
                <div class="card-body">
                    <form action="{{ route('jadwal_dokter.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="dokter_id" value="{{ $selectedDokter->id }}">

                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Hari</th>
                                        <th>Jam Mulai</th>
                                        <th>Jam Selesai</th>
                                        <th>Aktif</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
                                    @endphp

                                    @foreach ($days as $index => $day)
                                        @php
                                            $data = $jadwal_dokter[$day] ?? null;
                                        @endphp
                                        <tr>
                                            <td>
                                                {{ $day }}
                                                <input type="hidden" name="jadwal[{{ $index }}][hari]"
                                                    value="{{ $day }}">
                                            </td>
                                            <td>
                                                <input type="time" name="jadwal[{{ $index }}][jam_mulai]"
                                                    class="form-control @error('jadwal.' . $index . '.jam_mulai') is-invalid @enderror"
                                                    value="{{ old('jadwal.' . $index . '.jam_mulai', $data?->jam_mulai) }}"
                                                    {{ old('jadwal.' . $index . '.aktif', $data ? '1' : null) ? '' : 'disabled' }}>
                                                @error('jadwal.' . $index . '.jam_mulai')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </td>
                                            <td>
                                                <input type="time" name="jadwal[{{ $index }}][jam_selesai]"
                                                    class="form-control @error('jadwal.' . $index . '.jam_selesai') is-invalid @enderror"
                                                    value="{{ old('jadwal.' . $index . '.jam_selesai', $data?->jam_selesai) }}"
                                                    {{ old('jadwal.' . $index . '.aktif', $data ? '1' : null) ? '' : 'disabled' }}>
                                                @error('jadwal.' . $index . '.jam_selesai')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </td>
                                            <td>
                                                <input type="checkbox" name="jadwal[{{ $index }}][aktif]"
                                                    value="1" onchange="toggleInputs(this)"
                                                    {{ old('jadwal.' . $index . '.aktif', $data ? '1' : null) ? 'checked' : '' }}>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="text-end mt-3">
                            <button type="submit" class="btn btn-primary">Simpan Jadwal</button>
                        </div>
                    </form>
                </div>
            @endif
        </div>
    </section>

    <script>
        function toggleInputs(checkbox) {
            const row = checkbox.closest('tr');
            const inputs = row.querySelectorAll('input[type="time"]');
            inputs.forEach(input => input.disabled = !checkbox.checked);
        }

        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll("input[type=checkbox]").forEach(checkbox => {
                toggleInputs(checkbox);
            });
        });
    </script>
</x-layout>
