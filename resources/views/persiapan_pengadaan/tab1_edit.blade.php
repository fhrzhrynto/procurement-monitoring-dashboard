@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">Edit Proyek</h3>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('proyek.update', $proyek->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nama_proyek" class="form-label">Nama Proyek</label>
            <input type="text" name="nama_proyek" class="form-control" value="{{ old('nama_proyek', $proyek->nama_proyek) }}" required>
        </div>

        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea name="deskripsi" class="form-control" rows="3">{{ old('deskripsi', $proyek->deskripsi) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="start_date" class="form-label">Start Date</label>
            <input type="date" name="start_date" class="form-control" value="{{ old('start_date', $proyek->start_date) }}" required>
        </div>

        <div class="mb-3">
            <label for="target_date" class="form-label">Target Date</label>
            <input type="date" name="target_date" class="form-control" value="{{ old('target_date', $proyek->target_date) }}" required>
        </div>

        <div class="mb-3">
            <label for="progress" class="form-label">Keterangan Update Terakhir</label>
            <textarea name="progress" class="form-control" rows="2">{{ old('progress', $proyek->progress) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('persiapan_pengadaan') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
