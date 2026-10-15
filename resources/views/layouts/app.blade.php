<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}" class="link-favicon">
    <link rel="shortcut icon" href="{{ asset('img/logo.png') }}" class="link-favicon">


    <!-- <title>@yield('title', 'Dashboard')</title> -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <style>
        .link-favicon {
            width: auto !important;  /* Agar tidak dipaksa menjadi kotak */
            height: 32px;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }

        .sidebar {
            width: 250px;
            height: 100vh;
            background: #3f51b5;
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            padding-top: 20px;
            display: flex;
            flex-direction: column;
            box-sizing: border-box;
            z-index: 1000;
        }

        /* 3. Bungkus area menu utama agar fleksibel & bisa di-scroll jika panjang */
        .sidebar-content {
            flex-grow: 1;
            overflow-y: auto;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            display: block;
        }

        .sidebar a:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        /* 4. Bagian footer sidebar (Dark Mode, Logout, Version) */
        .sidebar-footer {
            margin-top: auto;          /* Mendorong otomatis ke bagian paling bawah */
            padding-bottom: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1); /* Opsional: garis pemisah tipis */
        }

        .main-content {
            margin-left: 260px;
            padding: 20px;
            max-width: 1400px; /* agar tidak terlalu melebar di TV */
        }

        .navbar {
            background: #3f51b5;
            color: white;
            padding: 10px 20px;
        }

        .navbar .profile {
            float: right;
        }

        .card {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        /* ------- RESPONSIVE UNTUK HP / TABLET ------- */
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
                display: block; /* Kembalikan ke normal block di HP */
            }
            .sidebar-footer {
                margin-top: 0; /* Reset margin di HP */
            }
            .main-content {
                margin-left: 0;
            }
            .navbar .profile {
                float: none;
                text-align: center;
                display: block;
            }
        }

        /* ------- RESPONSIVE UNTUK TV / LAYAR LEBAR ------- */
        @media (min-width: 1600px) {
            .main-content {
                margin: 0 auto; /* biar di tengah kalau di TV */
            }
        }
    </style>

</head>
<body>

    @include('layouts.sidebar')

    <div class="main-content">
    @include('layouts.navbar')
    <div class="container mt-4">
    @yield('content')
    </div>
    </div>
    @yield('scripts')

</body>
</html>
