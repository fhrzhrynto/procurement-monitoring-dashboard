@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Sapaan & Informasi -->
    <div class="card shadow-sm mb-4">
        <div class="card-body text-center">
            <h2 class="fw-bold">👋 Halo, {{ Auth::user()->name }}!</h2>
            <p class="text-muted">Selamat datang di dashboard Anda. Semoga hari Anda menyenangkan! 😊</p>
        </div>
    </div>

    <!-- Statistik Utama -->
    <div class="row mb-4">
        <div class="col-12 col-md-4 mb-3">
            <div class="card bg-primary text-white" style="min-height: 100px; height: 100%;">
                <div class="card-body text-center">
                    <h5>Total Pengadaan</h5>
                    <h3>{{ $statistik['total_pengadaan'] }}</h3>
                    <small>Nilai: Rp {{ number_format($statistik['total_nilai_pengadaan'], 0, ',', '.') }}</small>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4 mb-3">
            <div class="card bg-success text-white" style="min-height: 140px; height: 100%;">
                <div class="card-body text-center">
                    <h5>Total Proyek</h5>
                    <h3>{{ $statistik['total_perencanaan'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4 mb-3">
            <div class="card bg-info text-white" style="min-height: 140px; height: 100%;">
                <div class="card-body text-center">
                    <h5>Goods Receipt</h5>
                    <h3>{{ $statistik['total_gr'] }}</h3>
                </div>
            </div>
        </div>
    </div>

        <!-- Grafik Distribusi Status -->
        <div class="row mb-4">
            <div class="col-12 col-md-4 mb-4">
                <div class="chart-wrapper" style="background: #ffffff; border: 1px solid #ddd; border-radius: 10px; padding: 20px; width: 100%; box-shadow: 0px 4px 8px rgba(0,0,0,0.1); height: 300px; display: flex; flex-direction: column; justify-content: center; align-items: center;">
                    <h5 class="mb-3 fw-bold text-center">📊 Distribusi Status Pengadaan</h5>
                    <canvas id="statusChart" style="max-width: 100%; max-height: 220px;"></canvas>
                </div>
            </div>

        <!-- Urgent Pengadaan -->
        <div class="col-12 col-md-8 mb-4">
            <div class="table-responsive" style="background: #fff; border: 1px solid #ddd; border-radius: 10px; padding: 20px; box-shadow: 0px 4px 8px rgba(0,0,0,0.1); height: 300px; overflow-y: auto;">
                <h5 class="mb-3">⚠️ Pengadaan Urgent (Mendekati Deadline)</h5>
                <table class="table table-bordered">
                    <thead class="table-warning">
                        <tr>
                            <th>No. Kontrak</th>
                            <th>Nama</th>
                            <th>Akhir Kontrak</th>
                            <th>Status</th>
                            <th>Hari Menuju Akhir</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($urgentPengadaan as $item)
                            <tr>
                                <td>{{ $item->no_kontrak }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->end_date)->format('d-m-Y') }}</td>
                                <td>{{ $item->status }}</td>
                                <td>
                                    @if($item->days_to_deadline < 0)
                                        <span class="text-danger">Terlambat {{ abs($item->days_to_deadline) }} Hari</span>
                                    @elseif($item->days_to_deadline === 0)
                                        <span class="text-warning">Berakhir Hari Ini</span>
                                    @else
                                        {{ $item->days_to_deadline }} Hari Lagi
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada pengadaan yang mendekati deadline.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Statistik & Informasi -->
    <div class="row">
        <!-- Card 1 - Monitoring Pengadaan -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h5 class="card-title fw-bold">💻 Monitoring</h5>
                    <p class="text-muted">Monitoring Pengadaan dan Data Pengadaan</p>
                    <a href="{{ route('monitoring_pengadaan') }}" class="btn btn-warning text-white">Lihat Monitoring</a>
                </div>
            </div>
        </div>

        <!-- Card 2 - Daftar User -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h5 class="card-title fw-bold">📋 Daftar User</h5>
                    <p class="text-muted">Kelola user yang terdaftar dan terdata di dalam sistem</p>
                    <a href="{{ route('daftaruser') }}" class="btn btn-success">Lihat User</a>
                </div>
            </div>
        </div>

        <!-- Card 3 - Pengaturan Profil -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h5 class="card-title fw-bold">⚙️ Pengaturan Profil</h5>
                    <p class="text-muted">Atur informasi dan preferensi akun Anda.</p>
                    <a href="{{ route('profile') }}" class="btn btn-secondary">Edit Profil</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Motivational Quote -->
    <div class="card shadow-sm mt-4">
        <div class="card-body text-center">
            <blockquote class="blockquote">
                <p class="mb-0">"Sukses adalah hasil dari usaha kecil yang dilakukan setiap hari." -Einstein</p>
            </blockquote>
        </div>
    </div>
</div>
@endsection


@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const statusChartCtx = document.getElementById('statusChart').getContext('2d');
    const statusChart = new Chart(statusChartCtx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($statusChartLabels) !!},
            datasets: [{
                label: 'Jumlah',
                data: {!! json_encode($statusChartData) !!},
                backgroundColor: [
                    '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0',
                    '#9966FF', '#FF9F40', '#E7E9ED'
                ],
                borderColor: '#fff',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });
</script>
@endsection