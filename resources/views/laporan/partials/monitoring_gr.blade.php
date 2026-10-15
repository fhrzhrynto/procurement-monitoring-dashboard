<form method="GET" action="{{ route('laporan.bulanan') }}" class="row g-3 mb-4">
    <div class="col-md-3">
        <label for="filter_type_gr" class="form-label">Filter Berdasarkan</label>
        <select name="filter_type_gr" id="filter_type_gr" class="form-select">
            <option value="updated" {{ ($filterTypeGR ?? 'updated') === 'updated' ? 'selected' : '' }}>Updated At</option>
            <option value="created" {{ ($filterTypeGR ?? 'updated') === 'created' ? 'selected' : '' }}>Created At</option>
        </select>
    </div>
    <div class="col-md-3">
        <label for="bulan_gr" class="form-label">Bulan</label>
        <select name="bulan_gr" id="bulan_gr" class="form-select">
            <option value="">Semua</option>
            @for ($m = 1; $m <= 12; $m++)
                <option value="{{ $m }}" {{ ($bulanGR == $m) ? 'selected' : '' }}>
                    {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                </option>
            @endfor
        </select>
    </div>
    <div class="col-md-3">
        <label for="tahun_gr" class="form-label">Tahun</label>
        <select name="tahun_gr" id="tahun_gr" class="form-select">
            <option value="">Semua</option>
            @foreach ($availableYearsGR as $year)
                <option value="{{ $year }}" {{ ($tahunGR == $year) ? 'selected' : '' }}>
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
    <table class="table table-bordered text-center">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>No. PO</th>
                <th>No. GR</th>
                <th>Judul</th>
                <th>Nilai GR</th>
                <th>Created At</th>
                <th>Updated At</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($grList as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->no_po }}</td>
                    <td>{{ $item->no_gr }}</td>
                    <td class="text-start">{{ $item->judul }}</td>
                    <td class="text-end">Rp {{ number_format($item->nilai_gr, 0, ',', '.') }}</td>
                    <td>{{ $item->created_at ? $item->created_at->format('d-m-Y') : '-' }}</td>
                    <td>{{ $item->updated_at ? $item->updated_at->format('d-m-Y') : '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Tidak ada data GR.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
