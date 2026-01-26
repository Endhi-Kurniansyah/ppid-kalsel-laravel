@extends('layouts.frontend')

@section('content')

{{-- LOGIC PHP UNTUK ICON & BACKGROUND --}}
@php
    $extension = strtolower(pathinfo($document->file_path, PATHINFO_EXTENSION));
    $fileIcon = 'bi-file-earmark-text';
    $iconColor = 'text-secondary';

    if ($extension == 'pdf') { $fileIcon = 'bi-file-earmark-pdf-fill'; $iconColor = 'text-danger'; }
    elseif (in_array($extension, ['xls', 'xlsx', 'csv'])) { $fileIcon = 'bi-file-earmark-excel-fill'; $iconColor = 'text-success'; }
    elseif (in_array($extension, ['doc', 'docx'])) { $fileIcon = 'bi-file-earmark-word-fill'; $iconColor = 'text-primary'; }
    elseif (in_array($extension, ['jpg', 'jpeg', 'png', 'webp'])) { $fileIcon = 'bi-file-earmark-image-fill'; $iconColor = 'text-warning'; }

    // Background Image
    $bgImage = (isset($globalSettings) && isset($globalSettings['hero_bg']))
        ? asset('storage/' . $globalSettings['hero_bg'])
        : 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=2070&auto=format&fit=crop';
@endphp

{{-- 1. HERO SECTION --}}
<section class="hero-section">
    <div class="hero-bg" style="background-image: url('{{ $bgImage }}');"></div>
    <div class="hero-overlay"></div>

    {{-- PERBAIKAN: pb-5 dan mb-5 ditambahkan agar judul TIDAK KETUTUP gelombang --}}
    <div class="container position-relative z-2 text-center pt-5 pb-5 mt-4">

        {{-- Badge Kategori --}}
        <div class="d-inline-flex align-items-center bg-white bg-opacity-10 backdrop-blur border border-white border-opacity-25 rounded-pill px-3 py-1 mb-4 animate-fade-down">
            <i class="bi bi-folder2-open me-2 text-warning"></i>
            <span class="fw-bold ls-1 text-white text-uppercase">{{ $document->category ?? 'Dokumen Publik' }}</span>
        </div>

        {{-- Judul Dokumen (PERBAIKAN: margin bottom besar agar tidak kena wave) --}}
        <div class="row justify-content-center mb-5">
            <div class="col-lg-10">
                {{-- Text White dipastikan --}}
                <h1 class="display-4 fw-bold text-white animate-fade-up text-shadow" style="line-height: 1.2;">
                    {{ $document->title }}
                </h1>
            </div>
        </div>

        {{-- Metadata --}}
        <div class="d-flex justify-content-center align-items-center text-white-50 fs-6 animate-fade-up delay-100 gap-3 pb-5">
            <div class="d-flex align-items-center">
                <i class="bi bi-calendar-check me-2 text-warning"></i>
                <span class="text-white">{{ $document->created_at->format('d F Y') }}</span>
            </div>
            <div class="d-none d-md-block border-start border-white border-opacity-25 h-100" style="height: 15px;"></div>
            <div class="d-flex align-items-center">
                <i class="{{ $fileIcon }} me-2 text-white"></i>
                <span class="text-uppercase fw-bold text-white">{{ $extension }} FILE</span>
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

