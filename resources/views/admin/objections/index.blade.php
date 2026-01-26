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
            <h4 class="fw-bold text-dark mb-1">Pengajuan Keberatan</h4>
            <p class="text-muted small mb-0">Kelola dan tindak lanjuti pernyataan keberatan atas layanan informasi publik.</p>
        </div>

        <div class="d-flex flex-wrap gap-2 mt-3 mt-md-0 align-items-center">
            {{-- FORM FILTER (COMPACT) --}}
            <form action="{{ route('admin.objections.index') }}" method="GET" class="d-flex gap-1">
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

                <button type="submit" class="btn btn-dark btn-sm rounded-circle shadow-sm d-flex align-items-center justify-content-center hover-scale" style="width: 32px; height: 32px; border: none; background-color: #0f172a;">
                    <i class="bi bi-funnel-fill" style="font-size: 0.8rem;"></i>
                </button>
            </form>

            <div class="vr mx-1 opacity-10 d-none d-md-block"></div>

            {{-- CETAK LAPORAN --}}
            <a href="{{ route('admin.reports.objections', request()->all()) }}" target="_blank" class="btn btn-outline-danger btn-sm rounded-pill px-3 fw-bold d-flex align-items-center gap-2 hover-scale" style="font-size: 0.75rem;">
                <i class="bi bi-file-earmark-pdf"></i> Cetak Laporan
            </a>
        </div>
    </div>

    {{-- 2. TABLE CARD (SCROLLABLE INTERNAL) --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden flex-grow-1 d-flex flex-column bg-white">

        {{-- Header Tabel --}}
        <div class="card-header bg-white py-3 px-4 border-bottom d-flex justify-content-between align-items-center flex-shrink-0">
            <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-exclamation-triangle-fill me-2 text-danger"></i>Data Keberatan Masuk</h6>
            <span class="badge bg-light text-danger border rounded-pill fw-normal px-3">Total: {{ $objections->total() }} Entri</span>
        </div>

        {{-- Body Tabel (Scrollable Area) --}}
        <div class="card-body p-0 overflow-auto custom-scrollbar position-relative">
            <table class="table table-hover align-middle mb-0 w-100 text-nowrap">
                <thead class="bg-light text-secondary sticky-top" style="z-index: 5;">
                    <tr class="text-muted small text-uppercase fw-bold">
                        <th class="ps-4 py-3 border-0 bg-light">Kode Reg. & Tgl</th>
                        <th class="py-3 border-0 bg-light">Tiket & Pemohon</th>
                        <th class="py-3 border-0 bg-light">Alasan Keberatan</th>
                        <th class="py-3 border-0 bg-light">Status</th>
                        <th class="py-3 border-0 text-end pe-4 bg-light">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($objections as $obj)
                    <tr>
                        <td class="ps-4">
                            <div class="fw-bold text-danger mb-0" style="font-size: 0.85rem;">{{ $obj->objection_code }}</div>
                            <small class="text-muted" style="font-size: 0.7rem;">
                                <i class="bi bi-calendar-event me-1"></i>{{ $obj->created_at->format('d/m/Y') }}
                            </small>
                        </td>
                        <td>
                            <div class="fw-bold text-dark mb-0" style="font-size: 0.8rem;">{{ $obj->request->ticket_number ?? 'N/A' }}</div>
                            <small class="text-muted" style="font-size: 0.7rem;">
                                <i class="bi bi-person-circle me-1 text-primary"></i>{{ $obj->request->name ?? 'N/A' }}
                            </small>
                        </td>
                        <td>
                            <div class="text-muted small text-truncate" style="max-width: 250px;" title="{{ $obj->reason }}">
                                {{ Str::limit($obj->reason, 50) }}
                            </div>
                        </td>
                        <td>
                            @php
                                $statusConfig = [
                                    'pending'   => ['label' => 'Menunggu', 'class' => 'bg-warning bg-opacity-10 text-dark border-warning'],
                                    'processed' => ['label' => 'Diproses', 'class' => 'bg-info bg-opacity-10 text-info border-info'],
                                    'finished'  => ['label' => 'Selesai', 'class' => 'bg-success bg-opacity-10 text-success border-success'],
                                    'rejected'  => ['label' => 'Ditolak', 'class' => 'bg-danger bg-opacity-10 text-danger border-danger']
                                ];
                                $status = $statusConfig[$obj->status] ?? ['label' => 'N/A', 'class' => 'bg-secondary bg-opacity-10 text-secondary border-secondary'];
                            @endphp
                            <span class="badge {{ $status['class'] }} border rounded-pill px-3 py-1 fw-bold" style="font-size: 0.65rem; letter-spacing: 0.5px;">
                                {{ strtoupper($status['label']) }}
                            </span>
                        </td>
                        <td class="text-end pe-4">
                            <a href="{{ route('admin.objections.show', $obj->id) }}" class="btn btn-sm btn-light border rounded-pill px-3 fw-bold text-danger hover-danger" style="font-size: 0.7rem;">
                                TINDAK LANJUT <i class="bi bi-chevron-right ms-1"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <div class="opacity-25 mb-3"><i class="bi bi-exclamation-diamond display-4"></i></div>
                            <p class="text-muted small mb-0">Belum ada pengajuan keberatan informasi.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Footer Tabel / Pagination --}}
        @if($objections->hasPages())
        <div class="card-footer bg-white border-top py-2 px-4 flex-shrink-0">
            <div class="d-flex justify-content-between align-items-center">
                <small class="text-muted font-monospace" style="font-size: 0.7rem;">
                    Data {{ $objections->firstItem() }}-{{ $objections->lastItem() }} dari {{ $objections->total() }}
                </small>
                <div class="pagination-sm">
                    {{ $objections->appends(request()->all())->links('pagination::bootstrap-5') }}
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
    .hover-scale:hover { transform: scale(1.05); }

    .hover-danger:hover {
        background-color: #dc3545 !important;
        color: white !important;
        border-color: #dc3545 !important;
    }

    /* Pagination Styling Compact */
    .pagination { margin-bottom: 0; gap: 2px; }
    .page-link { padding: 0.25rem 0.6rem; font-size: 0.75rem; border-radius: 6px !important; border: none; color: #64748b; }
    .page-item.active .page-link { background-color: #dc3545; color: white; border: none; }
</style>

@endsection
