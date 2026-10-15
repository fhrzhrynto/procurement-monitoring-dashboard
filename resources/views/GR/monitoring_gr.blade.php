@extends('layouts.app')

@section('title', 'Monitoring Goods Receipt')

@section('content')
<div class="container">

    <!-- Chart Distribusi Penagihan (Dipindah ke atas tabel & Diperkecil) -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Grafik Distribusi Penagihan</h5>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="searchPenagihan">Cari Nama Pengadaan:</label>
                    <input type="text" id="searchPenagihan" class="form-control" placeholder="Ketik nama pengadaan...">
                </div>
            </div>
            <div style="width:100%; max-width:600px; margin:auto;">
                <canvas id="penagihanBarChart" height="200"></canvas>
            </div>
        </div>
    </div>

    <!-- Tabel Data -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Monitoring Goods Receipt (GR)</h5>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <!-- Search Section -->
            <form method="GET" action="{{ route('monitoring_gr.index') }}" class="mb-4">
                <div class="row">
                    <div class="col-md-8">
                        <input type="text" name="search" class="form-control" placeholder="Cari No. PO atau Judul..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-4 d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Cari</button>
                        @if(request('search'))
                            <a href="{{ route('monitoring_gr.index') }}" class="btn btn-secondary">Reset</a>
                        @endif
                    </div>
                </div>
            </form>

            <!-- Admin Button -->
            <div class="mb-3">
                <a href="{{ route('monitoring_gr.create') }}" class="btn btn-primary">
                    <i class="fa fa-plus"></i> Tambah GR
                </a>
            </div>

            <!-- Table -->
            <div class="table-responsive">
                <table class="table table-bordered table-hover text-center">
                    <thead class="table-primary">
                        <tr>
                            <th>No. PO</th>
                            <th>No. GR</th>
                            <th>Judul</th>
                            <th>Nilai GR</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($monitoring as $item)
                            <tr class="align-middle text-start">
                                <td class="text-center">{{ $item->no_po }}</td>
                                <td class="text-center">{{ $item->no_gr }}</td>
                                <td>{{ $item->judul }}</td>
                                <td class="text-end">Rp {{ number_format($item->nilai_gr, 0, ',', '.') }}</td>
                                <td class="text-center">
                                    <a href="{{ route('monitoring_gr.edit', $item->id) }}" class="btn btn-warning btn-sm">
                                        <i class="fa fa-edit"></i> Edit
                                    </a>
                                    <form id="delete-form-{{ $item->id }}" action="{{ route('monitoring_gr.destroy', $item->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete('{{ $item->id }}')">
                                            <i class="fa fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">
                                    <div class="alert alert-warning mb-0">Tidak ada data GR ditemukan</div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if(method_exists($monitoring, 'links'))
                <div class="d-flex justify-content-center mt-3">
                    {{ $monitoring->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    let penagihanChart;

    function renderChart(labels, data) {
        const ctx = document.getElementById('penagihanBarChart').getContext('2d');
        if (penagihanChart) penagihanChart.destroy();
        penagihanChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Bulan Penagihan',
                    data: data,
                    backgroundColor: 'rgba(255, 99, 132, 0.7)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        min: 1,
                        max: 12,
                        title: {
                            display: true,
                            text: 'Bulan (1-12)'
                        },
                        ticks: { stepSize: 1 }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Nama Kontrak'
                        }
                    }
                },
                plugins: {
                    legend: { display: false }
                }
            }
        });
    }

    function fetchChartData(nama = '') {
        $.ajax({
            url: '{{ url("/api/chart-penagihan") }}',
            type: 'GET',
            data: { nama: nama },
            success: function(response) {
                renderChart(response.labels, response.data);
            },
            error: function() {
                alert('Gagal memuat data chart!');
            }
        });
    }

    $(document).ready(function() {
        fetchChartData();

        $('#searchPenagihan').keypress(function(e) {
            if (e.which === 13) { // ENTER key pressed
                let nama = $(this).val();
                fetchChartData(nama);
            }
        });
    });

</script>

<style>
.card-header {
    background-color: #3f51b5 !important;
    color: white;
    text-align: center;
    border-top-left-radius: 20px;
    border-top-right-radius: 20px;
    padding: 15px;
    font-weight: bold;
}
.card-header h5 {
    margin: 0;
}
#penagihanBarChart {
    max-height: 300px !important;
}
</style>
@endsection
