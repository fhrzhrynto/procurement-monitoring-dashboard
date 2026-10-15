<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User - PLN Icon Plus</title>
    
    @extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header text-white text-center">
                    <h4>Edit User</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('users.update', $user->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user->name }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="password-confirm" class="form-label">Konfirmasi Password</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                                <select id="role" name="role" class="form-select" required>
                                    <option value="0" {{ $user->role == 0 ? 'selected' : '' }}>Visitor</option>
                                    <option value="1" {{ $user->role == 1 ? 'selected' : '' }}>Admin</option>
                                </select>
                            </div>
                        </div>

                        <div class="text-center">
                            <a href="{{ route('daftaruser') }}" class="btn btn-secondary">Kembali</a>
                            </a>
                            
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fas fa-save"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


<style>
/* Styling untuk Card */
.card {
    border-radius: 10px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
}

/* Header Card */
.card-header {
    background-color: #3f51b5 !important;
    color: white !important;
    text-align: center;
    font-size: 1.2rem;
    font-weight: bold;
    padding: 15px;
    border-radius: 10px 10px 0 0;
}

/* Input Group Styling */
.input-group-text {
    background-color: #3f51b5;
    color: white;
    border: none;
}

.input-group .form-control {
    border-left: none;
}

/* Tombol Simpan */
.btn-primary {
    background-color: #28a745;
    border: none;
    padding: 10px 20px;
    font-size: 1rem;
    border-radius: 5px;
    transition: 0.3s;
}

.btn-primary:hover {
    background-color: #218838;
}

/* Responsif */
@media (max-width: 768px) {
    .container {
        padding: 10px;
    }
}

.text-center {
    display: flex;
    justify-content: space-between;
}

.btn-secondary {
    background-color: #6c757d;
    border: none;
    padding: 10px 20px;
    font-size: 1rem;
    border-radius: 5px;
    transition: 0.3s;
}

.btn-secondary:hover {
    background-color: #5a6268;
}

</style>