<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PPID Provinsi Kalimantan Selatan</title>

    <link rel="stylesheet" href="{{ asset('assets/compiled/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/compiled/css/app-dark.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/compiled/css/iconly.css') }}">

    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-custom fixed-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                <img src="{{ asset('assets/static/images/logo/favicon.svg') }}" alt="Logo" style="height: 40px; margin-right: 10px;">
                <span style="font-weight: bold; font-size: 1.2rem; color: #25396f;">PPID Kalsel</span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="profilDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Profil
                        </a>
                        <ul class="dropdown-menu border-0 shadow" aria-labelledby="profilDropdown">
                            <li><a class="dropdown-item" href="{{ url('/page/tentang-ppid') }}">Tentang PPID</a></li>
                            <li><a class="dropdown-item" href="{{ url('/page/visi-misi') }}">Visi & Misi</a></li>
                            <li><a class="dropdown-item" href="{{ url('/page/struktur-organisasi') }}">Struktur Organisasi</a></li>
                            <li><a class="dropdown-item" href="{{ url('/page/tugas-fungsi') }}">Tugas & Fungsi</a></li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="infoDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Informasi Publik
                        </a>
                        <ul class="dropdown-menu border-0 shadow" aria-labelledby="infoDropdown">
                            <li><a class="dropdown-item" href="{{ route('public.documents', 'sop') }}">SOP Layanan</a></li>
                            <li><a class="dropdown-item" href="{{ route('public.documents', 'berkala') }}">Informasi Berkala</a></li>
                            <li><a class="dropdown-item" href="{{ route('public.documents', 'serta-merta') }}">Informasi Serta Merta</a></li>
                            <li><a class="dropdown-item" href="{{ route('public.documents', 'setiap-saat') }}">Informasi Setiap Saat</a></li>
                            <li><a class="dropdown-item" href="{{ route('public.documents', 'dikecualikan') }}">Informasi Dikecualikan</a></li>
                        </ul>
                    </li>

                    <li class="nav-item"><a class="nav-link" href="#">Berita</a></li>

                    <li class="nav-item"><a class="nav-link" href="#">Kontak</a></li>

                </ul>
            </div>
        </div>
    </nav>

    <div>
        @yield('content')
    </div>

    <footer class="bg-dark text-white pt-5 pb-3 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5>PPID Kalsel</h5>
                    <p>Layanan Informasi Publik Provinsi Kalimantan Selatan.</p>
                </div>
                <div class="col-md-4">
                    <h5>Alamat</h5>
                    <p>Jl. Dharma Praja No. 1, Banjarbaru<br>Provinsi Kalimantan Selatan</p>
                </div>
            </div>
            <hr>
            <div class="text-center">
                <small>&copy; 2025 Dinas Komunikasi dan Informatika Prov. Kalsel</small>
            </div>
        </div>
    </footer>

    <script src="{{ asset('assets/compiled/js/app.js') }}"></script>
</body>
</html>
