<form method="GET" action="{{ route('laporan.bulanan') }}" class="row g-3 mb-3">
    <div class="col-md-3">
        <label for="filter_type" class="form-label">Filter Berdasarkan</label>
        <select name="filter_type" id="filter_type" class="form-select">
            <option value="updated" {{ ($filterType ?? 'updated') === 'updated' ? 'selected' : '' }}>Updated At</option>
            <option value="created" {{ ($filterType ?? 'updated') === 'created' ? 'selected' : '' }}>Created At</option>
        </select>
    </div>
    <div class="col-md-3">
        <label for="bulan" class="form-label">Bulan</label>
        <select name="bulan" id="bulan" class="form-select">
            <option value="">Semua</option>
            @for ($m = 1; $m <= 12; $m++)
                <option value="{{ $m }}" {{ ($bulan == $m) ? 'selected' : '' }}>
                    {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                </option>
            @endfor
        </select>
    </div>
    <div class="col-md-3">
        <label for="tahun" class="form-label">Tahun</label>
        <select name="tahun" id="tahun" class="form-select">
            <option value="">Semua</option>
            @foreach ($availableYears as $year)
                <option value="{{ $year }}" {{ ($tahun == $year) ? 'selected' : '' }}>
                    {{ $year }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3 align-self-end">
        <button type="submit" class="btn btn-primary">Tampilkan</button>
    </div>
</form>

<div class="table-responsive">
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>No Kontrak</th>
                <th>No PO</th>
                <th>Nama</th>
                <th>Total Kontrak</th>
                <th>Updated At</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pengadaan as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->no_kontrak }}</td>
                    <td>{{ $item->no_po }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>Rp {{ number_format($item->total_kontrak, 2, ',', '.') }}</td>
                    <td>{{ $item->updated_at ? $item->updated_at->format('d-m-Y') : '-' }}</td>
                    <td>{{ $item->created_at ? $item->created_at->format('d-m-Y') : '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Tidak ada data pengadaan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
