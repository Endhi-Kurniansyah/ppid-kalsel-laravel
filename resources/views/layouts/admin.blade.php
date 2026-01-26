<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - PPID Provinsi Kalimantan Selatan</title>

    <link rel="shortcut icon" href="{{ asset('assets/static/images/logo/ppidutama.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('assets/compiled/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/compiled/css/app-dark.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* =========================================
           1. GLOBAL RESET (FONT & BACKGROUND)
           ========================================= */
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; overflow-x: hidden; }

        /* =========================================
           2. ICON PRESISION FIX (PENTING! JANGAN DIHAPUS)
           ========================================= */
        i, .bi, .fa, .fas, .fab {
            font-style: normal !important;
            font-weight: normal !important;
            font-variant: normal !important;
            text-transform: none !important;
            line-height: 1 !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            vertical-align: middle !important;
        }

        /* Reset Pseudo-element Bootstrap Icons */
        .bi::before, [class^="bi-"]::before {
            vertical-align: 0 !important;
            margin-top: 0 !important;
            margin-bottom: 0 !important;
            line-height: 1 !important;
            display: block !important;
        }

        /* =========================================
           3. SIDEBAR STYLES
           ========================================= */
        #sidebar { background-color: #ffffff; box-shadow: 4px 0 15px rgba(0,0,0,0.03); z-index: 1000; height: 100vh; position: fixed; left: 0; top: 0; }
        .sidebar-wrapper { height: 100%; overflow-y: auto; }

        /* Sidebar Header */
        .sidebar-header { padding: 1.5rem 1.5rem 1rem 1.5rem !important; }
        .sidebar-header .logo img { height: 42px !important; width: auto; }

        /* Sidebar Menu Group Title */
        .sidebar-title {
            font-size: 0.65rem !important; text-transform: uppercase; font-weight: 800 !important;
            color: #adb5bd !important; letter-spacing: 1px; margin-top: 1.5rem !important;
            margin-bottom: 0.5rem !important; padding: 0 1.2rem !important;
        }

        /* Sidebar Link Item */
        .sidebar-link {
            border-radius: 8px !important; margin: 2px 0.8rem !important;
            transition: all 0.2s ease; font-size: 0.85rem !important; font-weight: 500 !important;
            padding: 0.7rem 1rem !important;
            display: flex !important;
            align-items: center !important;
            color: #4b5563; text-decoration: none !important;
        }
        .sidebar-link:hover { background-color: #f3f4f6; color: #0f172a; }
        .sidebar-item.active > .sidebar-link { background-color: #0f172a !important; color: #fff !important; }

        /* Icon Sidebar specific adjustment */
        .sidebar-link i {
            font-size: 1.1rem; margin-right: 12px; width: 24px; height: 24px;
        }

        /* =========================================
           4. MAIN CONTENT LAYOUT
           ========================================= */
        #main {
            margin-left: 300px; /* Lebar Sidebar */
            min-height: 100vh;
            background-color: #f8fafc;
            transition: margin-left 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        /* Navbar Top */
        header { background: #fff; border-bottom: 1px solid #e2e8f0; padding: 0.8rem 1.5rem; height: 80px; display: flex; align-items: center; }
        .navbar-top { padding: 0 !important; background: transparent !important; box-shadow: none !important; width: 100%; }

        /* User Profile Text */
        .user-name h6 { color: #0f172a; font-weight: 700; margin-bottom: 0; font-size: 0.85rem; line-height: 1.2; }
        .user-name p { font-size: 0.7rem; margin-bottom: 0; color: #64748b; line-height: 1.2; }
        .avatar-md img { width: 38px; height: 38px; object-fit: cover; border-radius: 50%; }

        /* CONTENT WRAPPER */
        .main-content-wrapper { flex: 1; padding: 0; overflow: hidden; }

        /* Responsive Mobile */
        @media (max-width: 1199px) {
            #main { margin-left: 0; }
            #sidebar { transform: translateX(-100%); transition: transform 0.3s ease; }
            #sidebar.active { transform: translateX(0); }
        }

        /* Scrollbar Halus */
        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>

<body>
    <div id="app">

        {{-- SIDEBAR --}}
        <div id="sidebar" class="active">
            <div class="sidebar-wrapper active">
                <div class="sidebar-header">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="logo d-flex align-items-center gap-3">
                            <a href="{{ route('dashboard') }}" style="display: flex; align-items: center;">
                                <img src="{{ asset('assets/static/images/logo/ppidutama.png') }}" alt="Logo" style="height: 45px;">
                            </a>
                            <div class="logo-text d-flex flex-column justify-content-center">
                                <h6 class="mb-0 fw-bold text-dark" style="font-size: 0.9rem; letter-spacing: -0.5px;">ADMIN PANEL</h6>
                                <small class="text-muted fw-bold" style="font-size: 0.55rem; letter-spacing: 0.5px;">PPID PROV. KALSEL</small>
                            </div>
                        </div>
                        <div class="toggler">
                            <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                        </div>
                    </div>
                </div>

                <div class="sidebar-menu">
                    <ul class="menu">
                        <li class="sidebar-title">Menu Utama</li>
                        <li class="sidebar-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <a href="{{ route('dashboard') }}" class="sidebar-link">
                                <i class="bi bi-grid-fill"></i><span>Dashboard</span>
                            </a>
                        </li>

                        <li class="sidebar-title">Konten Website</li>
                        <li class="sidebar-item {{ request()->is('admin/pages*') ? 'active' : '' }}">
                            <a href="{{ route('pages.index') }}" class="sidebar-link">
                                <i class="bi bi-journal-richtext"></i><span>Kelola Halaman</span>
                            </a>
                        </li>
                        <li class="sidebar-item {{ request()->is('admin/posts*') ? 'active' : '' }}">
                            <a href="{{ route('posts.index') }}" class="sidebar-link">
                                <i class="bi bi-newspaper"></i><span>Kelola Berita</span>
                            </a>
                        </li>
                        <li class="sidebar-item {{ request()->is('admin/documents*') ? 'active' : '' }}">
                            <a href="{{ route('documents.index') }}" class="sidebar-link">
                                <i class="bi bi-file-earmark-pdf-fill"></i><span>Dokumen Publik</span>
                            </a>
                        </li>
                        <li class="sidebar-item {{ request()->is('admin/menus*') ? 'active' : '' }}">
                            <a href="{{ route('menus.index') }}" class="sidebar-link">
                                <i class="bi bi-list-nested"></i><span>Manajemen Menu</span>
                            </a>
                        </li>

                        <li class="sidebar-title">Data & Arsip</li>
                        <li class="sidebar-item {{ request()->is('admin/requests*') ? 'active' : '' }}">
                            <a href="{{ route('admin.requests.index') }}" class="sidebar-link">
                                <i class="bi bi-envelope-paper-fill"></i><span>Permohonan Masuk</span>
                            </a>
                        </li>
                        <li class="sidebar-item {{ request()->is('admin/objections*') ? 'active' : '' }}">
                            <a href="{{ route('admin.objections.index') }}" class="sidebar-link">
                                <i class="bi bi-exclamation-octagon-fill"></i><span>Keberatan</span>
                            </a>
                        </li>
                        <li class="sidebar-item {{ request()->is('admin/surveys*') ? 'active' : '' }}">
                            <a href="{{ route('surveys.index') }}" class="sidebar-link">
                                <i class="bi bi-graph-up-arrow"></i><span>Laporan Survei</span>
                            </a>
                        </li>

                        <li class="sidebar-title">Sistem</li>
                        <li class="sidebar-item {{ request()->is('admin/settings*') ? 'active' : '' }}">
                            <a href="{{ route('admin.settings.index') }}" class="sidebar-link">
                                <i class="bi bi-sliders"></i><span>Pengaturan</span>
                            </a>
                        </li>

                        @if(auth()->user()->role == 'super')
                        <li class="sidebar-item {{ request()->is('admin/users*') ? 'active' : '' }}">
                            <a href="{{ route('admin.users.index') }}" class="sidebar-link">
                                <i class="bi bi-people-fill"></i><span>Manajemen User</span>
                            </a>
                        </li>
                        @endif

                        <li class="sidebar-item mt-4">
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="sidebar-link text-danger bg-danger bg-opacity-10 fw-bold">
                                <i class="bi bi-box-arrow-left"></i><span>Keluar</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- MAIN CONTENT AREA --}}
        <div id="main">

            {{-- NAVBAR TOP --}}
            <header>
                <nav class="navbar navbar-expand navbar-light navbar-top">
                    <div class="container-fluid p-0">
                        <a href="#" class="burger-btn d-block d-xl-none text-dark me-3"><i class="bi bi-justify fs-3"></i></a>

                        <div class="collapse navbar-collapse" id="navbarSupportedContent">

                            <div class="me-auto d-none d-lg-block">
                                <span class="text-muted small fw-bold d-flex align-items-center">
                                    <i class="bi bi-calendar3 me-2 text-primary"></i>{{ now()->format('l, d F Y') }}
                                </span>
                            </div>

                            <div class="d-flex align-items-center gap-4">

                                {{-- Notification (PERBAIKAN WRAPPER) --}}
                                <div class="dropdown">
                                    {{-- Hapus position-relative dari <a>, pindahkan ke <div> pembungkus --}}
                                    <a href="#" data-bs-toggle="dropdown" aria-expanded="false" class="text-secondary d-flex align-items-center justify-content-center text-decoration-none" style="width: 40px; height: 40px;">
                                        <div class="position-relative d-inline-flex"> {{-- WRAPPER BARU AGAR BADGE NEMPEL KE ICON --}}
                                            <i class="bi bi-bell fs-5"></i>
                                            @if(auth()->user()->unreadNotifications->count() > 0)
                                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-white" style="font-size: 9px; padding: 2px 4px;">
                                                    {{ auth()->user()->unreadNotifications->count() }}
                                                </span>
                                            @endif
                                        </div>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-4 mt-3 p-0 overflow-hidden" style="width: 320px;">
                                        <li><div class="dropdown-header bg-light py-3 border-bottom small fw-bold text-uppercase text-dark px-3">Notifikasi</div></li>
                                        <div style="max-height: 300px; overflow-y: auto;">
                                            @forelse(auth()->user()->unreadNotifications as $notification)
                                                <li>
                                                    <a class="dropdown-item p-3 border-bottom d-flex gap-3 align-items-start bg-white hover-bg-light" href="{{ $notification->data['url'] ?? '#' }}">
                                                        <div class="bg-primary bg-opacity-10 p-2 rounded-circle text-primary lh-1 mt-1"><i class="bi bi-info-circle-fill"></i></div>
                                                        <div class="w-100">
                                                            <p class="mb-1 small fw-bold text-dark text-wrap lh-sm">{{ $notification->data['title'] ?? 'Notifikasi Baru' }}</p>
                                                            <small class="text-muted d-block" style="font-size: 10px;">{{ $notification->created_at->diffForHumans() }}</small>
                                                        </div>
                                                    </a>
                                                </li>
                                            @empty
                                                <li class="p-5 text-center text-muted">
                                                    <i class="bi bi-bell-slash fs-1 opacity-25 d-block mb-2"></i>
                                                    <small>Tidak ada notifikasi baru.</small>
                                                </li>
                                            @endforelse
                                        </div>
                                        @if(auth()->user()->unreadNotifications->count() > 0)
                                            <li><a class="dropdown-item text-center py-2 small fw-bold text-primary bg-light" href="{{ route('admin.notifications.readAll') }}">Tandai Semua Dibaca</a></li>
                                        @endif
                                    </ul>
                                </div>

                                {{-- User Profile --}}
                                <div class="dropdown">
                                    <a href="#" data-bs-toggle="dropdown" aria-expanded="false" class="d-flex align-items-center text-decoration-none">
                                        <div class="user-menu d-flex align-items-center">
                                            <div class="user-name text-end me-3 d-none d-sm-block">
                                                <h6 class="mb-0 text-dark">{{ auth()->user()->name }}</h6>
                                                <p class="mb-0 text-muted small">{{ auth()->user()->role == 'super' ? 'Super Admin' : 'Admin' }}</p>
                                            </div>
                                            <div class="avatar avatar-md border border-light shadow-sm">
                                                <img src="{{ asset('assets/compiled/jpg/1.jpg') }}" alt="Profile">
                                            </div>
                                        </div>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-4 mt-3 p-2" style="min-width: 200px;">
                                        <li><h6 class="dropdown-header text-uppercase small fw-bold text-muted mb-1">Akun Saya</h6></li>
                                        <li><a class="dropdown-item rounded-2 py-2" href="{{ route('profile.edit') }}"><i class="bi bi-person-gear me-2 text-primary"></i> Edit Profil</a></li>
                                        <li><hr class="dropdown-divider my-2"></li>
                                        <li><a class="dropdown-item rounded-2 py-2 text-danger fw-bold hover-bg-danger-light" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="bi bi-box-arrow-left me-2"></i> Keluar</a></li>
                                    </ul>
                                </div>

                            </div>
                        </div>
                    </div>
                </nav>
            </header>

            {{-- CONTENT WRAPPER --}}
            <div class="main-content-wrapper">
                {{-- KONTEN UTAMA AKAN DI-RENDER DI SINI --}}
                @yield('content')
            </div>

        </div>
    </div>

    <script src="{{ asset('assets/compiled/js/app.js') }}"></script>

    {{-- Script Sidebar Toggle --}}
    <script>
        document.querySelector('.burger-btn').addEventListener('click', () => {
            document.getElementById('sidebar').classList.toggle('active');
        });
        document.querySelector('.sidebar-hide').addEventListener('click', () => {
            document.getElementById('sidebar').classList.remove('active');
        });
    </script>
</body>
</html>
