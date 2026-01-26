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
            <span class="badge bg-warning text-dark me-2 rounded-pill">LAYANAN</span>
            <small class="fw-medium ls-1 text-white">PERMOHONAN INFORMASI</small>
        </div>

        {{-- Judul Emas --}}
        <h1 class="display-3 fw-bold mb-3 animate-fade-up text-white">
            Formulir <span class="text-gradient-gold">Permohonan</span>
        </h1>

        {{-- Deskripsi --}}
        <p class="text-white lead opacity-90 mb-5 animate-fade-up delay-100" style="max-width: 700px; margin: 0 auto; text-shadow: 0 2px 5px rgba(0,0,0,0.5);">
            Ajukan permohonan informasi publik secara online dengan mudah, cepat, dan transparan.
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
    {{-- Margin negatif ditarik ke atas --}}
    <div class="container" style="margin-top: -100px; position: relative; z-index: 10;">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                <div class="card border-0 shadow-lg rounded-4 overflow-hidden animate-fade-up delay-200">

                    {{-- Alert Info --}}
                    <div class="bg-primary bg-opacity-10 p-4 border-bottom border-primary border-opacity-10">
                        <div class="d-flex align-items-start">
                            <div class="bg-white p-2 rounded-circle shadow-sm me-3 text-primary">
                                <i class="bi bi-info-circle-fill fs-4"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold text-primary mb-1">Petunjuk Pengisian</h6>
                                <p class="small text-muted mb-0" style="line-height: 1.5;">
                                    Pastikan data yang Anda masukkan <strong>valid dan sesuai KTP</strong>. Permohonan yang tidak lengkap atau data palsu tidak akan diproses.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-4 p-md-5 bg-white">

                        {{-- Menampilkan Error --}}
                        @if($errors->any())
                            <div class="alert alert-danger rounded-3 mb-4 d-flex align-items-center">
                                <i class="bi bi-exclamation-triangle-fill me-3 fs-4"></i>
                                <div>
                                    <strong>Ups! Ada kesalahan input:</strong>
                                    <ul class="mb-0 small mt-1 ps-3">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif

                        <form action="{{ route('requests.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            {{-- BAGIAN 1: IDENTITAS --}}
                            <div class="mb-5 position-relative">
                                <span class="position-absolute top-0 start-0 translate-middle-y bg-white px-2 text-primary fw-bold small text-uppercase ls-1" style="margin-top: -10px; margin-left: 10px;">
                                    <i class="bi bi-person-vcard me-1"></i> 1. Identitas Pemohon
                                </span>
                                <div class="border rounded-4 p-4 pt-5 mt-2 bg-light bg-opacity-25">
                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold small text-muted">NIK (Nomor Induk Kependudukan)</label>
                                            <input type="number" name="nik" class="form-control form-control-lg" required placeholder="16 digit NIK" value="{{ old('nik') }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold small text-muted">Nama Lengkap</label>
                                            <input type="text" name="name" class="form-control form-control-lg" required placeholder="Sesuai KTP" value="{{ old('name') }}">
                                        </div>

                                        <div class="col-12">
                                            <label class="form-label fw-bold small text-muted">Upload Foto KTP / Identitas</label>
                                            <input type="file" name="ktp_file" class="form-control form-control-lg" accept="image/*" required>
                                            <div class="form-text small text-muted"><i class="bi bi-info-circle me-1"></i> Format: JPG/PNG. Maksimal 2MB. Pastikan foto jelas.</div>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label fw-bold small text-muted">Email Aktif</label>
                                            <input type="email" name="email" class="form-control form-control-lg" required placeholder="email@contoh.com" value="{{ old('email') }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold small text-muted">No. WhatsApp / HP</label>
                                            <input type="number" name="phone" class="form-control form-control-lg" required placeholder="08..." value="{{ old('phone') }}">
                                        </div>

                                        <div class="col-12">
                                            <label class="form-label fw-bold small text-muted">Alamat Lengkap</label>
                                            <textarea name="address" class="form-control form-control-lg" rows="2" required placeholder="Nama Jalan, RT/RW, Kelurahan, Kecamatan...">{{ old('address') }}</textarea>
                                        </div>

                                        <div class="col-12">
                                            <label class="form-label fw-bold small text-muted">Pekerjaan</label>
                                            <input type="text" name="job" class="form-control form-control-lg" placeholder="Contoh: Mahasiswa / PNS / Wiraswasta" value="{{ old('job') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- BAGIAN 2: RINCIAN --}}
                            <div class="mb-5 position-relative">
                                <span class="position-absolute top-0 start-0 translate-middle-y bg-white px-2 text-warning fw-bold small text-uppercase ls-1" style="margin-top: -10px; margin-left: 10px;">
                                    <i class="bi bi-file-earmark-text me-1"></i> 2. Detail Informasi
                                </span>
                                <div class="border rounded-4 p-4 pt-5 mt-2 bg-light bg-opacity-25">
                                    <div class="row g-4">
                                        <div class="col-12">
                                            <label class="form-label fw-bold small text-muted">Rincian Informasi yang Dibutuhkan</label>
                                            <textarea name="details" class="form-control form-control-lg" rows="4" required placeholder="Jelaskan secara spesifik informasi apa yang Anda cari...">{{ old('details') }}</textarea>
                                        </div>

                                        <div class="col-12">
                                            <label class="form-label fw-bold small text-muted">Tujuan Penggunaan Informasi</label>
                                            <textarea name="purpose" class="form-control form-control-lg" rows="3" required placeholder="Jelaskan untuk apa informasi ini akan digunakan...">{{ old('purpose') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-grid pt-2">
                                <button type="submit" class="btn btn-primary btn-lg rounded-pill fw-bold shadow-lg hover-scale">
                                    <i class="bi bi-send-fill me-2"></i> KIRIM PERMOHONAN
                                </button>
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
    /* HERO STYLES (Sama dengan Welcome/Docs) */
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

    /* FORM STYLES */
    .form-control, .form-select {
        border: 1px solid #e2e8f0;
        padding: 15px 20px; /* Padding lebih besar biar enak diklik */
        border-radius: 12px;
        font-size: 1rem;
        background-color: #fff;
        transition: all 0.3s ease;
    }
    .form-control:focus, .form-select:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        transform: translateY(-2px);
    }

    /* Tombol Submit Keren */
    .hover-scale { transition: transform 0.2s, box-shadow 0.2s; }
    .hover-scale:hover { transform: translateY(-3px); box-shadow: 0 10px 25px rgba(59, 130, 246, 0.4) !important; }

    /* Animations */
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
