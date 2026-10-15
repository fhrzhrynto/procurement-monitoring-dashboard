<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pengadaan - PLN Icon Plus</title>
    
    @extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header text-white text-center font-weight-bold" style="background-color: #3f51b5;">
            <h5 class="mb-0">Data Pengadaan</h5>  
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

            <!-- Search and Filter Section -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <form action="{{ route('data_pengadaan') }}" method="GET">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Cari nama pengadaan..." 
                                           name="search" value="{{ request('search') }}">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-primary" type="submit">
                                            <i class="fa fa-search"></i> Cari
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <select name="has_document" class="form-control">
                                    <option value="">-- Filter Dokumen --</option>
                                    <option value="tor" {{ request('has_document') == 'tor' ? 'selected' : '' }}>Memiliki TOR</option>
                                    <option value="rab" {{ request('has_document') == 'rab' ? 'selected' : '' }}>Memiliki RAB</option>
                                    <option value="sph" {{ request('has_document') == 'sph' ? 'selected' : '' }}>Memiliki SPH</option>
                                    <option value="bcr" {{ request('has_document') == 'bcr' ? 'selected' : '' }}>Memiliki BCR</option>
                                    <option value="nodin" {{ request('has_document') == 'nodin' ? 'selected' : '' }}>Memiliki NODIN</option>
                                    <option value="all" {{ request('has_document') == 'all' ? 'selected' : '' }}>Lengkap Semua Dokumen</option>
                                </select>
                            </div>
                            
                            <div class="col-md-2">
                                <div class="d-flex justify-content-between">
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                    @if(request('search') || request('has_document'))
                                        <a href="{{ route('data_pengadaan') }}" class="btn btn-secondary ml-2">Reset</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Admin Actions -->
            <div class="row mb-3">
                <div class="col-md-12">
                    @if(Auth::check() && Auth::user()->role == 1)
                    <a href="{{ route('data_pengadaan.create') }}" class="btn btn-primary">
                        <i class="fa fa-plus"></i> Tambah Data Pengadaan
                    </a>
                    @endif
                </div>
            </div>

            <!-- Results Information -->
            @if(request('search') || request('has_document'))
            <div class="alert alert-info">
                <p class="mb-0">
                    <strong>Hasil Filter:</strong> Menampilkan {{ $dataPengadaan->count() }} data pengadaan
                    @if(request('search'))
                    dengan kata kunci "{{ request('search') }}"
                    @endif
                    @if(request('has_document'))
                    @if(request('has_document') == 'all')
                    yang memiliki semua dokumen lengkap
                    @else
                    yang memiliki dokumen {{ strtoupper(request('has_document')) }}
                    @endif
                    @endif
                </p>
            </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-primary">
                        <tr class="text-center align-middle">
                            <th>No</th>
                            <th>Nama Pengadaan</th>
                            <th>TOR</th>
                            <th>RAB</th>
                            <th>SPH</th>
                            <th>BCR</th>
                            <th>NODIN</th>

                            @if(Auth::check() && Auth::user()->role == 1)
                            <th>Aksi</th>
                            @endif

                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($dataPengadaan as $index => $item)
                        <tr class="align-middle">
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $item->nama_pengadaan }}</td>
                            <td class="text-center">
                                @if($item->tor)
                                    <a href="{{ asset('storage/' . $item->tor) }}" target="_blank" class="btn btn-info btn-sm">Lihat</a>
                                @else
                                    <span class="badge bg-secondary text-white">Tidak Ada</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($item->rab)
                                    <a href="{{ asset('storage/' . $item->rab) }}" target="_blank" class="btn btn-info btn-sm">Lihat</a>
                                @else
                                    <span class="badge bg-secondary text-white">Tidak Ada</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($item->sph)
                                    <a href="{{ asset('storage/' . $item->sph) }}" target="_blank" class="btn btn-info btn-sm">Lihat</a>
                                @else
                                    <span class="badge bg-secondary text-white">Tidak Ada</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($item->bcr)
                                    <a href="{{ asset('storage/' . $item->bcr) }}" target="_blank" class="btn btn-info btn-sm">Lihat</a>
                                @else
                                    <span class="badge bg-secondary text-white">Tidak Ada</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($item->nodin)
                                    <a href="{{ asset('storage/' . $item->nodin) }}" target="_blank" class="btn btn-info btn-sm">Lihat</a>
                                @else
                                    <span class="badge bg-secondary text-white">Tidak Ada</span>
                                @endif
                            </td>

                            @if(Auth::check() && Auth::user()->role == 1)
                            <td class="text-center">
                                <a href="{{ route('data_pengadaan.edit', $item->id) }}" class="btn btn-warning btn-sm">
                                    <i class="fa fa-edit"></i> Edit
                                </a>
                                
                                <form id="delete-form-{{ $item->id }}" action="{{ route('data_pengadaan.destroy', $item->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete('{{ $item->id }}')">
                                        <i class="fa fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                            @endif
                            
                        </tr>
                        @empty
                        <tr>
                            <td colspan="{{ Auth::check() && Auth::user()->role == 1 ? '8' : '7' }}" class="text-center">
                                <div class="alert alert-warning mb-0">
                                    Tidak ada data pengadaan ditemukan
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div> <!-- End of table-responsive -->
        </div> <!-- End of card-body -->
    </div> <!-- End of card -->
</div> <!-- End of container -->

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmDelete(id) {
    Swal.fire({
        title: "Hapus Data?",
        text: "Data yang dihapus tidak bisa dikembalikan!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Ya, hapus!",
        cancelButtonText: "Batal"
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit(); // Submit form penghapusan
        }
    });
}
</script>
@endsection




<style>
    .card-header {
    background-color: #3f51b5 !important;
    color: white;
    text-align: center;
    border-top-left-radius: 20px;
    border-top-right-radius: 20px;
    padding: 15px;
    font-weight: bold;
}

.card-header h4, .card-header h5 {
    /* font-size: 1.5rem; Ukuran teks seragam */
    font-weight: bold; /* Teks dibuat tebal */
    margin: 0; /* Menghilangkan margin agar rata tengah sempurna */
}

</style>