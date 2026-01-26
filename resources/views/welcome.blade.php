@extends('layouts.frontend')

@section('content')

@php
    // Logika Gambar Background Hero (Default jika tidak ada di settings)
    $bgImage = (isset($globalSettings) && isset($globalSettings['hero_bg']))
        ? asset('storage/' . $globalSettings['hero_bg'])
        : 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=2070&auto=format&fit=crop';
@endphp

{{-- 1. HERO SECTION --}}
{{-- 1. HERO SECTION (REDESIGN) --}}
<section class="hero-section">
    {{-- Background Image Dinamis --}}
    <div class="hero-bg" style="background-image: url('{{ $bgImage }}');"></div>

    {{-- Overlay Gradient (Biar teks terbaca jelas) --}}
    <div class="hero-overlay"></div>

    {{-- Konten Utama --}}
    <div class="container position-relative text-center text-white" style="z-index: 5;">

        {{-- Badge Kecil di Atas Judul --}}
        <div class="d-inline-flex align-items-center bg-white bg-opacity-10 backdrop-blur border border-white border-opacity-25 rounded-pill px-3 py-1 mb-4 animate-fade-down">
            <span class="badge bg-warning text-dark me-2 rounded-pill">RESMI</span>
            <small class="fw-medium ls-1 text-white">PORTAL PPID PROVINSI KALSEL</small>
        </div>

        {{-- Judul Besar --}}
        <h1 class="display-3 fw-bold mb-3 animate-fade-up">
            Layanan Informasi Publik<br>
            <span class="text-gradient-gold">Kalimantan Selatan</span>
        </h1>
        <p class="lead opacity-90 mb-5 animate-fade-up delay-100" style="font-weight: 300; max-width: 700px; margin: 0 auto;">
            Transparan, Akuntabel, dan Melayani. Akses jutaan informasi publik dengan mudah, cepat, dan terpercaya.
        </p>

        {{-- SEARCH BOX MODERN (LEBIH BESAR & JELAS) --}}
        <div class="search-wrapper mx-auto animate-fade-up delay-200">
            <form action="{{ route('documents.search') }}" method="GET">
                <div class="input-group search-group shadow-lg">
                    {{-- Icon Kiri --}}
                    <span class="input-group-text bg-white border-0 ps-4">
                        <i class="bi bi-search text-primary fs-5"></i>
                    </span>

                    {{-- Input Field --}}
                    <input type="text" name="q"
                           class="form-control border-0 py-3 ps-3"
                           placeholder="Ketik kata kunci dokumen (misal: Renstra, Anggaran)..."
                           required
                           style="font-size: 1.1rem;">

                    {{-- Tombol Cari --}}
                    <button class="btn btn-primary px-5 fw-bold text-uppercase ls-1" type="submit">
                        Cari
                    </button>
                </div>
            </form>
            {{-- Teks Bantuan di Bawah Search --}}
            <div class="mt-3 text-white-50 small">
                <i class="bi bi-info-circle me-1"></i> Populer:
                <a href="#" class="text-white text-decoration-underline opacity-75 hover-opacity-100 me-2">Renstra</a>
                <a href="#" class="text-white text-decoration-underline opacity-75 hover-opacity-100 me-2">LAKIP</a>
                <a href="#" class="text-white text-decoration-underline opacity-75 hover-opacity-100">Anggaran</a>
            </div>
        </div>
    </div>

    {{-- Wave SVG (Pemisah Hero & Konten) --}}
    <div class="hero-wave">
        <svg viewBox="0 0 1440 320" xmlns="http://www.w3.org/2000/svg">
            <path fill="#f8f9fa" fill-opacity="1" d="M0,160L48,170.7C96,181,192,203,288,197.3C384,192,480,160,576,149.3C672,139,768,149,864,170.7C960,192,1056,224,1152,224C1248,224,1344,192,1392,176L1440,160L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
        </svg>
    </div>
</section>

