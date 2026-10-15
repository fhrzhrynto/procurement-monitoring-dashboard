<?php

namespace App\Http\Controllers;

use App\Models\ProyekPengadaan;
use App\Models\PlanPengadaan;
use Illuminate\Http\Request;

class PersiapanPengadaanController extends Controller
{
    // Halaman utama Persiapan Pengadaan (Tab 1 & Tab 2)
    public function index()
    {
        $proyek = ProyekPengadaan::all();
        $plan = PlanPengadaan::with('proyek')->get();
        return view('persiapan_pengadaan.index', compact('proyek', 'plan'));
    }

    // --- CRUD untuk Proyek (Tab 1) ---

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_proyek' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'start_date' => 'required|date',
            'target_date' => 'required|date',
            'progress' => 'nullable|string',
        ]);

        ProyekPengadaan::create($validated);

        return redirect()->route('persiapan_pengadaan')->with('success', 'Proyek berhasil dibuat.');
    }

    public function edit($id)
    {
        $proyek = ProyekPengadaan::findOrFail($id);
        return view('persiapan_pengadaan.tab1_edit', compact('proyek'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_proyek' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'start_date' => 'required|date',
            'target_date' => 'required|date',
            'progress' => 'nullable|string',
        ]);

        $proyek = ProyekPengadaan::findOrFail($id);
        $proyek->update($validated);

        return redirect()->route('persiapan_pengadaan')->with('success', 'Proyek berhasil diupdate.');
    }

    // --- CRUD untuk Plan Pengajuan (Tab 2) ---

    // Tampilkan form tambah Plan Pengajuan
    public function createPlan()
    {
        $proyek = ProyekPengadaan::all();
        return view('persiapan_pengadaan.tab2_create', compact('proyek'));
    }

    // Simpan Plan Pengajuan baru
    public function storePlan(Request $request)
    {
        $validated = $request->validate([
            'id_plan' => 'required|string|unique:plan_pengadaan,id_plan',
            'proyek_id' => 'required|exists:proyek_pengadaan,id',
        ]);

        PlanPengadaan::create($validated);

        return redirect()->route('persiapan_pengadaan')->with('success', 'Plan Pengajuan berhasil dibuat.');
    }

    // Form edit Plan Pengajuan
    public function editPlan($id)
    {
        $plan = PlanPengadaan::findOrFail($id);
        $proyek = ProyekPengadaan::all();
        return view('persiapan_pengadaan.tab2_edit', compact('plan', 'proyek'));
    }

    // Update Plan Pengajuan
    public function updatePlan(Request $request, $id)
    {
        $validated = $request->validate([
            'id_plan' => 'required|string|unique:plan_pengadaan,id_plan,' . $id,
            'proyek_id' => 'required|exists:proyek_pengadaan,id',
        ]);

        $plan = PlanPengadaan::findOrFail($id);
        $plan->update($validated);

        return redirect()->route('persiapan_pengadaan')->with('success', 'Plan Pengajuan berhasil diupdate.');
    }

    // Hapus Plan Pengajuan
    public function destroyPlan($id)
    {
        $plan = PlanPengadaan::findOrFail($id);
        $plan->delete();

        return redirect()->route('persiapan_pengadaan')->with('success', 'Plan Pengajuan berhasil dihapus.');
    }
}
