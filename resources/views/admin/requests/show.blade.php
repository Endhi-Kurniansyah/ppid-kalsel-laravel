@extends('layouts.admin')

@section('content')
{{-- Scroll Normal agar konten panjang seperti KTP tidak terpotong --}}
<div class="container-fluid p-4" style="background-color: #f8fafc; min-height: 100vh;">

    {{-- 1. HEADER HALAMAN --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 pb-3 border-bottom border-secondary border-opacity-10">
        <div>
            <h4 class="fw-bold text-dark mb-1">Proses Permohonan Informasi</h4>
            <p class="text-muted small mb-0">No. Tiket: <span class="fw-bold text-primary">{{ $req->ticket_number }}</span></p>
        </div>
        <div class="mt-3 mt-md-0">
            <a href="{{ route('admin.requests.index') }}" class="btn btn-light btn-sm rounded-pill px-4 shadow-sm border fw-bold text-secondary hover-scale">
                <i class="bi bi-arrow-left me-2"></i>Kembali ke Daftar
            </a>
        </div>
    </div>

    <div class="row g-4">
        {{-- KOLOM KIRI: DETAIL DATA --}}
        <div class="col-lg-8">

            {{-- DATA PEMOHON (PUTIH BERSIH) --}}
            <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden mb-4">
                <div class="card-header bg-white py-3 px-4 border-bottom">
                    <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-person-badge me-2 text-primary"></i>Identitas Pemohon</h6>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-sm table-borderless align-middle mb-0">
                            <tr>
                                <td class="text-muted small text-uppercase fw-bold py-2" width="30%">Nama Lengkap</td>
                                <td class="py-2 fw-bold text-dark">: {{ $req->name }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted small text-uppercase fw-bold py-2">NIK / Identitas</td>
                                <td class="py-2">: <span class="badge bg-light text-dark border px-2 fw-medium">{{ $req->nik }}</span></td>
                            </tr>
                            <tr>
                                <td class="text-muted small text-uppercase fw-bold py-2">Kontak</td>
                                <td class="py-2">: {{ $req->email }} <span class="mx-2 text-muted opacity-25">|</span> {{ $req->phone }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted small text-uppercase fw-bold py-2">Pekerjaan</td>
                                <td class="py-2">: {{ $req->job ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted small text-uppercase fw-bold py-2">Alamat</td>
                                <td class="py-2">: {{ $req->address }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            {{-- RINCIAN INFORMASI --}}
            <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden mb-4">
                <div class="card-header bg-white py-3 px-4 border-bottom">
                    <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-info-circle me-2 text-primary"></i>Rincian Permohonan</h6>
                </div>
                <div class="card-body p-4">
                    <div class="mb-4">
                        <label class="form-label small text-muted fw-bold text-uppercase ls-1">Informasi yang Diminta</label>
                        <div class="p-3 bg-light rounded-3 text-dark border-0 lh-lg" style="font-size: 0.9rem;">
                            {{ $req->details }}
                        </div>
                    </div>

                    <div class="mb-0">
                        <label class="form-label small text-muted fw-bold text-uppercase ls-1">Tujuan Penggunaan</label>
                        <div class="p-3 bg-light rounded-3 text-dark border-0 lh-lg" style="font-size: 0.9rem;">
                            {{ $req->purpose }}
                        </div>
                    </div>
                </div>
            </div>

            {{-- LAMPIRAN KTP --}}
            <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden mb-4">
                <div class="card-header bg-white py-3 px-4 border-bottom">
                    <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-image me-2 text-primary"></i>Lampiran KTP / Identitas</h6>
                </div>
                <div class="card-body p-4 text-center">
                    @if($req->ktp_file)
                        <div class="p-2 border rounded-4 bg-light d-inline-block">
                            <img src="{{ asset('storage/' . $req->ktp_file) }}" class="img-fluid rounded-3 shadow-sm" style="max-height: 500px;">
                        </div>
                    @else
                        <div class="py-5">
                            <i class="bi bi-file-earmark-excel display-4 text-muted opacity-25"></i>
                            <p class="text-danger mt-2 small fw-bold">Tidak ada lampiran KTP ditemukan.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- KOLOM KANAN: FORM TINDAKAN --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden mb-4">
                <div class="card-header bg-white py-3 px-4 border-bottom text-primary fw-bold">
                    <i class="bi bi-check2-circle me-2"></i>Keputusan / Tindak Lanjut
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.requests.update', $req->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- Update Status --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-muted text-uppercase ls-1">Pilih Status Keputusan</label>
                            <select name="status" class="form-select border-0 bg-light shadow-none py-2 rounded-3 fw-medium" required>
                                <option value="pending" {{ $req->status == 'pending' ? 'selected' : '' }}>Menunggu (Pending)</option>
                                <option value="processed" {{ $req->status == 'processed' ? 'selected' : '' }}>Sedang Diproses</option>
                                <option value="finished" {{ $req->status == 'finished' ? 'selected' : '' }}>Permohonan Diterima (Selesai)</option>
                                <option value="rejected" {{ $req->status == 'rejected' ? 'selected' : '' }}>Permohonan Ditolak</option>
                            </select>
                        </div>

                        {{-- Catatan --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-muted text-uppercase ls-1">Tanggapan Resmi (Admin Note)</label>
                            <textarea name="admin_note" class="form-control border-0 bg-light shadow-none py-2 px-3" rows="6"
                                      placeholder="Ketikkan alasan atau instruksi lanjutan di sini..." required>{{ $req->admin_note }}</textarea>
                            <div class="form-text mt-2 text-muted" style="font-size: 0.7rem;">
                                <i class="bi bi-info-circle me-1"></i> Tanggapan ini akan dapat dilihat oleh pemohon pada cek status.
                            </div>
                        </div>

                        {{-- Lampiran Balasan --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-muted text-uppercase ls-1">Upload Surat Tanggapan (Opsional)</label>
                            <input type="file" name="reply_file" class="form-control border-0 bg-light shadow-none" accept=".pdf,.jpg,.jpeg,.png">
                            <div class="form-text mt-2 text-muted" style="font-size: 0.7rem;">
                                <i class="bi bi-file-earmark-pdf me-1"></i> PDF atau Dokumen pendukung.
                            </div>

                            @if($req->reply_file)
                                <div class="mt-2 p-2 bg-light border rounded d-flex align-items-center">
                                    <i class="bi bi-paperclip me-2 text-primary"></i>
                                    <span class="small text-dark me-auto">File terupload: <a href="{{ asset('storage/' . $req->reply_file) }}" target="_blank" class="fw-bold text-decoration-none">Lihat File</a></span>
                                </div>
                            @endif
                        </div>

                        <hr class="my-4 opacity-10">

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary fw-bold rounded-pill shadow-sm py-2 px-4 hover-scale">
                                <i class="bi bi-send-fill me-2"></i> Simpan & Kirim Keputusan
                            </button>
                            <a href="{{ route('admin.requests.index') }}" class="btn btn-light border rounded-pill fw-bold py-2 text-muted">
                                Batalkan
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            {{-- INFO WAKTU --}}
            <div class="p-4 bg-white shadow-sm rounded-4 border-0 mb-4">
                <div class="d-flex align-items-center">
                    <div class="p-3 bg-light rounded-circle me-3">
                        <i class="bi bi-clock-history fs-4 text-primary"></i>
                    </div>
                    <div>
                        <label class="small text-muted text-uppercase fw-bold d-block mb-0" style="font-size: 0.6rem;">Waktu Pengajuan</label>
                        <span class="text-dark fw-bold small">{{ $req->created_at->format('d F Y, H:i') }} WITA</span>
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

    /* Border Dashed */
    .border-dashed { border-style: dashed !important; border-width: 2px !important; border-color: #dee2e6 !important; }

    /* Hover Effect */
    .hover-scale { transition: transform 0.2s; }
    .hover-scale:hover { transform: translateY(-2px); }

    .ls-1 { letter-spacing: 0.5px; }

    /* Tombol Utama */
    .btn-primary { background-color: #0d6efd; border: none; }
    .btn-primary:hover { background-color: #0b5ed7; }
</style>
@endsection
