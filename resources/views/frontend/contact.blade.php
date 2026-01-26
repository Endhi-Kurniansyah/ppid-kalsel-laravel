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
            <span class="badge bg-warning text-dark me-2 rounded-pill">KONTAK</span>
            <small class="fw-medium ls-1 text-white">HUBUNGI KAMI</small>
        </div>

        {{-- Judul Emas --}}
        <h1 class="display-3 fw-bold mb-3 animate-fade-up text-white">
            Pusat <span class="text-gradient-gold">Informasi</span>
        </h1>

        {{-- Deskripsi --}}
        <p class="text-white lead opacity-90 mb-5 animate-fade-up delay-100" style="max-width: 700px; margin: 0 auto; text-shadow: 0 2px 5px rgba(0,0,0,0.5);">
            Kami siap melayani kebutuhan informasi publik Anda. Silakan hubungi kami melalui saluran berikut.
        </p>
    </div>

    {{-- Wave Separator (Putih) --}}
    <div class="hero-wave">
        <svg viewBox="0 0 1440 100" xmlns="http://www.w3.org/2000/svg">
            <path fill="#ffffff" d="M0,64L48,69.3C96,75,192,85,288,80C384,75,480,53,576,42.7C672,32,768,32,864,42.7C960,53,1056,75,1152,80C1248,85,1344,75,1392,69.3L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
        </svg>
    </div>
</section>

{{-- 2. KONTEN UTAMA --}}
<div class="py-5 bg-white" style="min-height: 600px;">
    {{-- Margin negatif --}}
    <div class="container" style="margin-top: -100px; position: relative; z-index: 10;">

        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12">

                <div class="row g-4">
                    {{-- KOLOM KIRI: INFO KONTAK --}}
                    <div class="col-lg-5 animate-fade-up delay-200">
                        <div class="card border-0 shadow-lg h-100 rounded-4 overflow-hidden position-relative bg-white">
                            {{-- Aksen Garis Atas --}}
                            <div class="position-absolute top-0 start-0 w-100" style="height: 5px; background: linear-gradient(90deg, #0f172a, #fbbf24);"></div>

                            <div class="card-body p-4 p-md-5">
                                <h4 class="fw-bold mb-4 text-dark d-flex align-items-center">
                                    <i class="bi bi-building text-primary me-3 fs-3"></i> Kantor Layanan
                                </h4>

                                {{-- Item 1: Alamat --}}
                                <div class="contact-item d-flex mb-4 p-3 rounded-3 hover-bg-light transition-all border border-transparent">
                                    <div class="flex-shrink-0">
                                        <div class="icon-circle bg-primary bg-opacity-10 text-primary shadow-sm">
                                            <i class="bi bi-geo-alt-fill"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="fw-bold mb-1 text-uppercase text-muted small ls-1">Alamat</h6>
                                        <p class="text-dark mb-0 fw-medium small" style="line-height: 1.5;">
                                            Jl. Dharma Praja II, Kawasan Perkantoran Pemprov Kalsel, Banjarbaru.
                                        </p>
                                    </div>
                                </div>

                                {{-- Item 2: Email --}}
                                <div class="contact-item d-flex mb-4 p-3 rounded-3 hover-bg-light transition-all border border-transparent">
                                    <div class="flex-shrink-0">
                                        <div class="icon-circle bg-success bg-opacity-10 text-success shadow-sm">
                                            <i class="bi bi-envelope-fill"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="fw-bold mb-1 text-uppercase text-muted small ls-1">Email Resmi</h6>
                                        <a href="mailto:diskominfo@kalselprov.go.id" class="text-dark text-decoration-none fw-bold small stretched-link hover-primary">
                                            diskominfo@kalselprov.go.id
                                        </a>
                                    </div>
                                </div>

                                {{-- Item 3: Telepon --}}
                                <div class="contact-item d-flex mb-4 p-3 rounded-3 hover-bg-light transition-all border border-transparent">
                                    <div class="flex-shrink-0">
                                        <div class="icon-circle bg-warning bg-opacity-10 text-warning shadow-sm">
                                            <i class="bi bi-telephone-fill"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="fw-bold mb-1 text-uppercase text-muted small ls-1">Telepon / Fax</h6>
                                        <p class="text-dark mb-0 fw-bold small">(0511) 6749844</p>
                                    </div>
                                </div>

                                {{-- Item 4: Jam Layanan --}}
                                <div class="contact-item p-3 rounded-3 bg-light border border-light">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="icon-circle bg-dark text-white me-3 shadow-sm" style="width: 35px; height: 35px; font-size: 1rem;">
                                            <i class="bi bi-clock-fill"></i>
                                        </div>
                                        <h6 class="fw-bold mb-0 text-uppercase text-dark small ls-1">Jam Pelayanan</h6>
                                    </div>
                                    <ul class="list-unstyled mb-0 small fw-medium text-secondary ps-2 border-start border-3 border-warning">
                                        <li class="d-flex justify-content-between mb-1 px-3"><span>Senin - Kamis</span> <span class="fw-bold text-dark">08:00 - 16:00</span></li>
                                        <li class="d-flex justify-content-between mb-1 px-3"><span>Jumat</span> <span class="fw-bold text-dark">08:00 - 11:00</span></li>
                                        <li class="d-flex justify-content-between px-3 text-danger fw-bold"><span>Sabtu - Minggu</span> <span>LIBUR</span></li>
                                    </ul>
                                </div>

                            </div>
                        </div>
                    </div>

                    {{-- KOLOM KANAN: PETA --}}
                    <div class="col-lg-7 animate-fade-up delay-200">
                        <div class="card border-0 shadow-lg h-100 rounded-4 overflow-hidden p-1 bg-white">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3982.457997576274!2d114.83398931475837!3d-3.480287997467644!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2de6810a9c7969bf%3A0x67004396009623e1!2sDinas%20Komunikasi%20dan%20Informatika%20Provinsi%20Kalimantan%20Selatan!5e0!3m2!1sid!2sid!4v1679888273841!5m2!1sid!2sid"
                                width="100%"
                                height="100%"
                                style="border:0; min-height: 500px; border-radius: 12px;"
                                allowfullscreen=""
                                loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade">
                            </iframe>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

{{-- CSS KHUSUS --}}
<style>
    /* HERO STYLES */
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

    /* ICON & CONTACT ITEMS */
    .icon-circle {
        width: 45px; height: 45px;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.2rem;
        transition: transform 0.3s;
    }

    .contact-item { transition: all 0.3s ease; border: 1px solid transparent; }
    .contact-item:hover {
        background-color: #fff;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        border-color: #e2e8f0;
        transform: translateX(5px);
    }
    .contact-item:hover .icon-circle { transform: scale(1.1); }

    .hover-bg-light:hover { background-color: #f8fafc; }
    .hover-primary:hover { color: #2563eb !important; text-decoration: underline !important; }

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
