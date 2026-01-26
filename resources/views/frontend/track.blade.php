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
            <span class="badge bg-info text-dark me-2 rounded-pill">TRACKING</span>
            <small class="fw-medium ls-1 text-white">CEK STATUS PERMOHONAN</small>
        </div>

        {{-- Judul Emas --}}
        <h1 class="display-3 fw-bold mb-3 animate-fade-up text-white">
            Lacak <span class="text-gradient-gold">Permohonan</span>
        </h1>

        {{-- Deskripsi --}}
        <p class="text-white lead opacity-90 mb-5 animate-fade-up delay-100" style="max-width: 700px; margin: 0 auto; text-shadow: 0 2px 5px rgba(0,0,0,0.5);">
            Pantau status dan tindak lanjut permohonan informasi Anda secara real-time cukup dengan memasukkan nomor tiket.
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
    <div class="container" style="margin-top: -100px; position: relative; z-index: 10;">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                {{-- KARTU PENCARIAN --}}
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden mb-5 animate-fade-up delay-200">
                    <div class="card-body p-4 p-md-5">
                        <form action="{{ route('requests.track') }}" method="GET">
                            <label class="form-label fw-bold text-muted small text-uppercase ls-1 mb-2">Masukkan Nomor Tiket</label>
                            <div class="input-group input-group-lg shadow-sm rounded-pill overflow-hidden border transition-all hover-border-primary">
                                <span class="input-group-text bg-white border-0 ps-4 text-muted">
                                    <i class="bi bi-ticket-perforated-fill fs-5"></i>
                                </span>
                                <input type="text" name="ticket" class="form-control border-0 ps-2 fw-bold text-dark" placeholder="Contoh: REQ-2025-XXXX" required value="{{ request('ticket') }}" autofocus style="letter-spacing: 1px;">
                                <button class="btn btn-primary px-4 fw-bold" type="submit">
                                    <i class="bi bi-search me-2"></i> Lacak
                                </button>
                            </div>
                        </form>

                        @if(session('error'))
                            <div class="alert alert-danger border-0 rounded-4 mt-4 d-flex align-items-center shadow-sm">
                                <i class="bi bi-exclamation-triangle-fill me-3 fs-4 text-danger"></i>
                                <div>{{ session('error') }}</div>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- HASIL PENCARIAN --}}
                @if(isset($result))

                    {{-- KARTU STATUS UTAMA --}}
                    <div class="card border-0 shadow-lg rounded-4 mb-4 overflow-hidden animate-fade-up">

                        {{-- Header Status Dinamis --}}
                        <div class="card-header border-0 py-3 px-4 d-flex justify-content-between align-items-center
                            {{ $result->status == 'finished' ? 'bg-success bg-gradient' : ($result->status == 'rejected' ? 'bg-danger bg-gradient' : 'bg-warning bg-gradient') }} text-white">

                            <h5 class="mb-0 fw-bold"><i class="bi bi-file-earmark-text me-2"></i> Detail Permohonan</h5>

                            {{-- Badge Status --}}
                            <span class="badge bg-white
                                {{ $result->status == 'finished' ? 'text-success' : ($result->status == 'rejected' ? 'text-danger' : 'text-dark') }}
                                fw-bold px-3 py-2 rounded-pill shadow-sm">
                                @if($result->status == 'pending') MENUNGGU
                                @elseif($result->status == 'processed') DIPROSES
                                @elseif($result->status == 'finished') SELESAI
                                @elseif($result->status == 'rejected') DITOLAK
                                @endif
                            </span>
                        </div>

                        <div class="card-body p-4">

                            <div class="row g-4">
                                <div class="col-md-6 border-end border-light">
                                    <small class="text-muted text-uppercase fw-bold d-block mb-1">Nomor Tiket</small>
                                    <div class="fs-5 fw-bold text-primary font-monospace">{{ $result->ticket_number }}</div>
                                </div>
                                <div class="col-md-6">
                                    <small class="text-muted text-uppercase fw-bold d-block mb-1">Tanggal Masuk</small>
                                    <div class="fs-5 text-dark">{{ $result->created_at->format('d M Y, H:i') }}</div>
                                </div>
                                <div class="col-12">
                                    <small class="text-muted text-uppercase fw-bold d-block mb-1">Nama Pemohon</small>
                                    <div class="fs-5 text-dark fw-medium">{{ $result->name }}</div>
                                </div>
                                <div class="col-12">
                                    <div class="bg-light p-4 rounded-3 border border-dashed">
                                        <small class="text-muted text-uppercase fw-bold d-block mb-2">Informasi yang Diminta</small>
                                        <p class="mb-0 text-dark fst-italic">"{{ $result->details }}"</p>
                                    </div>
                                </div>
                            </div>

                            {{-- JAWABAN ADMIN --}}
                            @if($result->admin_note)
                                <div class="mt-4 pt-4 border-top">
                                    <h6 class="fw-bold text-primary mb-3"><i class="bi bi-chat-quote-fill me-2"></i> Tindak Lanjut / Jawaban:</h6>
                                    <div class="alert alert-secondary border-0 mb-0 rounded-3 shadow-sm bg-opacity-10">
                                        <p class="mb-2 text-dark">{{ $result->admin_note }}</p>

                                        @if($result->reply_file)
                                            <a href="{{ asset('storage/' . $result->reply_file) }}" class="btn btn-dark btn-sm rounded-pill mt-3 shadow-sm" target="_blank">
                                                <i class="bi bi-paperclip me-1"></i> Unduh Lampiran Jawaban
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            @endif

                        </div>

                        {{-- Tombol Ajukan Keberatan (Hanya jika selesai/ditolak & belum ada keberatan) --}}
                        @if(($result->status == 'finished' || $result->status == 'rejected') && !$result->objection)
                        <div class="card-footer bg-white border-top p-3 text-end">
                            <span class="text-muted small me-2">Tidak puas dengan jawaban?</span>
                            <a href="{{ route('objection.search') }}" class="btn btn-outline-danger btn-sm rounded-pill fw-bold hover-scale">
                                <i class="bi bi-exclamation-circle me-1"></i> Ajukan Keberatan
                            </a>
                        </div>
                        @endif
                    </div>

                    {{-- KARTU KEBERATAN (JIKA ADA) --}}
                    @if($result->objection)
                        <div class="card border-0 shadow-lg rounded-4 mt-4 overflow-hidden border-start border-5 border-danger animate-fade-up delay-100">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center mb-4">
                                    <div class="bg-danger bg-opacity-10 text-danger p-3 rounded-circle me-3">
                                        <i class="bi bi-shield-exclamation fs-3"></i>
                                    </div>
                                    <div>
                                        <h5 class="fw-bold text-danger mb-0">Pengajuan Keberatan</h5>
                                        <small class="text-muted">Kode Keberatan: <strong>{{ $result->objection->objection_code }}</strong></small>
                                    </div>
                                    <div class="ms-auto">
                                        @if($result->objection->status == 'pending')
                                            <span class="badge bg-warning text-dark border border-warning">MENUNGGU ATASAN</span>
                                        @elseif($result->objection->status == 'processed')
                                            <span class="badge bg-info text-white">DIPROSES</span>
                                        @elseif($result->objection->status == 'finished')
                                            <span class="badge bg-success">DITERIMA</span>
                                        @elseif($result->objection->status == 'rejected')
                                            <span class="badge bg-danger">DITOLAK</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="bg-light p-3 rounded-3 mb-3 border border-light">
                                    <small class="fw-bold text-muted d-block text-uppercase mb-1">Alasan Keberatan</small>
                                    <p class="mb-0 text-dark">{{ $result->objection->reason }}</p>
                                </div>

                                @if($result->objection->admin_note)
                                    <div class="alert alert-danger bg-opacity-10 border-danger border-opacity-25 mb-0 rounded-3">
                                        <small class="fw-bold text-danger d-block mb-1 text-uppercase"><i class="bi bi-gavel me-1"></i> Keputusan Atasan PPID</small>
                                        <p class="mb-0 text-dark">{{ $result->objection->admin_note }}</p>
                                    </div>
                                @else
                                    <div class="text-muted small fst-italic d-flex align-items-center">
                                        <div class="spinner-border spinner-border-sm me-2 text-secondary" role="status"></div>
                                        Sedang ditelaah oleh Atasan PPID. Harap menunggu.
                                    </div>
                                @endif
                            </div>
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

    /* INPUT & UTILS */
    .form-control:focus { box-shadow: none; }
    .input-group:focus-within {
        box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.15) !important;
        border-color: #0d6efd !important;
    }
    .hover-border-primary:hover { border-color: #0d6efd !important; }

    .border-dashed { border-style: dashed !important; border-color: #cbd5e1 !important; }
    .ls-1 { letter-spacing: 1px; }

    .hover-scale:hover { transform: scale(1.05); transition: 0.2s; }

    /* ANIMATIONS */
    .animate-fade-up { animation: fadeUp 0.8s ease-out forwards; opacity: 0; transform: translateY(20px); }
    .animate-fade-down { animation: fadeDown 0.8s ease-out forwards; opacity: 0; transform: translateY(-20px); }
    .delay-100 { animation-delay: 0.2s; }
    .delay-200 { animation-delay: 0.4s; }

    @keyframes fadeUp { to { opacity: 1; transform: translateY(0); } }
    @keyframes fadeDown { to { opacity: 1; transform: translateY(0); } }
    .backdrop-blur { backdrop-filter: blur(5px); }
</style>

@endsection
