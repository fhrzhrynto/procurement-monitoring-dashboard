<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengadaan;
use App\Models\User;
use App\Models\MonitoringGR;


class LaporanBulananController extends Controller
{
    public function index(Request $request)
    {
        // Filter untuk pengadaan (tab Laporan Bulanan Pengadaan)
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');
        $filterType = $request->input('filter_type', 'updated'); // default updated

        // Filter untuk users (tab Daftar User)
        $bulanUser = $request->input('bulan_user');
        $tahunUser = $request->input('tahun_user');
        $filterTypeUser = $request->input('filter_type_user', 'updated'); // default updated

        // Filter untuk monitoring GR (tab Monitoring GR)
        $bulanGR = $request->input('bulan_gr');
        $tahunGR = $request->input('tahun_gr');
        $filterTypeGR = $request->input('filter_type_gr', 'updated'); // default updated

        // Tahun tersedia untuk pengadaan
        $availableYears = Pengadaan::selectRaw('YEAR(updated_at) as tahun')
                            ->distinct()
                            ->orderBy('tahun', 'desc')
                            ->pluck('tahun')
                            ->toArray();

        // Tahun tersedia untuk users
        $availableYearsUser = User::selectRaw('YEAR(created_at) as tahun')
                            ->distinct()
                            ->orderBy('tahun', 'desc')
                            ->pluck('tahun')
                            ->toArray();

        // Tahun tersedia untuk GR
        $availableYearsGR = MonitoringGR::selectRaw('YEAR(' . $filterTypeGR . '_at) as tahun')
                            ->distinct()
                            ->orderBy('tahun', 'desc')
                            ->pluck('tahun')
                            ->toArray();

        // Query pengadaan dengan filter
        $pengadaan = Pengadaan::when($bulan, function($query) use ($bulan, $filterType) {
                                return $query->whereMonth($filterType . '_at', $bulan);
                            })
                            ->when($tahun, function($query) use ($tahun, $filterType) {
                                return $query->whereYear($filterType . '_at', $tahun);
                            })
                            ->orderBy($filterType . '_at', 'desc')
                            ->get();

        // Query users dengan filter
        $users = User::when($bulanUser, function($query) use ($bulanUser, $filterTypeUser) {
                            return $query->whereMonth($filterTypeUser . '_at', $bulanUser);
                        })
                        ->when($tahunUser, function($query) use ($tahunUser, $filterTypeUser) {
                            return $query->whereYear($filterTypeUser . '_at', $tahunUser);
                        })
                        ->orderBy($filterTypeUser . '_at', 'desc')
                        ->get();

        // Query monitoring GR dengan filter
        $grList = MonitoringGR::when($bulanGR, function($query) use ($bulanGR, $filterTypeGR) {
                                return $query->whereMonth($filterTypeGR . '_at', $bulanGR);
                            })
                            ->when($tahunGR, function($query) use ($tahunGR, $filterTypeGR) {
                                return $query->whereYear($filterTypeGR . '_at', $tahunGR);
                            })
                            ->orderBy($filterTypeGR . '_at', 'desc')
                            ->get();

        return view('laporan.bulanan', compact(
            'pengadaan', 'availableYears', 'bulan', 'tahun', 'filterType',
            'users', 'availableYearsUser', 'bulanUser', 'tahunUser', 'filterTypeUser',
            'grList', 'availableYearsGR', 'bulanGR', 'tahunGR', 'filterTypeGR'
        ));
    }


    public function loadPengadaan(Request $request)
    {
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');
        $filterType = $request->input('filter_type', 'updated');

        $pengadaan = Pengadaan::when($bulan, function ($q) use ($bulan, $filterType) {
            return $q->whereMonth($filterType . '_at', $bulan);
        })
        ->when($tahun, function ($q) use ($tahun, $filterType) {
            return $q->whereYear($filterType . '_at', $tahun);
        })
        ->orderBy($filterType . '_at', 'desc')
        ->get();

        return view('laporan.partials.pengadaan', compact('pengadaan', 'bulan', 'tahun', 'filterType'));
    }

    public function loadUser(Request $request)
    {
        $bulanUser = $request->input('bulan_user');
        $tahunUser = $request->input('tahun_user');
        $filterTypeUser = $request->input('filter_type_user', 'updated');

        $users = User::when($bulanUser, function ($q) use ($bulanUser, $filterTypeUser) {
            return $q->whereMonth($filterTypeUser . '_at', $bulanUser);
        })
        ->when($tahunUser, function ($q) use ($tahunUser, $filterTypeUser) {
            return $q->whereYear($filterTypeUser . '_at', $tahunUser);
        })
        ->orderBy($filterTypeUser . '_at', 'desc')
        ->get();

        return view('laporan.partials.user', compact('users', 'bulanUser', 'tahunUser', 'filterTypeUser'));
    }
}
