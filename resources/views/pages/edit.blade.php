@extends('layouts.app')

@section('title', 'Edit Pengadaan')

@section('content')
<div class="container d-flex justify-content-center">
    <div class="card shadow-lg bg-white card-custom w-75">
        <div class="card-header text-white text-center fw-bold" style="background-color: #3f51b5;">
            <h5 class="fw-bold m-0">Edit Pengadaan</h5>
        </div>

        <div class="card-body d-flex flex-column">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('pengadaan.update', $pengadaan->id) }}" method="POST" class="flex-grow-1">
                @csrf
                @method('PUT')

                <div class="mb-2">
                    <label class="form-label">No Kontrak</label>
                    <input type="text" name="no_kontrak" class="form-control" value="{{ old('no_kontrak', $pengadaan->no_kontrak) }}" required>
                </div>

                <div class="mb-2">
                    <label class="form-label">No PO</label>
                    <input type="text" name="no_po" class="form-control" value="{{ old('no_po', $pengadaan->no_po) }}">
                </div>

                <div class="mb-2">
                    <label class="form-label">Nama</label>
                    <input type="text" name="nama" class="form-control" value="{{ old('nama', $pengadaan->nama) }}">
                </div>

                <div class="mb-2">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control" required>
                        @foreach(['Diajukan Staf','Disetujui VP','Di Keuangan','Di Pengadaan','Di Legal','Selesai','Batal'] as $status)
                            <option value="{{ $status }}" {{ old('status', $pengadaan->status) == $status ? 'selected' : '' }}>
                                {{ $status }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-2">
                    <label class="form-label">Total Kontrak</label>
                    <input type="number" name="total_kontrak" class="form-control" value="{{ old('total_kontrak', $pengadaan->total_kontrak) }}">
                </div>

                <div class="mb-2">
                    <label class="form-label">Start Date</label>
                    <input type="date" name="start_date" class="form-control" value="{{ old('start_date', $pengadaan->start_date) }}">
                </div>

                <div class="mb-2">
                    <label class="form-label">End Date</label>
                    <input type="date" name="end_date" class="form-control" value="{{ old('end_date', $pengadaan->end_date) }}">
                </div>

                <div class="mb-2">
                    <label class="form-label">Penagihan  (Angka/Numerik)</label>
                    <input type="text" name="penagihan" class="form-control" value="{{ old('penagihan', $pengadaan->penagihan) }}">
                </div>

                <div class="d-flex justify-content-between align-items-center mt-3">
                    <a href="{{ route('monitoring_pengadaan') }}" class="btn btn-secondary px-4 rounded-pill">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">
                        Simpan Perubahan <i class="fas fa-save"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
