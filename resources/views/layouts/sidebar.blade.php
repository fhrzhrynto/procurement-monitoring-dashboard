<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar System</title>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.0/css/bootstrap.min.css">
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f6f9;
            color: #333;
            position: relative;
            min-height: 100vh;
            transition: all 0.3s ease;
        }
        
        body.dark-mode {
            background-color: #121212;
            color: #e0e0e0;
        }
        
        /* Sidebar Styling */
        .sidebar {
            width: 260px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            padding: 0;
            background: linear-gradient(180deg, #1e3c72 0%, #2a5298 100%);
            box-shadow: 0 4px 20px 0 rgba(0, 0, 0, 0.05);
            color: #f8f9fa;
            z-index: 10;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
        }
        
        body.dark-mode .sidebar {
            background: linear-gradient(180deg, #0f2047 0%, #1a3264 100%);
            box-shadow: 0 4px 20px 0 rgba(0, 0, 0, 0.2);
        }
        
        /* Logo dan Brand */
        .sidebar-brand-container {
            padding: 1.5rem 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            text-decoration: none;
            background-color: transparent; /* Tetapkan background transparan */
        }

        .logo {
            width: 180px;
            height: auto;
            margin-right: 10px;
            transition: transform 0.3s ease;
        }

        .brand-text {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 1.2rem;
            color: white;
            letter-spacing: 0.5px;
        }

        /* Modifikasi hover state */
        .sidebar-brand:hover {
            background-color: transparent !important; /* Gunakan !important untuk memastikan tidak ada override */
        }

        .sidebar-brand:hover .logo {
            transform: scale(1.1); /* Logo membesar 10% saat dihover */
            transition: transform 0.3s ease; /* Animasi halus */
        }
        
        /* User Profile */
        .user-profile {
            display: flex;
            align-items: center;
            padding: 1rem;
            margin: 0.5rem 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .profile-image {
            margin-right: 10px;
        }
        
        .profile-image img {
            width: 45px;
            height: 45px;
            border: 2px solid rgba(255, 255, 255, 0.2);
        }
        
        .profile-info {
            display: flex;
            flex-direction: column;
        }
        
        .user-name {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 14px;
            color: white;
        }
        
        .user-role {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.7);
        }
        
        /* Search Box */
        .sidebar-search {
            padding: 1rem;
            margin-bottom: 0.5rem;
            display: flex; /* Menggunakan flexbox untuk mengatur tata letak */
            align-items: center; /* Membuat elemen sejajar secara vertikal */
        }

        .search-menu {
            background-color: rgba(255, 255, 255, 0.1);
            border: none;
            border-radius: 20px 0 0 20px;
            color: rgb(255, 9, 9);
            font-size: 0.85rem;
            padding: 0.5rem 1rem;
            flex: 1; /* Membuat input field mengambil sisa ruang yang tersedia */
        }

        .search-menu:focus {
            background-color: rgba(255, 255, 255, 0.15);
            box-shadow: none;
            color: white;
        }

        .search-menu::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        .btn-search {
            background-color: rgba(255, 255, 255, 0.1);
            border: none;
            border-radius: 0 20px 20px 0;
            color: rgba(255, 255, 255, 0.7);
            padding: 0.1rem 1rem; /* Menambahkan padding untuk membuat tombol lebih besar */
            cursor: pointer; /* Menambahkan cursor pointer untuk menunjukkan bahwa itu adalah tombol */
        }

        .btn-search:hover {
            background-color: rgba(255, 255, 255, 0.2);
            color: white;
        }
        
        /* Menu Section */
        .sidebar-menu {
            flex-grow: 1;
            padding: 0.5rem 0;
        }
        
        .nav-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .nav-item.active .nav-link {
            color: #ffffff !important;
            font-weight: 600;
        }
        
        .menu-header {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: rgba(255, 255, 255, 0.4);
            font-weight: 600;
            padding: 0.75rem 1.5rem;
        }
        
        .nav-item {
            margin: 2px 0;
            border-radius: 5px;
            transition: all 0.3s;
        }
        
        .nav-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1.5rem;
            color: rgba(255, 255, 255, 0.7);
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
            border-radius: 5px;
            margin: 0 0.5rem;
            transition: all 0.2s ease;
        }
        
        .nav-link i {
            margin-right: 10px;
            font-size: 16px;
            width: 20px;
            text-align: center;
            transition: all 0.3s ease;
        }
        
        .nav-link:hover {
            color: white;
            background-color: rgba(255, 255, 255, 0.1);
            text-decoration: none;
        }
        
        .nav-link:hover i {
            transform: translateX(3px);
        }
        
        .badge {
            margin-left: auto;
            font-size: 10px;
            padding: 3px 6px;
            border-radius: 10px;
        }
        
        .badge-primary {
            background-color: #0984e3;
        }
        
        /* Dropdown Menu */
        .has-dropdown {
            position: relative;
        }
        
        .has-dropdown:after {
            content: "\f107";
            font-family: "Font Awesome 5 Free";
            font-weight: 900;
            margin-left: auto;
            transition: all 0.3s ease;
        }
        
        .has-dropdown[aria-expanded="true"]:after {
            transform: rotate(180deg);
        }
        
        .dropdown-menu {
            background-color: rgba(26, 55, 121, 0.7);
            border: none;
            margin-top: 0;
            border-radius: 5px;
            padding: 0.5rem 0;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            display: none;
            margin-left: 2.5rem;
        }
        
        body.dark-mode .dropdown-menu {
            background-color: rgba(15, 32, 71, 0.8);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }
        
        .dropdown-menu .nav-link {
            padding: 0.5rem 1.5rem;
            font-size: 13px;
        }
        
        .dropdown-menu .nav-link:before {
            content: "\f105";
            font-family: "Font Awesome 5 Free";
            font-weight: 900;
            margin-right: 10px;
            font-size: 12px;
        }
        
        /* Bottom Section */
        .sidebar-footer {
            padding: 1rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            font-size: 0.85rem;
        }
        
        /* Theme Switch */
        .theme-switch-wrapper {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }
        
        .theme-switch {
            position: relative;
            display: inline-block;
            width: 40px;
            height: 20px;
            margin-right: 10px;
        }
        
        .theme-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }
        
        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(255, 255, 255, 0.2);
            transition: .4s;
        }
        
        .slider:before {
            position: absolute;
            content: "";
            height: 16px;
            width: 16px;
            left: 2px;
            bottom: 2px;
            background-color: white;
            transition: .4s;
        }
        
        input:checked + .slider {
            background-color: #2196F3;
        }
        
        input:checked + .slider:before {
            transform: translateX(20px);
        }
        
        .slider.round {
            border-radius: 20px;
        }
        
        .slider.round:before {
            border-radius: 50%;
        }
        
        .theme-mode-text {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.7);
            margin-top: -7px;
        }
        
        /* Logout Button */
        .logout-btn {
            display: block;
            color: rgba(255, 255, 255, 0.7);
            padding: 0.5rem 0;
            margin-bottom: 0.5rem;
            text-decoration: none;
            font-family: 'Poppins', sans-serif;
            transition: all 0.3s ease;
        }
        
        .logout-btn:hover {
            color: #ff7675;
            text-decoration: none;
        }
        
        .logout-btn i {
            margin-right: 5px;
        }
        
        /* Version Text */
        .version {
            font-size: 11px;
            color: rgba(255, 255, 255, 0.4);
            text-align: center;
        }
        
        .version i {
            margin-right: 5px;
        }
        
        /* Collapsed Sidebar */
        .sidebar-collapsed {
            width: 70px;
        }
        
        .sidebar-collapsed .brand-text,
        .sidebar-collapsed .profile-info,
        .sidebar-collapsed .nav-link span,
        .sidebar-collapsed .has-dropdown:after,
        .sidebar-collapsed .sidebar-search,
        .sidebar-collapsed .menu-header,
        .sidebar-collapsed .theme-mode-text,
        .sidebar-collapsed .badge {
            display: none;
        }
        
        .sidebar-collapsed .nav-link {
            justify-content: center;
            padding: 0.75rem;
        }
        
        .sidebar-collapsed .nav-link i {
            margin-right: 0;
            font-size: 18px;
        }
        
        .sidebar-collapsed .sidebar-footer {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .sidebar-menu ul {
            list-style: none;
            padding-left: 0;
        }

        .sidebar-menu li::before {
            content: none !important;
        }

        .nav-item.active a {
            background-color: white !important;
            color: #2c3e50 !important; 
            border-radius: 8px;
        }
        
        body.dark-mode .nav-item.active a {
            background-color: #2d2d2d !important;
            color: #ffffff !important;
        }

        .nav-item.active .nav-link {
            color: black !important;
        }
        
        body.dark-mode .nav-item.active .nav-link {
            color: #ffffff !important;
        }

        /* Efek khusus untuk menu Dashboard aktif */
        .nav-item.dashboard-active {
            background-color: white !important;
            border-radius: 6px;
            padding: 3px 8px;
            margin: 3px 8px;
        }
        
        body.dark-mode .nav-item.dashboard-active {
            background-color: #2d2d2d !important;
        }

        /* Warna teks dan ikon agar tetap terlihat */
        .nav-item.dashboard-active a {
            color: black !important;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
        }
        
        body.dark-mode .nav-item.dashboard-active a {
            color: #ffffff !important;
        }

        /* Warna ikon agar tetap terlihat jelas */
        .nav-item.dashboard-active i {
            color: black !important;
            font-size: 14px;
        }
        
        body.dark-mode .nav-item.dashboard-active i {
            color: #ffffff !important;
        }

        .custom-active {
            background-color: #007bff !important;
            border-radius: 5px;
        }
        
        body.dark-mode .custom-active {
            background-color: #1a3264 !important;
        }

        .custom-active .nav-link {
            color: white !important;
            padding: 8px 12px;
        }
        
        /* Main Content Styling for Dark Mode */
        .main-content {
            transition: all 0.3s ease;
        }
        
        body.dark-mode .main-content {
            background-color: #1e1e1e;
            color: #e0e0e0;
        }
        
        /* Card Styling for Dark Mode */
        .card {
            transition: all 0.3s ease;
        }
        
        body.dark-mode .card {
            background-color: #2d2d2d;
            color: #e0e0e0;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
        }
        
        /* Navbar Styling for Dark Mode */
        .navbar {
            transition: all 0.3s ease;
        }
        
        body.dark-mode .navbar {
            background-color: #0f2047;
            color: #e0e0e0;
        }
        
        /* Table Styling for Dark Mode */
        body.dark-mode table {
            color: #e0e0e0;
        }
        
        body.dark-mode .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(255, 255, 255, 0.05);
        }
        
        body.dark-mode .table-hover tbody tr:hover {
            background-color: rgba(255, 255, 255, 0.075);
        }
        
        /* Form Controls for Dark Mode */
        body.dark-mode .form-control {
            background-color: #333;
            border-color: #444;
            color: #e0e0e0;
        }
        
        body.dark-mode .form-control:focus {
            background-color: #3a3a3a;
            border-color: #2196F3;
            color: #e0e0e0;
        }
        
        /* Modal Styling for Dark Mode */
        body.dark-mode .modal-content {
            background-color: #2d2d2d;
            color: #e0e0e0;
        }
        
        body.dark-mode .modal-header, 
        body.dark-mode .modal-footer {
            border-color: #444;
        }
        
        /* Button Styling for Dark Mode */
        body.dark-mode .btn-light {
            background-color: #444;
            border-color: #555;
            color: #e0e0e0;
        }
        
        body.dark-mode .btn-light:hover {
            background-color: #555;
            border-color: #666;
        }
        
        /* Dropdown Styling for Dark Mode */
        body.dark-mode .dropdown-menu {
            background-color: #333;
            border-color: #444;
        }
        
        body.dark-mode .dropdown-item {
            color: #e0e0e0;
        }
        
        body.dark-mode .dropdown-item:hover, 
        body.dark-mode .dropdown-item:focus {
            background-color: #444;
            color: #fff;
        }
        
        /* Pagination Styling for Dark Mode */
        body.dark-mode .page-link {
            background-color: #333;
            border-color: #444;
            color: #e0e0e0;
        }
        
        body.dark-mode .page-item.active .page-link {
            background-color: #2196F3;
            border-color: #2196F3;
        }
        
        body.dark-mode .page-item.disabled .page-link {
            background-color: #222;
            border-color: #333;
            color: #666;
        }
    </style>