{{-- 2. KARTU LAYANAN --}}
<section class="features-section bg-light pb-5">
    <div class="container">
        <div class="row g-4 justify-content-center card-container">
            {{-- Kartu 1: Cara Memperoleh Informasi --}}
            <div class="col-md-6 col-lg-3">
                <a href="{{ route('public.page', 'cara-memperoleh-informasi') }}" class="card-feature text-decoration-none h-100">
                    <div class="card border-0 shadow-sm h-100 text-center py-4 px-3">
                        <div class="icon-box bg-primary bg-opacity-10 text-primary">
                            <i class="bi bi-file-earmark-text"></i>
                        </div>
                        <h6 class="fw-bold text-dark mt-3">Cara Memperoleh Informasi</h6>
                        <p class="text-muted small mb-0">Panduan lengkap prosedur.</p>
                    </div>
                </a>
            </div>

            {{-- Kartu 2: Form Permintaan --}}
            <div class="col-md-6 col-lg-3">
                <a href="{{ route('requests.create') }}" class="card-feature text-decoration-none h-100">
                    <div class="card border-0 shadow-sm h-100 text-center py-4 px-3">
                        <div class="icon-box bg-success bg-opacity-10 text-success">
                            <i class="bi bi-ui-checks"></i>
                        </div>
                        <h6 class="fw-bold text-dark mt-3">Form Permintaan Info</h6>
                        <p class="text-muted small mb-0">Ajukan permohonan online.</p>
                    </div>
                </a>
            </div>

            {{-- Kartu 3: Pengajuan Keberatan --}}
            <div class="col-md-6 col-lg-3">
                <a href="{{ route('objection.search') }}" class="card-feature text-decoration-none h-100">
                    <div class="card border-0 shadow-sm h-100 text-center py-4 px-3">
                        <div class="icon-box bg-warning bg-opacity-10 text-warning">
                            <i class="bi bi-exclamation-triangle"></i>
                        </div>
                        <h6 class="fw-bold text-dark mt-3">Form Pengajuan Keberatan</h6>
                        <p class="text-muted small mb-0">Layanan pengajuan keberatan.</p>
                    </div>
                </a>
            </div>

            {{-- Kartu 4: DIP --}}
            <div class="col-md-6 col-lg-3">
                <a href="{{ route('documents.public', 'daftar-infomasi-publik') }}" class="card-feature text-decoration-none h-100">
                    <div class="card border-0 shadow-sm h-100 text-center py-4 px-3">
                        <div class="icon-box bg-danger bg-opacity-10 text-danger">
                            <i class="bi bi-collection"></i>
                        </div>
                        <h6 class="fw-bold text-dark mt-3">Daftar Informasi Publik</h6>
                        <p class="text-muted small mb-0">Akses dokumen publik.</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>

