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
<style>
    .note-group-select-from-files { display: none; } /* Opsional: Sembunyikan fitur upload file bawaan jika mau simpel */
</style>
</head>

<body>
    <script src="{{ asset('assets/static/js/initTheme.js') }}"></script>
    <div id="app">
        <div id="sidebar">
            <div class="sidebar-wrapper active">
                <div class="sidebar-header position-relative">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="logo">
                            <a href="#" style="font-size: 25px; font-weight: bold;">PPID Kalsel</a>
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

                        <li class="sidebar-title">Laporan Magang</li>

                        <li class="sidebar-item {{ Request::is('requests*') ? 'active' : '' }}">
                            <a href="{{ route('requests.index') }}" class='sidebar-link'>
                                <i class="bi bi-file-earmark-text"></i>
                                <span>Permohonan Info</span>
                            </a>
                        </li>
                        <li class="sidebar-item {{ Request::is('surveys*') ? 'active' : '' }}">
                            <a href="{{ route('surveys.index') }}" class='sidebar-link'>
                                <i class="bi bi-bar-chart-fill"></i>
                                <span>Laporan Survei (IKM)</span>
                            </a>
                        </li>
                        <li class="sidebar-item {{ Request::is('documents*') ? 'active' : '' }}">
                            <a href="{{ route('documents.index') }}" class='sidebar-link'>
                                <i class="bi bi-folder-fill"></i>
                                <span>Inventaris Dokumen</span>
                            </a>
                        </li>
                        <li class="sidebar-item {{ Request::is('pages*') ? 'active' : '' }}">
                            <a href="{{ route('pages.index') }}" class='sidebar-link'>
                                <i class="bi bi-journal-text"></i>
                                <span>Manajemen Halaman</span>
                            </a>
                        </li>

                        <li class="sidebar-item mt-5">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a href="{{ route('logout') }}" class='sidebar-link text-danger'
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    <i class="bi bi-box-arrow-left"></i>
                                    <span>Logout</span>
                                </a>
                            </form>
                        </li>

                    </ul>
                </div>
            </div>
        </div>

        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>

            <div class="page-heading">
                <h3>@yield('page-title')</h3>
            </div>

            <div class="page-content">
                @yield('content')
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/static/js/components/dark.js') }}"></script>
    <script src="{{ asset('assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/compiled/js/app.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

    <script>
        // Aktifkan Summernote di semua textarea yang punya ID 'content-editor'
        $('#content-editor').summernote({
            placeholder: 'Tulis isi konten di sini...',
            tabsize: 2,
            height: 400, // Tinggi editor
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']], // Bisa upload gambar
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
    </script>

</body>
</html>
