<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - PPID Kalsel</title>

    <link rel="stylesheet" href="{{ asset('assets/compiled/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/compiled/css/app-dark.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/compiled/css/iconly.css') }}">

    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/custom/admin-style.css') }}">
</head>

<body>
    <script src="{{ asset('assets/static/js/initTheme.js') }}"></script>
    <div id="app">

        <div id="sidebar">
            <div class="sidebar-wrapper active">
                <div class="sidebar-header position-relative">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="logo">
                            <a href="#" style="font-size: 24px; font-weight: 800; letter-spacing: -1px;">ADMIN PANEL</a>
                        </div>
                    </div>
                </div>

                <div class="sidebar-menu">
                    <ul class="menu">
                        <li class="sidebar-title">Menu Utama</li>

                        <li class="sidebar-item active">
                            <a href="{{ route('dashboard') }}" class='sidebar-link'>
                                <i class="bi bi-grid-fill"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>

                        <li class="sidebar-title">Konten Website</li>
                        <li class="sidebar-item {{ Request::is('pages*') ? 'active' : '' }}">
                            <a href="{{ route('pages.index') }}" class='sidebar-link'>
                                <i class="bi bi-journal-richtext"></i>
                                <span>Kelola Halaman</span>
                            </a>
                        </li>

                        <li class="sidebar-title">Data & Arsip</li>
                        <li class="sidebar-item {{ Request::is('documents*') ? 'active' : '' }}">
                            <a href="{{ route('documents.index') }}" class='sidebar-link'>
                                <i class="bi bi-folder-fill"></i>
                                <span>Inventaris Dokumen</span>
                            </a>
                        </li>
                        <li class="sidebar-item {{ Request::routeIs('admin.requests.index') ? 'active' : '' }}">
                            <a href="{{ route('admin.requests.index') }}" class='sidebar-link'>
                                <i class="bi bi-inbox-fill"></i>
                                <span>Permohonan Masuk</span>
                            </a>
                        </li>
                        <li class="sidebar-item {{ Request::routeIs('admin.objections.*') ? 'active' : '' }}">
                            <a href="{{ route('admin.objections.index') }}" class='sidebar-link'>
                                <i class="bi bi-exclamation-triangle"></i>
                                <span>Pengajuan Keberatan</span>
                            </a>
                        </li>
                        <li class="sidebar-item {{ Request::is('surveys*') ? 'active' : '' }}">
                            <a href="{{ route('surveys.index') }}" class='sidebar-link'>
                                <i class="bi bi-bar-chart-fill"></i>
                                <span>Laporan Survei</span>
                            </a>
                        </li>
                        <li class="sidebar-item {{ Request::is('posts*') ? 'active' : '' }}">
                            <a href="{{ route('posts.index') }}" class='sidebar-link'>
                                <i class="bi bi-newspaper"></i> <span>Kelola Berita</span>
                            </a>
                        </li>

                    </ul>
                </div>
            </div>
        </div>

        <div id="main" class='layout-navbar'>

            <header>
                <nav class="navbar navbar-expand navbar-light navbar-top">
                    <div class="container-fluid">
                        <a href="#" class="burger-btn d-block d-xl-none">
                            <i class="bi bi-justify fs-3"></i>
                        </a>

                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav ms-auto mb-2 mb-lg-0"></ul>

                            <div class="dropdown">
                                <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                    <div class="user-menu d-flex align-items-center">
                                        <div class="user-name text-end me-3">
                                            <h6 class="mb-0 text-gray-600">{{ Auth::user()->name }}</h6>
                                            @if(Auth::user()->role == 'super_admin')
                                                <span class="badge bg-danger user-role-badge">Super Admin</span>
                                            @else
                                                <span class="badge bg-primary user-role-badge">Staf Admin</span>
                                            @endif
                                        </div>
                                        <div class="user-img d-flex align-items-center">
                                            <div class="avatar avatar-md bg-light p-1">
                                                <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&background=EBF3FF&color=0D8ABC&bold=true&length=1"
                                                     alt="User" class="rounded-circle">
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0" aria-labelledby="dropdownMenuButton" style="min-width: 11rem;">
                                    <li><h6 class="dropdown-header">Halo, {{ Auth::user()->name }}</h6></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="dropdown-item text-danger">
                                                <i class="icon-mid bi bi-box-arrow-left me-2"></i> Logout
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </nav>
            </header>

            <div id="main-content" class="pt-0">
                <div class="page-heading">
                    <div class="page-title mb-4">
                        <div class="row">
                            <div class="col-12 col-md-6 order-md-1 order-last">
                                <h3 class="fw-bold text-dark">@yield('page-title')</h3>
                            </div>
                        </div>
                    </div>
                    <section class="section">
                        @yield('content')
                    </section>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/static/js/components/dark.js') }}"></script>
    <script src="{{ asset('assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/compiled/js/app.js') }}"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

    <script src="{{ asset('assets/custom/admin-script.js') }}"></script>

</body>
</html>