{{-- 3. BERITA TERBARU --}}
<section class="py-5 bg-white" id="berita">
    <div class="container py-3">
        <div class="row align-items-center mb-4">
            <div class="col-lg-8">
                <h3 class="fw-bold mb-1">Berita <span class="text-primary">Terbaru</span></h3>
                <p class="text-muted small mb-0">Informasi terkini dari PPID Kalimantan Selatan</p>
            </div>
            <div class="col-lg-4 text-lg-end mt-2 mt-lg-0">
                <a href="{{ route('news.index') }}" class="btn btn-outline-primary btn-sm rounded-pill px-4">
                    Lihat Semua <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
        </div>

        @if($posts->count() > 0)
        <div class="row g-3">
            @foreach($posts as $post)
            <div class="col-lg-4 col-md-6">
                <div class="card news-card border-0 shadow-sm h-100 overflow-hidden">
                    <div class="card-img-wrapper position-relative overflow-hidden">
                        @if($post->image)
                            <img src="{{ asset('storage/' . $post->image) }}" class="card-img-top" alt="{{ $post->title }}" style="height: 180px; object-fit: cover;">
                        @else
                            <div class="placeholder-img bg-gradient-primary d-flex align-items-center justify-content-center" style="height: 180px;">
                                <i class="bi bi-newspaper text-white" style="font-size: 2.5rem;"></i>
                            </div>
                        @endif
                        <span class="badge bg-primary position-absolute top-0 start-0 m-3 small shadow-sm">
                            {{ $post->category->name ?? 'Berita' }}
                        </span>
                    </div>

                    <div class="card-body p-3 d-flex flex-column">
                        <div class="text-muted small mb-2 d-flex align-items-center">
                            <i class="bi bi-calendar-event me-1"></i> {{ $post->created_at->format('d M Y') }}
                        </div>
                        <h6 class="card-title fw-bold mb-2">
                            <a href="{{ route('news.show', $post->slug) }}" class="text-dark text-decoration-none stretched-link">
                                {{ Str::limit($post->title, 55) }}
                            </a>
                        </h6>
                        <p class="card-text text-muted small mb-3 flex-grow-1" style="font-size: 0.85rem;">
                            {{ Str::limit(strip_tags($post->excerpt ?? $post->content), 90) }}
                        </p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-5">
            <div class="alert alert-light border shadow-sm d-inline-block px-5">
                <i class="bi bi-info-circle me-2"></i> Belum ada berita yang diterbitkan.
            </div>
        </div>
        @endif
    </div>
</section>

