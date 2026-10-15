<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengadaan;
use App\Models\MonitoringGR;
use App\Models\User; 
use App\Models\ProyekPengadaan;
use Carbon\Carbon;
use DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil semua data pengadaan
        $pengadaan = Pengadaan::orderBy('created_at', 'desc')->get();

        // Hitung jumlah pengadaan berdasarkan status
        $statusCounts = $pengadaan->groupBy('status')->map->count();

        // Siapkan data untuk chart lama (bar chart atau sejenisnya)
        $chartLabels = $statusCounts->keys()->toArray();
        $chartData = $statusCounts->values()->toArray();

        // Ambil data urgent pengadaan (mendekati deadline)
        $today = Carbon::today();
        $urgentPengadaan = Pengadaan::select('no_kontrak', 'nama', 'status', 'end_date')
            ->get()
            ->map(function ($item) use ($today) {
                $item->days_to_deadline = Carbon::parse($today)->diffInDays($item->end_date, false);
                return $item;
            });

        //Hitung Total Plan Pengadaan
        $totalPerencanaan = ProyekPengadaan::count();

        // Hitung total GR dari tabel GR yang sebenarnya
        $totalGR = MonitoringGR::count();

        // Hitung statistik utama
        $statistik = [
            'total_pengadaan' => $pengadaan->count(),
            'total_nilai_pengadaan' => $pengadaan->sum('total_kontrak'),
            'total_user_baru' => User::count(),
            'total_perencanaan' => $totalPerencanaan,
            'total_gr' => $pengadaan->whereNotNull('gr_date')->count(),
        ];

        // Distribusi Status Pengadaan (sesuai halaman /monitoring_pengadaan)
        $pengadaanPerStatus = Pengadaan::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total','status')
            ->toArray();

        // Siapkan label dan data untuk Pie/Donut Chart
        $statusChartLabels = array_keys($pengadaanPerStatus);
        $statusChartData = array_values($pengadaanPerStatus);

        // Data untuk Pie Chart Distribusi Status (bisa untuk table jika perlu)
        $data = Pengadaan::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();

        // Kirim semua data ke view
        return view('dashboard', compact(
            'pengadaan', 
            'chartLabels', 
            'chartData', 
            'urgentPengadaan', 
            'statistik', 
            'data',
            'statusChartLabels', // Pie Chart labels
            'statusChartData'    // Pie Chart data
        ));
    }
}
