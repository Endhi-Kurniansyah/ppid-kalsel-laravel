@extends('layouts.frontend')

@section('content')

{{-- 1. HERO SECTION (KEMBALI KE BIRU, MERAH HANYA DI BADGE) --}}
<section class="hero-section">
    @php
        $bgImage = (isset($globalSettings) && isset($globalSettings['hero_bg']))
            ? asset('storage/' . $globalSettings['hero_bg'])
            : 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=2070&auto=format&fit=crop';
    @endphp

    <div class="hero-bg" style="background-image: url('{{ $bgImage }}');"></div>

    {{-- OVERLAY BIRU STANDAR (Bukan Merah Lagi) --}}
    <div class="hero-overlay"></div>

    <div class="container position-relative z-2 text-center py-5 mt-4">

        {{-- Badge MERAH (Subtle Red Accent) --}}
        <div class="d-inline-flex align-items-center bg-white bg-opacity-10 backdrop-blur border border-white border-opacity-25 rounded-pill px-3 py-1 mb-4 animate-fade-down">
            <span class="badge bg-danger text-white me-2 rounded-pill">PENGADUAN</span>
            <small class="fw-medium ls-1 text-white">PENGAJUAN KEBERATAN</small>
        </div>

        {{-- Judul Emas --}}
        <h1 class="display-3 fw-bold mb-3 animate-fade-up text-white">
            Formulir <span class="text-gradient-gold">Keberatan</span>
        </h1>

        {{-- Deskripsi --}}
        <p class="text-white lead opacity-90 mb-5 animate-fade-up delay-100" style="max-width: 700px; margin: 0 auto; text-shadow: 0 2px 5px rgba(0,0,0,0.5);">
            Sampaikan keberatan Anda atas layanan informasi publik untuk ditindaklanjuti oleh Atasan PPID.
        </p>
    </div>

    {{-- Wave Separator (Putih) --}}
    <div class="hero-wave">
        <svg viewBox="0 0 1440 100" xmlns="http://www.w3.org/2000/svg">
            <path fill="#ffffff" d="M0,64L48,69.3C96,75,192,85,288,80C384,75,480,53,576,42.7C672,32,768,32,864,42.7C960,53,1056,75,1152,80C1248,85,1344,75,1392,69.3L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
        </svg>
    </div>
</section>