{{-- 4. SURVEI KEPUASAN (DINAMIS & MODERN) --}}
<section class="py-5 bg-light" id="survey">
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-10">

                <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                    <div class="row g-0">

                        {{-- BAGIAN KIRI: HASIL RATING (DINAMIS DARI DB) --}}
                        <div class="col-md-5 text-white p-5 d-flex flex-column justify-content-center align-items-center text-center position-relative"
                             style="background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);">

                            {{-- Ornamen Lingkaran Transparan --}}
                            <div style="position: absolute; top: -20px; left: -20px; width: 100px; height: 100px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
                            <div style="position: absolute; bottom: -30px; right: -30px; width: 150px; height: 150px; background: rgba(255,255,255,0.05); border-radius: 50%;"></div>

                            <h6 class="fw-bold text-uppercase ls-1 text-white-50 mb-3">Indeks Kepuasan Masyarakat</h6>

                            {{-- Angka Rata-Rata Dinamis --}}
                            <div class="display-1 fw-bold text-white mb-0" style="line-height: 1;">
                                {{ isset($surveyStats) ? number_format($surveyStats['average'], 1) : '0.0' }}
                            </div>

                            {{-- Bintang Dinamis (Logic Blade) --}}
                            <div class="my-3 text-warning fs-3">
                                @php
                                    $rating = isset($surveyStats) ? $surveyStats['average'] : 0;
                                @endphp
                                @foreach(range(1,5) as $i)
                                    @if($rating >= $i)
                                        <i class="bi bi-star-fill"></i> {{-- Penuh --}}
                                    @elseif($rating >= $i - 0.5)
                                        <i class="bi bi-star-half"></i> {{-- Setengah --}}
                                    @else
                                        <i class="bi bi-star text-white-50"></i> {{-- Kosong --}}
                                    @endif
                                @endforeach
                            </div>

                            {{-- Label Teks Dinamis --}}
                            <div class="badge bg-warning text-dark rounded-pill px-4 py-2 mb-3 fw-bold shadow-sm">
                                {{ isset($label) ? $label : 'Belum Ada Data' }}
                            </div>

                            <p class="small text-white-50 mb-0">
                                Berdasarkan suara dari <strong>{{ isset($surveyStats) ? number_format($surveyStats['count']) : '0' }}</strong> responden<br>Masyarakat Kalimantan Selatan.
                            </p>
                        </div>

                        {{-- BAGIAN KANAN: FORM INPUT --}}
                        <div class="col-md-7 bg-white p-4 p-md-5">
                            <h4 class="fw-bold mb-2 text-dark">Bantu Kami Lebih Baik</h4>
                            <p class="text-muted small mb-4">Masukan Anda sangat berharga untuk peningkatan kualitas pelayanan publik kami.</p>

                            {{-- Notifikasi Sukses --}}
                            @if(session('success_survey'))
                                <div class="alert alert-success py-2 px-3 small rounded-3 mb-4 d-flex align-items-center border-0 bg-success bg-opacity-10 text-success">
                                    <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                                    <div>{{ session('success_survey') }}</div>
                                </div>
                            @endif

                            <form action="{{ route('survey.store') }}" method="POST">
                                @csrf

                                {{-- INPUT BINTANG (Interactive) --}}
                                <div class="mb-4">
                                    <label class="form-label fw-bold small text-muted text-uppercase mb-2">Seberapa puas Anda?</label>

                                    <div class="star-rating d-flex flex-row-reverse justify-content-end gap-1">
                                        <input type="radio" id="star5" name="rating" value="5" hidden {{ old('rating') == '5' ? 'checked' : '' }}>
                                        <label for="star5" title="Sangat Puas (5)"><i class="bi bi-star-fill"></i></label>

                                        <input type="radio" id="star4" name="rating" value="4" hidden {{ old('rating') == '4' ? 'checked' : '' }}>
                                        <label for="star4" title="Puas (4)"><i class="bi bi-star-fill"></i></label>

                                        <input type="radio" id="star3" name="rating" value="3" hidden {{ old('rating') == '3' ? 'checked' : '' }}>
                                        <label for="star3" title="Cukup (3)"><i class="bi bi-star-fill"></i></label>

                                        <input type="radio" id="star2" name="rating" value="2" hidden {{ old('rating') == '2' ? 'checked' : '' }}>
                                        <label for="star2" title="Kurang (2)"><i class="bi bi-star-fill"></i></label>

                                        <input type="radio" id="star1" name="rating" value="1" hidden {{ old('rating') == '1' ? 'checked' : '' }}>
                                        <label for="star1" title="Buruk (1)"><i class="bi bi-star-fill"></i></label>
                                    </div>

                                    @error('rating')
                                        <div class="text-danger small mt-1">
                                            <i class="bi bi-exclamation-circle me-1"></i> Mohon berikan penilaian bintang.
                                        </div>
                                    @enderror
                                </div>

                                {{-- INPUT FEEDBACK --}}
                                <div class="form-floating mb-4">
                                    <textarea name="feedback" class="form-control bg-light border-0"
                                              placeholder="Saran" id="feedbackArea"
                                              style="height: 120px; font-size: 0.95rem; resize: none;">{{ old('feedback') }}</textarea>
                                    <label for="feedbackArea" class="text-muted">Tulis kritik & saran Anda di sini...</label>

                                    @error('feedback')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary rounded-pill py-3 fw-bold shadow-sm transition-btn">
                                        Kirim Penilaian Saya <i class="bi bi-send-fill ms-2"></i>
                                    </button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
