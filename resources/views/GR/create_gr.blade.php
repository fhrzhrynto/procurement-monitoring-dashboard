@extends('layouts.app')

@section('title', 'Tambah Monitoring GR - PLN Icon Plus')
@section('content')
<div class="container">
    <div class="card shadow-lg bg-white card-custom">
        <!-- Header Card -->
        <div class="card-header text-white text-center fw-bold">
            <h5 class="fw-bold m-0">Tambah Monitoring GR</h5>
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

            <form method="POST" action="{{ route('monitoring_gr.store') }}">
                @csrf

                <!-- No. PO -->
                <div class="mb-3">
                    <label for="no_po" class="form-label"><strong>No. PO</strong></label>
                    <select class="form-select" id="no_po" name="no_po" required onchange="updateJudul()">
                        <option value="">-- Pilih No. PO --</option>
                        @foreach ($pengadaans as $item)
                            <option value="{{ $item->no_po }}" data-judul="{{ $item->nama }}">{{ $item->no_po }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Judul -->
                <div class="mb-3">
                    <label for="judul" class="form-label"><strong>Judul</strong></label>
                    <input type="text" class="form-control" id="judul" name="judul" readonly required>
                </div>

                <!-- No. GR -->
                <div class="mb-3">
                    <label for="no_gr" class="form-label"><strong>No. GR</strong></label>
                    <input type="text" class="form-control" id="no_gr" name="no_gr" required>
                </div>

                <!-- Nilai GR -->
                <div class="mb-3">
                    <label for="nilai_gr" class="form-label"><strong>Nilai GR (Rp)</strong></label>
                    <input type="number" class="form-control" id="nilai_gr" name="nilai_gr" required>
                </div>

                <!-- Buttons -->
                <div class="d-flex justify-content-between">
                    <a href="{{ route('monitoring_gr.index') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function updateJudul() {
        const select = document.getElementById('no_po');
        const selectedOption = select.options[select.selectedIndex];
        const judul = selectedOption.getAttribute('data-judul') || '';
        document.getElementById('judul').value = judul;
    }
</script>
@endsection

<style>
.card-custom {
    max-width: 900px;
    margin: auto;
    border-radius: 20px;
    background: #ffffff;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
    overflow: hidden;
}
.card-header {
    background-color: #3f51b5 !important;
    color: white;
    text-align: center;
    border-top-left-radius: 20px;
    border-top-right-radius: 20px;
    padding: 15px;
    font-weight: bold;
}
.card-header h4,
.card-header h5 {
    font-size: 1.25rem;
}
.form-label {
    font-weight: bold;
    color: #495057;
}
.form-control,
.form-select {
    border-radius: 8px;
    padding: 10px;
    font-size: 16px;
}
.form-control:focus,
.form-select:focus {
    border-color: #198754;
    box-shadow: 0 0 5px rgba(25, 135, 84, 0.5);
}
.btn {
    font-size: 16px;
    padding: 10px 15px;
    border-radius: 8px;
}
.btn-secondary {
    background-color: #6c757d;
    border-color: #6c757d;
}
.btn-primary {
    background-color: #3f51b5;
    border: none;
    color: white;
    font-weight: bold;
    padding: 10px 20px;
    border-radius: 10px;
}
.btn-primary:hover {
    background-color: #2E6BE7 !important;
}
</style>