{{-- 2. KONTEN FORMULIR --}}
<div class="py-5 bg-white" style="min-height: 600px;">
    <div class="container" style="margin-top: -100px; position: relative; z-index: 10;">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                <div class="card border-0 shadow-lg rounded-4 overflow-hidden animate-fade-up delay-200">

                    {{-- Header Card --}}
                    <div class="bg-light p-4 border-bottom">
                        <div class="d-flex align-items-center">
                            {{-- Ikon Merah --}}
                            <div class="bg-white p-3 rounded-circle border shadow-sm me-3 text-danger">
                                <i class="bi bi-ticket-detailed-fill fs-3"></i>
                            </div>
                            <div>
                                <small class="text-muted text-uppercase fw-bold ls-1 d-block mb-1">Data Permohonan Asal</small>
                                <h5 class="fw-bold mb-0 text-dark">Nomor Tiket: <span class="text-primary">#{{ $infoRequest->ticket_number }}</span></h5>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-4 p-md-5 bg-white">

                        {{-- Detail Permohonan (Read Only Box) --}}
                        <div class="row g-3 mb-5 bg-light rounded-4 p-4 border border-dashed mx-0">
                            <div class="col-md-6 border-end border-light">
                                <label class="small text-muted fw-bold text-uppercase mb-1">Tanggal Pengajuan</label>
                                <div class="text-dark fw-medium fs-5">{{ $infoRequest->created_at->format('d F Y') }}</div>
                            </div>
                            <div class="col-md-6">
                                <label class="small text-muted fw-bold text-uppercase mb-1">Status Terakhir</label>
                                <div>
                                    <span class="badge bg-secondary rounded-pill px-3">{{ $infoRequest->status }}</span>
                                </div>
                            </div>
                            <div class="col-12 mt-3 pt-3 border-top border-light">
                                <label class="small text-muted fw-bold text-uppercase mb-2">Informasi yang Diminta</label>
                                <div class="p-3 bg-white rounded border fst-italic text-secondary">
                                    "{{ $infoRequest->details }}"
                                </div>
                            </div>
                        </div>

                        {{-- Form Keberatan --}}
                        <form action="{{ route('objection.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="information_request_id" value="{{ $infoRequest->id }}">

                            <div class="mb-4">
                                <label class="form-label fw-bold text-dark mb-2">
                                    {{-- Ikon Merah --}}
                                    <i class="bi bi-exclamation-circle-fill text-danger me-2"></i> Alasan Keberatan
                                </label>
                                <select name="reason" class="form-select form-select-lg" required>
                                    <option value="" disabled selected>-- Pilih salah satu alasan --</option>
                                    <option value="Permohonan Informasi Ditolak">Permohonan Informasi Ditolak</option>
                                    <option value="Informasi Berkala Tidak Disediakan">Informasi Berkala Tidak Disediakan</option>
                                    <option value="Permintaan Tidak Ditanggapi">Permintaan Tidak Ditanggapi</option>
                                    <option value="Permintaan Tidak Dipenuhi Sebagaimana Mestinya">Permintaan Tidak Dipenuhi Sebagaimana Mestinya</option>
                                    <option value="Biaya yang Dikenakan Tidak Wajar">Biaya yang Dikenakan Tidak Wajar</option>
                                    <option value="Penyampaian Informasi Melebihi Waktu">Penyampaian Informasi Melebihi Waktu</option>
                                </select>
                            </div>

                            <div class="mb-5">
                                <label class="form-label fw-bold text-dark mb-2">
                                    {{-- Ikon Merah --}}
                                    <i class="bi bi-textarea-t text-danger me-2"></i> Kasus Posisi (Kronologi)
                                </label>
                                <textarea name="description" class="form-control" rows="6" required placeholder="Ceritakan secara detail kronologi dan alasan mengapa Anda mengajukan keberatan ini..."></textarea>
                                <div class="form-text text-end mt-2" id="charCount">0 karakter</div>
                            </div>

                            <div class="d-grid gap-3">
                                {{-- Tombol Submit MERAH (Aksi Utama) --}}
                                <button type="submit" class="btn btn-danger btn-lg rounded-pill fw-bold shadow-lg hover-scale py-3">
                                    <i class="bi bi-send-fill me-2"></i> KIRIM PERNYATAAN KEBERATAN
                                </button>

                                {{-- Tombol Batal Abu-abu --}}
                                <a href="{{ route('objection.search') }}" class="btn btn-light btn-lg rounded-pill fw-bold text-muted border py-3 hover-bg-light">
                                    Batal
                                </a>
                            </div>

                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

{{-- CSS KHUSUS --}}
<style>
    /* HERO STYLES (BIRU GELAP STANDAR) */
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
        /* Overlay BIRU, bukan Merah */
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

    /* FORM STYLES */
    .form-control, .form-select {
        border: 1px solid #e2e8f0; padding: 15px 20px; border-radius: 12px; font-size: 1rem;
        background-color: #fff; transition: all 0.3s ease;
    }

    /* Focus Effect MERAH (Hanya saat diklik) */
    .form-control:focus, .form-select:focus {
        border-color: #dc3545; /* Merah */
        box-shadow: 0 0 0 4px rgba(220, 53, 69, 0.1);
        transform: translateY(-2px);
    }
    .border-dashed { border-style: dashed !important; border-color: #cbd5e1 !important; }

    /* BUTTONS */
    .hover-scale { transition: transform 0.2s, box-shadow 0.2s; }
    .hover-scale:hover { transform: translateY(-3px); box-shadow: 0 10px 25px rgba(220, 53, 69, 0.4) !important; } /* Shadow Merah */
    .hover-bg-light:hover { background-color: #f1f5f9; }

    /* ANIMATIONS */
    .animate-fade-up { animation: fadeUp 0.8s ease-out forwards; opacity: 0; transform: translateY(20px); }
    .delay-100 { animation-delay: 0.2s; }
    .delay-200 { animation-delay: 0.4s; }
    @keyframes fadeUp { to { opacity: 1; transform: translateY(0); } }
    .ls-1 { letter-spacing: 1px; }
    .backdrop-blur { backdrop-filter: blur(5px); }
</style>

{{-- SCRIPT --}}
<script>
    const textarea = document.querySelector('textarea[name="description"]');
    const counter = document.getElementById('charCount');
    if(textarea){
        textarea.addEventListener('input', function() {
            counter.innerText = this.value.length + ' karakter';
        });
    }
</script>

@endsection
