@extends('layouts.frontend')

@section('content')

{{-- 1. HERO SECTION (STYLE WELCOME) --}}
<section class="hero-section">
    @php
        $bgImage = (isset($globalSettings) && isset($globalSettings['hero_bg']))
            ? asset('storage/' . $globalSettings['hero_bg'])
            : 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=2070&auto=format&fit=crop';
    @endphp

    <div class="hero-bg" style="background-image: url('{{ $bgImage }}');"></div>
    <div class="hero-overlay"></div>

    <div class="container position-relative z-2 text-center py-5 mt-4">

        {{-- Badge --}}
        <div class="d-inline-flex align-items-center bg-white bg-opacity-10 backdrop-blur border border-white border-opacity-25 rounded-pill px-3 py-1 mb-4 animate-fade-down">
            <span class="badge bg-warning text-dark me-2 rounded-pill">INFO</span>
            <small class="fw-medium ls-1 text-white">KABAR TERBARU</small>
        </div>

        {{-- Judul Emas --}}
        <h1 class="display-3 fw-bold mb-3 animate-fade-up text-white">
            Berita & <span class="text-gradient-gold">Kegiatan</span>
        </h1>

        {{-- Deskripsi --}}
        <p class="text-white lead opacity-90 mb-5 animate-fade-up delay-100" style="max-width: 700px; margin: 0 auto; text-shadow: 0 2px 5px rgba(0,0,0,0.5);">
            Informasi terkini seputar kegiatan Dinas Kominfo Kalsel dan layanan publik.
        </p>

        {{-- FORM PENCARIAN (HERO STYLE) --}}
        <div class="row justify-content-center animate-fade-up delay-200">
            <div class="col-lg-7">
                <form action="" method="GET">
                    <div class="input-group search-group shadow-lg">
                        <span class="input-group-text bg-white border-0 ps-4">
                            <i class="bi bi-search text-primary fs-5"></i>
                        </span>
                        <input type="text" name="q" class="form-control border-0 py-3 ps-3"
                               placeholder="Cari berita atau artikel..."
                               value="{{ request('q') }}"
                               style="font-size: 1.1rem;">
                        <button class="btn btn-primary px-4 fw-bold" type="submit">CARI</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Wave Separator (Putih) --}}
    <div class="hero-wave">
        <svg viewBox="0 0 1440 100" xmlns="http://www.w3.org/2000/svg">
            <path fill="#ffffff" d="M0,64L48,69.3C96,75,192,85,288,80C384,75,480,53,576,42.7C672,32,768,32,864,42.7C960,53,1056,75,1152,80C1248,85,1344,75,1392,69.3L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
        </svg>
    </div>
</section>

