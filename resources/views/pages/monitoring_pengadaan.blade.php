@extends('layouts.app')

@section('content')
<div class="container">
    @if(!isset($hideHeader) || !$hideHeader)
        <h2>Monitoring Pengadaan (Kontrak)</h2>
        <a href="{{ route('pengadaan.create') }}" class="btn btn-primary mb-3">+ Tambah Kontrak</a>
        
        <form action="{{ route('monitoring_pengadaan') }}" method="GET" class="d-flex gap-2 mb-3">
            <select name="status" class="form-select">
                <option value="">-- Semua Status --</option>
                <option value="Diajukan Staf" {{ request('status') == 'Diajukan Staf' ? 'selected' : '' }}>Diajukan Staf</option>
                <option value="Disetujui VP" {{ request('status') == 'Disetujui VP' ? 'selected' : '' }}>Disetujui VP</option>
                <option value="Di Keuangan" {{ request('status') == 'Di Keuangan' ? 'selected' : '' }}>Di Keuangan</option>
                <option value="Di Pengadaan" {{ request('status') == 'Di Pengadaan' ? 'selected' : '' }}>Di Pengadaan</option>
                <option value="Di Legal" {{ request('status') == 'Di Legal' ? 'selected' : '' }}>Di Legal</option>
                <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                <option value="Batal" {{ request('status') == 'Batal' ? 'selected' : '' }}>Batal</option>
            </select>
            <input type="text" name="search" class="form-control" placeholder="Cari berdasarkan nama kontrak..." value="{{ request('search') }}">
            <input type="date" name="start_date" class="form-control" placeholder="Tanggal Mulai" value="{{ request('start_date') }}">
            <input type="date" name="end_date" class="form-control" placeholder="Tanggal Selesai" value="{{ request('end_date') }}">
            <button type="submit" class="btn btn-outline-primary">Filter</button>
            <a href="{{ route('monitoring_pengadaan') }}" class="btn btn-outline-secondary">Reset</a>
        </form>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered" style="min-width: 1200px;">
            <thead class="table-primary text-center">
                <tr>
                    <th>No. Kontrak</th>
                    <th>No. PO</th>
                    <th>Nama</th>
                    <th>Status</th>
                    <th>Total Kontrak</th>
                    <th>Start (tanggal mulai)</th>
                    <th>End (tanggal berakhir)</th>
                    <th>Penagihan</th>
                    @if(!isset($hideHeader) || !$hideHeader)
                    <th>Action</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse ($pengadaan as $item)
                <tr>
                    <td>{{ $item->no_kontrak }}</td>
                    <td>{{ $item->no_po }}</td>
                    <td>{{ $item->nama }}</td>
                    <td class="text-center">
                        @if($item->status == 'Diajukan Staf')
                            <span class="badge bg-info text-dark">Diajukan Staf</span>
                        @elseif($item->status == 'Disetujui VP')
                            <span class="badge bg-primary">Disetujui VP</span>
                        @elseif($item->status == 'Di Keuangan')
                            <span class="badge bg-warning text-dark">Di Keuangan</span>
                        @elseif($item->status == 'Di Pengadaan')
                            <span class="badge bg-warning text-dark">Di Pengadaan</span>
                        @elseif($item->status == 'Di Legal')
                            <span class="badge bg-warning text-dark">Di Legal</span>
                        @elseif($item->status == 'Selesai')
                            <span class="badge bg-success">Selesai</span>
                        @else
                            <span class="badge bg-danger">Batal</span>
                        @endif
                    </td>
                    <td>Rp {{ number_format($item->total_kontrak, 2, ',', '.') }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->start_date)->format('d-m-Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->end_date)->format('d-m-Y') }}</td>
                    <td>{{ $item->penagihan ? $item->penagihan . ' Kali' : '-' }}</td>
                    @if(!isset($hideHeader) || !$hideHeader)
                    <td>
                        <a href="{{ route('pengadaan.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('pengadaan.destroy', $item->id) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus data?')">Delete</button>
                        </form>
                    </td>
                    @endif
                </tr>
                @empty
                <tr>
                    <td colspan="{{ (isset($hideHeader) && $hideHeader) ? 8 : 9 }}" class="text-center">Data tidak tersedia</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
