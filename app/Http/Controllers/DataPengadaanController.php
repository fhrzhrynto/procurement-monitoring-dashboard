<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataPengadaan;
use Illuminate\Support\Facades\Storage;

class DataPengadaanController extends Controller
{
    // Menampilkan daftar pengadaan
    public function index(Request $request)
    {
        $query = DataPengadaan::query();

        // Search by nama_pengadaan
        if ($request->has('search') && $request->search != '') {
            $searchTerm = '%' . $request->search . '%';
            $query->where('nama_pengadaan', 'like', $searchTerm);
        }

        // Filter by document presence
        if ($request->filled('has_document')) {
            $documentType = $request->has_document;
            if (in_array($documentType, ['tor', 'rab', 'sph', 'bcr', 'nodin', 'all'])) {
                if ($documentType == 'all') {
                    $query->whereNotNull('tor')
                          ->whereNotNull('rab')
                          ->whereNotNull('sph')
                          ->whereNotNull('bcr')
                          ->whereNotNull('nodin');
                } else {
                    $query->whereNotNull($documentType);
                }
            }
        }

        // Get results
        $dataPengadaan = $query->orderBy('id', 'desc')->get();

        return view('data.data_pengadaan', compact('dataPengadaan'));
    }

    // Menampilkan halaman tambah data
    public function create()
    {
        return view('data.create_pengadaan');
    }

    // Menyimpan data ke database
    public function store(Request $request)
    {
        $request->validate([
            'nama_pengadaan' => 'required|string|max:255',
            'tor' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'rab' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'sph' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'bcr' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'nodin' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        // Simpan file jika diunggah
        $files = ['tor', 'rab', 'sph', 'bcr', 'nodin'];
        $filePaths = [];

        foreach ($files as $file) {
            $filePaths[$file] = $request->hasFile($file) ? $request->file($file)->store('pengadaan', 'public') : null;
        }

        // Simpan data ke database
        DataPengadaan::create(array_merge(
            ['nama_pengadaan' => $request->nama_pengadaan],
            $filePaths
        ));

        return redirect()->route('data_pengadaan')->with('success', 'Data Pengadaan berhasil ditambahkan!');
    }

    // Menampilkan halaman edit
    public function edit($id)
    {
        $dataPengadaan = DataPengadaan::findOrFail($id);
        return view('data.edit_pengadaan', compact('dataPengadaan'));
    }

    // Update data pengadaan
    public function update(Request $request, $id)
    {
        $dataPengadaan = DataPengadaan::findOrFail($id);
    
        // Update nama pengadaan
        $dataPengadaan->nama_pengadaan = $request->nama_pengadaan;
    
        // File yang bisa diupload
        $fields = ['tor', 'rab', 'sph', 'bcr', 'nodin'];
        $updateData = [];
    
        foreach ($fields as $field) {
            // Jika tombol delete diklik, hapus file lama
            if ($request->input("delete_$field") == 1) {
                if ($dataPengadaan->$field) {
                    Storage::delete('public/' . $dataPengadaan->$field);
                    $updateData[$field] = null;
                }
            }
    
            // Jika ada file baru, hapus file lama lalu simpan yang baru
            if ($request->hasFile($field)) {
                if ($dataPengadaan->$field) {
                    Storage::delete('public/' . $dataPengadaan->$field);
                }
                $updateData[$field] = $request->file($field)->store('pengadaan', 'public');
            }
        }
    
        // Simpan perubahan
        $dataPengadaan->update($updateData);
    
        return redirect()->route('data_pengadaan')->with('success', 'Data berhasil diperbarui.');
    }

    // Menghapus data pengadaan
    public function destroy($id)
    {
        $data = DataPengadaan::findOrFail($id);

        // Hapus file terkait jika ada
        $files = ['tor', 'rab', 'sph', 'bcr', 'nodin'];
        foreach ($files as $file) {
            if ($data->$file) {
                Storage::delete('public/' . $data->$file);
            }
        }

        // Hapus data dari database
        $data->delete();

        return redirect()->route('data_pengadaan')->with('success', 'Data Pengadaan berhasil dihapus!');
    }
}