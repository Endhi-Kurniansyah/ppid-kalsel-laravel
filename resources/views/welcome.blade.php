@extends('layouts.frontend')

@section('content')

<section class="hero-section">
    <div class="container text-center">
        <h1 class="display-3 fw-bold mb-3">Selamat Datang di PPID</h1>
        <h2 class="h4 mb-4">Provinsi Kalimantan Selatan</h2>
        <p class="lead mb-5 px-5">Transparan, Akuntabel, dan Melayani. Dapatkan informasi publik dengan mudah dan cepat melalui layanan digital kami.</p>
    </div>
</section>

<section class="py-5 bg-light">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-3 mb-4">
                <a href="#" class="text-decoration-none text-dark">
                    <div class="card border-0 shadow-sm h-100 py-4 hover-zoom">
                        <div class="card-body">
                            <div class="mb-3 text-primary">
                                <i class="bi bi-file-earmark-text fs-1"></i>
                            </div>
                            <h5 class="card-title">Cara Memperoleh Informasi</h5>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-3 mb-4">
                <a href="{{ route('requests.create') }}" class="text-decoration-none text-dark">
                    <div class="card border-0 shadow-sm h-100 py-4 hover-zoom">
                        <div class="card-body">
                            <div class="mb-3 text-success">
                                <i class="bi bi-ui-checks fs-1"></i>
                            </div>
                            <h5 class="card-title">Form Permintaan Informasi</h5>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-3 mb-4">
                <a href="requests.create" class="text-decoration-none text-dark">
                    <div class="card border-0 shadow-sm h-100 py-4 hover-zoom">
                        <div class="card-body">
                            <div class="mb-3 text-warning">
                                <i class="bi bi-exclamation-triangle fs-1"></i>
                            </div>
                            <h5 class="card-title">Form Pengajuan Keberatan</h5>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-3 mb-4">
                <a href="{{ route('public.documents', 'berkala') }}" class="text-decoration-none text-dark">
                    <div class="card border-0 shadow-sm h-100 py-4 hover-zoom">
                        <div class="card-body">
                            <div class="mb-3 text-danger">
                                <i class="bi bi-collection fs-1"></i>
                            </div>
                            <h5 class="card-title">Daftar Informasi Publik</h5>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>

<section id="berita" class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold text-primary">Berita & Artikel Terbaru</h2>
            <p class="text-muted">Ikuti kegiatan dan informasi terkini dari PPID Kalsel</p>
        </div>

        <div class="row">
            @forelse($posts as $post)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm border-0 hover-card">

                    <div class="position-relative">
                        @if($post->image)
                            <img src="{{ asset('storage/' . $post->image) }}" class="card-img-top" alt="{{ $post->title }}" style="height: 200px; object-fit: cover;">
                        @else
                            <img src="https://via.placeholder.com/400x200?text=No+Image" class="card-img-top" style="height: 200px; object-fit: cover;">
                        @endif

                        <span class="badge bg-primary position-absolute top-0 start-0 m-3 shadow">
                            {{ $post->category->name ?? 'Berita' }}
                        </span>
                    </div>

                    <div class="card-body">
                        <small class="text-muted d-block mb-2">
                            <i class="bi bi-calendar-event me-1"></i> {{ $post->created_at->format('d M Y') }}
                            &nbsp;|&nbsp;
                            <i class="bi bi-person me-1"></i> {{ $post->user->name }}
                        </small>

                        <h5 class="card-title fw-bold">
                            <a href="{{ route('news.show', $post->slug) }}" class="text-decoration-none text-dark stretched-link"></a>
                                {{ Str::limit($post->title, 50) }}
                            </a>
                        </h5>

                        <p class="card-text text-muted small">
                            {{ Str::limit(strip_tags($post->content), 100) }}
                        </p>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <div class="alert alert-info border-0 shadow-sm d-inline-block px-5">
                    <i class="bi bi-info-circle me-2"></i> Belum ada berita yang diterbitkan.
                </div>
            </div>
            @endforelse
        </div>

        <div class="text-center mt-4">
            <a href="#" class="btn btn-outline-primary px-4 rounded-pill">
                Lihat Semua Berita <i class="bi bi-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</section>
<section class="py-5 bg-white border-top">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h3 class="fw-bold mb-3">Bagaimana Pelayanan Kami?</h3>
                <p class="text-muted">Partisipasi Anda sangat berarti bagi peningkatan kualitas pelayanan publik Provinsi Kalimantan Selatan.</p>

                @if(session('success_survey'))
                    <div class="alert alert-success">
                        <i class="bi bi-heart-fill"></i> {{ session('success_survey') }}
                    </div>
                @endif
            </div>

            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <form action="{{ route('survey.store') }}" method="POST">
                            @csrf
                            <label class="form-label fw-bold">Berikan Penilaian Anda:</label>

                            <div class="d-flex flex-column gap-2 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="rating" value="5" id="puas5" required>
                                    <label class="form-check-label" for="puas5">⭐⭐⭐⭐⭐ Sangat Puas</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="rating" value="4" id="puas4">
                                    <label class="form-check-label" for="puas4">⭐⭐⭐⭐ Puas</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="rating" value="3" id="puas3">
                                    <label class="form-check-label" for="puas3">⭐⭐⭐ Cukup</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="rating" value="2" id="puas2">
                                    <label class="form-check-label" for="puas2">⭐⭐ Kurang Puas</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="rating" value="1" id="puas1">
                                    <label class="form-check-label" for="puas1">⭐ Tidak Puas</label>
                                </div>
                            </div>

                            <div class="mb-3">
                                <input type="text" name="feedback" class="form-control" placeholder="Saran/Masukan (Opsional)">
                            </div>

                            <button type="submit" class="btn btn-success w-100 rounded-pill">Kirim Penilaian</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
