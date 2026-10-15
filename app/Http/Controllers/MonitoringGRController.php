<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MonitoringGR;
use App\Models\Pengadaan;
use Carbon\Carbon;

class MonitoringGRController extends Controller
{
    public function index(Request $request)
    {
        $query = MonitoringGR::query();

        if ($request->filled('no_po')) {
            $query->where('no_po', 'like', '%' . $request->no_po . '%');
        }

        if ($request->filled('min_nilai')) {
            $query->where('nilai_gr', '>=', $request->min_nilai);
        }

        if ($request->filled('max_nilai')) {
            $query->where('nilai_gr', '<=', $request->max_nilai);
        }

        $monitoring = $query->orderBy('created_at', 'desc')->get();

        // Data untuk Gantt Chart
        $pengadaanData = Pengadaan::select('nama', 'start_date', 'end_date')->get();

        $chartData = [];
        foreach ($pengadaanData as $item) {
            $chartData[] = [
                'nama' => $item->nama,
                'start_month' => (int) Carbon::parse($item->start_date)->format('n'),
                'end_month' => (int) Carbon::parse($item->end_date)->format('n'),
            ];
        }

        // 🔥 Data untuk Bar Chart Penagihan
        $penagihanData = Pengadaan::select('nama', 'penagihan')->get();

        $penagihanLabels = $penagihanData->pluck('nama')->toArray();
        $penagihanValues = $penagihanData->pluck('penagihan')->map(function($val) {
            return (int) $val;
        })->toArray();

        // 🔥 Ambil nilai unik Penagihan untuk dropdown filter chart
        $uniquePenagihan = Pengadaan::select('penagihan')->distinct()->pluck('penagihan');

        return view('GR.monitoring_gr', compact(
            'monitoring',
            'chartData',
            'penagihanLabels',
            'penagihanValues',
            'uniquePenagihan' // untuk dropdown filter
        ));
    }



    public function create()
    {
        // Ambil semua data pengadaan untuk pilihan No. PO
        $pengadaans = Pengadaan::select('no_po', 'nama')->get();

        return view('GR.create_gr', compact('pengadaans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'no_po'    => 'required|exists:pengadaan,no_po',
            'judul'    => 'required|string|max:255',
            'no_gr'    => 'required|string|max:255',
            'nilai_gr' => 'required|numeric|min:0',
        ]);

        MonitoringGR::create([
            'no_po'    => $request->no_po,
            'judul'    => $request->judul,
            'no_gr'    => $request->no_gr,
            'nilai_gr' => $request->nilai_gr,
        ]);

        return redirect()->route('monitoring_gr.index')->with('success', 'Data berhasil ditambahkan.');
    }

    public function edit(MonitoringGR $monitoring_gr)
    {
        $dataPengadaan = Pengadaan::select('no_po', 'nama')->get();

        return view('GR.edit_gr', compact('monitoring_gr', 'dataPengadaan'));
    }


    public function update(Request $request, MonitoringGR $monitoring_gr)
    {
        $request->validate([
            'no_po'    => 'required|exists:pengadaan,no_po',
            'judul'    => 'required|string|max:255',
            'no_gr'    => 'required|string|max:255',
            'nilai_gr' => 'required|numeric|min:0',
        ]);

        $monitoring_gr->update([
            'no_po'    => $request->no_po,
            'judul'    => $request->judul,
            'no_gr'    => $request->no_gr,
            'nilai_gr' => $request->nilai_gr,
        ]);

        return redirect()->route('monitoring_gr.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy(MonitoringGR $monitoring_gr)
    {
        $monitoring_gr->delete();

        return redirect()->route('monitoring_gr.index')->with('success', 'Data berhasil dihapus.');
    }

    public function getChartData(Request $request)
    {
        $nama = $request->query('nama');

        $query = Pengadaan::select('nama', 'penagihan');
        if (!empty($nama)) {
            $query->where('nama', 'like', '%' . $nama . '%');
        }

        $pengadaans = $query->get();

        return response()->json([
            'labels' => $pengadaans->pluck('nama'),
            'data' => $pengadaans->pluck('penagihan')->map(fn($v) => (int)$v),
        ]);
    }   
}