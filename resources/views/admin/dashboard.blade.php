@extends('layouts.admin')

@section('content')
{{--
    CONTAINER UTAMA:
    - Tidak ada fixed height (h-auto)
    - Scroll body diaktifkan kembali (default)
--}}
<div class="container-fluid p-4" style="background-color: #f8fafc; min-height: 100vh;">

    {{-- 1. HEADER --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 pb-3 border-bottom border-secondary border-opacity-10">
        <div>
            <h4 class="fw-bold text-dark mb-1">Dashboard Overview</h4>
            <p class="text-muted small mb-0">
                Selamat datang kembali, <span class="text-primary fw-bold">{{ auth()->user()->name }}</span>!
            </p>
        </div>

        <div class="mt-3 mt-md-0 d-flex gap-2 align-items-center">
            {{-- Tanggal --}}
            <div class="bg-white border rounded-pill px-3 py-2 shadow-sm d-none d-md-block">
                <small class="fw-bold text-secondary font-monospace">
                    <i class="bi bi-calendar-check me-2 text-success"></i>{{ date('d F Y') }}
                </small>
            </div>

            {{-- Form Cetak --}}
            <form action="{{ route('admin.reports.statistics') }}" method="GET" target="_blank" class="d-flex gap-2">
                <select name="year" class="form-select form-select-sm shadow-sm border-0 fw-bold text-center bg-white" style="width: 80px; height: 38px; border-radius: 20px;">
                    @foreach(range(date('Y'), 2020) as $y)
                        <option value="{{ $y }}" {{ date('Y') == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-dark btn-sm rounded-pill px-4 shadow-sm fw-bold d-flex align-items-center gap-2" style="height: 38px;">
                    <i class="bi bi-printer-fill"></i> Cetak
                </button>
            </form>
        </div>
    </div>

    {{-- 2. KARTU STATISTIK --}}
    <div class="row g-4 mb-4">
        {{-- Menunggu --}}
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100 rounded-4 bg-white stat-hover">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted fw-bold text-uppercase mb-1 small ls-1">Menunggu</p>
                        <h2 class="fw-bolder mb-0 text-warning">{{ $pendingRequests }}</h2>
                    </div>
                    <div class="icon-box bg-warning bg-opacity-10 text-warning rounded-circle shadow-sm">
                        <i class="bi bi-hourglass-split fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Total --}}
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100 rounded-4 bg-white stat-hover">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted fw-bold text-uppercase mb-1 small ls-1">Total Masuk</p>
                        <h2 class="fw-bolder mb-0 text-primary">{{ $totalRequests }}</h2>
                    </div>
                    <div class="icon-box bg-primary bg-opacity-10 text-primary rounded-circle shadow-sm">
                        <i class="bi bi-inbox-fill fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Berita --}}
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100 rounded-4 bg-white stat-hover">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted fw-bold text-uppercase mb-1 small ls-1">Berita</p>
                        <h2 class="fw-bolder mb-0 text-info">{{ $totalPosts }}</h2>
                    </div>
                    <div class="icon-box bg-info bg-opacity-10 text-info rounded-circle shadow-sm">
                        <i class="bi bi-newspaper fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Dokumen --}}
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100 rounded-4 bg-white stat-hover">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted fw-bold text-uppercase mb-1 small ls-1">Dokumen</p>
                        <h2 class="fw-bolder mb-0 text-success">{{ $totalDocs }}</h2>
                    </div>
                    <div class="icon-box bg-success bg-opacity-10 text-success rounded-circle shadow-sm">
                        <i class="bi bi-file-earmark-check-fill fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- 3. CONTENT AREA (TABEL & PANEL) --}}
    <div class="row g-4">

        {{-- KOLOM KIRI: TABEL --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white mb-4 h-100">
                <div class="card-header bg-white py-4 px-4 border-bottom d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-activity me-2 text-primary"></i>Permohonan Terbaru</h6>
                    <a href="{{ route('admin.requests.index') }}" class="btn btn-outline-primary btn-sm rounded-pill fw-bold px-3 hover-scale">Lihat Semua</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 text-nowrap w-100">
                            <thead class="bg-light text-secondary">
                                <tr>
                                    <th class="ps-4 py-3 small fw-bold border-0 bg-light text-muted text-uppercase">Tiket</th>
                                    <th class="py-3 small fw-bold border-0 bg-light text-muted text-uppercase">Pemohon</th>
                                    <th class="py-3 small fw-bold border-0 text-center bg-light text-muted text-uppercase">Status</th>
                                    <th class="py-3 small fw-bold border-0 text-end pe-4 bg-light text-muted text-uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($latestRequests as $req)
                                <tr>
                                    <td class="ps-4">
                                        <span class="badge bg-light text-dark border font-monospace px-3 py-2">{{ $req->ticket_number }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="fw-bold text-dark">{{ Str::limit($req->name, 25) }}</span>
                                            <small class="text-muted" style="font-size: 0.75rem;">{{ $req->created_at->diffForHumans() }}</small>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        @php
                                            $statusClass = match($req->status) {
                                                'pending' => 'bg-warning text-dark',
                                                'processed' => 'bg-info text-white',
                                                'finished' => 'bg-success text-white',
                                                'rejected' => 'bg-danger text-white',
                                                default => 'bg-secondary text-white',
                                            };
                                            $statusLabel = match($req->status) {
                                                'pending' => 'Menunggu',
                                                'processed' => 'Diproses',
                                                'finished' => 'Selesai',
                                                'rejected' => 'Ditolak',
                                                default => '-',
                                            };
                                        @endphp
                                        <span class="badge {{ $statusClass }} rounded-pill px-3 py-2 fw-normal">{{ $statusLabel }}</span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <a href="{{ route('admin.requests.show', $req->id) }}" class="btn btn-sm btn-light border rounded-circle shadow-sm p-0 d-inline-flex align-items-center justify-content-center hover-scale" style="width: 35px; height: 35px;">
                                            <i class="bi bi-chevron-right text-secondary"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted">
                                        <div class="opacity-25 mb-2"><i class="bi bi-inbox fs-1"></i></div>
                                        <span class="small">Belum ada data permohonan baru.</span>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- KOLOM KANAN: PANEL INFO --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden text-white mb-4 h-100" style="background-color: #0f172a; min-height: 400px;">
                <div class="card-body p-4 d-flex flex-column">

                    {{-- Dekorasi --}}
                    <div class="position-absolute top-0 end-0 p-3 opacity-10">
                        <i class="bi bi-shield-check" style="font-size: 8rem;"></i>
                    </div>

                    <h5 class="fw-bold mb-4 pb-3 border-bottom border-secondary border-opacity-25 small text-uppercase ls-1">
                        <i class="bi bi-grid-fill me-2 text-warning"></i>Admin Tools
                    </h5>

                    {{-- User Profile --}}
                    <div class="d-flex align-items-center bg-white bg-opacity-10 p-3 rounded-4 mb-4 position-relative z-2">
                        <div class="bg-warning text-dark fw-bold rounded-circle me-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 50px; height: 50px; font-size: 1.2rem;">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                        <div class="overflow-hidden">
                            <h6 class="mb-1 fw-bold text-white text-truncate">{{ auth()->user()->name }}</h6>
                            <small class="text-white-50 d-block text-truncate">{{ auth()->user()->email }}</small>
                        </div>
                    </div>

                    {{-- Shortcut Menu --}}
                    <div class="flex-grow-1 position-relative z-2">
                        <small class="text-white-50 fw-bold ls-1 d-block mb-3" style="font-size: 0.75rem;">AKSES CEPAT</small>
                        <div class="d-grid gap-2">
                            @if(Route::has('admin.posts.create'))
                                <a href="{{ route('admin.posts.create') }}" class="btn btn-outline-light text-start border-0 bg-white bg-opacity-5 hover-bg-opacity-10 py-3 rounded-3">
                                    <i class="bi bi-pencil-square me-3 text-warning"></i> Tulis Berita Baru
                                </a>
                            @endif

                            @if(Route::has('admin.documents.create'))
                                <a href="{{ route('admin.documents.create') }}" class="btn btn-outline-light text-start border-0 bg-white bg-opacity-5 hover-bg-opacity-10 py-3 rounded-3">
                                    <i class="bi bi-cloud-upload me-3 text-success"></i> Upload Dokumen
                                </a>
                            @endif
                        </div>
                    </div>

                    {{-- Logout --}}
                    <div class="mt-auto pt-4 border-top border-secondary border-opacity-25 position-relative z-2">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger w-100 fw-bold rounded-pill shadow-sm hover-scale py-2">
                                <i class="bi bi-box-arrow-right me-2"></i> Keluar Aplikasi
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

{{-- CSS KHUSUS --}}
<style>
    /* Kembalikan scroll body default */
    body { overflow-y: auto !important; background-color: #f8fafc; }

    .icon-box {
        width: 50px; height: 50px;
        display: flex; align-items: center; justify-content: center;
    }

    .ls-1 { letter-spacing: 0.5px; }
    .stat-hover:hover { transform: translateY(-5px); transition: 0.3s; box-shadow: 0 10px 20px rgba(0,0,0,0.08)!important; }
    .hover-scale:hover { transform: scale(1.02); transition: 0.2s; }
</style>

@endsection
