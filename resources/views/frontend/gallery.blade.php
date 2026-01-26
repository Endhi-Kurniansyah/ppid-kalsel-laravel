@extends('layouts.frontend')

@section('content')

{{-- 1. HERO SECTION --}}
<section class="hero-section">
    @php
        $bgImage = (isset($globalSettings) && isset($globalSettings['hero_bg']))
            ? asset('storage/' . $globalSettings['hero_bg'])
            : 'https://images.unsplash.com/photo-1557804506-669a67965ba0?q=80&w=2574&auto=format&fit=crop';
    @endphp
    <div class="hero-bg" style="background-image: url('{{ $bgImage }}');"></div>
    <div class="hero-overlay"></div>

    <div class="container position-relative z-2 text-center py-5 mt-4">
        {{-- Badge --}}
        <div class="d-inline-flex align-items-center bg-white bg-opacity-10 backdrop-blur border border-white border-opacity-25 rounded-pill px-3 py-1 mb-4 animate-fade-down">
            <span class="badge bg-danger text-white me-2 rounded-pill">VISUAL</span>
            <small class="fw-bold ls-1 text-white">DOKUMENTASI KEGIATAN</small>
        </div>

        {{-- Judul Emas --}}
        <h1 class="display-3 fw-bold mb-3 animate-fade-up text-white" style="font-style: normal !important;">
            Galeri <span class="text-gradient-gold">Multimedia</span>
        </h1>

        {{-- Deskripsi --}}
        <p class="text-white lead opacity-90 mb-5 animate-fade-up delay-100" style="max-width: 700px; margin: 0 auto; text-shadow: 0 2px 5px rgba(0,0,0,0.5); font-style: normal;">
            Arsip foto kegiatan, infografis, dan dokumentasi layanan informasi publik Provinsi Kalimantan Selatan.
        </p>
    </div>

    {{-- Wave Separator (Putih) --}}
    <div class="hero-wave">
        <svg viewBox="0 0 1440 100" xmlns="http://www.w3.org/2000/svg">
            <path fill="#ffffff" d="M0,64L48,69.3C96,75,192,85,288,80C384,75,480,53,576,42.7C672,32,768,32,864,42.7C960,53,1056,75,1152,80C1248,85,1344,75,1392,69.3L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
        </svg>
    </div>
</section>

{{-- 2. GALERI GRID (Uniform Layout) --}}
<div class="py-5 bg-white" style="min-height: 600px;">
    <div class="container" style="margin-top: -60px; position: relative; z-index: 10;">
        
        <div class="row g-3 section-animation">
            @forelse($galleries as $gallery)
            <div class="col-6 col-md-4 col-lg-3">
                <div class="card border-0 shadow-sm rounded-3 overflow-hidden h-100 hover-lift group-card">
                    
                    {{-- Image Wrapper --}}
                    <div class="position-relative overflow-hidden" style="padding-top: 100%;"> {{-- Aspect Ratio 1:1 (Square) for neater look --}}
                        <img src="{{ asset('storage/' . $gallery->file_path) }}" 
                             class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover transition-scale" 
                             alt="{{ $gallery->title }}"
                             style="cursor: pointer;"
                             onclick="openLightbox('{{ asset('storage/' . $gallery->file_path) }}', '{{ $gallery->title }}', '{{ $gallery->description }}')">
                        
                        {{-- Hover Overlay (Lighter & Gradient) --}}
                        <div class="position-absolute top-0 start-0 w-100 h-100 bg-gradient-fade d-flex align-items-center justify-content-center opacity-0 hover-opacity transition-all pointer-events-none">
                            <i class="bi bi-arrows-fullscreen text-white fs-4 drop-shadow"></i>
                        </div>
                        
                        {{-- Type Badge (Smaller) --}}
                        <div class="position-absolute top-0 end-0 m-2">
                            <span class="badge bg-white bg-opacity-75 backdrop-blur text-dark border shadow-sm rounded-pill px-2 py-1 fw-bold" style="font-size: 0.6rem;">
                                <i class="bi {{ $gallery->type == 'video' ? 'bi-play-circle-fill text-danger' : 'bi-image-fill text-primary' }} me-1"></i>
                                {{ $gallery->type == 'video' ? 'VIDEO' : 'FOTO' }}
                            </span>
                        </div>
                    </div>

                    {{-- Content --}}
                    <div class="card-body p-3 bg-white d-flex flex-column">
                        <small class="text-muted fw-bold mb-1 d-block" style="font-size: 0.65rem; font-style: normal;">
                            {{ $gallery->created_at->isoFormat('D MMM Y') }}
                        </small>
                        
                        <h6 class="fw-bold text-dark mb-1 text-truncate" style="font-style: normal; font-size: 0.85rem;" title="{{ $gallery->title }}">
                            {{ $gallery->title }}
                        </h6>
                        
                        <p class="text-secondary small mb-3 flex-grow-1 line-clamp-3" style="font-style: normal;">
                            {{ Str::limit($gallery->description, 100) ?: 'Tidak ada keterangan tambahan.' }}
                        </p>

                        <div class="d-grid mt-auto">
                            <button class="btn btn-outline-primary rounded-pill btn-sm fw-bold hover-bg-primary" 
                                    onclick="openLightbox('{{ asset('storage/' . $gallery->file_path) }}', '{{ $gallery->title }}', '{{ $gallery->description }}')">
                                Lihat Detail
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <div class="mb-3">
                    <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                        <i class="bi bi-images fs-1 text-secondary opacity-50"></i>
                    </div>
                </div>
                <h5 class="fw-bold text-dark" style="font-style: normal;">Galeri Kosong</h5>
                <p class="text-muted" style="font-style: normal;">Belum ada dokumentasi yang diunggah.</p>
            </div>
            @endforelse
        </div>

        {{-- PAGINATION --}}
        @if($galleries->hasPages())
        <div class="mt-5 d-flex justify-content-center">
            {{ $galleries->links('pagination::bootstrap-5') }}
        </div>
        @endif

    </div>
