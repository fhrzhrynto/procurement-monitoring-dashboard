<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar User - PLN Icon Plus</title>
    
    @extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="card mb-4 border-0 shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Daftar User</h5>
            <a href="{{ route('users.add') }}" class="btn btn-light">Tambah User</a>
        </div>

        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Filter dan Pencarian -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <form method="GET" action="{{ route('daftaruser') }}" class="d-flex gap-2 align-items-center">
                        <input type="text" name="search" placeholder="Cari berdasarkan nama"
                            value="{{ request('search') }}" class="form-control" style="width: 250px;" />
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Cari
                        </button>
                        <a href="{{ route('daftaruser') }}" class="btn btn-secondary">
                            <i class="fas fa-sync-alt"></i> Reset
                        </a>
                    </form>
                </div>
            </div>

            <!-- Nav Tabs -->
            <ul class="nav nav-tabs mb-3" id="userTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="all-tab" data-bs-toggle="tab" data-bs-target="#all-users" type="button" role="tab" aria-controls="all-users" aria-selected="true">Semua User</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="admin-tab" data-bs-toggle="tab" data-bs-target="#admin-users" type="button" role="tab" aria-controls="admin-users" aria-selected="false">Admin</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="visitor-tab" data-bs-toggle="tab" data-bs-target="#visitor-users" type="button" role="tab" aria-controls="visitor-users" aria-selected="false">Visitor</button>
                </li>
            </ul>

            <!-- Tab Content -->
            <div class="tab-content" id="userTabsContent">
                <!-- Semua User -->
                <div class="tab-pane fade show active" id="all-users" role="tabpanel" aria-labelledby="all-tab">
                    @include('users.partials.user_table', ['userList' => $users])
                </div>

                <!-- Admin -->
                <div class="tab-pane fade" id="admin-users" role="tabpanel" aria-labelledby="admin-tab">
                    @include('users.partials.user_table', ['userList' => $users->where('role', 1)])
                </div>

                <!-- Visitor -->
                <div class="tab-pane fade" id="visitor-users" role="tabpanel" aria-labelledby="visitor-tab">
                    @include('users.partials.user_table', ['userList' => $users->where('role', 0)])
                </div>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $users->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>



<!-- Tambahkan SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Saat klik tab, simpan hash di URL
        document.querySelectorAll('[data-bs-toggle="tab"]').forEach(function (tab) {
            tab.addEventListener('shown.bs.tab', function (e) {
                let id = e.target.getAttribute('data-bs-target');
                history.replaceState(null, null, id);
            });
        });

        // Saat halaman dimuat, cek hash di URL
        let hash = window.location.hash;
        if (hash) {
            let targetTab = document.querySelector('[data-bs-target="' + hash + '"]');
            if (targetTab) {
                let tabInstance = bootstrap.Tab.getOrCreateInstance(targetTab);
                tabInstance.show();
            }
        }
    });
</script>


<style>
    /* Custom styling to match your theme */
    .card-header {
        background: linear-gradient(135deg, #2c52b3 0%, #3a67c9 100%);
    }
    
    .table th {
        font-weight: 600;
    }
    
    .nav-tabs .nav-link {
        color: #495057;
        border-radius: 0;
        padding: 10px 20px;
    }
    
    .nav-tabs .nav-link.active {
        font-weight: bold;
        border-bottom: 3px solid #2c52b3;
    }
    
    .badge {
        font-weight: 500;
        padding: 6px 10px;
    }
    
    .btn-sm {
        padding: 0.25rem 0.5rem;
    }
    
    .table-responsive {
        border-radius: 5px;
        overflow: hidden;
    }
    
    .table-hover tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.05);
    }
</style>
@endsection
    
    
<style> 
    /* General Styles */
body {
    font-family: 'Poppins', sans-serif;
    background-color: #f8f9fa;
    color: #333;
}

.container {
    margin-top: 20px;
}

.card {
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.card-header {
    background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
    color: #fff;
    font-weight: bold;
    border-top-left-radius: 8px;
    border-top-right-radius: 8px;
}

.card-body {
    background-color: #fff;
    padding: 20px;
}

/* Table Styles */
.table {
    border-collapse: separate;
    border-spacing: 0 10px;
}

.table thead {
    background-color: #1e3c72;
    color: white;
    border-radius: 8px;
}

.table thead th {
    padding: 12px;
    text-align: center;
}

.table tbody tr {
    background-color: #fff;
    transition: all 0.3s;
}

.table tbody tr:hover {
    background-color: #f1f1f1;
}

.table td {
    text-align: center;
    vertical-align: middle;
    padding: 12px;
    border-radius: 5px;
}

/* Buttons */
.btn {
    border-radius: 5px;
    transition: all 0.3s ease;
}

.btn-primary {
    background-color: #007bff;
    border: none;
}

.btn-primary:hover {
    background-color: #0056b3;
}

.btn-warning {
    background-color: #ffc107;
    border: none;
}

.btn-warning:hover {
    background-color: #e0a800;
}

.btn-danger {
    background-color: #dc3545;
    border: none;
}

.btn-danger:hover {
    background-color: #c82333;
}

h4 {
    color: white !important;
}

.card-header span {
    color: white !important;
}

/* Responsive Design */
@media (max-width: 768px) {
    .table-responsive {
        overflow-x: auto;
    }
}

</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Saat klik tab, simpan hash di URL
    $('[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
    let id = $(e.target).attr('data-bs-target');
    history.replaceState(null, null, id);
    });

    // Saat halaman dimuat, cek hash di URL
    $(document).ready(function () {
        let hash = window.location.hash;
        if (hash) {
            let targetTab = $('[data-bs-target="' + hash + '"]');
            if (targetTab.length) {
                let tabInstance = bootstrap.Tab.getOrCreateInstance(targetTab[0]);
                tabInstance.show();
            }
        }
    })
</script>
