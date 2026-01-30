@extends('layouts.admin')

@section('content')
{{--
    CONTAINER UTAMA:
    - height: calc(100vh - 80px) -> Pas layar
    - overflow: hidden -> Mencegah scroll body browser
--}}
<div class="container-fluid d-flex flex-column p-4" style="height: calc(100vh - 80px); background-color: #f8fafc; overflow: hidden;">

    {{-- 1. HEADER HALAMAN --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-3 flex-shrink-0">
        <div>
            <h4 class="fw-bold text-dark mb-1">Manajemen Halaman</h4>
            <p class="text-muted small mb-0">Kelola konten statis (Profil, Visi Misi, dll) pada portal publik.</p>
        </div>
        <div class="mt-3 mt-md-0">
            <a href="{{ route('pages.create') }}" class="btn btn-primary btn-sm rounded-pill px-4 shadow-sm fw-bold d-flex align-items-center gap-2 hover-scale" style="background-color: #0d6efd;">
                <i class="bi bi-plus-lg"></i> Tambah Halaman
            </a>
        </div>
    </div>

    {{-- 2. NOTIFIKASI (COMPACT) --}}
    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-3 mb-2 py-2 px-3 d-flex align-items-center bg-white border-start border-success border-4 flex-shrink-0">
            <i class="bi bi-check-circle-fill me-2 text-success"></i>
            <div class="text-dark fw-medium small">{{ session('success') }}</div>
            <button type="button" class="btn-close ms-auto small" data-bs-dismiss="alert" style="font-size: 0.5rem;"></button>
        </div>
    @endif

    {{-- 3. TABEL DATA (MENGISI SISA LAYAR & SCROLLABLE INTERNAL) --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden flex-grow-1 d-flex flex-column bg-white">

        {{-- Header Card --}}
        <div class="card-header bg-white py-3 px-4 border-bottom d-flex justify-content-between align-items-center flex-shrink-0">
            <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-files me-2 text-primary"></i>Daftar Halaman</h6>
            <span class="badge bg-light text-primary border rounded-pill fw-normal px-3">Total: {{ $pages->count() }}</span>
        </div>

        {{-- Body Card (Scrollable Area) --}}
        <div class="card-body p-0 overflow-auto custom-scrollbar position-relative">
            <table class="table table-hover align-middle mb-0 w-100 text-nowrap">
                <thead class="bg-light text-secondary sticky-top" style="z-index: 5;">
                    <tr class="text-muted small text-uppercase fw-bold">
                        <th class="ps-4 py-3 border-0 bg-light">Judul Halaman</th>
                        <th class="py-3 border-0 bg-light">Tipe & Status</th>
                        <th class="py-3 border-0 bg-light">Link (Slug)</th>
                        <th class="py-3 border-0 bg-light">Update Terakhir</th>
                        <th class="py-3 border-0 text-end pe-4 bg-light">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pages as $page)
                    <tr>
                        <td class="ps-4">
                            <div class="fw-bold text-dark mb-0" style="font-size: 0.85rem;">{{ Str::limit($page->title, 50) }}</div>
                            <small class="text-muted font-monospace" style="font-size: 10px;">ID: #PG-{{ str_pad($page->id, 3, '0', STR_PAD_LEFT) }}</small>
                        </td>

                        <td>
                            <div class="d-flex flex-column gap-1 align-items-start">
                                {{-- Label Tipe --}}
                                @if($page->is_static)
                                    <span class="badge bg-primary bg-opacity-10 text-primary border border-primary small rounded-pill px-2" style="font-size: 0.65rem; letter-spacing: 0.5px;">
                                        <i class="bi bi-shield-lock me-1"></i>UTAMA
                                    </span>
                                @else
                                    <span class="badge bg-info bg-opacity-10 text-info border border-info small rounded-pill px-2" style="font-size: 0.65rem; letter-spacing: 0.5px;">TAMBAHAN</span>
                                @endif

                                {{-- Label Kunci --}}
                                @if($page->is_locked)
                                    <span class="badge bg-danger bg-opacity-10 text-danger border border-danger small rounded-pill px-2" style="font-size: 0.65rem; letter-spacing: 0.5px;">
                                        <i class="bi bi-lock-fill me-1"></i>TERKUNCI
                                    </span>
                                @endif
                            </div>
                        </td>

                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <code class="small text-primary bg-light px-2 py-1 rounded border" style="font-size: 0.7rem;">/page/{{ Str::limit($page->slug, 20) }}</code>
                                <a href="{{ route('public.page', $page->slug) }}" target="_blank" class="btn btn-sm btn-light border rounded-circle d-flex align-items-center justify-content-center text-secondary hover-bg-light" style="width: 24px; height: 24px;" title="Lihat di Web">
                                    <i class="bi bi-box-arrow-up-right" style="font-size: 0.7rem;"></i>
                                </a>
                            </div>
                        </td>

                        <td class="text-muted small">
                            <i class="bi bi-clock-history me-1 text-primary"></i>{{ $page->updated_at->format('d M Y, H:i') }}
                        </td>

                        <td class="text-end pe-4">
                            <div class="d-flex justify-content-end gap-2">

                                {{-- EDIT --}}
                                <a href="{{ route('pages.edit', $page->id) }}" class="btn btn-sm btn-outline-warning rounded-circle d-flex align-items-center justify-content-center hover-scale" style="width: 32px; height: 32px;" title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                {{-- HAPUS (KONDISIONAL) --}}
                                @if(!$page->is_locked || auth()->user()->role == 'super')
                                    @if($page->is_static == 0)
                                        <form action="{{ route('pages.destroy', $page->id) }}" method="POST" class="d-inline" onsubmit="return confirmDelete(event)">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger rounded-circle d-flex align-items-center justify-content-center hover-scale" style="width: 32px; height: 32px;" title="Hapus">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </form>
                                    @else
                                        <button class="btn btn-sm btn-light rounded-circle d-flex align-items-center justify-content-center text-muted border shadow-none" style="width: 32px; height: 32px; cursor: not-allowed;" title="Halaman Utama tidak bisa dihapus">
                                            <i class="bi bi-slash-circle"></i>
                                        </button>
                                    @endif
                                @else
                                    <button class="btn btn-sm btn-light rounded-circle d-flex align-items-center justify-content-center text-muted border shadow-none" style="width: 32px; height: 32px; cursor: not-allowed;" title="Terkunci">
                                        <i class="bi bi-lock-fill"></i>
                                    </button>
                                @endif

                                {{-- GEMBOK (SUPER ADMIN) --}}
                                @if(auth()->user()->role == 'super')
                                    <div class="vr mx-1 opacity-10"></div>
                                    <form action="{{ route('pages.toggle-lock', $page->id) }}" method="POST" class="d-inline">
                                        @csrf @method('PUT')
                                        <button class="btn btn-sm {{ $page->is_locked ? 'btn-outline-success' : 'btn-outline-dark' }} rounded-circle d-flex align-items-center justify-content-center hover-scale" style="width: 32px; height: 32px;" title="{{ $page->is_locked ? 'Buka Kunci' : 'Kunci Halaman' }}">
                                            <i class="bi {{ $page->is_locked ? 'bi-unlock-fill' : 'bi-lock-fill' }}"></i>
                                        </button>
                                    </form>
                                @endif

                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <div class="opacity-25 mb-3"><i class="bi bi-journal-x display-4"></i></div>
                            <p class="text-muted small mb-0">Belum ada halaman statis yang dibuat.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
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
    .hover-bg-light:hover { background-color: #e9ecef !important; color: #0d6efd !important; }
</style>

@endsection
