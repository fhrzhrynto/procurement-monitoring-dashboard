<form method="GET" action="{{ route('laporan.bulanan') }}" class="row g-3 mb-3">
    <div class="col-md-3">
        <label for="filter_type_user" class="form-label">Filter Berdasarkan</label>
        <select name="filter_type_user" id="filter_type_user" class="form-select">
            <option value="updated" {{ ($filterTypeUser ?? 'updated') === 'updated' ? 'selected' : '' }}>Updated At</option>
            <option value="created" {{ ($filterTypeUser ?? 'updated') === 'created' ? 'selected' : '' }}>Created At</option>
        </select>
    </div>
    <div class="col-md-3">
        <label for="bulan_user" class="form-label">Bulan</label>
        <select name="bulan_user" id="bulan_user" class="form-select">
            <option value="">Semua</option>
            @for ($m = 1; $m <= 12; $m++)
                <option value="{{ $m }}" {{ ($bulanUser == $m) ? 'selected' : '' }}>
                    {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                </option>
            @endfor
        </select>
    </div>
    <div class="col-md-3">
        <label for="tahun_user" class="form-label">Tahun</label>
        <select name="tahun_user" id="tahun_user" class="form-select">
            <option value="">Semua</option>
            @foreach ($availableYearsUser as $year)
                <option value="{{ $year }}" {{ ($tahunUser == $year) ? 'selected' : '' }}>
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
                <th>Nama</th>
                <th>Email</th>
                <th>Created At</th>
                <th>Updated At</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($users as $user)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->created_at ? $user->created_at->format('d-m-Y') : '-' }}</td>
                    <td>{{ $user->updated_at ? $user->updated_at->format('d-m-Y') : '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Tidak ada data user.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
