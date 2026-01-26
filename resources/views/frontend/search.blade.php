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
            <span class="badge bg-warning text-dark me-2 rounded-pill">PENCARIAN</span>
            <small class="fw-medium ls-1 text-white">HASIL PENELUSURAN</small>
        </div>

        {{-- Judul Emas --}}
        <h1 class="display-4 fw-bold mb-3 animate-fade-up text-white">
            Hasil <span class="text-gradient-gold">Pencarian</span>
        </h1>
        <p class="text-white lead opacity-90 mb-5 animate-fade-up delay-100" style="max-width: 700px; margin: 0 auto; text-shadow: 0 2px 5px rgba(0,0,0,0.5);">
            Hasil pencarian Berita dan dokumen.
        </p>

        {{-- Deskripsi Kata Kunci (DIHAPUS SESUAI REQUEST) --}}

        {{-- FORM PENCARIAN (HERO STYLE) --}}
        <div class="row justify-content-center animate-fade-up delay-200">
            <div class="col-lg-7">
                <form action="{{ route('global.search') }}" method="GET">
                    <div class="input-group search-group shadow-lg">
                        <span class="input-group-text bg-white border-0 ps-4">
                            <i class="bi bi-search text-primary fs-5"></i>
                        </span>
                        <input type="text" name="q" class="form-control border-0 py-3 ps-3"
                               placeholder="Cari berita atau dokumen..."
                               value="{{ $keyword ?? request('q') }}"
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