</div>

{{-- LIGHTBOX MODAL --}}
<div class="modal fade" id="publicLightboxModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content bg-transparent border-0 shadow-none">
            <div class="modal-body p-0 position-relative text-center">
                {{-- Close Button --}}
                <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3 z-3 bg-dark bg-opacity-50 p-3 rounded-circle shadow-none" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(1);"></button>
                
                {{-- Image Container --}}
                <div class="position-relative d-inline-block shadow-lg rounded-4 overflow-hidden bg-black" style="max-width: 100%;">
                    <img id="lbImage" src="" class="img-fluid" style="max-height: 80vh; object-fit: contain;">
                    
                    {{-- Caption Container (Bottom) --}}
                    <div class="bg-white p-4 text-start border-top">
                        <h5 id="lbTitle" class="text-dark fw-bold mb-2" style="font-style: normal;"></h5>
                        <p id="lbDesc" class="text-secondary mb-0" style="font-style: normal; font-size: 0.95rem; line-height: 1.6;"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function openLightbox(src, title, desc) {
        document.getElementById('lbImage').src = src;
        document.getElementById('lbTitle').innerText = title;
        document.getElementById('lbDesc').innerText = desc || 'Tidak ada deskripsi lengkap untuk foto ini.';
        new bootstrap.Modal(document.getElementById('publicLightboxModal')).show();
    }
</script>

<style>
    /* Hero Styles */
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
        background: linear-gradient(180deg, rgba(15, 23, 42, 0.8) 0%, rgba(15, 23, 42, 0.9) 100%);
        z-index: 1;
    }
    .hero-wave { position: absolute; bottom: -2px; left: 0; width: 100%; line-height: 0; z-index: 1; pointer-events: none; }

    .text-gradient-gold {
        background: linear-gradient(to right, #FFF8DC, #FFD700, #FFA500);
        -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        font-weight: 800; filter: drop-shadow(0 2px 2px rgba(0,0,0,0.5));
    }
    
    @keyframes zoomEffect { from { transform: scale(1); } to { transform: scale(1.1); } }

    /* CARD HOVER EFFECTS */
    .bg-gradient-fade {
        background: linear-gradient(to top, rgba(0,0,0,0.6), transparent);
    }

    .hover-lift { transition: transform 0.3s cubic-bezier(0.25, 0.8, 0.25, 1), box-shadow 0.3s ease; }
    .hover-lift:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important; }
    
    .group-card:hover .transition-scale { transform: scale(1.08); }
    .group-card:hover .hover-opacity { opacity: 1 !important; }
    
    .transition-scale { transition: transform 0.6s ease; }
    .transition-all { transition: all 0.3s ease; }
    .opacity-0 { opacity: 0; }
    .pointer-events-none { pointer-events: none; }
    
    .object-fit-cover { object-fit: cover; }
    .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    .line-clamp-3 { display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }

    /* Animation */
    .animate-fade-up { animation: fadeUp 0.8s ease-out forwards; opacity: 0; transform: translateY(20px); }
    .animate-fade-down { animation: fadeDown 0.8s ease-out forwards; opacity: 0; transform: translateY(-20px); }
    .delay-100 { animation-delay: 0.2s; }
    .section-animation { animation: fadeUp 0.6s ease-out forwards; }
    
    @keyframes fadeUp { to { opacity: 1; transform: translateY(0); } }
    @keyframes fadeDown { to { opacity: 1; transform: translateY(0); } }
    
    .backdrop-blur { backdrop-filter: blur(5px); }
    .ls-1 { letter-spacing: 1px; }

    /* Force normal font style */
    body, h1, h2, h3, h4, h5, h6, p, a, span, div, small { font-style: normal !important; }
</style>

@endsection
