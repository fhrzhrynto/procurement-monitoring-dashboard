@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Plan Pengajuan</h2>

    <form action="{{ route('persiapan_pengadaan.plan.update', $plan->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="proyek_id">Proyek</label>
            <select name="proyek_id" id="proyek_id" class="form-control @error('proyek_id') is-invalid @enderror" required>
                <option value="">-- Pilih Proyek --</option>
                @foreach($proyek as $p)
                    <option value="{{ $p->id }}" {{ $plan->proyek_id == $p->id ? 'selected' : '' }}>
                        {{ $p->nama_proyek }}
                    </option>
                @endforeach
            </select>
            @error('proyek_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="id_plan">ID Plan</label>
            <input type="text" name="id_plan" class="form-control @error('id_plan') is-invalid @enderror" value="{{ $plan->id_plan }}" required>
            @error('id_plan')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Update Plan</button>
        <a href="{{ route('persiapan_pengadaan') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
