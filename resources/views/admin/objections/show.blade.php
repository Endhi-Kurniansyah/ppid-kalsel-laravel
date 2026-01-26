@extends('layouts.admin')

@section('content')
{{-- Scroll Normal agar konten kronologi yang panjang tidak terpotong --}}
<div class="container-fluid p-4" style="background-color: #f8fafc; min-height: 100vh;">

    {{-- 1. HEADER HALAMAN --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 pb-3 border-bottom border-secondary border-opacity-10">
        <div>
            <h4 class="fw-bold text-dark mb-1">Tindak Lanjut Keberatan</h4>
            <p class="text-muted small mb-0">Pemrosesan kode pengajuan: <span class="fw-bold text-danger">{{ $objection->objection_code }}</span></p>
        </div>
        <div class="mt-3 mt-md-0">
            <a href="{{ route('admin.objections.index') }}" class="btn btn-light btn-sm rounded-pill px-4 shadow-sm border fw-bold text-secondary hover-scale">
                <i class="bi bi-arrow-left me-2"></i>Kembali ke Daftar
            </a>
        </div>
    </div>

    <div class="row g-4">
        {{-- KOLOM KIRI: DETAIL DATA KEBERATAN --}}
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden mb-4">
                <div class="card-header bg-white py-3 px-4 border-bottom">
                    <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-info-circle me-2 text-danger"></i>Informasi Keberatan</h6>
                </div>
                <div class="card-body p-4">
                    <div class="mb-4">
                        <label class="small text-muted fw-bold text-uppercase ls-1 d-block mb-1">Alasan Keberatan</label>
                        <h5 class="fw-bold text-dark mb-0">{{ $objection->reason }}</h5>
                    </div>

                    <div class="mb-4">
                        <label class="small text-muted fw-bold text-uppercase ls-1 d-block mb-2">Kronologi (Kasus Posisi)</label>
                        <div class="p-3 bg-light rounded-3 text-dark border-0 lh-lg" style="font-size: 0.9rem;">
                            {!! nl2br(e($objection->description)) !!}
                        </div>
                    </div>

                    <hr class="my-4 opacity-10">

                    <h6 class="fw-bold text-dark mb-3"><i class="bi bi-ticket-perforated me-2 text-primary"></i>Data Permohonan Terkait</h6>
                    <div class="table-responsive">
                        <table class="table table-sm table-borderless align-middle mb-0">
                            <tr>
                                <td class="text-muted small text-uppercase fw-bold py-2" width="35%">No. Tiket Asal</td>
                                <td class="py-2 fw-bold text-primary">: {{ $objection->request->ticket_number }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted small text-uppercase fw-bold py-2">Nama Pemohon</td>
                                <td class="py-2 fw-bold text-dark">: {{ $objection->request->name }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted small text-uppercase fw-bold py-2">Informasi Diminta</td>
                                <td class="py-2 text-muted small">: {{ $objection->request->details }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted small text-uppercase fw-bold py-2">Status Permohonan</td>
                                <td class="py-2">:
                                    <span class="badge bg-light text-secondary border rounded-pill px-3 fw-medium" style="font-size: 0.7rem;">
                                        {{ strtoupper($objection->request->status) }}
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- KOLOM KANAN: FORM KEPUTUSAN --}}
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden mb-4">
                <div class="card-header bg-white py-3 px-4 border-bottom text-primary fw-bold">
                    <i class="bi bi-check2-circle me-2"></i>Keputusan Atasan PPID
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.objections.update', $objection->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label class="form-label fw-bold small text-muted text-uppercase ls-1">Pilih Status Keputusan</label>
                            <select name="status" class="form-select border-0 bg-light shadow-none py-2 rounded-3 fw-medium" required>
                                <option value="pending" {{ $objection->status == 'pending' ? 'selected' : '' }}>Menunggu (Pending)</option>
                                <option value="processed" {{ $objection->status == 'processed' ? 'selected' : '' }}>Sedang Diproses</option>
                                <option value="finished" {{ $objection->status == 'finished' ? 'selected' : '' }}>Keberatan Diterima (Selesai)</option>
                                <option value="rejected" {{ $objection->status == 'rejected' ? 'selected' : '' }}>Keberatan Ditolak</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold small text-muted text-uppercase ls-1">Tanggapan Resmi (Admin Note)</label>
                            <textarea name="admin_note" class="form-control border-0 bg-light shadow-none py-2 px-3" rows="8"
                                      placeholder="Ketikkan alasan atau instruksi lanjutan di sini..." required>{{ $objection->admin_note }}</textarea>
                            <div class="form-text mt-2 text-muted" style="font-size: 0.7rem;">
                                <i class="bi bi-info-circle me-1"></i> Tanggapan ini akan dapat dilihat oleh pemohon pada cek status.
                            </div>
                        </div>

                        <hr class="my-4 opacity-10">

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary fw-bold rounded-pill shadow-sm py-2 px-4 hover-scale">
                                <i class="bi bi-send-fill me-2"></i> Simpan & Kirim Keputusan
                            </button>
                            <a href="{{ route('admin.objections.index') }}" class="btn btn-light border rounded-pill fw-bold py-2 text-muted">
                                Batalkan
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            {{-- INFO TEKNIS --}}
            <div class="p-4 bg-white shadow-sm rounded-4 border-0 mb-4">
                <div class="d-flex align-items-center">
                    <div class="p-3 bg-light rounded-circle me-3 text-primary">
                        <i class="bi bi-shield-lock-fill fs-4"></i>
                    </div>
                    <div>
                        <label class="small text-muted text-uppercase fw-bold d-block mb-0" style="font-size: 0.6rem;">Waktu Masuk Sistem</label>
                        <span class="text-dark fw-bold small">{{ $objection->created_at->format('d F Y, H:i') }} WITA</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Styling Body */
    body { background-color: #f8fafc; overflow-y: auto !important; }

    /* Fokus Input */
    .form-control:focus, .form-select:focus {
        background-color: #fff !important;
        border: 1px solid #0d6efd !important;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.05);
    }

    /* Hover Effect */
    .hover-scale { transition: transform 0.2s; }
    .hover-scale:hover { transform: translateY(-2px); }

    .ls-1 { letter-spacing: 0.5px; }

    /* Tombol Utama */
    .btn-primary { background-color: #0d6efd; border: none; }
    .btn-primary:hover { background-color: #0b5ed7; }
</style>
@endsection
