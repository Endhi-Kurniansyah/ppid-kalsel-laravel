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

        {{-- Deskripsi Kata Kunci --}}
        <p class="text-white lead opacity-90 mb-5 animate-fade-up delay-100" style="max-width: 700px; margin: 0 auto; text-shadow: 0 2px 5px rgba(0,0,0,0.5);">
            Menampilkan hasil untuk kata kunci: <strong class="text-warning fst-italic">"{{ $keyword ?? request('q') }}"</strong>
        </p>
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
    <div class="container" style="margin-top: -100px; position: relative; z-index: 10;">
        <div class="row justify-content-center">
            <div class="col-lg-10">

                <div class="card border-0 shadow-lg rounded-4 overflow-hidden mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="fw-bold text-dark mb-0">
                                <i class="bi bi-file-earmark-text me-2 text-primary"></i> Ditemukan {{ $documents->total() }} dokumen
                            </h5>
                            <a href="{{ url('/') }}" class="btn btn-outline-secondary btn-sm rounded-pill fw-bold">
                                <i class="bi bi-house-door-fill me-1"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>

                @if($documents->count() > 0)
                    <div class="row g-4">
                        @foreach($documents as $doc)
                        <div class="col-lg-6">
                            <div class="card h-100 border-0 shadow-sm hover-lift rounded-4 overflow-hidden doc-card">
                                <div class="card-body p-4 d-flex align-items-start">
                                    {{-- Icon --}}
                                    <div class="flex-shrink-0 me-3">
                                        <div class="doc-icon bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 50px; height: 50px;">
                                            <i class="bi bi-file-earmark-text-fill fs-4"></i>
                                        </div>
                                    </div>

                                    {{-- Content --}}
                                    <div class="flex-grow-1">
                                        <h6 class="fw-bold mb-1">
                                            <a href="{{ route('documents.public.show', $doc->id) }}" class="text-dark text-decoration-none stretched-link hover-title">
                                                {{ $doc->title }}
                                            </a>
                                        </h6>
                                        <p class="text-muted small mb-2 text-truncate-2">
                                            {{ Str::limit(strip_tags($doc->description), 100) }}
                                        </p>
                                        <div class="d-flex align-items-center small text-muted">
                                            <span class="badge bg-light text-primary border me-2">{{ $doc->category }}</span>
                                            <span><i class="bi bi-calendar3 me-1"></i> {{ $doc->created_at->format('d M Y') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-5 d-flex justify-content-center">
                        {{ $documents->appends(['q' => request('q')])->links() }}
                    </div>

                @else
                    {{-- TAMPILAN JIKA KOSONG --}}
                    <div class="text-center py-5">
                        <div class="mb-3 opacity-25">
                            <i class="bi bi-search fs-1 text-dark"></i>
                        </div>
                        <h4 class="fw-bold text-dark">Oops, tidak ditemukan!</h4>
                        <p class="text-muted">Maaf, kami tidak menemukan dokumen dengan kata kunci <strong class="text-danger">"{{ $keyword ?? request('q') }}"</strong>.</p>
                        <a href="{{ route('documents.public') }}" class="btn btn-primary rounded-pill px-4 mt-2 shadow-sm">
                            <i class="bi bi-list-ul me-2"></i> Lihat Semua Dokumen
                        </a>
                    </div>
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
</style>

@endsection
