@extends('layouts.frontend')

@section('content')
<div class="container py-5" style="margin-top: 80px;">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card border-0 shadow-lg">
                <div class="card-header bg-danger text-white py-3">
                    <h4 class="mb-0 fw-bold text-white"><i class="bi bi-exclamation-octagon-fill me-2"></i> Form Pernyataan Keberatan</h4>
                </div>
                <div class="card-body p-5">

                    <div class="alert alert-light border mb-4">
                        <h6 class="fw-bold text-muted mb-3">Data Permohonan Asal:</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <small class="text-muted d-block">Nomor Tiket</small>
                                <strong>{{ $infoRequest->ticket_number }}</strong>
                            </div>
                            <div class="col-md-6">
                                <small class="text-muted d-block">Tanggal Pengajuan</small>
                                <strong>{{ $infoRequest->created_at->format('d M Y') }}</strong>
                            </div>
                            <div class="col-12 mt-2">
                                <small class="text-muted d-block">Informasi yang Diminta</small>
                                <p class="mb-0">{{ $infoRequest->details }}</p>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <form action="{{ route('objection.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="information_request_id" value="{{ $infoRequest->id }}">

                        <div class="mb-3">
                            <label class="form-label fw-bold">Alasan Pengajuan Keberatan</label>
                            <select name="reason" class="form-select" required>
                                <option value="" disabled selected>-- Pilih Alasan --</option>
                                <option value="Permohonan Informasi Ditolak">Permohonan Informasi Ditolak</option>
                                <option value="Informasi Berkala Tidak Disediakan">Informasi Berkala Tidak Disediakan</option>
                                <option value="Permintaan Tidak Ditanggapi">Permintaan Tidak Ditanggapi</option>
                                <option value="Permintaan Tidak Dipenuhi Sebagaimana Mestinya">Permintaan Tidak Dipenuhi Sebagaimana Mestinya</option>
                                <option value="Biaya yang Dikenakan Tidak Wajar">Biaya yang Dikenakan Tidak Wajar</option>
                                <option value="Penyampaian Informasi Melebihi Waktu">Penyampaian Informasi Melebihi Waktu</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Kasus Posisi (Deskripsi Lengkap)</label>
                            <textarea name="description" class="form-control" rows="5" required placeholder="Jelaskan secara rinci kronologi atau alasan mengapa Anda mengajukan keberatan..."></textarea>
                        </div>

                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-danger btn-lg rounded-pill">
                                <i class="bi bi-send-fill me-2"></i> KIRIM KEBERATAN
                            </button>
                            <a href="{{ route('objection.search') }}" class="btn btn-outline-secondary">Batal</a>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
