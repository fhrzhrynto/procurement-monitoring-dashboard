<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Pengadaan - PLN Icon Plus</title>
    
    @extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow-lg rounded-4 bg-white" style="max-width: 1200px; margin: auto;">
        <div class="card-header bg-primary text-white text-center rounded-top">
            <h5 class="fw-bold m-0">Edit Data Pengadaan</h5>
        </div>

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

            <form action="{{ route('data_pengadaan.update', $dataPengadaan->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="form-label fw-bold">Nama Pengadaan</label>
                    <input type="text" name="nama_pengadaan" class="form-control rounded-3" value="{{ $dataPengadaan->nama_pengadaan }}" required>
                </div>

                <p class="fw-bold fs-5 text-primary">Unggah File Baru:</p>

                @foreach (['tor', 'rab', 'sph', 'bcr', 'nodin'] as $file)
                    <div class="mb-3 p-3 border rounded-4 bg-light shadow-sm file-container">
                        <label class="form-label fw-bold text-uppercase text-dark">{{ strtoupper($file) }} (PDF)</label>
                        <div class="d-flex align-items-center">
                            <input type="file" name="{{ $file }}" class="form-control rounded-3 file-input">

                            @if($dataPengadaan->$file)
                                <button type="button" class="btn btn-danger btn-sm ms-2 delete-btn"
                                    onclick="confirmDeleteFile(this, '{{ $file }}')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            @endif
                        </div>

                        @if($dataPengadaan->$file)
                            <div class="mt-2 file-link">
                                <a href="{{ asset('storage/' . $dataPengadaan->$file) }}" target="_blank" class="text-decoration-none text-primary fw-bold">
                                    📝 Lihat {{ strtoupper($file) }}
                                </a>
                            </div>
                        @endif

                        <input type="hidden" name="delete_{{ $file }}" value="0">
                    </div>
                @endforeach

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('data_pengadaan') }}" class="btn btn-secondary rounded-pill px-4">
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmDeleteFile(button, file) {
    Swal.fire({
        title: "Hapus File?",
        text: "File akan dihapus secara permanen!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Ya, hapus!",
        cancelButtonText: "Batal"
    }).then((result) => {
        if (result.isConfirmed) {
            let parentDiv = button.closest('.file-container'); 
            let inputHidden = parentDiv.querySelector(`[name="delete_${file}"]`);
            let fileLink = parentDiv.querySelector('.file-link');
            let trashButton = parentDiv.querySelector('.delete-btn');

            inputHidden.value = "1";
            
            if (fileLink) fileLink.remove();
            if (trashButton) trashButton.remove();
        }
    });
}
</script>
@endsection


<style>
    .file-input {
        transition: all 0.3s ease-in-out;
    }
    
    .file-input:hover {
        background-color: #eef5ff;
        border-color: #007bff;
    }

    .delete-btn {
        transition: all 0.2s ease-in-out;
    }

    .delete-btn:hover {
        background-color: #dc3545;
        box-shadow: 0px 0px 8px rgba(220, 53, 69, 0.6);
    }

    .card {
        max-width: 1200px;
        margin: auto;
        border-radius: 15px;
        background: #ffffff;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
    }

    .card-header {
        background-color: #3f51b5 !important;
        color: white;
        text-align: center;
        border-top-left-radius: 15px;
        border-top-right-radius: 15px;
        padding: 15px;  
        font-weight: bold;
    }

    .card-header h2 {
        margin: 0;
        font-size: 24px;
        font-weight: 700;
    }

    .card:hover {
        box-shadow: 0px 6px 15px rgba(0, 0, 0, 0.3);
    }
</style>

