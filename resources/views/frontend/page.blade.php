@extends('layouts.frontend')

@section('content')

{{-- 1. HERO SECTION (STYLE KONSISTEN) --}}
<section class="hero-section">
    @php
        $bgImage = (isset($globalSettings) && isset($globalSettings['hero_bg']))
            ? asset('storage/' . $globalSettings['hero_bg'])
            : 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=2070&auto=format&fit=crop';
    @endphp

    <div class="hero-bg" style="background-image: url('{{ $bgImage }}');"></div>
    <div class="hero-overlay"></div>

    <div class="container position-relative z-2 text-center py-5 mt-4">

        {{-- BADGE (Menggantikan Tombol Beranda agar seragam dengan halaman lain) --}}
        <div class="d-inline-flex align-items-center bg-white bg-opacity-10 backdrop-blur border border-white border-opacity-25 rounded-pill px-3 py-1 mb-4 animate-fade-down">
            <span class="badge bg-warning text-dark me-2 rounded-pill">INFO</span>
            <small class="fw-medium ls-1 text-white">HALAMAN RESMI</small>
        </div>

        {{-- JUDUL HALAMAN (Emas & Besar) --}}
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <h1 class="display-3 fw-bold text-white mb-3 animate-fade-up text-shadow">
                    <span class="text-gradient-gold">{{ $page->title }}</span>
                </h1>
            </div>
        </div>

        {{-- Deskripsi Singkat (Opsional, pemanis) --}}
        <p class="text-white lead opacity-90 mb-5 animate-fade-up delay-100" style="max-width: 700px; margin: 0 auto; text-shadow: 0 2px 5px rgba(0,0,0,0.5);">
            Informasi publik Dinas Komunikasi dan Informatika Provinsi Kalimantan Selatan.
        </p>
    </div>

    {{-- Wave Separator (Putih) --}}
    <div class="hero-wave">
        <svg viewBox="0 0 1440 100" xmlns="http://www.w3.org/2000/svg">
            <path fill="#ffffff" d="M0,64L48,69.3C96,75,192,85,288,80C384,75,480,53,576,42.7C672,32,768,32,864,42.7C960,53,1056,75,1152,80C1248,85,1344,75,1392,69.3L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
        </svg>
    </div>
</section>

{{-- 2. KONTEN HALAMAN --}}
<div class="bg-white" style="min-height: 600px; padding-bottom: 5rem;">

    {{-- Margin negatif untuk menarik konten ke atas wave --}}
    <div class="container" style="margin-top: -100px; position: relative; z-index: 10;">
        <div class="row justify-content-center">
            <div class="col-lg-10">

                {{-- Card Konten --}}
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden animate-fade-up delay-100">
                    <div class="card-body p-4 p-md-5 bg-white">

                        {{-- Render Konten dari Database (CKEditor) --}}
                        <div class="ck-content">
                            {!! $page->content !!}
                        </div>

                    </div>

                    {{-- Footer Card Kecil --}}
                    <div class="card-footer bg-light border-top py-3 text-center">
                        <small class="text-muted">
                            <i class="bi bi-clock-history me-1"></i> Terakhir diperbarui: {{ $page->updated_at->format('d F Y') }}
                        </small>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

{{-- CSS KHUSUS --}}
<style>
    /* HERO & ANIMATION STYLES (Sama Persis dengan Welcome/Docs) */
    .hero-section {
        position: relative; min-height: 55vh; display: flex; align-items: center; justify-content: center;
        background-color: #0f172a; overflow: hidden; margin-top: -85px; padding-top: 100px;
    }
    .hero-bg {
        position: absolute; top: 0; left: 0; width: 100%; height: 100%;
        background-position: center; background-size: cover; background-repeat: no-repeat;
        z-index: 0; animation: zoomEffect 20s infinite alternate;
    }
    .hero-overlay {
        position: absolute; top: 0; left: 0; width: 100%; height: 100%;
        background: linear-gradient(180deg, rgba(15, 23, 42, 0.9) 0%, rgba(15, 23, 42, 0.7) 100%);
        z-index: 1;
    }
    .hero-wave { position: absolute; bottom: -2px; left: 0; width: 100%; line-height: 0; z-index: 1; pointer-events: none; }

    .text-gradient-gold {
        background: linear-gradient(to right, #FFF8DC, #FFD700, #FFA500);
        -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        font-weight: 800; filter: drop-shadow(0 2px 2px rgba(0,0,0,0.5));
    }

    @keyframes zoomEffect { from { transform: scale(1); } to { transform: scale(1.1); } }
    .text-shadow { text-shadow: 0 2px 4px rgba(0,0,0,0.5); }
    .backdrop-blur { backdrop-filter: blur(5px); }
    .ls-1 { letter-spacing: 1px; }

    /* Animation Utilities */
    .animate-fade-up { animation: fadeUp 0.8s ease-out forwards; opacity: 0; transform: translateY(20px); }
    .animate-fade-down { animation: fadeDown 0.8s ease-out forwards; opacity: 0; transform: translateY(-20px); }
    .delay-100 { animation-delay: 0.2s; }
    @keyframes fadeUp { to { opacity: 1; transform: translateY(0); } }
    @keyframes fadeDown { to { opacity: 1; transform: translateY(0); } }

    /* CKEDITOR CONTENT STYLES (Agar isi tulisan rapi) */
    .ck-content {
        color: #334155;
        line-height: 1.8;
        font-size: 1.1rem;
        text-align: justify;
    }
    .ck-content p { margin-bottom: 1.5rem; }

    /* Gambar di dalam konten */
    .ck-content img {
        max-width: 100% !important;
        height: auto !important;
        display: block;
        margin: 30px auto;
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        transition: transform 0.3s ease;
    }
    .ck-content img:hover { transform: scale(1.02); }

    /* Heading di dalam konten */
    .ck-content h2, .ck-content h3, .ck-content h4 {
        color: #0f172a; font-weight: 800; margin-top: 2.5rem; margin-bottom: 1rem;
        position: relative; display: inline-block;
    }

    /* List */
    .ck-content ul, .ck-content ol { padding-left: 1.5rem; margin-bottom: 1.5rem; }
    .ck-content li { margin-bottom: 0.8rem; }

    /* Tabel di dalam konten */
    .ck-content table { width: 100%; border-collapse: separate; border-spacing: 0; margin: 2rem 0; border-radius: 8px; overflow: hidden; border: 1px solid #e2e8f0; }
    .ck-content table th { background-color: #f1f5f9; color: #0f172a; padding: 15px; font-weight: bold; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 0.5px; }
    .ck-content table td { padding: 15px; border-top: 1px solid #e2e8f0; }
    .ck-content table tr:hover td { background-color: #f8fafc; }

    /* Blockquote */
    .ck-content blockquote {
        border-left: 5px solid #FFD700;
        background: #fffbeb;
        padding: 20px;
        font-style: italic;
        color: #475569;
        margin: 20px 0;
        border-radius: 0 8px 8px 0;
    }
</style>

@endsection
