@extends('layouts.frontend')

@section('content')

{{-- 1. HERO SECTION --}}
<section class="hero-section">
    @php
        $bgImage = (isset($globalSettings) && isset($globalSettings['hero_bg']))
            ? asset('storage/' . $globalSettings['hero_bg'])
            : 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=2070&auto=format&fit=crop';
    @endphp

    {{-- Background Image --}}
    <div class="hero-bg" style="background-image: url('{{ $bgImage }}');"></div>

    {{-- Overlay Gelap --}}
    <div class="hero-overlay"></div>

    <div class="container position-relative z-2 text-center py-5 mt-4">
        {{-- Badge --}}
        <div class="d-inline-flex align-items-center bg-white bg-opacity-10 backdrop-blur border border-white border-opacity-25 rounded-pill px-3 py-1 mb-4 animate-fade-down">
            <span class="badge bg-warning text-dark me-2 rounded-pill">DIP</span>
            <small class="fw-medium ls-1 text-white">REKAPITULASI DOKUMEN</small>
        </div>

        {{-- Judul Emas & Putih --}}
        <h1 class="display-3 fw-bold mb-3 animate-fade-up text-white">
            Daftar Informasi <span class="text-gradient-gold">Publik</span>
        </h1>

        {{-- Deskripsi --}}
        <p class="text-white lead opacity-90 mb-5 animate-fade-up delay-100" style="max-width: 700px; margin: 0 auto; text-shadow: 0 2px 5px rgba(0,0,0,0.5);">
            Seluruh informasi publik yang tersedia dikelompokkan berdasarkan kategori.
        </p>
    </div>

    {{-- Wave Separator (Putih) --}}
    <div class="hero-wave">
        <svg viewBox="0 0 1440 100" xmlns="http://www.w3.org/2000/svg">
            <path fill="#ffffff" d="M0,64L48,69.3C96,75,192,85,288,80C384,75,480,53,576,42.7C672,32,768,32,864,42.7C960,53,1056,75,1152,80C1248,85,1344,75,1392,69.3L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
        </svg>
    </div>
</section>

