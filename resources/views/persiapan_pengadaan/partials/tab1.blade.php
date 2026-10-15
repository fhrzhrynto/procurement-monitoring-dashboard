<div class="d-flex justify-content-between align-items-center mb-3">
    <input type="text" class="form-control w-50" id="searchTab1" placeholder="Cari di Daftar Proyek...">
    <a href="{{ route('proyek.create') }}" class="btn btn-success ms-3">+ Tambah Proyek</a>
</div>

<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>No</th>
            <th>Nama Proyek</th>
            <th>Description</th>
            <th>Start</th>
            <th>Target</th>
            <th>Update Progress</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody id="tab1Table">
        @forelse ($proyek as $index => $item)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $item->nama_proyek }}</td>
            <td>{{ $item->deskripsi ?? '-' }}</td>
            <td>{{ $item->start_date ? \Carbon\Carbon::parse($item->start_date)->format('d/m/Y') : '-' }}</td>
            <td>{{ $item->target_date ? \Carbon\Carbon::parse($item->target_date)->format('d/m/Y') : '-' }}</td>
            <td>{{ $item->progress ?? '-' }}</td>
            <td>
                <a href="{{ route('proyek.edit', $item->id) }}" class="btn btn-sm btn-primary">Edit</a>
                <form action="{{ route('proyek.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus proyek ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="7" class="text-center">Belum ada data proyek.</td>
        </tr>
        @endforelse
    </tbody>
</table>
