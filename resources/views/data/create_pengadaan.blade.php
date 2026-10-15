<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Pengadaan - PLN Icon Plus</title>
    
    @extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow-lg bg-white card-custom">
        <!-- Header Card -->
        <div class="card-header text-white text-center fw-bold">
            <h5 class="fw-bold m-0">Tambah Data Pengadaan</h5>
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

            <form action="{{ route('data_pengadaan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="nama_pengadaan" class="form-label"><strong>Nama Pengadaan</strong></label>
                    <input type="text" class="form-control" id="nama_pengadaan" name="nama_pengadaan" required>
                </div>
                
                <h5 class="mt-4">Unggah File Baru:</h5>
                <div class="mb-3 p-3 border rounded bg-light">
                    <label class="form-label"><strong>TOR (PDF)</strong></label>
                    <input type="file" class="form-control" name="tor" accept="application/pdf">
                </div>
                
                <div class="mb-3 p-3 border rounded bg-light">
                    <label class="form-label"><strong>RAB (PDF)</strong></label>
                    <input type="file" class="form-control" name="rab" accept="application/pdf">
                </div>
                
                <div class="mb-3 p-3 border rounded bg-light">
                    <label class="form-label"><strong>SPH (PDF)</strong></label>
                    <input type="file" class="form-control" name="sph" accept="application/pdf">
                </div>
                
                <div class="mb-3 p-3 border rounded bg-light">
                    <label class="form-label"><strong>BCR (PDF)</strong></label>
                    <input type="file" class="form-control" name="bcr" accept="application/pdf">
                </div>
                
                <div class="mb-3 p-3 border rounded bg-light">
                    <label class="form-label"><strong>NODIN (PDF)</strong></label>
                    <input type="file" class="form-control" name="nodin" accept="application/pdf">
                </div>
                
                <div class="d-flex justify-content-between">
                    <a href="{{ route('data_pengadaan') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>                
            </form>
        </div> <!-- End Card Body -->
    </div> <!-- End Card -->
</div>
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

    .card-header h4 {
        font-size: 1.25rem; /* Ukuran teks disamakan */
    }

    .form-label {
        font-weight: bold;
        color: #495057;
    }

    .form-control {
        border-radius: 8px;
        padding: 10px;
        font-size: 16px;
    }

    .form-control:focus {
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