<style>
    /* =========================================
       1. HERO SECTION CUSTOM
       ========================================= */
    .hero-section {
        position: relative;
        min-height: 85vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #0f172a;
        overflow: hidden;
        margin-top: -85px;
        padding-top: 100px;
    }

    .hero-bg {
        position: absolute; top: 0; left: 0; width: 100%; height: 100%;
        background-position: center; background-size: cover; background-repeat: no-repeat;
        z-index: 0;
        animation: zoomEffect 20s infinite alternate;
    }

    /* OVERLAY LEBIH GELAP SEDIKIT (Agar teks putih makin jelas) */
    .hero-overlay {
        position: absolute; top: 0; left: 0; width: 100%; height: 100%;
        background: linear-gradient(180deg, rgba(15, 23, 42, 0.85) 0%, rgba(15, 23, 42, 0.6) 50%, rgba(15, 23, 42, 0.95) 100%);
        z-index: 1;
    }

    .hero-wave {
        position: absolute; bottom: -2px; left: 0; width: 100%;
        line-height: 0; z-index: 4; pointer-events: none;
    }

    /* --- UPDATE WARNA TEKS --- */

    /* 1. Judul Utama (Putih dengan Shadow Kuat) */
    .hero-section h1 {
        color: #ffffff;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.5); /* Bayangan Hitam */
    }

    /* 2. Warna Emas Metallic (Lebih Terang & Mewah) */
    .text-gradient-gold {
        /* Gradasi dari Putih Emas -> Kuning Emas -> Orange Emas */
        background: linear-gradient(to right, #FFF8DC, #FFD700, #FFA500);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        font-weight: 800;
        /* Filter Drop Shadow agar emasnya timbul */
        filter: drop-shadow(0 2px 2px rgba(0,0,0,0.5));
    }

    /* 3. Teks Deskripsi (Putih Bersih + Shadow) */
    .hero-section .lead {
        color: #f8f9fa !important; /* Putih terang */
        text-shadow: 0 1px 3px rgba(0,0,0,0.8); /* Outline hitam tipis agar terbaca di bg putih */
        font-weight: 400;
        line-height: 1.6;
    }

    @keyframes zoomEffect {
        from { transform: scale(1); }
        to { transform: scale(1.1); }
    }

    /* =========================================
       2. SEARCH BOX (MODERN STYLE)
       ========================================= */
    .search-wrapper { max-width: 700px; width: 100%; }

    .search-group {
        border-radius: 50px;
        overflow: hidden;
        padding: 5px;
        background: rgba(255, 255, 255, 0.9); /* Putih agak solid agar teks input jelas */
        box-shadow: 0 10px 30px rgba(0,0,0,0.2); /* Shadow kotak pencarian */
    }

    .search-group input {
        color: #333; /* Warna ketikan teks (Hitam Abu) */
        font-weight: 500;
    }

    .search-group input:focus { box-shadow: none; background: transparent; }

    .search-group .btn-primary {
        border-radius: 50px;
        background: linear-gradient(45deg, #2563eb, #1d4ed8);
        border: none;
        transition: all 0.3s ease;
    }
    .search-group .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(37, 99, 235, 0.4);
    }

    /* =========================================
       3. ICON BOX & CARDS
       ========================================= */
    .card-container { margin-top: -80px; position: relative; z-index: 10; }

    .card-feature .card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border-radius: 20px;
        background: #fff;
    }

    .card-feature:hover .card {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.08) !important;
        border-color: #FFD700 !important; /* Border Emas saat hover */
    }

    .icon-box {
        width: 90px; height: 90px;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 1.5rem auto; padding: 0;
        transition: transform 0.3s;
    }
    .card-feature:hover .icon-box { transform: scale(1.1) rotate(5deg); }
    .icon-box i { font-size: 36px; }

    /* =========================================
       4. ANIMASI & LAINNYA
       ========================================= */
    .animate-fade-up { animation: fadeUp 0.8s ease-out forwards; opacity: 0; transform: translateY(20px); }
    .animate-fade-down { animation: fadeDown 0.8s ease-out forwards; opacity: 0; transform: translateY(-20px); }

    .delay-100 { animation-delay: 0.2s; }
    .delay-200 { animation-delay: 0.4s; }

    @keyframes fadeUp { to { opacity: 1; transform: translateY(0); } }
    @keyframes fadeDown { to { opacity: 1; transform: translateY(0); } }

    /* Star Rating */
    .star-rating { font-size: 2.2rem; cursor: pointer; }
    .star-rating label { color: #e9ecef; transition: all 0.2s; cursor: pointer; padding: 0 5px; }
    .star-rating label:hover, .star-rating label:hover ~ label, .star-rating input:checked ~ label {
        color: #FFD700; transform: scale(1.15);
    }

    .ls-1 { letter-spacing: 1px; }
    .backdrop-blur { backdrop-filter: blur(5px); }
</style>
@endsection
