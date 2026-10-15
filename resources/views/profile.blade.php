<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - PLN Icon Plus</title>
    
    @extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <!-- Profile Sidebar -->
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-body text-center">
                    <div class="position-relative mb-3 mx-auto" style="width: 150px; height: 150px;">
                        @if($user->profile_photo ?? false)
                            <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="Profile Picture" 
                                class="rounded-circle img-fluid" style="width: 150px; height: 150px; object-fit: cover;">
                        @else
                            <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center text-white" 
                                style="width: 150px; height: 150px; font-size: 3rem;">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                        @endif
                        <div class="position-absolute bottom-0 end-0">
                            <button class="btn btn-sm btn-primary rounded-circle" data-bs-toggle="modal" data-bs-target="#uploadPhotoModal">
                                <i class="fas fa-camera"></i>
                            </button>
                        </div>
                    </div>
                    <h5 class="my-3" style="font-family: 'Poppins', sans-serif; font-weight: 600;">{{ $user->name }}</h5>
                    <p class="text-muted mb-1">{{ $user->role == 1 ? 'Administrator' : 'User' }}</p>
                    <p class="text-muted mb-4">{{ $user->department ?? 'Department not set' }}</p>
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                            <a href="{{ route('profile') }}" class="text-decoration-none text-primary">
                                <i class="fas fa-user me-2"></i> My Profile
                            </a>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                            <a href="#" class="text-decoration-none text-dark" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                                <i class="fas fa-lock me-2"></i> Change Password
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Profile Content -->
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                        <i class="fas fa-user-circle me-2"></i> Profile Information
                    </h5>
                    <button id="editProfileBtn" class="btn btn-primary">
                        <i class="fas fa-edit me-1"></i> Edit Profile
                    </button>
                </div>
                <div class="card-body">
                    <form id="profileForm" action="{{ route('profile.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Full Name</h6>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="name" value="{{ $user->name }}" disabled>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Email</h6>
                            </div>
                            <div class="col-sm-9">
                                <input type="email" class="form-control" name="email" value="{{ $user->email }}" disabled>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Phone</h6>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="phone" value="{{ $user->phone ?? '' }}" disabled>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Department</h6>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="department" value="{{ $user->department ?? '' }}" disabled>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Job Title</h6>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="job_title" value="{{ $user->job_title ?? '' }}" disabled>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Member Since</h6>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0">{{ optional($user->birthdate)->format('d-m-Y') }}
                                </p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Last Login</h6>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0">{{ $user->last_login ?? 'Never' }}</p>
                            </div>
                        </div>
                        <div class="row" id="actionButtons" style="display: none;">
                            <div class="col-sm-3"></div>
                            <div class="col-sm-9">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i> Save Changes
                                </button>
                                <button type="button" class="btn btn-secondary" id="cancelEdit">
                                    <i class="fas fa-times me-1"></i> Cancel
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                        <i class="fas fa-shield-alt me-2"></i> Account Security
                    </h5>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-4">Secure your account with strong password and two-factor authentication</p>
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Password</h6>
                        </div>
                        <div class="col-sm-9 d-flex align-items-center">
                            <span class="text-muted me-3">••••••••</span>
                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                                <i class="fas fa-edit me-1"></i> Change
                            </button>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Two-factor Authentication</h6>
                        </div>
                        <div class="col-sm-9 d-flex align-items-center">
                            <span class="text-danger me-3">Not enabled</span>
                            <button class="btn btn-sm btn-outline-success">
                                <i class="fas fa-lock me-1"></i> Enable
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Upload Photo Modal -->
<div class="modal fade" id="uploadPhotoModal" tabindex="-1" aria-labelledby="uploadPhotoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadPhotoModalLabel">Upload Profile Photo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('profile.photo.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="profilePhoto" class="form-label">Choose Photo</label>
                        <input type="file" class="form-control" id="profilePhoto" name="profile_photo" accept="image/*" required>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Change Password Modal -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('password.update') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="currentPassword" class="form-label">Current Password</label>
                        <input type="password" class="form-control" id="currentPassword" name="current_password" required>
                    </div>
                    <div class="mb-3">
                        <label for="newPassword" class="form-label">New Password</label>
                        <input type="password" class="form-control" id="newPassword" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirmPassword" class="form-label">Confirm New Password</label>
                        <input type="password" class="form-control" id="confirmPassword" name="password_confirmation" required>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
    
    body {
        background-color: #f8f9fa;
    }
    
    .card {
        border: none;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        margin-bottom: 1.5rem;
        transition: all 0.3s ease;
    }
    
    .card:hover {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }
    
    .card-header {
        padding: 1rem 1.25rem;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }
    
    .btn-primary {
        background-color: #3f51b5;
        border-color: #3f51b5;
    }
    
    .btn-primary:hover {
        background-color: #303f9f;
        border-color: #303f9f;
    }
    
    .list-group-item {
        border: none;
        padding: 0.75rem 1.25rem;
    }
    
    .list-group-item:hover {
        background-color: #f8f9fa;
    }
    
    .form-control:focus {
        border-color: #3f51b5;
        box-shadow: 0 0 0 0.25rem rgba(63, 81, 181, 0.25);
    }
    
    h5, h6 {
        font-family: 'Poppins', sans-serif;
    }
    
    .text-primary {
        color: #3f51b5 !important;
    }
</style>
@endsection


<script defer>
       document.addEventListener('DOMContentLoaded', function() {
    console.log("JavaScript Loaded");

    const editProfileBtn = document.getElementById('editProfileBtn');
    const cancelEdit = document.getElementById('cancelEdit');
    const actionButtons = document.getElementById('actionButtons');
    const inputs = document.querySelectorAll('#profileForm input:not([name="email"])'); // Semua input kecuali email
    const profileForm = document.getElementById('profileForm');

    if (!editProfileBtn || !cancelEdit || !actionButtons || !profileForm) {
        console.error("Some required elements not found!");
        return;
    }

    // Enable editing (except email)
    editProfileBtn.addEventListener('click', function(event) {
        event.preventDefault();
        console.log("Edit Profile Clicked");

        inputs.forEach(input => input.disabled = false); // Aktifkan semua input kecuali email
        actionButtons.style.display = 'flex';
        editProfileBtn.style.display = 'none';
    });

    // Cancel editing
    cancelEdit.addEventListener('click', function(event) {
        event.preventDefault();
        console.log("Cancel Edit Clicked");

        inputs.forEach(input => input.disabled = true); // Nonaktifkan kembali input
        actionButtons.style.display = 'none';
        editProfileBtn.style.display = 'block';
        profileForm.reset(); // Reset form ke nilai awal
    });
});

    </script>
