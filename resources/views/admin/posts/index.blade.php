@extends('layouts.admin')

@section('content')
{{--
    CONTAINER UTAMA:
    - height: calc(100vh - 80px) -> Pas layar
    - overflow: hidden -> Mencegah scroll body
--}}
<div class="container-fluid d-flex flex-column p-4" style="height: calc(100vh - 80px); background-color: #f8fafc; overflow: hidden;">

    {{-- 1. HEADER & ACTIONS --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-end mb-3 flex-shrink-0">
        <div>
            <h4 class="fw-bold text-dark mb-1">Manajemen Berita</h4>
            <p class="text-muted small mb-0">Publikasikan kegiatan dan informasi terbaru instansi.</p>
        </div>

        <div class="d-flex flex-wrap gap-2 mt-3 mt-md-0 align-items-center">
            {{-- FORM FILTER (COMPACT) --}}
            <form action="{{ route('posts.index') }}" method="GET" class="d-flex gap-1">
                <select name="month" class="form-select form-select-sm shadow-sm border-0 fw-bold bg-white" style="width: 110px; border-radius: 20px; font-size: 0.75rem;">
                    <option value="">Bulan</option>
                    @foreach(range(1, 12) as $m)
                        <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>
                            {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                        </option>
                    @endforeach
                </select>

                <select name="year" class="form-select form-select-sm shadow-sm border-0 fw-bold bg-white text-center" style="width: 80px; border-radius: 20px; font-size: 0.75rem;">
                    <option value="">Tahun</option>
                    @foreach(range(date('Y'), 2020) as $y)
                        <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endforeach
                </select>

                <button type="submit" class="btn btn-primary btn-sm rounded-circle shadow-sm d-flex align-items-center justify-content-center hover-scale" style="width: 32px; height: 32px; background-color: #0f172a; border: none;">
                    <i class="bi bi-funnel-fill" style="font-size: 0.8rem;"></i>
                </button>
            </form>

            <div class="vr mx-1 opacity-10 d-none d-md-block"></div>

            {{-- CETAK LAPORAN --}}
            <a href="{{ route('admin.reports.news', request()->all()) }}" target="_blank" class="btn btn-outline-danger btn-sm rounded-pill px-3 fw-bold d-flex align-items-center gap-2 hover-scale" style="font-size: 0.75rem;">
                <i class="bi bi-file-earmark-pdf"></i> Laporan
            </a>

            {{-- TAMBAH BERITA --}}
            <a href="{{ route('posts.create') }}" class="btn btn-primary btn-sm rounded-pill px-3 fw-bold shadow-sm d-flex align-items-center gap-2 hover-scale" style="font-size: 0.75rem; background-color: #0d6efd;">
                <i class="bi bi-plus-lg"></i> Tulis Berita
            </a>
        </div>
    </div>

    {{-- 2. ALERT NOTIFIKASI (COMPACT) --}}
    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-3 mb-2 py-2 px-3 d-flex align-items-center bg-white border-start border-success border-4 flex-shrink-0">
            <i class="bi bi-check-circle-fill me-2 text-success"></i>
            <div class="text-dark fw-medium small">{{ session('success') }}</div>
            <button type="button" class="btn-close ms-auto small" data-bs-dismiss="alert" style="font-size: 0.5rem;"></button>
        </div>
    @endif

    {{-- 3. TABLE CARD (SCROLLABLE INTERNAL) --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden flex-grow-1 d-flex flex-column bg-white">

        {{-- Header Tabel --}}
        <div class="card-header bg-white py-3 px-4 border-bottom d-flex justify-content-between align-items-center flex-shrink-0">
            <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-newspaper me-2 text-primary"></i>Daftar Publikasi</h6>
            <span class="badge bg-light text-primary border rounded-pill fw-normal px-3">Total: {{ $posts->total() }}</span>
        </div>

        {{-- Body Tabel (Scrollable Area) --}}
        <div class="card-body p-0 overflow-auto custom-scrollbar position-relative">
            <table class="table table-hover align-middle mb-0 w-100 text-nowrap">
                <thead class="bg-light text-secondary sticky-top" style="z-index: 5;">
                    <tr class="text-muted small text-uppercase fw-bold">
                        <th class="ps-4 py-3 border-0 bg-light" width="5%">No</th>
                        <th class="py-3 border-0 bg-light" width="10%">Gambar</th>
                        <th class="py-3 border-0 bg-light" width="45%">Judul & Kontributor</th>
                        <th class="py-3 border-0 bg-light" width="15%">Kategori</th>
                        <th class="py-3 border-0 bg-light" width="10%">Statistik</th>
                        <th class="py-3 border-0 text-end pe-4 bg-light" width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($posts as $key => $post)
                    <tr>
                        <td class="ps-4 text-muted small font-monospace">{{ $posts->firstItem() + $key }}</td>
                        <td>
                            @if($post->image)
                                <img src="{{ asset('storage/' . $post->image) }}" class="rounded-3 shadow-sm border" style="width: 70px; height: 45px; object-fit: cover;">
                            @else
                                <div class="bg-light text-center rounded-3 text-muted border d-flex align-items-center justify-content-center" style="width: 70px; height: 45px;">
                                    <i class="bi bi-image fs-5 opacity-25"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <div class="fw-bold text-dark mb-0 lh-sm" style="font-size: 0.85rem;">{{ Str::limit($post->title, 60) }}</div>
                            <small class="text-muted d-flex align-items-center gap-2 mt-1" style="font-size: 0.7rem;">
                                <span class="d-flex align-items-center"><i class="bi bi-calendar3 me-1 text-primary"></i> {{ $post->created_at->format('d M Y') }}</span>
                                <span class="text-secondary opacity-25">|</span>
                                <span class="d-flex align-items-center"><i class="bi bi-person me-1 text-primary"></i> {{ $post->user->name ?? 'Admin' }}</span>
                            </small>
                        </td>
                        <td>
                            <span class="badge bg-info bg-opacity-10 text-info border border-info small rounded-pill px-3 py-1 fw-bold" style="font-size: 0.65rem; letter-spacing: 0.5px;">
                                {{ strtoupper($post->category->name ?? 'UMUM') }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center text-muted small">
                                <i class="bi bi-eye-fill me-2 text-secondary"></i>
                                <span class="fw-bold text-dark" style="font-size: 0.75rem;">{{ number_format($post->views) }}</span>
                            </div>
                        </td>
                        <td class="text-end pe-4">
                            <div class="d-flex justify-content-end gap-2">
                                {{-- EDIT --}}
                                <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-sm btn-outline-warning rounded-circle d-flex align-items-center justify-content-center hover-scale" style="width: 32px; height: 32px;" title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                {{-- HAPUS --}}
                                <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus berita ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger rounded-circle d-flex align-items-center justify-content-center hover-scale" style="width: 32px; height: 32px;" title="Hapus">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <div class="opacity-25 mb-3"><i class="bi bi-newspaper display-4"></i></div>
                            <p class="text-muted small mb-0">Belum ada berita yang diterbitkan.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Footer Tabel / Pagination (Fixed at bottom of card) --}}
        @if($posts->hasPages())
        <div class="card-footer bg-white border-top py-2 px-4 flex-shrink-0">
            <div class="d-flex justify-content-between align-items-center">
                <small class="text-muted font-monospace" style="font-size: 0.7rem;">
                    Data {{ $posts->firstItem() }}-{{ $posts->lastItem() }} dari {{ $posts->total() }}
                </small>
                <div class="pagination-sm">
                    {{ $posts->appends(request()->all())->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

{{-- CSS KHUSUS --}}
<style>
    /* Paksa Body Tidak Scroll */
    html, body { height: 100%; overflow: hidden !important; background-color: #f8fafc; }

    /* Scrollbar Halus */
    .custom-scrollbar::-webkit-scrollbar { width: 5px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

    /* Hover & Transitions */
    .hover-scale { transition: transform 0.2s ease; }
    .hover-scale:hover { transform: scale(1.1); }

    /* Pagination Styling Compact */
    .pagination { margin-bottom: 0; gap: 2px; }
    .page-link { padding: 0.25rem 0.6rem; font-size: 0.75rem; border-radius: 6px !important; border: none; color: #64748b; }
    .page-item.active .page-link { background-color: #0f172a; border: none; }
</style>

@endsection
