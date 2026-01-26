@extends('layouts.frontend')

@section('content')

{{-- 1. HERO SECTION (KEMBALI KE BIRU STANDAR) --}}
<section class="hero-section">
    @php
        $bgImage = (isset($globalSettings) && isset($globalSettings['hero_bg']))
            ? asset('storage/' . $globalSettings['hero_bg'])
            : 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=2070&auto=format&fit=crop';
    @endphp

    <div class="hero-bg" style="background-image: url('{{ $bgImage }}');"></div>

    {{-- Overlay Biru Gelap (Konsisten dengan halaman lain) --}}
    <div class="hero-overlay" style="background: linear-gradient(180deg, rgba(15, 23, 42, 0.9) 0%, rgba(15, 23, 42, 0.7) 100%);"></div>

    <div class="container position-relative z-2 text-center py-5 mt-4">

        {{-- Badge Merah (Sebagai penanda fungsi) --}}
        <div class="d-inline-flex align-items-center bg-white bg-opacity-10 backdrop-blur border border-white border-opacity-25 rounded-pill px-3 py-1 mb-4 animate-fade-down">
            <span class="badge bg-danger text-white me-2 rounded-pill">LAYANAN</span>
            <small class="fw-medium ls-1 text-white">PENGAJUAN KEBERATAN</small>
        </div>

        {{-- Judul Emas --}}
        <h1 class="display-3 fw-bold mb-3 animate-fade-up text-white">
            Ajukan <span class="text-gradient-gold">Keberatan</span>
        </h1>

        {{-- Deskripsi --}}
        <p class="text-white lead opacity-90 mb-5 animate-fade-up delay-100" style="max-width: 700px; margin: 0 auto; text-shadow: 0 2px 5px rgba(0,0,0,0.5);">
            Jika permohonan informasi Anda tidak ditanggapi atau tidak sesuai, silakan ajukan keberatan di sini.
        </p>
    </div>

    {{-- Wave Separator (Putih) --}}
    <div class="hero-wave">
        <svg viewBox="0 0 1440 100" xmlns="http://www.w3.org/2000/svg">
            <path fill="#ffffff" d="M0,64L48,69.3C96,75,192,85,288,80C384,75,480,53,576,42.7C672,32,768,32,864,42.7C960,53,1056,75,1152,80C1248,85,1344,75,1392,69.3L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
        </svg>
    </div>
</section>

{{-- 2. KONTEN INPUT TIKET --}}
<div class="py-5 bg-white" style="min-height: 600px;">
    <div class="container" style="margin-top: -100px; position: relative; z-index: 10;">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">

                <div class="card border-0 shadow-lg rounded-4 overflow-hidden animate-fade-up delay-200">
                    <div class="card-body p-4 p-md-5">

                        {{-- Ikon Header Merah --}}
                        <div class="text-center mb-4">
                            <div class="d-inline-flex align-items-center justify-content-center bg-danger bg-opacity-10 text-danger rounded-circle mb-3 shadow-sm" style="width: 80px; height: 80px;">
                                <i class="bi bi-shield-exclamation" style="font-size: 2.5rem;"></i>
                            </div>
                            <h4 class="fw-bold text-dark mb-2">Verifikasi Tiket Permohonan</h4>
                            <p class="text-muted small">
                                Masukkan <strong>Nomor Tiket</strong> permohonan informasi Anda sebelumnya untuk melanjutkan proses.
                            </p>
                        </div>

                        {{-- Alert Error (Jika Tiket Salah) --}}
                        @if(session('error'))
                            <div class="alert alert-danger border-0 d-flex align-items-center mb-4 rounded-3 shadow-sm animate-fade-down">
                                <i class="bi bi-exclamation-triangle-fill me-3 fs-4"></i>
                                <div>{{ session('error') }}</div>
                            </div>
                        @endif

                        {{-- FORM INPUT --}}
                        <form action="{{ route('objection.create') }}" method="GET">

                            <div class="mb-4">
                                <label class="form-label fw-bold small text-uppercase text-muted ls-1 mb-2">Nomor Tiket</label>
                                <div class="input-group input-group-lg shadow-sm rounded-pill overflow-hidden border transition-all hover-border-danger">
                                    <span class="input-group-text bg-white border-0 ps-4 text-muted">
                                        <i class="bi bi-ticket-perforated-fill fs-5"></i>
                                    </span>
                                    <input type="text" name="ticket" class="form-control border-0 ps-2 fw-bold text-dark" placeholder="Contoh: REQ-2025-XXXX" required autofocus style="letter-spacing: 1px;">
                                </div>
                            </div>

                            <div class="d-grid">
                                <button class="btn btn-danger btn-lg rounded-pill fw-bold shadow-lg hover-scale py-3" type="submit">
                                    Lanjut Proses <i class="bi bi-arrow-right ms-2"></i>
                                </button>
                            </div>

                        </form>

                        {{-- Footer Card --}}
                        <div class="mt-4 pt-4 border-top text-center">
                            <p class="text-muted small mb-2">Belum punya tiket? Ajukan permohonan dulu.</p>
                            <a href="{{ route('requests.create') }}" class="text-decoration-none small fw-bold text-danger hover-underline">
                                <i class="bi bi-file-earmark-plus me-1"></i> Form Permohonan Informasi
                            </a>
                        </div>

                    </div>
                </div>

                {{-- Bantuan --}}
                <div class="text-center mt-4 animate-fade-up delay-200">
                    <p class="text-muted small">
                        Lupa nomor tiket? <a href="{{ route('requests.track') }}" class="text-danger text-decoration-none fw-bold hover-underline">Cek Status Disini</a>
                    </p>
                </div>

            </div>
        </div>
    </div>
