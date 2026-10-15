<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengadaan;
use App\Models\ProyekPengadaan;

class PengadaanController extends Controller
{
    // ================= Monitoring Pengadaan =================

    public function index(Request $request)
    {
        $query = Pengadaan::query();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where('nama', 'LIKE', '%' . $request->search . '%');
        }

        if ($request->filled('start_date')) {
            $query->whereDate('start_date', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('end_date', '<=', $request->end_date);
        }

        $pengadaan = $query->get();

        return view('pages.monitoring_pengadaan', compact('pengadaan'));
    }

    public function create()
    {
        return view('pages.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'no_kontrak' => 'required|unique:pengadaan',
            'no_po' => 'nullable|string',
            'nama' => 'required|string',
            'status' => 'required|in:Diajukan Staf,Disetujui VP,Di Keuangan,Di Pengadaan,Di Legal,Selesai,Batal',
            'total_kontrak' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'penagihan' => 'nullable|integer|min:1|max:12',
        ]);

        Pengadaan::create($validated);

        return redirect()->route('monitoring_pengadaan')->with('success', 'Kontrak berhasil ditambahkan');
    }

    public function edit($id)
    {
        $pengadaan = Pengadaan::findOrFail($id);
        return view('pages.edit', compact('pengadaan'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'no_kontrak' => 'required|unique:pengadaan,no_kontrak,' . $id,
            'no_po' => 'nullable|string',
            'nama' => 'required|string',
            'status' => 'required|in:Diajukan Staf,Disetujui VP,Di Keuangan,Di Pengadaan,Di Legal,Selesai,Batal',
            'total_kontrak' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'penagihan' => 'nullable|string',
        ]);

        $pengadaan = Pengadaan::findOrFail($id);
        $pengadaan->update($validated);

        return redirect()->route('monitoring_pengadaan')->with('success', 'Kontrak berhasil diperbarui');
    }

    public function destroy($id)
    {
        $pengadaan = Pengadaan::findOrFail($id);
        $pengadaan->delete();

        return redirect()->route('monitoring_pengadaan')->with('success', 'Kontrak berhasil dihapus');
    }
}