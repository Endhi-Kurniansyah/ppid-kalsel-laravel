@extends('layouts.frontend')

@section('content')
<div class="container py-5" style="margin-top: 80px;">
    <div class="row justify-content-center">
        <div class="col-md-6 text-center">

            <div class="mb-4">
                <i class="bi bi-shield-check text-danger" style="font-size: 5rem;"></i>
            </div>

            <h2 class="fw-bold mb-3">Keberatan Diterima</h2>
            <p class="text-muted mb-4">Pengajuan keberatan Anda telah kami terima dan akan segera ditindaklanjuti oleh Atasan PPID.</p>

            <div class="card bg-light border-0 shadow-sm mx-auto mb-4" style="max-width: 400px;">
                <div class="card-body p-4">
                    <small class="text-uppercase text-muted fw-bold d-block mb-2">Kode Registrasi Keberatan:</small>
                    <h1 class="display-6 fw-bold text-danger mb-0">{{ $code }}</h1>
                </div>
            </div>

            <a href="{{ url('/') }}" class="btn btn-outline-danger px-4 rounded-pill">
                Kembali ke Beranda
            </a>

        </div>
    </div>
</div>
@endsection
