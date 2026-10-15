@extends('layouts.app')

@section('title', 'Tambah Kontrak Pengadaan')

@section('content')
<div class="container">
    <div class="card shadow-lg bg-white card-custom">
        <!-- Header Card -->
        <div class="card-header text-white text-center fw-bold">
            <h5 class="fw-bold m-0">Tambah Kontrak Pengadaan</h5>
        </div>

        <!-- Body Card -->
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

            {{-- Menampilkan pesan error jika ada --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('pengadaan.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="no_kontrak" class="form-label fw-bold">No. Kontrak</label>
                    <input type="text" name="no_kontrak" id="no_kontrak" class="form-control @error('no_kontrak') is-invalid @enderror" value="{{ old('no_kontrak') }}" required>
                    @error('no_kontrak')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="no_po" class="form-label fw-bold">No. PO</label>
                    <input type="text" name="no_po" id="no_po" class="form-control @error('no_po') is-invalid @enderror" value="{{ old('no_po') }}" required>
                    @error('no_po')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="nama" class="form-label fw-bold">Nama Kontrak</label>
                    <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}" required>
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label fw-bold">Status</label>
                    <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                        <option value="Diajukan Staf">Diajukan Staf</option>
                        <option value="Disetujui VP">Disetujui VP</option>
                        <option value="Di Keuangan">Di Keuangan</option>
                        <option value="Di Pengadaan">Di Pengadaan</option>
                        <option value="Di Legal">Di Legal</option>
                        <option value="Selesai">Selesai</option>
                        <option value="Batal">Batal</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="total_kontrak" class="form-label fw-bold">Total Kontrak</label>
                    <input type="number" name="total_kontrak" id="total_kontrak" class="form-control @error('total_kontrak') is-invalid @enderror" value="{{ old('total_kontrak') }}" required>
                    @error('total_kontrak')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="start_date" class="form-label fw-bold">Tanggal Mulai</label>
                    <input type="date" name="start_date" id="start_date" class="form-control @error('start_date') is-invalid @enderror" value="{{ old('start_date') }}" required>
                    @error('start_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="end_date" class="form-label fw-bold">Tanggal Selesai</label>
                    <input type="date" name="end_date" id="end_date" class="form-control @error('end_date') is-invalid @enderror" value="{{ old('end_date') }}" required>
                    @error('end_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="penagihan" class="form-label fw-bold">Penagihan (Angka/Numerik)</label>
                    <input type="text" name="penagihan" id="penagihan" class="form-control @error('penagihan') is-invalid @enderror" value="{{ old('penagihan') }}" required>
                    @error('penagihan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('monitoring_pengadaan') }}" class="btn btn-secondary">
                        <span class="small">Batal</span>
                    </a>
                    <button type="submit" class="btn btn-primary" style="background-color: #3f51b5;">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

<style>
    /* Variabel untuk radius card */
    :root {
        --radius-card: 20px; /* Bisa diubah sesuai kebutuhan */
    }

    /* Agar card serasi dengan tampilan edit */
    .card-custom {
        max-width: 800px;
        margin: auto;
        border-radius: var(--radius-card);
        background: #ffffff;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        overflow: hidden;
    }

    .card-header {
        background-color: #3f51b5 !important;
        color: white;
        text-align: center;
        border-top-left-radius: var(--radius-card);
        border-top-right-radius: var(--radius-card);
        padding: 15px;
        font-weight: bold;
    }

    .form-label {
        font-weight: bold;
    }

    .btn-primary {
        background-color: #3f51b5 !important;
        border: none;
    }

    .btn-primary:hover {
        background-color: #303f9f !important;
    }

    /* Ukuran lebih kecil untuk teks "Tambah Pengadaan" */
    .card-header h5 {
        font-size: 1.25rem; /* Ukuran lebih kecil dari h2 */
    }
</style>
