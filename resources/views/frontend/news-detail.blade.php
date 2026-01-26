@extends('layouts.frontend')

@section('content')

{{-- 1. HERO SECTION (STYLE WELCOME) --}}
<section class="hero-section">
    @php
        // Gunakan gambar berita sebagai background jika ada, jika tidak pakai default
        $bgImage = $post->image ? asset('storage/' . $post->image) : (
            (isset($globalSettings) && isset($globalSettings['hero_bg']))
            ? asset('storage/' . $globalSettings['hero_bg'])
            : 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=2070&auto=format&fit=crop'
        );
    @endphp

    <div class="hero-bg" style="background-image: url('{{ $bgImage }}');"></div>
    <div class="hero-overlay"></div>

    <div class="container position-relative z-2 text-center py-5 mt-4">

        {{-- Badge Kategori --}}
        <div class="d-inline-flex align-items-center bg-white bg-opacity-10 backdrop-blur border border-white border-opacity-25 rounded-pill px-3 py-1 mb-4 animate-fade-down">
            <span class="badge bg-warning text-dark me-2 rounded-pill">BERITA</span>
            <small class="fw-medium ls-1 text-white text-uppercase">{{ $post->category->name ?? 'UMUM' }}</small>
        </div>

        {{-- Judul Berita (Emas & Putih) --}}
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <h1 class="display-4 fw-bold text-white mb-3 animate-fade-up text-shadow" style="line-height: 1.2;">
                    {{ $post->title }}
                </h1>
            </div>
        </div>

        {{-- Metadata --}}
        <div class="d-flex justify-content-center flex-wrap gap-3 text-white-50 fs-6 animate-fade-up delay-100 pb-5">
            <div class="d-flex align-items-center">
                <i class="bi bi-person-circle me-2 text-warning"></i>
                <span class="text-white">{{ $post->user->name }}</span>
            </div>
            <div class="d-none d-md-block border-start border-white border-opacity-25 h-100 mx-2" style="height: 15px;"></div>
            <div class="d-flex align-items-center">
                <i class="bi bi-calendar-event me-2 text-warning"></i>
                <span class="text-white">{{ $post->created_at->format('d F Y') }}</span>
            </div>
            <div class="d-none d-md-block border-start border-white border-opacity-25 h-100 mx-2" style="height: 15px;"></div>
            <div class="d-flex align-items-center">
                <i class="bi bi-eye me-2 text-warning"></i>
                <span class="text-white">{{ $post->views }}x Dibaca</span>
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
    <div class="container" style="margin-top: -120px; position: relative; z-index: 10;">
        <div class="row justify-content-center">
            <div class="col-lg-9">

                <div class="card border-0 shadow-lg rounded-4 overflow-hidden animate-fade-up delay-200">
                    <div class="card-body p-0">

                        {{-- GAMBAR UTAMA (Jika ada) --}}
                        @if($post->image)
                            <div class="position-relative">
                                <img src="{{ asset('storage/' . $post->image) }}" class="w-100 object-fit-cover" style="max-height: 500px;" alt="{{ $post->title }}">
                                {{-- Overlay halus --}}
                                <div class="position-absolute bottom-0 start-0 w-100 h-25" style="background: linear-gradient(to top, rgba(0,0,0,0.1), transparent);"></div>
                            </div>
                        @endif

                        {{-- ISI ARTIKEL --}}
                        <div class="p-4 p-md-5">

                            {{-- Konten --}}
                            <article class="blog-content text-dark" style="font-size: 1.1rem; line-height: 1.8;">
                                {!! $post->content !!}
                            </article>

                            <hr class="my-5 border-secondary opacity-10">

                            {{-- FOOTER (SHARE & BACK) --}}
                            <div class="d-md-flex justify-content-between align-items-center">

                                {{-- Tombol Kembali --}}
                                <div class="mb-3 mb-md-0">
                                    <a href="{{ route('news.index') }}" class="btn btn-outline-secondary rounded-pill px-4 fw-bold hover-scale">
                                        <i class="bi bi-arrow-left me-2"></i> Kembali ke Berita
                                    </a>
                                </div>

                                {{-- Tombol Share --}}
                                <div class="d-flex align-items-center bg-light rounded-pill px-3 py-2 border">
                                    <span class="text-muted me-3 small fw-bold text-uppercase">Bagikan:</span>
                                    <div class="d-flex gap-2">
                                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}" target="_blank" class="btn btn-primary btn-sm rounded-circle social-share" title="Facebook">
                                            <i class="bi bi-facebook"></i>
                                        </a>
                                        <a href="https://wa.me/?text={{ $post->title }}%20{{ url()->current() }}" target="_blank" class="btn btn-success btn-sm rounded-circle social-share" title="WhatsApp">
                                            <i class="bi bi-whatsapp"></i>
                                        </a>
                                        <a href="https://twitter.com/intent/tweet?text={{ $post->title }}&url={{ url()->current() }}" target="_blank" class="btn btn-dark btn-sm rounded-circle social-share" title="Twitter / X">
                                            <i class="bi bi-twitter-x"></i>
                                        </a>
                                        <button onclick="navigator.clipboard.writeText('{{ url()->current() }}'); alert('Link berhasil disalin!');" class="btn btn-secondary btn-sm rounded-circle social-share" title="Salin Link">
                                            <i class="bi bi-link-45deg"></i>
                                        </button>
                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

{{-- CSS KHUSUS --}}
<style>
    /* HERO STYLES (Sama dengan Welcome/Docs) */
    .hero-section {
        position: relative; min-height: 60vh; display: flex; align-items: center; justify-content: center;
        background-color: #0f172a; overflow: hidden; margin-top: -85px; padding-top: 100px;
    }
    .hero-bg {
        position: absolute; top: 0; left: 0; width: 100%; height: 100%;
        background-position: center; background-size: cover; background-repeat: no-repeat;
        z-index: 0; animation: zoomEffect 20s infinite alternate;
        filter: blur(3px); /* Blur sedikit agar teks lebih terbaca */
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

    /* CONTENT STYLES */
    .blog-content img {
        max-width: 100% !important; height: auto !important;
        border-radius: 12px; margin: 20px 0;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    .blog-content p { margin-bottom: 1.5rem; color: #334155; }
    .blog-content blockquote {
        border-left: 5px solid #FFD700; background: #fffbeb;
        padding: 15px 20px; border-radius: 0 10px 10px 0;
        font-style: italic; color: #555; margin: 20px 0;
    }

    /* SHARE BUTTONS */
    .social-share {
        width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;
        transition: transform 0.2s; border: none;
    }
    .social-share:hover { transform: translateY(-3px); }
    .hover-scale:hover { transform: scale(1.02); }

    /* ANIMATIONS */
    .animate-fade-up { animation: fadeUp 0.8s ease-out forwards; opacity: 0; transform: translateY(20px); }
    .animate-fade-down { animation: fadeDown 0.8s ease-out forwards; opacity: 0; transform: translateY(-20px); }
    .delay-100 { animation-delay: 0.2s; }
    .delay-200 { animation-delay: 0.4s; }

    @keyframes fadeUp { to { opacity: 1; transform: translateY(0); } }
    @keyframes fadeDown { to { opacity: 1; transform: translateY(0); } }
</style>

@endsection
