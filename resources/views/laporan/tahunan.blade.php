@extends('layouts.app')

@section('title', 'Laporan Tahunan')

@section('content')
<div class="container">
    <div class="card shadow-lg bg-white card-custom">
        <!-- Header Card -->
        <div class="card-header text-white text-center fw-bold" style="background-color: #3f51b5;">
            <h5 class="fw-bold m-0">Laporan Tahunan - {{ $tahun }}</h5>
        </div>

        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
        
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Filter -->
            <form method="GET" action="{{ route('laporan.tahunan') }}" class="d-flex gap-2 mb-4">
                <select name="tahun" class="form-select">
                    @for($i=2023; $i<=date('Y'); $i++)
                        <option value="{{ $i }}" {{ $i == $tahun ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ route('laporan.tahunan') }}" class="btn btn-secondary">Reset</a>
            </form>

            <!-- Status Pengadaan Cards -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-warning text-dark">
                    <h5 class="m-0 fw-bold">Status Pengadaan</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr class="table-secondary">
                                            <th>Status</th>
                                            <th class="text-center">Jumlah</th>
                                            <th class="text-center">Persentase</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $totalPengadaan = array_sum($statistik['pengadaan_per_status']); @endphp
                                        @foreach($statistik['pengadaan_per_status'] as $status => $total)
                                        <tr>
                                            <td>
                                                @if($status == 'Diajukan Staf')
                                                    <span class="badge bg-info text-dark">Diajukan Staf</span>
                                                @elseif($status == 'Disetujui VP')
                                                    <span class="badge bg-primary">Disetujui VP</span>
                                                @elseif($status == 'Di Keuangan')
                                                    <span class="badge bg-warning text-dark">Di Keuangan</span>
                                                @elseif($status == 'Di Pengadaan')
                                                    <span class="badge bg-warning text-dark">Di Pengadaan</span>
                                                @elseif($status == 'Di Legal')
                                                    <span class="badge bg-warning text-dark">Di Legal</span>
                                                @elseif($status == 'Selesai')
                                                    <span class="badge bg-success">Selesai</span>
                                                @else
                                                    <span class="badge bg-danger">Batal</span>
                                                @endif
                                                {{ $status }}
                                            </td>
                                            <td class="text-center">{{ $total }}</td>
                                            <td class="text-center">
                                                {{ number_format(($total / $totalPengadaan) * 100, 1) }}%
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="table-secondary">
                                        <tr>
                                            <th>Total</th>
                                            <th class="text-center">{{ $totalPengadaan }}</th>
                                            <th class="text-center">100%</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <canvas id="statusChart" width="400" height="250"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tren Bulanan -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="m-0 fw-bold">Tren Bulanan {{ $tahun }}</h5>
                </div>
                <div class="card-body">
                    <canvas id="trenBulananChart" height="250"></canvas>
                </div>
            </div>

            <!-- Tab Navigation -->
            <ul class="nav nav-tabs mb-3" id="laporanTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="pengadaan-tab" data-bs-toggle="tab" data-bs-target="#pengadaan" type="button" role="tab">Pengadaan</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="user-tab" data-bs-toggle="tab" data-bs-target="#user" type="button" role="tab">User</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="gr-tab" data-bs-toggle="tab" data-bs-target="#gr" type="button" role="tab">Goods Receipt</button>
                </li>
            </ul>

            <!-- Tab Content -->
            <div class="tab-content" id="laporanTabsContent">
                <!-- Tab Pengadaan -->
                <div class="tab-pane fade show active" id="pengadaan" role="tabpanel">
                    <div class="mb-3 d-flex gap-2">
                        <select id="filterStatus" class="form-select" style="max-width: 250px;">
                            <option value="">Semua Status</option>
                            @foreach($statistik['pengadaan_per_status'] as $status => $total)
                                <option value="{{ $status }}">{{ $status }} ({{ $total }})</option>
                            @endforeach
                        </select>
                        
                        <select id="filterBulan" class="form-select" style="max-width: 200px;">
                            <option value="">Semua Bulan</option>
                            @foreach($bulan_list as $idx => $nama_bulan)
                                <option value="{{ $idx }}">{{ $nama_bulan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered shadow-sm text-center table-custom" id="tablePengadaan">
                            <thead class="table-primary">
                                <tr>
                                    <th>No</th>
                                    <th>Judul</th>
                                    <th>No SPP</th>
                                    <th>Nilai</th>
                                    <th>Status</th>
                                    <th>Bulan</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pengadaan as $index => $item)
                                <tr data-status="{{ $item->status }}" data-bulan="{{ date('n', strtotime($item->created_at)) }}">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->judul }}</td>
                                    <td>{{ $item->no_spp }}</td>
                                    <td>Rp {{ number_format($item->nilai, 0, ',', '.') }}</td>
                                    <td>
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
                                    <td>{{ date('F', strtotime($item->created_at)) }}</td>
                                    <td>{{ $item->created_at->format('d-m-Y H:i') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Tab User -->
                <div class="tab-pane fade" id="user" role="tabpanel">
                    <div class="mb-3">
                        <select id="filterBulanUser" class="form-select" style="max-width: 200px;">
                            <option value="">Semua Bulan</option>
                            @foreach($bulan_list as $idx => $nama_bulan)
                                <option value="{{ $idx }}">{{ $nama_bulan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered shadow-sm text-center table-custom" id="tableUser">
                            <thead class="table-primary">
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Bulan</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($user as $index => $item)
                                <tr data-bulan="{{ date('n', strtotime($item->created_at)) }}">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>
                                        @if($item->role == 1)
                                            <span class="badge bg-primary">Admin</span>
                                        @else
                                            <span class="badge bg-secondary">Visitor</span>
                                        @endif
                                    </td>
                                    <td>{{ date('F', strtotime($item->created_at)) }}</td>
                                    <td>{{ $item->created_at->format('d-m-Y H:i') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Tab Goods Receipt -->
                <div class="tab-pane fade" id="gr" role="tabpanel">
                    <div class="mb-3">
                        <select id="filterBulanGR" class="form-select" style="max-width: 200px;">
                            <option value="">Semua Bulan</option>
                            @foreach($bulan_list as $idx => $nama_bulan)
                                <option value="{{ $idx }}">{{ $nama_bulan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered shadow-sm text-center table-custom" id="tableGR">
                            <thead class="table-primary">
                                <tr>
                                    <th>No</th>
                                    <th>No SPP</th>
                                    <th>Judul SPP</th>
                                    <th>Bulan</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($gr as $index => $item)
                                <tr data-bulan="{{ date('n', strtotime($item->created_at)) }}">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->no_spp }}</td>
                                    <td>{{ $item->judul_spp }}</td>
                                    <td>{{ date('F', strtotime($item->created_at)) }}</td>
                                    <td>{{ $item->created_at->format('d-m-Y H:i') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tambahkan Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Inisialisasi tab
    const tabElms = document.querySelectorAll('button[data-bs-toggle="tab"]');
    tabElms.forEach(tabEl => {
        tabEl.addEventListener('click', function(event) {
            event.preventDefault();
            const tabTarget = this.getAttribute('data-bs-target');
            const tabPane = document.querySelector(tabTarget);
            
            // Sembunyikan semua tab panes
            document.querySelectorAll('.tab-pane').forEach(pane => {
                pane.classList.remove('show', 'active');
            });
            
            // Tampilkan target tab
            tabPane.classList.add('show', 'active');
            
            // Set active pada tab button
            tabElms.forEach(el => el.classList.remove('active'));
            this.classList.add('active');
        });
    });
    
    // Filter pengadaan berdasarkan status
    const filterStatus = document.getElementById('filterStatus');
    const filterBulan = document.getElementById('filterBulan');
    if (filterStatus && filterBulan) {
        const applyFilters = function() {
            const selectedStatus = filterStatus.value;
            const selectedBulan = filterBulan.value;
            const rows = document.querySelectorAll('#tablePengadaan tbody tr');
            
            rows.forEach(row => {
                const status = row.getAttribute('data-status');
                const bulan = row.getAttribute('data-bulan');
                
                const statusMatch = !selectedStatus || status === selectedStatus;
                const bulanMatch = !selectedBulan || bulan === selectedBulan;
                
                if (statusMatch && bulanMatch) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        };
        
        filterStatus.addEventListener('change', applyFilters);
        filterBulan.addEventListener('change', applyFilters);
    }
    
    // Filter untuk user dan GR berdasarkan bulan
    const setupBulanFilter = function(filterId, tableId) {
        const filter = document.getElementById(filterId);
        if (filter) {
            filter.addEventListener('change', function() {
                const selectedBulan = this.value;
                const rows = document.querySelectorAll(`#${tableId} tbody tr`);
                
                rows.forEach(row => {
                    const bulan = row.getAttribute('data-bulan');
                    if (!selectedBulan || bulan === selectedBulan) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        }
    };
    
    setupBulanFilter('filterBulanUser', 'tableUser');
    setupBulanFilter('filterBulanGR', 'tableGR');
    
    // Inisialisasi chart untuk status pengadaan
    const statusData = @json($statistik['pengadaan_per_status']);
    const statusLabels = Object.keys(statusData);
    const statusValues = Object.values(statusData);
    
    // Warna untuk chart
    const statusColors = {
        'Diajukan Staf': 'rgba(168, 230, 255, 0.87)', //Biru Muda
        'Disetujui VP': 'rgba(0, 123, 255, 0.7)',  // Biru berbeda (shade baru)
        'Di Keuangan': 'rgba(255, 221, 51, 0.7)',  // Bright Yellow
        'Di Pengadaan': 'rgba(255, 247, 0, 0.7)', // Lemon
        'Di Legal': 'rgba(255, 196, 12, 0.7)',  // Mikado Yellow
        'Selesai': 'rgba(40, 167, 69, 0.7)',        // Hijau (tetap)
        'Batal': 'rgba(220, 53, 69, 0.7)'           // Merah (tetap)
    };
    
    const backgroundColors = statusLabels.map(label => statusColors[label] || 'rgba(108, 117, 125, 0.7)');
    
    const ctxStatus = document.getElementById('statusChart').getContext('2d');
    new Chart(ctxStatus, {
        type: 'pie',
        data: {
            labels: statusLabels,
            datasets: [{
                data: statusValues,
                backgroundColor: backgroundColors,
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'right',
                }
            }
        }
    });
    
    // Chart untuk tren bulanan
    const trenData = @json($statistik['tren_bulanan']);
    const bulanLabels = @json($bulan_list);
    
    const ctxTren = document.getElementById('trenBulananChart').getContext('2d');
    new Chart(ctxTren, {
        type: 'line',
        data: {
            labels: bulanLabels,
            datasets: [
                {
                    label: 'Pengadaan',
                    data: trenData.pengadaan,
                    borderColor: 'rgba(13, 110, 253, 1)',
                    backgroundColor: 'rgba(13, 110, 253, 0.1)',
                    tension: 0.1,
                    fill: true
                },
                {
                    label: 'User Baru',
                    data: trenData.user,
                    borderColor: 'rgba(40, 167, 69, 1)',
                    backgroundColor: 'rgba(40, 167, 69, 0.1)',
                    tension: 0.1,
                    fill: true
                },
                {
                    label: 'Goods Receipt',
                    data: trenData.gr,
                    borderColor: 'rgba(23, 162, 184, 1)',
                    backgroundColor: 'rgba(23, 162, 184, 0.1)',
                    tension: 0.1,
                    fill: true
                }
            ]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
});
</script>

<style>
    /* Gunakan styling yang sama dengan file lainnya */
    .card-custom {
        max-width: 1200px;
        margin: auto;
        border-radius: 8px;
        background: #ffffff;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        overflow: hidden;
    }

    .card-header {
        background-color: #3f51b5 !important;
        color: white;
        text-align: center;
        border-top-left-radius: 8px;
        border-top-right-radius: 8px;
        padding: 15px;
        font-weight: bold;
    }

    .table-custom {
        border-radius: 5px;
        overflow: hidden;
    }

    .table-primary th {
        background-color: #3f51b5;
        color: white;
    }

    .nav-tabs .nav-link {
        color: #495057;
    }

    .nav-tabs .nav-link.active {
        color: #3f51b5;
        font-weight: bold;
        border-bottom: 3px solid #3f51b5;
    }

    .badge {
        font-size: 0.9em;
        padding: 5px 10px;
    }
</style>
@endsection