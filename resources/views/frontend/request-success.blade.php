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

        {{-- Badge Sukses --}}
        <div class="d-inline-flex align-items-center bg-white bg-opacity-10 backdrop-blur border border-white border-opacity-25 rounded-pill px-3 py-1 mb-4 animate-fade-down">
            <span class="badge bg-success text-white me-2 rounded-pill"><i class="bi bi-check-circle-fill"></i></span>
            <small class="fw-medium ls-1 text-white">TERKIRIM</small>
        </div>

        {{-- Judul Emas --}}
        <h1 class="display-3 fw-bold mb-3 animate-fade-up text-white">
            Permohonan <span class="text-gradient-gold">Berhasil</span>
        </h1>

        {{-- Deskripsi --}}
        <p class="text-white lead opacity-90 mb-5 animate-fade-up delay-100" style="max-width: 700px; margin: 0 auto; text-shadow: 0 2px 5px rgba(0,0,0,0.5);">
            Data permohonan informasi Anda telah berhasil kami terima dan sedang dalam antrean proses.
        </p>
    </div>

    {{-- Wave Separator (Putih) --}}
    <div class="hero-wave">
        <svg viewBox="0 0 1440 100" xmlns="http://www.w3.org/2000/svg">
            <path fill="#ffffff" d="M0,64L48,69.3C96,75,192,85,288,80C384,75,480,53,576,42.7C672,32,768,32,864,42.7C960,53,1056,75,1152,80C1248,85,1344,75,1392,69.3L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
        </svg>
    </div>
</section>

{{-- 2. KONTEN UTAMA (KARTU SUKSES) --}}
<div class="py-5 bg-white" style="min-height: 600px;">
    <div class="container" style="margin-top: -100px; position: relative; z-index: 10;">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">

                <div class="card border-0 shadow-lg rounded-4 overflow-hidden text-center animate-fade-up delay-200">
                    <div class="card-body p-5">

                        {{-- Ikon Sukses Animasi --}}
                        <div class="mb-4">
                            <div class="d-inline-flex align-items-center justify-content-center bg-success bg-opacity-10 text-success rounded-circle p-4 animate-bounce">
                                <i class="bi bi-send-check-fill display-3"></i>
                            </div>
                        </div>

                        <h3 class="fw-bold text-dark mb-2">Terima Kasih!</h3>
                        <p class="text-muted mb-4">
                            Permohonan Anda sedang kami proses. Mohon simpan <strong>Nomor Tiket</strong> di bawah ini untuk mengecek status pengajuan secara berkala.
                        </p>

                        {{-- KOTAK KODE TIKET --}}
                        <div class="ticket-box bg-light border border-2 border-dashed rounded-4 p-4 mb-4 position-relative mx-auto" style="max-width: 400px;">
                            <span class="position-absolute top-0 start-50 translate-middle badge bg-primary px-3 py-2 rounded-pill shadow-sm ls-1">
                                NOMOR TIKET ANDA
                            </span>

                            <h2 class="fw-bold text-primary mb-0 mt-3 tracking-wide font-monospace" id="ticketCode">
                                {{ $ticket }}
                            </h2>
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="d-grid gap-3 col-md-8 mx-auto">
                            {{-- Tombol Copy --}}
                            <button class="btn btn-outline-primary fw-bold rounded-pill py-2 hover-scale" onclick="copyToClipboard()">
                                <i class="bi bi-clipboard me-2"></i> Salin Nomor Tiket
                            </button>

                            {{-- Tombol Lacak --}}
                            <a href="{{ route('requests.track', ['ticket' => $ticket]) }}" class="btn btn-primary fw-bold rounded-pill shadow-sm py-3 hover-scale text-white">
                                <i class="bi bi-search me-2"></i> Lacak Status Sekarang
                            </a>

                            <a href="{{ url('/') }}" class="btn btn-link text-muted text-decoration-none small mt-2">
                                Kembali ke Beranda
                            </a>
                        </div>

                    </div>

                    {{-- Footer Kartu --}}
                    <div class="card-footer bg-light border-0 py-3 small text-muted">
                        PPID Provinsi Kalimantan Selatan
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

{{-- CSS KHUSUS --}}
<style>
    /* HERO STYLES (Sama dengan halaman lain) */
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

    /* TICKET BOX */
    .border-dashed { border-style: dashed !important; border-color: #cbd5e1 !important; }
    .tracking-wide { letter-spacing: 2px; }

    /* ANIMATIONS */
    .animate-fade-up { animation: fadeUp 0.8s ease-out forwards; opacity: 0; transform: translateY(20px); }
    .animate-fade-down { animation: fadeDown 0.8s ease-out forwards; opacity: 0; transform: translateY(-20px); }
    .delay-100 { animation-delay: 0.2s; }
    .delay-200 { animation-delay: 0.4s; }

    @keyframes fadeUp { to { opacity: 1; transform: translateY(0); } }
    @keyframes fadeDown { to { opacity: 1; transform: translateY(0); } }

    .animate-bounce { animation: bounce 2s infinite; }
    @keyframes bounce { 0%, 20%, 50%, 80%, 100% {transform: translateY(0);} 40% {transform: translateY(-10px);} 60% {transform: translateY(-5px);} }

    .ls-1 { letter-spacing: 1px; }
    .backdrop-blur { backdrop-filter: blur(5px); }
    .hover-scale:hover { transform: scale(1.02); transition: 0.2s; }
</style>

{{-- SCRIPT COPY CODE --}}
<script>
    function copyToClipboard() {
        var codeText = document.getElementById("ticketCode").innerText.trim();
        var tempInput = document.createElement("input");
        tempInput.value = codeText;
        document.body.appendChild(tempInput);
        tempInput.select();
        document.execCommand("copy");
        document.body.removeChild(tempInput);
        alert("Nomor Tiket berhasil disalin: " + codeText);
    }
</script>

@endsection
