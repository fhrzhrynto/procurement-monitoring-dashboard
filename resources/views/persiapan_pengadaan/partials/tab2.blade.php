<div class="mb-3">
    <input type="text" class="form-control" id="searchTab2" placeholder="Cari di Plan Pengajuan...">
</div>

{{-- Tombol Tambah Plan --}}
<div class="mb-3">
    <a href="{{ route('persiapan_pengadaan.plan.create') }}" class="btn btn-success">Tambah Plan Pengajuan</a>
</div>

<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>No</th>
            <th>ID Plan Pengajuan</th>
            <th>Nama Proyek</th>
            <th>Start</th>
            <th>Target</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody id="tab2Table">
        @forelse ($plan as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->id_plan }}</td>
                <td>{{ $item->proyek->nama_proyek ?? 'Tidak Ada Proyek' }}</td>
                <td>{{ $item->proyek->start_date ?? '-' }}</td>
                <td>{{ $item->proyek->target_date ?? '-' }}</td>
                <td>
                    {{-- Edit Button --}}
                    <a href="{{ route('persiapan_pengadaan.plan.edit', $item->id) }}" class="btn btn-sm btn-primary">Edit</a>

                    {{-- Delete Button --}}
                    <form action="{{ route('persiapan_pengadaan.plan.destroy', $item->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Yakin ingin menghapus?')" class="btn btn-sm btn-danger">
                            Hapus
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center">Tidak ada data Plan Pengajuan.</td>
            </tr>
        @endforelse
    </tbody>
</table>
