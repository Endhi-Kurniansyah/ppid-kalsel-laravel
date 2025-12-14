@extends('layouts.frontend')

@section('content')
<div class="container py-5" style="margin-top: 80px;">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="text-center mb-4">
                <h2 class="fw-bold text-danger">Ajukan Keberatan</h2>
                <p class="text-muted">Jika permohonan informasi Anda tidak ditanggapi atau ditolak tanpa alasan yang jelas, silakan ajukan keberatan di sini.</p>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body p-4">

                    @if(session('error'))
                        <div class="alert alert-danger">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('objection.create') }}" method="GET">
                        <label class="form-label fw-bold">Nomor Tiket Permohonan</label>
                        <div class="input-group input-group-lg mb-3">
                            <input type="text" name="ticket" class="form-control" placeholder="Contoh: REQ-2025-XXXX" required>
                            <button class="btn btn-danger" type="submit">
                                Lanjut <i class="bi bi-arrow-right"></i>
                            </button>
                        </div>
                        <small class="text-muted">Masukkan nomor tiket yang Anda dapatkan saat mengajukan permohonan informasi.</small>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
