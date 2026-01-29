@extends('layouts.admin')

@section('content')
{{--
    KONSISTEN DENGAN DESAIN SEBELUMNYA:
    - Scroll body normal (overflow-y: auto).
    - Background light dengan kartu putih bersih.
--}}
<div class="container-fluid p-4" style="background-color: #f8fafc; min-height: 100vh;">

    {{-- 1. HEADER HALAMAN --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 pb-3 border-bottom border-secondary border-opacity-10">
        <div>
            <h4 class="fw-bold text-dark mb-1">Upload Dokumen Baru</h4>
            <p class="text-muted small mb-0">Tambahkan berkas PDF baru ke dalam sistem Inventaris Dokumen Publik.</p>
        </div>
        <div class="mt-3 mt-md-0">
            <a href="{{ route('documents.index') }}" class="btn btn-light btn-sm rounded-pill px-4 shadow-sm border fw-bold text-secondary hover-scale">
                <i class="bi bi-arrow-left me-2"></i>Kembali ke Daftar
            </a>
        </div>
    </div>

    {{-- 2. FORM UTAMA --}}
    <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row g-4">

            {{-- KOLOM KIRI: DETAIL DOKUMEN --}}
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden mb-4">
                    <div class="card-header bg-white py-3 px-4 border-bottom">
                        <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-file-earmark-text me-2 text-primary"></i>Informasi Dokumen</h6>
                    </div>
                    <div class="card-body p-4">

                        {{-- Alert Error --}}
                        @if ($errors->any())
                            <div class="alert alert-danger border-0 rounded-3 mb-4 small bg-danger bg-opacity-10 py-2">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i> Mohon periksa kembali inputan Anda.
                            </div>
                        @endif

                        {{-- Judul Dokumen --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-uppercase text-muted ls-1">Judul Dokumen <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control form-control-lg border-0 bg-light fw-bold text-dark shadow-none @error('title') is-invalid @enderror"
                                   placeholder="Contoh: Laporan Keuangan Tahunan 2025" value="{{ old('title') }}" required autofocus style="font-size: 1.1rem;">
                            @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Deskripsi --}}
                        <div class="mb-0">
                            <label class="form-label fw-bold small text-uppercase text-muted ls-1 mb-2">Deskripsi / Keterangan Singkat</label>
                            <textarea name="description" rows="5" class="form-control border-0 bg-light shadow-none"
                                      placeholder="Jelaskan secara singkat isi atau maksud dari dokumen ini...">{{ old('description') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            {{-- KOLOM KANAN: KATEGORI & BERKAS --}}
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden mb-4">
                    <div class="card-header bg-white py-3 px-4 border-bottom text-primary fw-bold">
                        <i class="bi bi-upload me-2"></i>Upload & Kategori
                    </div>
                    <div class="card-body p-4">

                        {{-- Kategori --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-muted text-uppercase">Kategori Informasi</label>
                            <select name="category" class="form-select border-0 bg-light shadow-none py-2 rounded-3 fw-medium @error('category') is-invalid @enderror" required>
                                <option value="" selected disabled>Pilih Kategori...</option>
                                <option value="berkala" {{ old('category') == 'berkala' ? 'selected' : '' }}>Informasi Berkala</option>
                                <option value="serta-merta" {{ old('category') == 'serta-merta' ? 'selected' : '' }}>Informasi Serta Merta</option>
                                <option value="setiap-saat" {{ old('category') == 'setiap-saat' ? 'selected' : '' }}>Informasi Setiap Saat</option>
                                <option value="dikecualikan" {{ old('category') == 'dikecualikan' ? 'selected' : '' }}>Informasi Dikecualikan</option>
                                <option value="sop-ppid" {{ old('category') == 'sop-ppid' ? 'selected' : '' }}>SOP Layanan</option>
                                <option value="lainnya" {{ old('category') == 'lainnya' ? 'selected' : '' }}>Lainnya / Umum</option>
                            </select>
                            @error('category') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- File Upload --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-muted text-uppercase">Berkas Dokumen (PDF)</label>
                            <div class="p-4 bg-light rounded-4 border border-dashed text-center">
                                <i class="bi bi-file-pdf-fill fs-1 text-danger opacity-25 mb-3 d-block"></i>
                                <input type="file" name="file_path" class="form-control form-control-sm bg-white shadow-none @error('file_path') is-invalid @enderror" accept=".pdf" required>
                                <small class="text-muted mt-2 d-block" style="font-size: 0.65rem;">Hanya file PDF. Ukuran maksimal: 10MB.</small>
                            </div>
                            @error('file_path') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <hr class="my-4 opacity-10">

                        {{-- TOMBOL AKSI --}}
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary fw-bold rounded-pill shadow-sm py-2 px-4 hover-scale">
                                <i class="bi bi-cloud-arrow-up-fill me-2"></i> Simpan & Publikasi
                            </button>
                            <a href="{{ route('documents.index') }}" class="btn btn-light border rounded-pill fw-bold py-2 text-muted">
                                Batal
                            </a>
                        </div>
                    </div>
                </div>

                {{-- INFO BOX --}}
                <div class="p-3 bg-primary bg-opacity-10 rounded-4 border-0">
                    <div class="d-flex">
                        <i class="bi bi-info-circle-fill text-primary me-2"></i>
                        <small class="text-dark lh-sm">Dokumen yang diunggah akan langsung tersedia di halaman publik sesuai dengan kategori yang dipilih.</small>
                    </div>
                </div>
            </div>

        </div>
    </form>
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

    /* Border Dashed untuk Upload */
    .border-dashed { border-style: dashed !important; border-width: 2px !important; border-color: #dee2e6 !important; }

    /* Hover Scale Effect */
    .hover-scale { transition: transform 0.2s; }
    .hover-scale:hover { transform: translateY(-2px); }

    .ls-1 { letter-spacing: 0.5px; }

    /* Tombol Utama */
    .btn-primary { background-color: #0d6efd; border: none; }
    .btn-primary:hover { background-color: #0b5ed7; }
</style>
@endsection
