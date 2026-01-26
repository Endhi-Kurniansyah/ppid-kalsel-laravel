<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PPID Provinsi Kalimantan Selatan</title>

    {{-- LOGO TITLE BAR --}}
    <link rel="shortcut icon" href="{{ asset('assets/static/images/logo/ppidutama.png') }}" type="image/x-icon">

    {{-- ASSETS --}}
    <link rel="stylesheet" href="{{ asset('assets/compiled/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/compiled/css/app-dark.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        /* =========================================
           1. GLOBAL RESET & TYPOGRAPHY
           ========================================= */
        body {
            font-family: 'Inter', sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-color: #f8f9fa; /* Background abu sangat muda agar konten menonjol */
        }

        /* Reset Icon agar Presisi di Tengah */
        i, .bi, .fa, .fas, .fab {
            font-style: normal !important; font-weight: normal !important; line-height: 1 !important;
            display: inline-flex !important; align-items: center !important; justify-content: center !important;
            vertical-align: middle !important;
        }
        .bi::before { vertical-align: 0 !important; margin: 0 !important; display: block !important; }

        /* =========================================
           2. NAVBAR STYLES (Modern & Clean)
           ========================================= */
        .navbar-custom {
            background-color: rgba(255, 255, 255, 0.95); /* Sedikit transparan */
            backdrop-filter: blur(10px); /* Efek blur di belakang navbar */
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
            padding: 15px 0; /* Padding lebih lega */
            transition: all 0.3s ease;
        }

        .nav-link {
            font-weight: 600;
            color: #334155 !important; /* Abu tua elegan */
            font-size: 0.95rem;
            margin-left: 5px;
            padding: 8px 16px !important;
            border-radius: 50px; /* Rounded Pill saat hover */
            transition: all 0.3s ease;
        }

        /* Hover Effect: Biru Muda Pudar */
        .nav-link:hover, .nav-link:focus {
            color: #2563eb !important; /* Biru Utama */
            background-color: rgba(37, 99, 235, 0.05);
        }

        /* Active State */
        .nav-link.active {
            color: #2563eb !important;
            font-weight: 700;
        }

        /* Dropdown Menu */
        .dropdown-menu {
            border: none;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            border-radius: 12px;
            margin-top: 10px !important;
            padding: 10px;
        }
        .dropdown-item {
            border-radius: 8px;
            padding: 10px 15px;
            font-weight: 500;
            color: #475569;
        }
        .dropdown-item:hover {
            background-color: #f1f5f9;
            color: #2563eb;
            transform: translateX(3px); /* Efek geser dikit */
            transition: transform 0.2s;
        }

        /* =========================================
           3. FOOTER STYLES (Deep Blue Theme)
           ========================================= */
        footer {
            background: #0f172a;
            color: #cbd5e1;
            font-size: 0.9rem;
            padding-top: 4rem;
            margin-top: auto;
            position: relative;
            overflow: hidden;
        }

        footer::before {
            content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 4px;
            background: linear-gradient(to right, #0f172a, #facc15, #0f172a);
        }

        .footer-header {
            color: #ffffff; font-weight: 700; font-size: 1rem; margin-bottom: 1.5rem;
            text-transform: uppercase; letter-spacing: 0.5px;
        }

        /* --- PERBAIKAN LIST (HILANGKAN TITIK) --- */
        .footer-links, .contact-list, .schedule-list {
            list-style: none !important; /* HILANGKAN DOT */
            padding: 0 !important;       /* HILANGKAN JARAK KIRI BAWAAN */
            margin: 0 !important;
        }

        /* Link Footer (Jelajahi) */
        .footer-links li { margin-bottom: 12px; }
        .footer-links a {
            color: #94a3b8; text-decoration: none; transition: all 0.3s;
            display: flex; align-items: center; /* Agar panah & teks sejajar */
        }
        .footer-links a:hover {
            color: #facc15; transform: translateX(5px);
        }
        .footer-links a i { font-size: 0.8rem; margin-top: 1px; } /* Ukuran panah */

        /* Kontak List (Hubungi Kami) - LEBIH RAPI */
        .contact-list li {
            display: flex;
            align-items: flex-start; /* Icon tetap di atas jika teks panjang */
            margin-bottom: 18px;     /* Jarak antar item lebih lega */
        }
        .contact-list li i {
            color: #facc15;
            min-width: 25px; /* Lebar tetap agar teks rata kiri */
            margin-top: 3px; /* Penyesuaian vertikal */
            font-size: 1.1rem;
        }
        .contact-list li span {
            line-height: 1.5; /* Spasi baris teks */
        }

        /* Jam Pelayanan */
        .schedule-list li {
            display: flex; justify-content: space-between; margin-bottom: 10px;
            border-bottom: 1px solid rgba(255,255,255,0.05); padding-bottom: 8px;
        }

        /* Social Media */
        .social-link {
            width: 40px; height: 40px; background: rgba(255,255,255,0.05); color: #fff;
            border-radius: 50%; display: inline-flex !important; align-items: center !important;
            justify-content: center !important; text-decoration: none; margin-right: 8px;
            transition: all 0.3s; border: 1px solid rgba(255,255,255,0.1);
        }
        .social-link:hover {
            background: #facc15; color: #0f172a; transform: translateY(-3px); border-color: #facc15;
        }

        .copyright-bar {
            background: rgba(0,0,0,0.3); border-top: 1px solid rgba(255,255,255,0.05);
            padding: 25px 0; margin-top: 50px; font-size: 0.85rem;
        }
    </style>
</head>

<body>

    {{-- HEADER --}}
    @include('layouts.partials.header')

    {{-- CONTENT --}}
    <div style="margin-top: 85px;">
        @yield('content')
    </div>

    {{-- FOOTER --}}
    @include('layouts.partials.footer')

    {{-- SCRIPTS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