{{-- 2. DAFTAR HASIL --}}
<div class="py-5 bg-white" style="min-height: 600px;">
    {{-- Margin negatif tarik ke atas --}}
    <div class="container" style="margin-top: -60px; position: relative; z-index: 10;">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                {{-- Hasil Pencarian Info (ADDED TO MATCH USER REQUEST) --}}
                @if(request('q') || isset($keyword))
                    <div class="alert alert-light border shadow-sm mb-4 d-flex justify-content-between align-items-center animate-fade-up">
                        <span><i class="bi bi-info-circle me-2 text-primary"></i> Menampilkan hasil pencarian: <strong>"{{ $keyword ?? request('q') }}"</strong></span>
                    </div>
                @endif

                {{-- SUMMARY REMOVED AS REQUESTED --}}

                @if($posts->count() == 0 && $documents->count() == 0)
                    {{-- TAMPILAN JIKA KOSONG (MATCHING NEWS STYLE) --}}
                    <div class="text-center py-5">
                        <div class="mb-3 opacity-25">
                            <i class="bi bi-search fs-1 text-dark"></i>
                        </div>
                        <h5 class="fw-bold text-dark">Tidak ditemukan hasil pencarian.</h5>
                        <p class="text-muted">Silakan coba kata kunci lain.</p>
                    </div>
                @else
                    {{-- 1. HASIL BERITA --}}
                    @if($posts->count() > 0)
                    <div class="mb-5">
                        <div class="d-flex align-items-center mb-4">
                            <h4 class="fw-bold text-dark mb-0 me-3"><i class="bi bi-newspaper text-primary me-2"></i> Berita Terkait</h4>
                            <div class="flex-grow-1 border-bottom"></div>
                        </div>

                        <div class="row g-4">
                            @foreach($posts as $post)
                            <div class="col-md-6 col-lg-4">
                                <div class="card h-100 border-0 shadow-sm hover-lift rounded-4 overflow-hidden">
                                     <div class="position-relative">
                                         @if($post->image)
                                            <img src="{{ asset('storage/' . $post->image) }}" class="card-img-top" style="height: 200px; object-fit: cover;" alt="{{ $post->title }}">
                                         @else
                                            <div class="bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                                <i class="bi bi-image text-muted fs-1"></i>
                                            </div>
                                         @endif
                                         <span class="badge bg-primary position-absolute top-0 end-0 m-3">{{ $post->category->name ?? 'Umum' }}</span>
                                     </div>
                                     <div class="card-body p-4">
                                         <small class="text-muted d-block mb-2"><i class="bi bi-calendar-event me-1"></i> {{ $post->created_at->format('d M Y') }}</small>
                                         <h6 class="fw-bold mb-2 line-clamp-2">
                                             <a href="{{ route('news.show', $post->slug) }}" class="text-dark text-decoration-none stretched-link">{{ $post->title }}</a>
                                         </h6>
                                     </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                         @if($posts->count() >= 6)
                            <div class="text-center mt-3">
                                <a href="{{ route('news.index', ['q' => $keyword]) }}" class="btn btn-outline-primary rounded-pill btn-sm">Lihat Semua Berita <i class="bi bi-arrow-right ms-1"></i></a>
                            </div>
                         @endif
                    </div>
                    @endif

                    {{-- 2. HASIL DOKUMEN --}}
                    @if($documents->count() > 0)
                    <div class="mb-4">
                        <div class="d-flex align-items-center mb-4">
                            <h4 class="fw-bold text-dark mb-0 me-3"><i class="bi bi-file-earmark-text text-warning me-2"></i> Dokumen Terkait</h4>
                            <div class="flex-grow-1 border-bottom"></div>
                        </div>

                        <div class="row g-4">
                            @foreach($documents as $doc)
                            <div class="col-lg-6">
                                <div class="card h-100 border-0 shadow-sm hover-lift rounded-4 overflow-hidden doc-card">
                                    <div class="card-body p-4 d-flex align-items-start">
                                        <div class="flex-shrink-0 me-3">
                                            <div class="doc-icon bg-warning bg-opacity-10 text-warning rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 50px; height: 50px;">
                                                <i class="bi bi-file-earmark-text-fill fs-4"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="fw-bold mb-1">
                                                <a href="{{ route('documents.public.show', $doc->id) }}" class="text-dark text-decoration-none stretched-link hover-title">
                                                    {{ $doc->title }}
                                                </a>
                                            </h6>
                                            <div class="d-flex align-items-center small text-muted">
                                                <span class="badge bg-light text-dark border me-2">{{ $doc->category }}</span>
                                                <span><i class="bi bi-calendar3 me-1"></i> {{ $doc->created_at->format('d M Y') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                         @if($documents->count() >= 8)
                            <div class="text-center mt-3">
                                <a href="{{ route('documents.public', ['q' => $keyword]) }}" class="btn btn-outline-warning text-dark rounded-pill btn-sm">Lihat Semua Dokumen <i class="bi bi-arrow-right ms-1"></i></a>
                            </div>
                         @endif
                    </div>
                    @endif
                @endif

            </div>
        </div>
    </div>
</div>

{{-- CSS KHUSUS --}}
<style>
    /* HERO STYLES */
    .hero-section {
        position: relative; min-height: 50vh; display: flex; align-items: center; justify-content: center;
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

    /* CARD STYLES */
    .hover-lift { transition: transform 0.3s ease, box-shadow 0.3s ease; }
    .hover-lift:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important; }
    .doc-card { background: #fff; border: 1px solid #f0f0f0; }
    .doc-card:hover .doc-icon { background-color: #FFD700 !important; color: #0f172a !important; transition: 0.3s; }
    .hover-title:hover { color: #2563eb !important; text-decoration: underline !important; }

    /* ANIMATIONS */
    .animate-fade-up { animation: fadeUp 0.8s ease-out forwards; opacity: 0; transform: translateY(20px); }
    .animate-fade-down { animation: fadeDown 0.8s ease-out forwards; opacity: 0; transform: translateY(-20px); }
    .delay-100 { animation-delay: 0.2s; }

    @keyframes fadeUp { to { opacity: 1; transform: translateY(0); } }
    @keyframes fadeDown { to { opacity: 1; transform: translateY(0); } }

    .ls-1 { letter-spacing: 1px; }
    .backdrop-blur { backdrop-filter: blur(5px); }
    .text-truncate-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }

    /* SEARCH BAR PREMIUM */
    .search-group {
        border-radius: 50px; overflow: hidden; padding: 5px;
        background: rgba(255, 255, 255, 0.95);
        transition: all 0.3s ease;
    }
    .search-group:hover { box-shadow: 0 15px 40px rgba(0,0,0,0.1) !important; transform: translateY(-2px); }
    .search-group input:focus { box-shadow: none; background: transparent; }
    .search-group .btn-primary {
        border-radius: 50px; background: linear-gradient(45deg, #2563eb, #1d4ed8); border: none;
    }
</style>

@endsection