</head>
<body>
<!-- Sidebar -->
<div class="sidebar d-flex flex-column" style="height: 100vh; position: fixed; top: 0; left: 0; width: 250px; background: #3f51b5; color: white;">
    
    <!-- Logo dan Brand -->
    <div class="sidebar-brand-container" style="padding: 20px 20px 10px 20px;">
        <a class="sidebar-brand text-decoration-none text-white d-flex align-items-center" href="{{ url('/') }}">
            <img src="{{ asset('img/icon.png') }}" class="logo" alt="PLN Logo" style="height: 32px; width: auto;">
            <span class="brand-text"></span>
        </a>
    </div>
    
    <hr style="border-top: 2px solid rgba(255, 255, 255, 0.7); margin: 0 15px 10px 15px;">

    <!-- ========================================== -->
    <!-- WADAH UTAMA (Bisa di-scroll jika menu panjang) -->
    <!-- ========================================== -->
    <div class="sidebar-menu" style="flex-grow: 1; overflow-y: auto; overflow-x: hidden; padding: 0 10px;">
        <ul class="nav flex-column">
            <!-- Dashboard -->
            <li class="nav-item {{ Request::is('dashboard') ? 'active' : '' }}">
                <a class="nav-link text-white" href="{{ url('dashboard') }}">
                    <i class="fas fa-home me-2"></i>
                    <span>Dashboard</span>
                </a>
            </li>  

            <li class="menu-header text-white-50 px-3 mt-3 mb-1" style="font-size: 11px; letter-spacing: 1px;">MASTER DATA</li>
            
            <li class="nav-item {{ Request::is('persiapan-pengadaan*') ? 'active' : '' }}">
                <a class="nav-link text-white" href="{{ route('persiapan_pengadaan') }}">
                    <i class="fas fa-tools me-2"></i>
                    <span>Persiapan Pengadaan</span>
                </a>
            </li>
            
            <li class="nav-item {{ Request::is('monitoring_pengadaan*') || Request::is('pengadaan*') ? 'active' : '' }}">
                <a class="nav-link text-white" href="{{ route('monitoring_pengadaan') }}">
                    <i class="fas fa-clipboard-list me-2"></i>
                    <span>Monitoring Pengadaan</span>
                </a>
            </li>
                        
            <li class="nav-item {{ Request::is('data-pengadaan*') ? 'active' : '' }}">
                <a class="nav-link text-white" href="{{ route('data_pengadaan') }}">
                    <i class="fas fa-folder me-2"></i>
                    <span>Data Pengadaan</span>
                </a>
            </li>

            <li class="nav-item {{ Request::is('monitoring_gr*') || Request::is('monitoring-gr') ? 'active' : '' }}">
                <a class="nav-link text-white" href="{{ route('monitoring.gr') }}">
                    <i class="fas fa-boxes me-2"></i>
                    <span>Monitoring GR</span>
                </a>
            </li>                                        
            
            @if(Auth::check() && Auth::user()->role == 1) 
            <li class="nav-item {{ Request::is('users') || Request::is('users/add') || Request::is('users/*/edit') ? 'active' : '' }}">
                <a class="nav-link text-white" href="{{ route('daftaruser') }}">
                    <i class="fas fa-users me-2"></i>
                    <span>Daftar User</span>
                </a>
            </li>
            @endif

            <li class="nav-item {{ Request::is('statistik/*') ? 'active' : '' }}">
                <a class="nav-link text-white" href="#" data-toggle="dropdown">
                    <i class="fas fa-chart-bar me-2"></i>
                    <span>Statistik & Laporan</span>
                </a>
                <ul class="dropdown-menu bg-secondary border-0">
                    <li><a class="nav-link text-white" href="{{ route('laporan.bulanan') }}">Laporan Bulanan</a></li>
                    <li><a class="nav-link text-white" href="{{ route('laporan.tahunan') }}">Laporan Tahunan</a></li>
                </ul>
            </li>
            
            <li class="nav-item {{ Request::is('profile') ? 'active' : '' }}">
                <a class="nav-link text-white" href="{{ route('profile') }}">
                    <i class="fas fa-cog me-2"></i>
                    <span>Pengaturan</span>
                </a>
            </li>
        </ul>
    </div>
    
    <!-- ========================================== -->
    <!-- FOOTER SECTION (Terkunci rapi di paling bawah) -->
    <!-- ========================================== -->
    <div class="sidebar-footer mt-auto" style="padding: 10px 15px; background: rgba(0, 0, 0, 0.15);">
        <!-- Garis Pembatas Bawah -->
        <hr style="border-top: 2px solid rgba(255, 255, 255, 0.7); margin: 0 0 10px 0;">
        
        <div class="theme-switch-wrapper mb-2 d-flex align-items-center">
            <label class="theme-switch me-2 mb-0" for="checkbox">
                <input type="checkbox" id="checkbox" />
                <span class="slider round"></span>
            </label>
            <span class="theme-mode-text" style="font-size: 14px;">Dark Mode</span>
        </div>
        
        <a href="#" class="logout-btn text-white text-decoration-none d-block mb-2" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="font-size: 14px;">
            <i class="fas fa-sign-out-alt me-2"></i> Logout
        </a>
        
        <!-- Hidden Logout Form -->
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
        
        <div class="version text-white-50" style="font-size: 11px;">
            <i class="fas fa-code-branch me-1"></i> Version 1.1
        </div>
    </div>
