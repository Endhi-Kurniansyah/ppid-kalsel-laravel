@extends('layouts.frontend')

@section('content')

{{-- 1. HERO SECTION (STYLE WELCOME PAGE) --}}
<section class="hero-section">
    @php
        $bgImage = (isset($globalSettings) && isset($globalSettings['hero_bg']))
            ? asset('storage/' . $globalSettings['hero_bg'])
            : 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=2070&auto=format&fit=crop';
    @endphp

    {{-- Background & Overlay --}}
    <div class="hero-bg" style="background-image: url('{{ $bgImage }}');"></div>
    <div class="hero-overlay"></div>

    <div class="container position-relative z-2 text-center py-5 mt-4">
        {{-- Badge --}}
        <div class="d-inline-flex align-items-center bg-white bg-opacity-10 backdrop-blur border border-white border-opacity-25 rounded-pill px-3 py-1 mb-4 animate-fade-down">
            <span class="badge bg-warning text-dark me-2 rounded-pill">ARSIP</span>
            <small class="fw-bold ls-1 text-white">DOKUMEN PUBLIK</small>
        </div>

        {{-- Judul Emas --}}
        <h1 class="display-3 fw-bold mb-3 animate-fade-up text-white">
            <span class="text-gradient-gold">{{ $category_title ?? 'Dokumen Publik' }}</span>
        </h1>

        {{-- Deskripsi --}}
        <p class="text-white lead opacity-90 mb-5 animate-fade-up delay-100" style="max-width: 700px; margin: 0 auto; text-shadow: 0 2px 5px rgba(0,0,0,0.5);">
            {{ $category_desc ?? 'Transparansi informasi untuk masyarakat Kalimantan Selatan.' }}
        </p>

        {{-- FORM PENCARIAN (HERO STYLE) --}}
        <div class="row justify-content-center animate-fade-up delay-200">
            <div class="col-lg-7">
                <form action="{{ request()->url() }}" method="GET">
                    @if(request('category'))
                        <input type="hidden" name="category" value="{{ request('category') }}">
                    @endif

                    <div class="input-group search-group shadow-lg">
                        <span class="input-group-text bg-white border-0 ps-4">
                            <i class="bi bi-search text-primary fs-5"></i>
                        </span>
                        <input type="text" name="q" class="form-control border-0 py-3 ps-3"
                               placeholder="Cari judul dokumen..."
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

{{-- 2. KONTEN LIST DOKUMEN --}}
<div class="py-5 bg-white" style="min-height: 600px;">

    {{-- Posisi Konten (Ditarik ke atas sedikit agar menyatu) --}}
    <div class="container" style="margin-top: -60px; position: relative; z-index: 10;">

        <div class="row justify-content-center">
            <div class="col-lg-8">

                {{-- Hasil Pencarian Info --}}
                @if(request('q'))
                    <div class="alert alert-light border shadow-sm mb-4 d-flex justify-content-between align-items-center animate-fade-up">
                        <span><i class="bi bi-info-circle me-2 text-primary"></i> Menampilkan hasil pencarian: <strong>"{{ request('q') }}"</strong></span>
                    </div>
                @endif

                {{-- LIST DOKUMEN --}}
                <div class="d-flex flex-column gap-3">
                    @forelse($documents as $doc)
                        <div class="card doc-card border-0 shadow-lg rounded-4 overflow-hidden p-1 animate-fade-up">
                            <div class="card-body d-flex align-items-center p-3">

                                {{-- Icon --}}
                                <div class="flex-shrink-0 me-3 d-none d-md-block">
                                    <div class="doc-icon bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 60px; height: 60px;">
                                        <i class="bi bi-file-earmark-text-fill fs-3"></i>
                                    </div>
                                </div>

                                {{-- Text Content --}}
                                <div class="flex-grow-1">
                                    <div class="d-flex align-items-center mb-1">
                                        <span class="badge bg-light text-primary border border-primary border-opacity-25 me-2 rounded-pill px-2" style="font-size: 0.7rem;">
                                            {{ $doc->category ?? 'Umum' }}
                                        </span>
                                        <small class="text-muted fw-medium" style="font-size: 0.75rem;">
                                            <i class="bi bi-calendar3 me-1"></i> {{ $doc->created_at->format('d M Y') }}
                                        </small>
                                    </div>

                                    <h5 class="fw-bold mb-1">
                                        <a href="{{ route('documents.public.show', $doc->id) }}" class="text-dark text-decoration-none stretched-link hover-title">
                                            {{ $doc->title }}
                                        </a>
                                    </h5>

                                    @if($doc->description)
                                    <p class="text-muted small mb-0 text-truncate-2" style="font-size: 0.9rem; line-height: 1.5;">
                                        {{ Str::limit(strip_tags($doc->description), 120) }}
                                    </p>
                                    @endif
                                </div>

                                {{-- Arrow --}}
                                <div class="flex-shrink-0 ms-3 text-muted arrow-icon">
                                    <i class="bi bi-chevron-right fs-5"></i>
                                </div>
                            </div>
                        </div>
                    @empty
                        {{-- STATE KOSONG --}}
                        <div class="text-center py-5">
                            <div class="mb-3 opacity-25">
                                <i class="bi bi-folder-x fs-1 text-dark"></i>
                            </div>
                            <h5 class="fw-bold text-dark">Dokumen tidak ditemukan.</h5>
                            <p class="text-muted">Silakan coba kata kunci lain.</p>
                        </div>
                    @endforelse
                </div>

                {{-- PAGINATION --}}
                <div class="mt-5 d-flex justify-content-center">
                    @if($documents instanceof \Illuminate\Pagination\LengthAwarePaginator)
                        {{ $documents->links() }}
                    @endif
                </div>

            </div>
        </div>

    </div>
</div>

{{-- CSS KHUSUS --}}
<style>
    /* HERO SECTION */
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

    /* TYPOGRAPHY */
    .text-gradient-gold {
        background: linear-gradient(to right, #FFF8DC, #FFD700, #FFA500);
        -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        font-weight: 800; filter: drop-shadow(0 2px 2px rgba(0,0,0,0.5));
    }

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

    /* CARD STYLES */
    .doc-card { transition: all 0.3s ease; border-left: 4px solid transparent !important; background-color: #fff; }
    .doc-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important;
        border-left: 4px solid #FFD700 !important; /* Aksen Emas */
    }
    .doc-card:hover .doc-icon { background-color: #FFD700 !important; color: #0f172a !important; transform: scale(1.1) rotate(5deg); transition: 0.3s; }
    .doc-card:hover .arrow-icon { transform: translateX(5px); color: #FFD700 !important; transition: 0.3s; }
    .hover-title:hover { color: #2563eb !important; text-decoration: underline !important; }

    /* ANIMATIONS & UTILS */
    @keyframes zoomEffect { from { transform: scale(1); } to { transform: scale(1.1); } }
    .animate-fade-up { animation: fadeUp 0.8s ease-out forwards; opacity: 0; transform: translateY(20px); }
    .animate-fade-down { animation: fadeDown 0.8s ease-out forwards; opacity: 0; transform: translateY(-20px); }
    .delay-100 { animation-delay: 0.2s; }
    .delay-200 { animation-delay: 0.4s; }

    @keyframes fadeUp { to { opacity: 1; transform: translateY(0); } }
    @keyframes fadeDown { to { opacity: 1; transform: translateY(0); } }

    .ls-1 { letter-spacing: 1px; }
    .backdrop-blur { backdrop-filter: blur(5px); }
    .text-truncate-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
</style>

@endsection
