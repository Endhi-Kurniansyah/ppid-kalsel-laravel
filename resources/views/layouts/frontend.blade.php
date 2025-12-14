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

    <style>
        .navbar-custom {
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .nav-link {
            font-weight: 500;
            color: #25396f;
        }
        .nav-link:hover {
            color: #435ebe;
        }
    </style>
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

                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}">Beranda</a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="profilDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Profil
                        </a>
                        <ul class="dropdown-menu border-0 shadow" aria-labelledby="profilDropdown">
                            <li><a class="dropdown-item" href="{{ url('/page/tentang-ppid') }}">Tentang PPID</a></li>
                            <li><a class="dropdown-item" href="{{ url('/page/visi-misi') }}">Visi & Misi</a></li>
                            <li><a class="dropdown-item" href="{{ url('/page/struktur-organisasi') }}">Struktur Organisasi</a></li>
                            <li><a class="dropdown-item" href="{{ url('/page/tugas-fungsi') }}">Tugas & Fungsi</a></li>

                            @php
                                $slugWajib = ['tentang-ppid', 'visi-misi', 'struktur-organisasi', 'tugas-fungsi'];
                                $halamanBaru = \App\Models\Page::where('is_static', 0)
                                    ->whereNotIn('slug', $slugWajib)
                                    ->latest()->get();
                            @endphp

                            @if($halamanBaru->count() > 0)
                                <li><hr class="dropdown-divider"></li>
                                @foreach($halamanBaru as $page)
                                    <li>
                                        <a class="dropdown-item" href="{{ route('public.page', $page->slug) }}">
                                            {{ $page->title }}
                                        </a>
                                    </li>
                                @endforeach
                            @endif
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

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="serviceDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Layanan
                        </a>
                        <ul class="dropdown-menu border-0 shadow" aria-labelledby="serviceDropdown">
                            <li><a class="dropdown-item" href="{{ route('requests.create') }}">Ajukan Permohonan</a></li>
                            <li><a class="dropdown-item" href="{{ route('requests.track') }}">Cek Status Permohonan</a></li>

                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="{{ route('objection.search') }}">Ajukan Keberatan</a></li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('news.index') }}">Berita</a>
                    </li>

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
                    <h5 class="fw-bold text-primary">PPID Kalsel</h5>
                    <p class="text-secondary">Layanan Informasi Publik Provinsi Kalimantan Selatan untuk mewujudkan keterbukaan informasi.</p>
                </div>
                <div class="col-md-4">
                    <h5 class="fw-bold">Alamat Kantor</h5>
                    <p class="text-secondary">Jl. Dharma Praja No. 1, Banjarbaru<br>Provinsi Kalimantan Selatan</p>
                </div>
                <div class="col-md-4">
                    <h5 class="fw-bold">Kontak Kami</h5>
                    <p class="text-secondary">
                        <i class="bi bi-envelope me-2"></i> ppid@kalselprov.go.id<br>
                        <i class="bi bi-telephone me-2"></i> (0511) 477XXXX
                    </p>
                </div>
            </div>
            <hr class="border-secondary">
            <div class="text-center">
                <small class="text-secondary">&copy; 2025 Dinas Komunikasi dan Informatika Prov. Kalsel</small>
            </div>
        </div>
    </footer>

    <script src="{{ asset('assets/compiled/js/app.js') }}"></script>
</body>
</html>