{{-- 2. KONTEN BERITA --}}
<div class="py-5 bg-white" style="min-height: 600px;">
    {{-- Margin negatif ditarik ke atas --}}
    <div class="container" style="margin-top: -60px; position: relative; z-index: 10;">

        <div class="row justify-content-center">
            <div class="col-lg-8">

                {{-- Hasil Pencarian Info --}}
                @if(request('q'))
                    <div class="alert alert-light border shadow-sm mb-4 d-flex justify-content-between align-items-center animate-fade-up">
                        <span><i class="bi bi-info-circle me-2 text-primary"></i> Menampilkan hasil pencarian: <strong>"{{ request('q') }}"</strong></span>
                    </div>
                @endif

                {{-- LIST BERITA (CARD STYLE) --}}
                <div class="d-flex flex-column gap-4">
                    @forelse($posts as $post)
                        <div class="card border-0 shadow-lg rounded-4 overflow-hidden hover-lift animate-fade-up news-card">
                            <div class="row g-0">

                                {{-- GAMBAR (KIRI) --}}
                                <div class="col-md-4 position-relative overflow-hidden news-img-wrapper">
                                    <a href="{{ route('news.show', $post->slug) }}" class="d-block h-100">
                                        @if($post->image)
                                            <img src="{{ asset('storage/' . $post->image) }}" class="img-fluid w-100 h-100 object-fit-cover transition-scale" alt="{{ $post->title }}">
                                        @else
                                            <div class="w-100 h-100 bg-light d-flex align-items-center justify-content-center text-muted" style="min-height: 200px;">
                                                <i class="bi bi-image fs-1 opacity-25"></i>
                                            </div>
                                        @endif
                                    </a>
                                    {{-- Badge Kategori --}}
                                    <div class="position-absolute top-0 start-0 m-3">
                                        <span class="badge bg-primary bg-opacity-90 backdrop-blur rounded-pill shadow-sm px-3 py-2 text-uppercase ls-1">
                                            {{ $post->category->name ?? 'Berita' }}
                                        </span>
                                    </div>
                                </div>

                                {{-- KONTEN (KANAN) --}}
                                <div class="col-md-8">
                                    <div class="card-body p-4 d-flex flex-column h-100">

                                        {{-- Tanggal --}}
                                        <div class="d-flex align-items-center text-muted small mb-2 fw-medium">
                                            <i class="bi bi-calendar-event me-2 text-warning"></i>
                                            {{ $post->created_at->format('d F Y') }}
                                        </div>

                                        {{-- Judul --}}
                                        <h4 class="card-title fw-bold mb-2">
                                            <a href="{{ route('news.show', $post->slug) }}" class="text-dark text-decoration-none hover-title">
                                                {{ Str::limit($post->title, 60) }}
                                            </a>
                                        </h4>

                                        {{-- Cuplikan Isi --}}
                                        <p class="card-text text-muted mb-3 flex-grow-1" style="line-height: 1.6; font-size: 0.95rem;">
                                            {{ Str::limit(strip_tags($post->content), 120) }}
                                        </p>

                                        {{-- Footer Card --}}
                                        <div class="mt-auto d-flex align-items-center justify-content-between border-top pt-3">
                                            <div class="d-flex align-items-center small text-muted">
                                                <div class="bg-light rounded-circle p-1 me-2 border">
                                                    <i class="bi bi-person-fill text-secondary"></i>
                                                </div>
                                                <span class="fw-medium">{{ Str::limit($post->user->name, 15) }}</span>
                                            </div>
                                            <a href="{{ route('news.show', $post->slug) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-bold">
                                                Baca Selengkapnya <i class="bi bi-arrow-right ms-1"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    @empty
                        {{-- STATE KOSONG --}}
                        <div class="text-center py-5">
                            <div class="mb-3 opacity-25">
                                <i class="bi bi-newspaper fs-1 text-dark"></i>
                            </div>
                            <h5 class="fw-bold text-dark">Belum ada berita terbaru.</h5>
                            <p class="text-muted">Silakan cek kembali nanti.</p>
                        </div>
                    @endforelse
                </div>

                {{-- PAGINATION --}}
                <div class="mt-5 d-flex justify-content-center">
                    {{-- {!! $posts->links() !!} --}}
                </div>

            </div>
        </div>

    </div>
</div>

{{-- CSS KHUSUS --}}
<style>
    /* HERO STYLES (Sama dengan Welcome/Docs) */
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

    /* SEARCH BAR */
    .search-group {
        border-radius: 50px; overflow: hidden; padding: 5px;
        background: rgba(255, 255, 255, 0.95);
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    }
    .search-group input:focus { box-shadow: none; background: transparent; }
    .search-group .btn-primary {
        border-radius: 50px; background: linear-gradient(45deg, #2563eb, #1d4ed8); border: none;
    }

    /* NEWS CARD STYLES */
    .news-card { transition: all 0.3s ease; border-left: 4px solid transparent !important; background-color: #fff; }
    .news-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important;
        border-left: 4px solid #FFD700 !important; /* Aksen Emas */
    }
    .news-img-wrapper { min-height: 250px; } /* Tinggi minimal gambar */

    .object-fit-cover { object-fit: cover; }
    .transition-scale { transition: transform 0.6s ease; }
    .news-card:hover .transition-scale { transform: scale(1.05); }
    .hover-title:hover { color: #2563eb !important; text-decoration: underline !important; }

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
