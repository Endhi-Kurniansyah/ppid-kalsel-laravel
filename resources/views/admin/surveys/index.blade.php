@extends('layouts.admin')

@section('content')
{{--
    CONTAINER UTAMA:
    - height: calc(100vh - 80px) -> Pas layar
    - overflow: hidden -> Mencegah scroll body browser
--}}
<div class="container-fluid d-flex flex-column p-4" style="height: calc(100vh - 80px); background-color: #f8fafc; overflow: hidden;">

    {{-- 1. HEADER HALAMAN --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-end mb-3 flex-shrink-0">
        <div>
            <h4 class="fw-bold text-dark mb-1">Indeks Kepuasan Masyarakat (IKM)</h4>
            <p class="text-muted small mb-0">Pantau statistik penilaian dan masukan layanan secara real-time.</p>
        </div>

        <div class="d-flex flex-wrap gap-2 mt-3 mt-md-0 align-items-center">
            {{-- FORM FILTER --}}
            <form action="{{ route('surveys.index') }}" method="GET" class="d-flex gap-1">
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
            <a href="{{ route('admin.reports.surveys', request()->all()) }}" target="_blank" class="btn btn-danger btn-sm rounded-pill px-3 fw-bold d-flex align-items-center gap-2 hover-scale shadow-sm" style="font-size: 0.75rem;">
                <i class="bi bi-printer-fill"></i> Cetak Laporan
            </a>
        </div>
    </div>

    {{-- 2. RINGKASAN STATISTIK (TANPA GARIS BAWAH & TANPA SHADOW ICON) --}}
    <div class="row g-3 mb-3 flex-shrink-0">
        {{-- CARD RATA-RATA KESELURUHAN --}}
        <div class="col-12 col-md-4 col-lg-2">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-gradient" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <div class="card-body text-center p-3 text-white">
                    <div class="mb-2">
                        <i class="bi bi-star-fill fs-2"></i>
                    </div>
                    <h3 class="fw-bold mb-0">{{ number_format($averageRating, 1) }}</h3>
                    <p class="small fw-bold mb-0 opacity-75" style="font-size: 0.6rem; text-transform: uppercase; letter-spacing: 0.5px;">RATA-RATA</p>
                    <p class="small mb-0 mt-1 opacity-75" style="font-size: 0.65rem;">{{ number_format($totalResponden) }} Responden</p>
                </div>
            </div>
        </div>

        @php
            $labels = [
                5 => ['teks' => 'Sangat Puas', 'color' => '#10b981', 'icon' => 'bi-emoji-heart-eyes'],
                4 => ['teks' => 'Puas', 'color' => '#3b82f6', 'icon' => 'bi-emoji-smile'],
                3 => ['teks' => 'Cukup', 'color' => '#f59e0b', 'icon' => 'bi-emoji-neutral'],
                2 => ['teks' => 'Kurang', 'color' => '#f97316', 'icon' => 'bi-emoji-frown'],
                1 => ['teks' => 'Buruk', 'color' => '#ef4444', 'icon' => 'bi-emoji-angry']
            ];
        @endphp

        @foreach($results as $res)
        @php $info = $labels[$res->rating] ?? ['teks' => 'Lainnya', 'color' => '#64748b', 'icon' => 'bi-star']; @endphp
        <div class="col-6 col-md-4 col-lg-2">
            {{-- shadow-none dan border-light untuk tampilan flat --}}
            <div class="card border border-light shadow-none rounded-4 h-100 bg-white overflow-hidden transition-up">
                <div class="card-body text-center p-3">
                    {{-- Style color langsung tanpa drop-shadow filter --}}
                    <div class="mb-2" style="color: {{ $info['color'] }};">
                        <i class="bi {{ $info['icon'] }} fs-2"></i>
                    </div>
                    <h4 class="fw-bold text-dark mb-0">{{ $res->total }}</h4>
                    <p class="text-muted small fw-bold mb-0" style="font-size: 0.6rem; text-transform: uppercase; letter-spacing: 0.5px;">{{ $info['teks'] }}</p>
                </div>
                {{-- GARIS WARNA DI BAWAH SUDAH DIHAPUS --}}
            </div>
        </div>
        @endforeach
    </div>

    {{-- 3. TABLE DETAIL (SCROLLABLE INTERNAL) --}}
    <div class="card border border-light shadow-none rounded-4 overflow-hidden flex-grow-1 d-flex flex-column bg-white">

        <div class="card-header bg-white py-3 px-4 border-bottom d-flex justify-content-between align-items-center flex-shrink-0">
            <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-chat-left-text me-2 text-primary"></i>Masukan Masyarakat</h6>
            <span class="badge bg-light text-primary border rounded-pill fw-normal px-3">Total Data: {{ $surveys->total() }}</span>
        </div>

        <div class="card-body p-0 overflow-auto custom-scrollbar position-relative">
            <table class="table table-hover align-middle mb-0 w-100 text-nowrap">
                <thead class="bg-light text-secondary sticky-top" style="z-index: 5;">
                    <tr class="text-muted small text-uppercase fw-bold">
                        <th class="ps-4 py-3 border-0 bg-light">Waktu</th>
                        <th class="py-3 border-0 bg-light">Penilaian</th>
                        <th class="py-3 border-0 bg-light" style="width: 50%;">Saran / Masukan</th>
                        <th class="py-3 border-0 text-end pe-4 bg-light">IP Address</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($surveys as $s)
                    <tr>
                        <td class="ps-4">
                            <div class="text-dark small fw-bold">{{ $s->created_at->format('d M Y') }}</div>
                            <small class="text-muted" style="font-size: 10px;">{{ $s->created_at->format('H:i') }} WIB</small>
                        </td>
                        <td>
                            @php
                                $ratingColor = $s->rating >= 5 ? '#10b981' : ($s->rating >= 4 ? '#3b82f6' : ($s->rating == 3 ? '#f59e0b' : '#ef4444'));
                            @endphp
                            <div class="d-flex align-items-center gap-1">
                                @for($i=1; $i<=5; $i++)
                                    <i class="bi bi-star{{ $i <= $s->rating ? '-fill' : '' }}" style="font-size: 0.65rem; color: {{ $i <= $s->rating ? $ratingColor : '#dee2e6' }}"></i>
                                @endfor
                                <span class="ms-1 small fw-bold text-dark" style="font-size: 0.7rem;">{{ $s->rating }}</span>
                            </div>
                        </td>
                        <td>
                            <div class="text-dark small text-wrap bg-light p-2 rounded-3 border-0" style="max-width: 450px; line-height: 1.4; font-size: 0.75rem;">
                                {{ $s->feedback ?? '--- Tidak ada komentar ---' }}
                            </div>
                        </td>
                        <td class="text-end pe-4">
                            <code class="small text-muted font-monospace" style="font-size: 0.7rem;">{{ $s->ip_address }}</code>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-5">
                            <div class="opacity-25 mb-3"><i class="bi bi-chat-square-x display-4"></i></div>
                            <p class="text-muted small mb-0">Belum ada data survei yang masuk.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($surveys->hasPages())
        <div class="card-footer bg-white border-top py-2 px-4 flex-shrink-0">
            <div class="d-flex justify-content-between align-items-center">
                <small class="text-muted font-monospace" style="font-size: 0.7rem;">
                    Data {{ $surveys->firstItem() }}-{{ $surveys->lastItem() }} dari {{ $surveys->total() }}
                </small>
                <div class="pagination-sm">
                    {{ $surveys->appends(request()->all())->links('pagination::bootstrap-5') }}
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

    /* Hover & Transitions */
    .transition-up { transition: transform 0.3s ease; }
    .transition-up:hover { transform: translateY(-5px); }
    .hover-scale { transition: transform 0.2s ease; }
    .hover-scale:hover { transform: scale(1.1); }

    /* Pagination Styling Compact */
    .pagination { margin-bottom: 0; gap: 2px; }
    .page-link { padding: 0.25rem 0.6rem; font-size: 0.75rem; border-radius: 6px !important; border: none; color: #64748b; }
    .page-item.active .page-link { background-color: #0f172a; color: white; border: none; }

    /* Fix table td content */
    .table td { white-space: normal !important; }
</style>

@endsection
