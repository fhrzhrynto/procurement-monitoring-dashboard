<?php

namespace App\Http\Controllers;

use App\Models\Pengadaan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AnalisisDataController extends Controller
{
    public function index()
    {
        // Data untuk chart
        $data = Pengadaan::select('status')
            ->selectRaw('count(*) as total')
            ->groupBy('status')
            ->get();

        // Data urgent pengadaan
        $urgentPengadaan = Pengadaan::whereNotNull('deadline')
            ->orderBy('deadline')
            ->get();

        foreach ($urgentPengadaan as $pengadaan) {
            $deadline = Carbon::parse($pengadaan->deadline);
            $now = Carbon::now();
            $diffInDays = $now->diffInDays($deadline, false);
            $diff = $now->diff($deadline);

            $pengadaan->days_to_deadline = $diffInDays;
            $pengadaan->deadline_human = $diffInDays < 0
                ? 'Terlambat ' . $diff->m . ' Bulan ' . $diff->d . ' Hari'
                : ($diffInDays === 0
                    ? 'Deadline Hari Ini'
                    : ($diffInDays === 1
                        ? 'Besok'
                        : ($diff->m > 0
                            ? $diff->m . ' Bulan ' . $diff->d . ' Hari Lagi'
                            : $diff->d . ' Hari Lagi')));
        }

        // Data untuk Status Aging Report
        $agingData = Pengadaan::select('judul', 'status', 'updated_at')
            ->get()
            ->map(function ($item) {
                $daysInStatus = Carbon::parse($item->updated_at)->diffInDays(now());
                $item->days_in_status = $daysInStatus;
                return $item;
            })
            ->filter(function ($item) {
                return $item->days_in_status >= 15; // Threshold 15 hari
            })
            ->values(); // Reset index

        return view('laporan.analisis_data', compact('data', 'urgentPengadaan', 'agingData'));
    }
}