{{-- 2. KONTEN UTAMA --}}
<div class="py-5 bg-white" style="min-height: 600px;">
    {{-- Margin negatif ditarik lebih tinggi (-120px) agar kartu menutupi sebagian header dengan cantik --}}
    <div class="container" style="margin-top: -120px; position: relative; z-index: 10;">
        <div class="row">

            {{-- KOLOM KIRI: PREVIEW & DESKRIPSI --}}
            <div class="col-lg-8 mb-4">
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden mb-4 animate-fade-up delay-200">
                    <div class="card-body p-0">

                        {{-- LOGIKA PREVIEW --}}
                        @if($extension == 'pdf')
                            <div class="ratio ratio-16x9 bg-dark">
                                <iframe src="{{ asset('storage/' . $document->file_path) }}" allowfullscreen></iframe>
                            </div>
                        @elseif(in_array($extension, ['jpg', 'jpeg', 'png', 'webp']))
                            <div class="text-center bg-light p-4 border-bottom">
                                <img src="{{ asset('storage/' . $document->file_path) }}" class="img-fluid rounded shadow-sm border" style="max-height: 500px;">
                            </div>
                        @else
                            <div class="text-center py-5 bg-light border-bottom">
                                <div class="d-inline-block p-4 bg-white rounded-circle shadow-sm mb-3">
                                    <i class="{{ $fileIcon }} {{ $iconColor }} display-1"></i>
                                </div>
                                <h5 class="fw-bold text-dark">Pratinjau Tidak Tersedia</h5>
                                <p class="text-muted small mb-0">File ini berformat <span class="badge bg-secondary text-uppercase">{{ $extension }}</span></p>
                                <p class="text-muted small">Silakan unduh untuk membuka file.</p>
                            </div>
                        @endif

                        {{-- Deskripsi --}}
                        <div class="p-4 p-md-5 bg-white">
                            <h5 class="fw-bold mb-3 border-start border-4 border-primary ps-3 text-dark">Deskripsi Dokumen</h5>
                            <article class="text-secondary" style="line-height: 1.8; font-size: 1.05rem;">
                                {!! $document->description ?? '<span class="text-muted fst-italic">Tidak ada deskripsi tambahan.</span>' !!}
                            </article>
                        </div>
                    </div>
                </div>
            </div>

            {{-- KOLOM KANAN: DOWNLOAD & SHARE --}}
            <div class="col-lg-4 animate-fade-up delay-200">

                {{-- Wrapper Sticky --}}
                <div class="sticky-lg-top" style="top: 100px; z-index: 1;">
                    <div class="card border-0 shadow-lg rounded-4 mb-4">
                        <div class="card-body p-4">

                            {{-- Tombol Download (PERBAIKAN WARNA: btn-primary Biru) --}}
                            <a href="{{ asset('storage/' . $document->file_path) }}" class="btn btn-primary w-100 py-3 fw-bold rounded-pill shadow-sm mb-4 hover-scale position-relative overflow-hidden text-white" download>
                                <span class="position-relative z-1"><i class="bi bi-cloud-arrow-down-fill me-2 fs-5"></i> DOWNLOAD FILE</span>
                            </a>

                            {{-- Info File --}}
                            <ul class="list-group list-group-flush mb-4 rounded-3 border-0">
                                <li class="list-group-item d-flex justify-content-between align-items-center bg-light border-0 mb-1 rounded px-3 py-3">
                                    <span class="text-muted small fw-bold"><i class="bi bi-filetype-{{ $extension }} me-2"></i>Tipe File</span>
                                    <span class="fw-bold text-dark text-uppercase">{{ $extension }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center bg-light border-0 rounded px-3 py-3">
                                    <span class="text-muted small fw-bold"><i class="bi bi-server me-2"></i>Sumber</span>
                                    <span class="fw-bold text-dark">PPID Kalsel</span>
                                </li>
                            </ul>

                            {{-- Tombol Kembali --}}
                            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary w-100 rounded-pill fw-bold btn-sm py-2">
                                <i class="bi bi-arrow-left me-2"></i> Kembali
                            </a>
                        </div>
                    </div>

                    {{-- Share Buttons --}}
                    <div class="text-center">
                        <small class="text-muted text-uppercase fw-bold ls-1 mb-2 d-block" style="font-size: 0.7rem;">Bagikan Dokumen Ini</small>
                        <div class="d-flex gap-2 justify-content-center">
                            <a href="https://wa.me/?text={{ urlencode($document->title . ' ' . url()->current()) }}" target="_blank" class="btn btn-success btn-sm rounded-circle social-share shadow-sm" title="WhatsApp">
                                <i class="bi bi-whatsapp"></i>
                            </a>
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}" target="_blank" class="btn btn-primary btn-sm rounded-circle social-share shadow-sm" title="Facebook">
                                <i class="bi bi-facebook"></i>
                            </a>
                            <button onclick="navigator.clipboard.writeText('{{ url()->current() }}'); alert('Link berhasil disalin!')" class="btn btn-secondary btn-sm rounded-circle social-share shadow-sm" title="Salin Link">
                                <i class="bi bi-link-45deg"></i>
                            </button>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

{{-- CSS KHUSUS --}}
<style>
    /* HERO STYLES (Sama dengan Halaman Lain) */
    .hero-section {
        position: relative;
        min-height: 60vh; /* Tinggi ditambah agar muat */
        display: flex; align-items: center; justify-content: center;
        background-color: #0f172a; overflow: hidden; margin-top: -85px; padding-top: 120px; /* Padding atas ditambah */
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

    @keyframes zoomEffect { from { transform: scale(1); } to { transform: scale(1.1); } }

    .text-shadow { text-shadow: 0 2px 4px rgba(0,0,0,0.5); }
    .ls-1 { letter-spacing: 1px; }
    .backdrop-blur { backdrop-filter: blur(5px); }

    /* Buttons & Interactions */
    .hover-scale:hover { transform: translateY(-2px); box-shadow: 0 10px 20px rgba(13, 110, 253, 0.2) !important; transition: 0.3s; }
    .social-share {
        width: 40px; height: 40px;
        display: flex; align-items: center; justify-content: center;
        transition: transform 0.2s; border: 2px solid #fff; font-size: 1.1rem;
    }
    .social-share:hover { transform: translateY(-3px); }

    /* Animations */
    .animate-fade-up { animation: fadeUp 0.8s ease-out forwards; opacity: 0; transform: translateY(20px); }
    .delay-100 { animation-delay: 0.2s; }
    .delay-200 { animation-delay: 0.4s; }
    @keyframes fadeUp { to { opacity: 1; transform: translateY(0); } }
</style>

@endsection