</div>

{{-- CSS KHUSUS --}}
<style>
    /* HERO STYLES (Biru Gelap Standar) */
    .hero-section {
        position: relative; min-height: 55vh; display: flex; align-items: center; justify-content: center;
        background-color: #0f172a; /* Kembali ke biru */
        overflow: hidden; margin-top: -85px; padding-top: 100px;
    }
    .hero-bg {
        position: absolute; top: 0; left: 0; width: 100%; height: 100%;
        background-position: center; background-size: cover; background-repeat: no-repeat;
        z-index: 0; animation: zoomEffect 20s infinite alternate;
    }
    .hero-overlay {
        position: absolute; top: 0; left: 0; width: 100%; height: 100%;
        /* Hapus background merah di sini karena sudah di-set di inline style HTML */
        z-index: 1;
    }
    .hero-wave { position: absolute; bottom: -2px; left: 0; width: 100%; line-height: 0; z-index: 1; pointer-events: none; }

    .text-gradient-gold {
        background: linear-gradient(to right, #FFF8DC, #FFD700, #FFA500);
        -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        font-weight: 800; filter: drop-shadow(0 2px 2px rgba(0,0,0,0.5));
    }

    @keyframes zoomEffect { from { transform: scale(1); } to { transform: scale(1.1); } }

    /* INPUT STYLES (Aksen Merah) */
    .form-control:focus { box-shadow: none; }
    .input-group:focus-within {
        box-shadow: 0 0 0 4px rgba(220, 53, 69, 0.15) !important; /* Ring Merah */
        border-color: #dc3545 !important;
    }
    .hover-border-danger:hover { border-color: #dc3545 !important; }

    /* BUTTONS (Aksen Merah) */
    .hover-scale { transition: transform 0.2s, box-shadow 0.2s; }
    .hover-scale:hover { transform: translateY(-3px); box-shadow: 0 10px 25px rgba(220, 53, 69, 0.4) !important; }
    .hover-underline:hover { text-decoration: underline !important; }

    /* ANIMATIONS */
    .animate-fade-up { animation: fadeUp 0.8s ease-out forwards; opacity: 0; transform: translateY(20px); }
    .animate-fade-down { animation: fadeDown 0.8s ease-out forwards; opacity: 0; transform: translateY(-20px); }
    .delay-100 { animation-delay: 0.2s; }
    .delay-200 { animation-delay: 0.4s; }

    @keyframes fadeUp { to { opacity: 1; transform: translateY(0); } }
    @keyframes fadeDown { to { opacity: 1; transform: translateY(0); } }

    .ls-1 { letter-spacing: 1px; }
    .backdrop-blur { backdrop-filter: blur(5px); }
</style>

@endsection
