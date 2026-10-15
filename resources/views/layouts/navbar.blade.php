<nav class="navbar" style="background-color: #3f51b5;">
    <div class="container-fluid">
        <span class="custom-title">
            @if (Route::is('dashboard'))
                Dashboard
            @elseif (Route::is('users.add*'))
                Tambah User
            @elseif (Route::is('profile'))
                Pengaturan
            @elseif (Route::is('daftaruser*'))
                Daftar User
            @elseif (Route::is('users.edit*'))  
                Edit User
            @elseif (Route::is('monitoring_pengadaan') || Route::is('pengadaan.create') || Route::is('pengadaan.edit'))
                Monitoring Pengadaan
            @elseif (Route::is('data_pengadaan') || Route::is('data_pengadaan.create') || Route::is('data_pengadaan.edit'))
                Data Pengadaan
            @else
                Dashboard
            @endif
        </span>
        
        <div class="profile" id="userProfile">
            <div class="profile-image">
                <img 
                    src="{{ Auth::user()->profile_photo ? asset('storage/' . Auth::user()->profile_photo) : asset('img/admin.png') }}" 
                    alt="Profile Picture"
                    class="rounded-circle"
                    style="width: 40px; height: 40px; object-fit: cover;"
                >
            </div>
            <div class="profile-info">
                <h6 class="user-name">{{ Auth::user()->name ?? 'Admin User' }}</h6>
                <span class="user-role">
                    {{ Auth::user()->role == 1 ? 'Administrator' : 'Visitor' }}
                </span>
            </div>

            <!-- Ikon dropdown -->
            <i class="fas fa-chevron-down dropdown-icon"></i>
            
            <div class="dropdown-menu" id="profileDropdown">
                <a class="dropdown-item" href="{{ route('profile') }}">
                    <i class="fas fa-user-cog"></i> Account Settings
                </a>
                <div class="dropdown-divider"></div>
                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                    @csrf
                </form>
                <a class="dropdown-item text-danger" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </div>
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const profile = document.getElementById('userProfile');
        const dropdown = document.getElementById('profileDropdown');
    
        if (profile && dropdown) {
            profile.addEventListener('click', function(e) {
                const isOpen = dropdown.classList.contains('show');
    
                if (isOpen) {
                    dropdown.classList.remove('show');
                    profile.classList.remove('active');
                } else {
                    dropdown.classList.add('show');
                    profile.classList.add('active');
                }
    
                e.stopPropagation();
            });
    
            document.addEventListener('click', function(e) {
                if (!profile.contains(e.target) && !dropdown.contains(e.target)) {
                    dropdown.classList.remove('show');
                    profile.classList.remove('active');
                }
            });
    
            dropdown.addEventListener('click', function(e) {
                if (!e.target.classList.contains('text-danger') && !e.target.closest('.text-danger')) {
                    e.stopPropagation();
                }
            });
        }
    });
    </script>

<style>
    .custom-title {
        font-size: 24px;
        font-weight: bold;
        text-transform: capitalize;
    }

    /* Navbar Styles */
    .navbar {
        padding: 0.75rem 1rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        display: flex;
        align-items: center;
        border-radius: 5px;
        justify-content: space-between;
    }

    .nav-link {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        transition: background-color 0.3s ease;
    }

    .nav-link:hover {
        background-color: rgba(255, 255, 255, 0.1);
    }

    /* Profile Section */
    .profile {
        position: relative;
        display: flex;
        align-items: center;
        gap: 12px;
        color: white;
        cursor: pointer;
        padding: 10px 15px;
        border-radius: 8px;
        transition: background-color 0.3s ease;
        width: 220px;
    }

    /* Profile Image Container */
    .profile-image {
        flex-shrink: 0;
        width: 40px;
        height: 40px;
    }

    /* Profile Image */
    .profile-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* Profile Info Container */
    .profile-info {
        overflow: hidden;
        flex-grow: 1;
    }

    /* User Name */
    .user-name {
        margin: 0;
        font-size: 14px;
        font-weight: 600;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        color: #fff;
    }

    /* User Role */
    .user-role {
        font-size: 12px;
        color: rgba(255, 255, 255, 0.8);
        display: block;
    }

    /* Ikon dropdown */
    .dropdown-icon {
        font-size: 12px;
        margin-left: auto;
        transition: transform 0.3s ease;
    }
    
    /* Rotasi ikon saat dropdown aktif */
    .profile.active .dropdown-icon {
        transform: rotate(180deg);
    }

    /* Dropdown Menu */
    .dropdown-menu {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        padding: 8px 0;
        z-index: 1000;
        min-width: 100%;
        width: auto;
        margin: 0;
        box-sizing: border-box;
    }

    /* Menampilkan dropdown saat ada class 'show' */
    .dropdown-menu.show {
        display: block;
    }

    /* Dropdown Items */
    .dropdown-menu a {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 15px;
        color: #333;
        font-size: 14px;
        text-decoration: none;
        transition: background-color 0.2s ease;
    }

    .dropdown-menu a:hover {
        background-color: rgba(0, 0, 0, 0.05);
    }

    /* Dropdown Item Icons */
    .dropdown-menu a i {
        width: 16px;
        text-align: center;
    }

    /* Danger Link Color */
    .dropdown-menu a.text-danger {
        color: #dc3545;
    }

    /* Divider */
    .dropdown-divider {
        margin: 5px 0;
        border-top: 1px solid #eee;
    }

    /* Hover effect on profile */
    .profile:hover {
        background-color: rgba(255, 255, 255, 0.1);
    }

    .profile .dropdown-menu.show {
    display: block !important;
    z-index: 9999 !important;
}


</style>