</div>
<!-- Bootstrap JS and dependencies -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Elements
    const checkbox = document.getElementById('checkbox');
    const body = document.body;
    const themeText = document.querySelector('.theme-mode-text');
    
    // Function to set the theme
    function setDarkMode(isDark) {
        if (isDark) {
            // Enable Dark Mode
            body.classList.add('dark-mode');
            themeText.textContent = 'Light Mode';
            localStorage.setItem('darkMode', 'enabled');
        } else {
            // Disable Dark Mode
            body.classList.remove('dark-mode');
            themeText.textContent = 'Dark Mode';
            localStorage.setItem('darkMode', 'disabled');
        }
    }
    
    // Check for saved theme preference
    const darkMode = localStorage.getItem('darkMode');
    
    // Set initial state based on saved preference
    if (darkMode === 'enabled') {
        checkbox.checked = true;
        setDarkMode(true);
    } else {
        checkbox.checked = false;
        setDarkMode(false);
    }
    
    // Toggle theme when checkbox changes
    checkbox.addEventListener('change', function() {
        setDarkMode(this.checked);
    });
    
    // Initialize dropdown functionality for sidebar
    const dropdownLinks = document.querySelectorAll('.nav-link[data-toggle="dropdown"]');
    
    dropdownLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const dropdownMenu = this.nextElementSibling;
            
            if (dropdownMenu.style.display === 'block') {
                dropdownMenu.style.display = 'none';
                this.setAttribute('aria-expanded', 'false');
            } else {
                // Close all other dropdowns
                document.querySelectorAll('.dropdown-menu').forEach(menu => {
                    menu.style.display = 'none';
                });
                
                dropdownMenu.style.display = 'block';
                this.setAttribute('aria-expanded', 'true');
            }
        });
    });
    
    // Close dropdowns when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.nav-item')) {
            document.querySelectorAll('.dropdown-menu').forEach(menu => {
                menu.style.display = 'none';
            });
            
            document.querySelectorAll('.nav-link[data-toggle="dropdown"]').forEach(link => {
                link.setAttribute('aria-expanded', 'false');
            });
        }
    });
});
</script>
</body>
</html>