{{-- 2. KONTEN TABEL --}}
<div class="py-5 bg-white" style="min-height: 600px;">
    <div class="container" style="margin-top: -100px; position: relative; z-index: 10;">

        <div class="row justify-content-center">
            <div class="col-lg-12">

                {{-- CARD PEMBUNGKUS TABEL --}}
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden animate-fade-up delay-200">

                    {{-- Judul Tabel Kecil --}}
                    <div class="card-header bg-white py-4 px-4 border-bottom">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="fw-bold text-dark mb-0"><i class="bi bi-list-columns-reverse me-2 text-primary"></i> Indeks Dokumen</h5>
                            {{-- Total Dokumen Tetap Ada di Kanan Atas (Opsional) --}}
                            <small class="text-muted fw-bold">Total: {{ $groupedDocuments->flatten()->count() }} Dokumen</small>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0" style="min-width: 800px;">
                            <thead class="bg-light text-secondary">
                                <tr>
                                    <th class="py-3 ps-4 text-uppercase small fw-bold" style="width: 5%;">No</th>
                                    <th class="py-3 text-uppercase small fw-bold" style="width: 50%;">Judul Informasi</th>
                                    <th class="py-3 text-uppercase small fw-bold text-center" style="width: 20%;">Tanggal</th>
                                    <th class="py-3 pe-4 text-uppercase small fw-bold text-end" style="width: 25%;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $globalNo = 1; @endphp
                                @forelse($groupedDocuments as $categoryName => $docs)

                                    {{-- BARIS HEADER KATEGORI (BERSIH TANPA ANGKA 1) --}}
                                    <tr class="category-header-row">
                                        <td colspan="4" class="py-3 ps-4 bg-primary bg-opacity-10">
                                            <div class="d-flex align-items-center text-primary fw-bold text-uppercase ls-1">
                                                <i class="bi bi-folder2-open me-2 fs-5"></i>
                                                {{ $categoryName }}
                                                {{-- BAGIAN ANGKA (BADGE) SUDAHDIHAPUS --}}
                                            </div>
                                        </td>
                                    </tr>

                                    {{-- BARIS DOKUMEN --}}
                                    @foreach($docs as $doc)
                                    <tr class="doc-row transition-all">
                                        <td class="ps-4 fw-bold text-muted">{{ $globalNo++ }}</td>
                                        <td class="py-3">
                                            <a href="{{ route('documents.public.show', $doc->id) }}" class="text-dark fw-bold text-decoration-none hover-title d-block mb-1">
                                                {{ $doc->title }}
                                            </a>
                                            {{-- Deskripsi Pendek --}}
                                            @if($doc->description)
                                                <div class="text-muted small text-truncate" style="max-width: 450px;">
                                                    {{ Str::limit(strip_tags($doc->description), 80) }}
                                                </div>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <div class="badge bg-light text-secondary border fw-normal">
                                                <i class="bi bi-calendar3 me-1"></i> {{ $doc->created_at->format('d M Y') }}
                                            </div>
                                        </td>
                                        <td class="pe-4 text-end">
                                            <div class="d-flex justify-content-end gap-2">
                                                <a href="{{ route('documents.public.show', $doc->id) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-bold">
                                                    Detail
                                                </a>

                                                @if($doc->file_path)
                                                    <a href="{{ asset('storage/' . $doc->file_path) }}" class="btn btn-sm btn-primary rounded-pill px-3 fw-bold text-white shadow-sm" target="_blank">
                                                        <i class="bi bi-download"></i>
                                                    </a>
                                                @else
                                                    <button class="btn btn-sm btn-light border rounded-pill px-3 text-muted disabled" title="Tidak ada file">
                                                        <i class="bi bi-dash"></i>
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach

                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-5">
                                            <div class="opacity-25 mb-3">
                                                <i class="bi bi-inbox fs-1"></i>
                                            </div>
                                            <h5 class="fw-bold text-muted">Belum ada data DIP.</h5>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="card-footer bg-white py-3 text-center text-muted small">
                        &copy; {{ date('Y') }} PPID Provinsi Kalimantan Selatan
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

{{-- CSS KHUSUS --}}
<style>
    /* HERO SECTION STYLE */
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
        background: linear-gradient(180deg, rgba(15, 23, 42, 0.9) 0%, rgba(15, 23, 42, 0.8) 100%);
        z-index: 1;
    }

    /* WAVE SEPARATOR (PUTIH) */
    .hero-wave {
        position: absolute; bottom: -2px; left: 0; width: 100%; line-height: 0;
        z-index: 1; pointer-events: none;
    }

    .text-gradient-gold {
        background: linear-gradient(to right, #FFF8DC, #FFD700, #FFA500);
        -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        font-weight: 800; filter: drop-shadow(0 2px 2px rgba(0,0,0,0.5));
    }
    @keyframes zoomEffect { from { transform: scale(1); } to { transform: scale(1.1); } }

    /* TABLE STYLES */
    .category-header-row td {
        border-top: 2px solid #e2e8f0;
        border-bottom: 2px solid #e2e8f0;
    }

    .doc-row:hover { background-color: #f8fafc; }
    .hover-title:hover { color: #2563eb !important; text-decoration: underline !important; }

    .transition-all { transition: all 0.2s ease; }

    /* ANIMATIONS */
    .animate-fade-up { animation: fadeUp 0.8s ease-out forwards; opacity: 0; transform: translateY(20px); }
    .animate-fade-down { animation: fadeDown 0.8s ease-out forwards; opacity: 0; transform: translateY(-20px); }

    @keyframes fadeUp { to { opacity: 1; transform: translateY(0); } }
    @keyframes fadeDown { to { opacity: 1; transform: translateY(0); } }

    .ls-1 { letter-spacing: 1px; }
    .backdrop-blur { backdrop-filter: blur(5px); }
</style>

@endsection
