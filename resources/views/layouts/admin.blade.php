<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - PPID Provinsi Kalimantan Selatan</title>
    <link rel="shortcut icon" href="{{ asset('assets/static/images/logo/ppidutama.png') }}" type="image/x-icon">
    
    {{-- CSS Frameworks --}}
    <link rel="stylesheet" href="{{ asset('assets/compiled/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/compiled/css/app-dark.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    {{-- Google Fonts: Outfit --}}
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: #4361ee;
            --primary-dark: #3a56d4;
            --secondary: #475569;
            --dark-bg: #0f172a;
            --sidebar-bg: #ffffff;
            --sidebar-width: 280px;
            --header-height: 80px;
            --border-color: #e2e8f0;
            --body-bg: #f1f5f9;
        }

        body { 
            font-family: 'Outfit', sans-serif; 
            background-color: var(--body-bg); 
            color: #334155;
            overflow-x: hidden; 
        }

        /* SIDEBAR STYLES */
        #sidebar {
            background-color: var(--sidebar-bg); 
            box-shadow: 4px 0 24px rgba(0,0,0,0.02);
            border-right: 1px solid var(--border-color);
            z-index: 1000; 
            height: 100vh; 
            position: fixed; 
            left: 0; 
            top: 0; 
            width: var(--sidebar-width);
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        .sidebar-header { 
            padding: 2rem 1.5rem !important; 
            display: flex; 
            align-items: center; 
            justify-content: space-between; 
            border-bottom: 1px dashed var(--border-color);
            background: linear-gradient(to bottom, #ffffff, #fcfcfc);
        }

        .sidebar-menu { padding: 1.5rem 1rem; }
        
        .sidebar-title { 
            font-size: 0.7rem !important; 
            text-transform: uppercase; 
            font-weight: 700 !important; 
            color: #94a3b8 !important; 
            letter-spacing: 1.2px; 
            margin: 1.5rem 0 0.8rem 0.8rem !important; 
        }

        .sidebar-link { 
            border-radius: 10px !important; 
            margin: 4px 0 !important; 
            font-size: 0.9rem !important; 
            font-weight: 500 !important; 
            padding: 0.8rem 1rem !important; 
            display: flex !important; 
            align-items: center !important; 
            color: #64748b; 
            text-decoration: none !important; 
            transition: all 0.2s ease;
        }

        .sidebar-link i { 
            font-size: 1.2rem; 
            margin-right: 12px; 
            width: 24px; 
            height: 24px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.2s;
        }
        i, .bi { 
            display: inline-flex !important; 
            align-items: center !important; 
            justify-content: center !important; 
            vertical-align: middle !important; 
            font-style: normal !important; 
        }
        .sidebar-link:hover { 
            background-color: #f8fafc; 
            color: var(--primary); 
            transform: translateX(4px);
        }

        /* Active State: Solid Primary (High Contrast) */
        .sidebar-item.active > .sidebar-link { 
            background-color: var(--primary) !important; 
            color: #ffffff !important; 
            font-weight: 600 !important;
            box-shadow: 0 4px 12px rgba(67, 97, 238, 0.3) !important;
        }
        .sidebar-item.active > .sidebar-link i {
            color: #ffffff !important;
        }

        /* MAIN CONTENT & HEADER */
        #main { 
            margin-left: var(--sidebar-width); 
            min-height: 100vh; 
            display: flex; 
            flex-direction: column; 
            transition: margin-left 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        header { 
            background: rgba(255, 255, 255, 0.85); 
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border-color); 
            padding: 0 2rem; 
            height: var(--header-height); 
            display: flex; 
            align-items: center; 
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .main-content-wrapper { 
            flex: 1; 
            padding: 0; 
            overflow: hidden; 
        }

        /* Utilities */
        .avatar-md { width: 42px; height: 42px; border-radius: 50%; object-fit: cover; border: 2px solid #fff; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .dropdown-menu { box-shadow: 0 10px 40px rgba(0,0,0,0.08) !important; border: 1px solid var(--border-color) !important; border-radius: 12px !important; }

        /* Responsive */
        @media (max-width: 1199px) { 
            #main { margin-left: 0 !important; } 
            #sidebar { transform: translateX(-100%); width: 280px; } 
            #sidebar.active { transform: translateX(0); box-shadow: 10px 0 50px rgba(0,0,0,0.1); } 
            header { padding: 0 1rem; }
        }
    </style>
</head>
<body>
    <div id="app">
        <div id="sidebar">
            <div class="sidebar-wrapper">
                <div class="sidebar-header">
                    <div class="logo d-flex align-items-center gap-3">
                        <img src="{{ asset('assets/static/images/logo/ppidutama.png') }}" alt="Logo" style="height: 45px;">
                        <div class="logo-text d-flex flex-column">
                            <h6 class="mb-0 fw-bold text-dark" style="font-size: 0.95rem; line-height: 1.1;">PPID KALSEL</h6>
                            <small class="text-muted fw-bold text-uppercase ls-1" style="font-size: 0.6rem; letter-spacing: 1.5px;">Admin Panel</small>
                        </div>
                    </div>
                    <a href="#" class="sidebar-hide d-xl-none text-muted"><i class="bi bi-x-lg fs-4"></i></a>
                </div>
                <div class="sidebar-menu">
                    <ul class="menu list-unstyled">
                        <li class="sidebar-title">Menu Utama</li>
                        
                        <li class="sidebar-item {{ request()->routeIs('dashboard*') ? 'active' : '' }}">
                            <a href="{{ route('dashboard') }}" class="sidebar-link">
                                <i class="bi bi-grid-1x2-fill"></i><span>Dashboard</span>
                            </a>
                        </li>

                        <li class="sidebar-title">Manajemen Konten</li>
                        
                        <li class="sidebar-item {{ request()->is('admin/pages*') || request()->routeIs('pages.*') ? 'active' : '' }}">
                            <a href="{{ route('pages.index') }}" class="sidebar-link">
                                <i class="bi bi-window-sidebar"></i><span>Halaman Profil</span>
                            </a>
                        </li>
                        <li class="sidebar-item {{ request()->is('admin/posts*') || request()->routeIs('posts.*') ? 'active' : '' }}">
                            <a href="{{ route('posts.index') }}" class="sidebar-link">
                                <i class="bi bi-newspaper"></i><span>Berita & Artikel</span>
                            </a>
                        </li>
                        <li class="sidebar-item {{ request()->is('admin/documents*') || request()->routeIs('documents.*') ? 'active' : '' }}">
                            <a href="{{ route('documents.index') }}" class="sidebar-link">
                                <i class="bi bi-folder-fill"></i><span>Dokumen Publik</span>
                            </a>
                        </li>
                        <li class="sidebar-item {{ request()->is('admin/menus*') || request()->routeIs('menus.*') ? 'active' : '' }}">
                            <a href="{{ route('menus.index') }}" class="sidebar-link">
                                <i class="bi bi-list-task"></i><span>Navigasi Menu</span>
                            </a>
                        </li>
                        <li class="sidebar-item {{ request()->is('admin/galleries*') || request()->routeIs('galleries.*') ? 'active' : '' }}">
                            <a href="{{ route('galleries.index') }}" class="sidebar-link">
                                <i class="bi bi-images"></i><span>Galeri Multimedia</span>
                            </a>
                        </li>

                        <li class="sidebar-title">Layanan & Laporan</li>
                        
                        <li class="sidebar-item {{ request()->is('admin/requests*') ? 'active' : '' }}">
                            <a href="{{ route('admin.requests.index') }}" class="sidebar-link">
                                <i class="bi bi-inbox-fill"></i><span>Permohonan Info</span>
                            </a>
                        </li>
                        <li class="sidebar-item {{ request()->is('admin/objections*') ? 'active' : '' }}">
                            <a href="{{ route('admin.objections.index') }}" class="sidebar-link">
                                <i class="bi bi-exclamation-triangle-fill"></i><span>Pengajuan Keberatan</span>
                            </a>
                        </li>
                        <li class="sidebar-item {{ request()->is('*surveys*') || request()->routeIs('surveys.*') ? 'active' : '' }}">
                            <a href="{{ route('surveys.index') }}" class="sidebar-link">
                                <i class="bi bi-bar-chart-fill"></i><span>Survei IKM</span>
                            </a>
                        </li>

                        <li class="sidebar-title">Pengaturan</li>
                        
                        <li class="sidebar-item {{ request()->is('admin/settings*') ? 'active' : '' }}">
                            <a href="{{ route('admin.settings.index') }}" class="sidebar-link">
                                <i class="bi bi-gear-fill"></i><span>Konfigurasi Website</span>
                            </a>
                        </li>

                        @if(auth()->check() && auth()->user()->role == 'super_admin')
                        <li class="sidebar-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                            <a href="{{ route('admin.users.index') }}" class="sidebar-link">
                                <i class="bi bi-people-fill"></i><span>Manajemen User</span>
                            </a>
                        </li>
                        @endif

                        <li class="sidebar-item mt-5 pt-3 border-top">
                            <form id="logout-form-sidebar" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>

                            <a href="javascript:void(0)"
                            onclick="event.preventDefault(); document.getElementById('logout-form-sidebar').submit();"
                            class="sidebar-link text-danger fw-bold" style="background: #fef2f2;">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Keluar Sistem</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div id="main">
            <header>
                <nav class="navbar navbar-expand navbar-light w-100">
                    <div class="container-fluid p-0 d-flex justify-content-between">
                        
                        {{-- Burger Button --}}
                        <a href="#" class="burger-btn d-xl-none text-dark"><i class="bi bi-list fs-2"></i></a>
                        
                        {{-- Date Display --}}
                        <div class="d-none d-lg-block me-auto ps-3 border-start ms-3">
                            <span class="text-secondary small fw-bold">
                                {{ now()->translatedFormat('l, d F Y') }}
                            </span>
                        </div>

                        <div class="d-flex align-items-center gap-4">
                            
                            {{-- Notifications --}}
                            <div class="dropdown">
                                <a href="#" data-bs-toggle="dropdown" class="text-secondary position-relative p-2 rounded-circle hover-bg-light transition-all">
                                    <i class="bi bi-bell-fill fs-5"></i>
                                    @if(auth()->user()->unreadNotifications->count() > 0)
                                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-white small-badge">
                                            {{ auth()->user()->unreadNotifications->count() }}
                                        </span>
                                    @endif
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-4 mt-3 p-0 overflow-hidden" style="width: 320px;">
                                    <li><div class="dropdown-header bg-light py-3 small fw-bold text-dark px-3 border-bottom">Notifikasi Terbaru</div></li>
                                    <div style="max-height: 280px; overflow-y: auto;">
                                        @forelse(auth()->user()->unreadNotifications as $n)
                                        <li>
                                            <a class="dropdown-item p-3 border-bottom d-flex gap-3 align-items-start" href="{{ $n->data['url'] ?? '#' }}">
                                                <div class="bg-primary bg-opacity-10 text-primary rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                                                    <i class="bi bi-info-circle-fill"></i>
                                                </div>
                                                <div class="w-100">
                                                    <p class="mb-1 small fw-bold text-dark text-wrap line-clamp-2">{{ $n->data['title'] ?? 'Notifikasi' }}</p>
                                                    <small class="text-muted d-block" style="font-size: 0.65rem;">{{ $n->created_at->diffForHumans() }}</small>
                                                </div>
                                            </a>
                                        </li>
                                        @empty 
                                        <li class="p-5 text-center text-muted small">
                                            <i class="bi bi-bell-slash fs-4 d-block mb-2 text-muted opacity-50"></i>
                                            Tidak ada notifikasi
                                        </li> 
                                        @endforelse
                                    </div>
                                    <li><div class="dropdown-footer p-2 text-center bg-light border-top"><a href="#" class="small text-primary fw-bold text-decoration-none">Lihat Semua</a></div></li>
                                </ul>
                            </div>

                            {{-- User Profile --}}
                            <div class="dropdown">
                                <a href="#" data-bs-toggle="dropdown" class="d-flex align-items-center text-decoration-none gap-3">
                                    <div class="user-name text-end d-none d-sm-block">
                                        <h6 class="mb-0 text-dark small fw-bold">{{ auth()->user()->name }}</h6>
                                        <p class="mb-0 text-muted" style="font-size: 0.65rem; text-transform: uppercase; letter-spacing: 0.5px;">{{ str_replace('_', ' ', auth()->user()->role) }}</p>
                                    </div>
                                    <div class="avatar-md bg-light d-flex align-items-center justify-content-center text-primary fs-5 fw-bold">
                                        {{ substr(auth()->user()->name, 0, 1) }}
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-4 mt-3">
                                    <div class="d-flex align-items-center gap-3 px-3 py-3 border-bottom mb-2 bg-light bg-opacity-50">
                                        <div class="avatar-md bg-primary text-white d-flex align-items-center justify-content-center fs-5 fw-bold">
                                            {{ substr(auth()->user()->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <h6 class="mb-0 text-dark fw-bold">{{ auth()->user()->name }}</h6>
                                            <small class="text-muted">{{ auth()->user()->email }}</small>
                                        </div>
                                    </div>
                                    <li><a class="dropdown-item py-2 px-3" href="{{ route('profile.edit') }}"><i class="bi bi-person-gear me-2"></i> Pengaturan Profil</a></li>
                                    <li><hr class="dropdown-divider my-2"></li>
                                    <li><a class="dropdown-item text-danger fw-bold py-2 px-3" href="#" onclick="event.preventDefault(); document.getElementById('logout-form-sidebar').submit();"><i class="bi bi-box-arrow-left me-2"></i> Keluar</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </nav>
            </header>
            
            {{-- Main Content --}}
            <div class="main-content-wrapper fade-in-up">
                @yield('content')
            </div>
            
            {{-- Footer --}}
            <footer class="py-4 px-4 mt-auto text-center border-top bg-white">
                <small class="text-muted fw-medium">&copy; {{ date('Y') }} Dinas Komunikasi dan Informatika Provinsi Kalimantan Selatan. <span class="d-none d-md-inline">All Rights Reserved.</span></small>
            </footer>
        </div>
    </div>
    
    <script src="{{ asset('assets/compiled/js/app.js') }}"></script>
    <script>
        /* Sidebar Toggle Script */
        document.querySelector('.burger-btn')?.addEventListener('click', (e) => { e.preventDefault(); document.getElementById('sidebar').classList.toggle('active'); });
        document.querySelector('.sidebar-hide')?.addEventListener('click', () => { document.getElementById('sidebar').classList.remove('active'); });
    </script>
</body>
</html>
