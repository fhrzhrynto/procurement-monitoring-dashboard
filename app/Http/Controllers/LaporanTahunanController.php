<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengadaan;
use App\Models\User;
use App\Models\MonitoringGR;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LaporanTahunanController extends Controller
{
    public function index(Request $request)
    {
        // Default value
        $tahun = $request->input('tahun', date('Y'));
        
        // Query data berdasarkan tahun
        $pengadaan = Pengadaan::whereYear('created_at', $tahun)
                            ->orderBy('created_at', 'desc')
                            ->get();
        
        $user = User::whereYear('created_at', $tahun)
                    ->orderBy('created_at', 'desc')
                    ->get();
        
        $gr = MonitoringGR::whereYear('created_at', $tahun)
                        ->orderBy('created_at', 'desc')
                        ->get();
        
        // Hitung statistik
        $total_pengadaan = $pengadaan->count();
        $total_user_baru = $user->count();
        $total_gr = $gr->count();
        $total_nilai_pengadaan = $pengadaan->sum('nilai');
        
        // Hitung pengadaan per status
        $pengadaan_per_status = $pengadaan->groupBy('status')
                                        ->map(function ($items) {
                                            return $items->count();
                                        })
                                        ->toArray();
        
        // Data tren bulanan
        $tren_bulanan = [
            'pengadaan' => [],
            'user' => [],
            'gr' => []
        ];
        
        // List bulan
        $bulan_list = [];
        for ($i = 1; $i <= 12; $i++) {
            $bulan_list[$i] = Carbon::createFromDate($tahun, $i, 1)->format('F');
            
            // Hitung jumlah data per bulan
            $tren_bulanan['pengadaan'][$i-1] = $pengadaan->filter(function($item) use ($i) {
                return Carbon::parse($item->created_at)->month == $i;
            })->count();
            
            $tren_bulanan['user'][$i-1] = $user->filter(function($item) use ($i) {
                return Carbon::parse($item->created_at)->month == $i;
            })->count();
            
            $tren_bulanan['gr'][$i-1] = $gr->filter(function($item) use ($i) {
                return Carbon::parse($item->created_at)->month == $i;
            })->count();
        }
        
        // Data statistik
        $statistik = [
            'total_pengadaan' => $total_pengadaan,
            'total_user_baru' => $total_user_baru,
            'total_gr' => $total_gr,
            'total_nilai_pengadaan' => $total_nilai_pengadaan,
            'pengadaan_per_status' => $pengadaan_per_status,
            'tren_bulanan' => $tren_bulanan
        ];
        
        return view('laporan.tahunan', compact(
            'pengadaan', 
            'user', 
            'gr', 
            'statistik', 
            'tahun',
            'bulan_list'
        ));
    }
}