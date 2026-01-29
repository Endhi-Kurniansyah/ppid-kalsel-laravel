@extends('layouts.admin')

@section('content')
{{--
    CONTAINER UTAMA:
    - height: calc(100vh - 80px) -> Pas layar
    - overflow: hidden -> Mencegah scroll body browser
--}}
<div class="container-fluid d-flex flex-column p-4" style="height: calc(100vh - 80px); background-color: #f8fafc; overflow: hidden;">

    {{-- 1. HEADER & ACTIONS --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-end mb-3 flex-shrink-0">
        <div>
            <h4 class="fw-bold text-dark mb-1">Inventaris Dokumen</h4>
            <p class="text-muted small mb-0">Manajemen klasifikasi informasi sesuai standar layanan PPID.</p>
        </div>

        <div class="d-flex flex-wrap gap-2 mt-3 mt-md-0 align-items-center">
            {{-- FORM FILTER (COMPACT) --}}
            <form action="{{ route('documents.index') }}" method="GET" class="d-flex gap-1">
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

                <button type="submit" class="btn btn-white btn-sm rounded-pill px-3 fw-bold shadow-sm d-flex align-items-center gap-2 border hover-scale" style="font-size: 0.75rem;">
                    <i class="bi bi-funnel"></i> Filter
                </button>
            </form>

            <div class="vr mx-1 opacity-10 d-none d-md-block"></div>

            {{-- CETAK LAPORAN --}}
            <a href="{{ route('admin.reports.documents', request()->all()) }}" target="_blank" class="btn btn-danger btn-sm rounded-pill px-3 fw-bold d-flex align-items-center gap-2 hover-scale shadow-sm" style="font-size: 0.75rem;">
                <i class="bi bi-printer-fill"></i> Cetak Laporan
            </a>

            {{-- TAMBAH DOKUMEN --}}
            <a href="{{ route('documents.create') }}" class="btn btn-primary btn-sm rounded-pill px-3 fw-bold shadow-sm d-flex align-items-center gap-2 hover-scale" style="font-size: 0.75rem; background-color: #0d6efd;">
                <i class="bi bi-plus-lg"></i> Upload
            </a>
        </div>
    </div>

    {{-- 2. ALERT SUCCESS (COMPACT) --}}
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
            <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-file-earmark-pdf-fill me-2 text-primary"></i>Daftar Dokumen Publik</h6>
            <span class="badge bg-light text-primary border rounded-pill fw-normal px-3">Total: {{ $documents->total() }}</span>
        </div>

        {{-- Body Tabel (Scrollable Area) --}}
        <div class="card-body p-0 overflow-auto custom-scrollbar position-relative">
            <table class="table table-hover align-middle mb-0 w-100 text-nowrap">
                <thead class="bg-light text-secondary sticky-top" style="z-index: 5;">
                    <tr class="text-muted small text-uppercase fw-bold">
                        <th class="ps-4 py-3 border-0 bg-light">Judul Dokumen</th>
                        <th class="py-3 border-0 bg-light">Kategori</th>
                        <th class="py-3 border-0 bg-light text-center">Tgl Upload</th>
                        <th class="py-3 border-0 bg-light text-center">Preview</th>
                        <th class="py-3 border-0 text-end pe-4 bg-light">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($documents as $doc)
                    <tr>
                        <td class="ps-4">
                            <div class="fw-bold text-dark mb-0" style="font-size: 0.85rem;">{{ Str::limit($doc->title, 60) }}</div>
                            <small class="text-muted" style="font-size: 0.7rem;">
                                <i class="bi bi-person-circle me-1 text-primary"></i> Administrator PPID
                            </small>
                        </td>
                        <td>
                            @php
                                $categoryConfig = [
                                    'sop' => ['label' => 'SOP LAYANAN', 'class' => 'bg-info bg-opacity-10 text-info border-info'],
                                    'berkala' => ['label' => 'BERKALA', 'class' => 'bg-primary bg-opacity-10 text-primary border-primary'],
                                    'sertamerta' => ['label' => 'SERTA MERTA', 'class' => 'bg-warning bg-opacity-10 text-warning border-warning'],
                                    'setiapsaat' => ['label' => 'SETIAP SAAT', 'class' => 'bg-success bg-opacity-10 text-success border-success'],
                                ];
                                $config = $categoryConfig[$doc->category] ?? ['label' => strtoupper($doc->category), 'class' => 'bg-secondary bg-opacity-10 text-secondary border-secondary'];
                            @endphp
                            <span class="badge {{ $config['class'] }} border rounded-pill px-3 py-1 fw-bold" style="font-size: 0.65rem; letter-spacing: 0.5px;">
                                {{ $config['label'] }}
                            </span>
                        </td>
                        <td class="text-center">
                            <div class="small text-muted font-monospace" style="font-size: 0.75rem;">
                                <i class="bi bi-calendar-check me-1"></i>{{ $doc->created_at->format('d M Y') }}
                            </div>
                        </td>
                        <td class="text-center">
                            <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="btn btn-sm btn-light border rounded-pill px-3 fw-bold text-primary hover-bg-light" style="font-size: 0.7rem;">
                                <i class="bi bi-eye-fill me-1"></i> LIHAT
                            </a>
                        </td>
                        <td class="text-end pe-4">
                            <div class="d-flex justify-content-end gap-2">
                                {{-- EDIT --}}
                                <a href="{{ route('documents.edit', $doc->id) }}" class="btn btn-sm btn-outline-warning rounded-circle d-flex align-items-center justify-content-center hover-scale" style="width: 32px; height: 32px;" title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                {{-- HAPUS --}}
                                <form action="{{ route('documents.destroy', $doc->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus dokumen ini?')">
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
                        <td colspan="5" class="text-center py-5">
                            <div class="opacity-25 mb-3"><i class="bi bi-folder2-open display-4"></i></div>
                            <p class="text-muted small mb-0">Belum ada dokumen yang diunggah.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Footer Tabel / Pagination (Fixed) --}}
        @if($documents->hasPages())
        <div class="card-footer bg-white border-top py-2 px-4 flex-shrink-0">
            <div class="d-flex justify-content-between align-items-center">
                <small class="text-muted font-monospace" style="font-size: 0.7rem;">
                    Data {{ $documents->firstItem() }}-{{ $documents->lastItem() }} dari {{ $documents->total() }}
                </small>
                <div class="pagination-sm">
                    {{ $documents->appends(request()->all())->links('pagination::bootstrap-5') }}
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
