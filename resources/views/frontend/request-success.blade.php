@extends('layouts.frontend')

@section('content')
<div class="container py-5" style="margin-top: 80px;">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">

            <div class="mb-4">
                <i class="bi bi-check-circle-fill text-success" style="font-size: 5rem;"></i>
            </div>

            <h2 class="fw-bold mb-3">Permohonan Terkirim!</h2>
            <p class="text-muted mb-4">Terima kasih, data permohonan informasi Anda telah berhasil masuk ke sistem kami.</p>

            <div class="card bg-light border-0 shadow-sm mx-auto" style="max-width: 400px;">
                <div class="card-body p-4">
                    <small class="text-uppercase text-muted fw-bold d-block mb-2">Nomor Tiket Anda:</small>

                    <h1 class="display-5 fw-bold text-primary mb-0">{{ $ticket }}</h1>

                    <hr>
                    <small class="text-danger fst-italic">*Harap simpan/screenshot nomor tiket ini untuk mengecek status permohonan Anda.</small>
                </div>
            </div>

            <div class="mt-5">
                <a href="{{ url('/') }}" class="btn btn-outline-primary px-4 rounded-pill">
                    <i class="bi bi-arrow-left"></i> Kembali ke Beranda
                </a>
            </div>

        </div>
    </div>
</div>
@endsection
