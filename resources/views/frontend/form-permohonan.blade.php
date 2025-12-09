@extends('layouts.frontend')

@section('content')
<div class="container py-5" style="margin-top: 80px;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-lg">
                <div class="card-header bg-primary text-white text-center py-4">
                    <h3 class="mb-0 text-white">Formulir Permohonan Informasi</h3>
                    <p class="mb-0">Silakan isi data diri dan informasi yang dibutuhkan</p>
                </div>
                <div class="card-body p-5">

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('public.submit') }}" method="POST">
                        @csrf

                        <h5 class="text-primary mb-3">1. Identitas Pemohon</h5>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">NIK (KTP)</label>
                                <input type="number" name="nik_ktp" class="form-control" required placeholder="16 digit NIK">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" name="name" class="form-control" required placeholder="Sesuai KTP">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">No. WhatsApp/HP</label>
                                <input type="text" name="phone" class="form-control" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Alamat Lengkap</label>
                            <textarea name="address" class="form-control" rows="2" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Pekerjaan</label>
                            <input type="text" name="job" class="form-control">
                        </div>

                        <hr class="my-4">

                        <h5 class="text-primary mb-3">2. Rincian Informasi</h5>
                        <div class="mb-3">
                            <label class="form-label">Rincian Informasi yang Dibutuhkan</label>
                            <textarea name="details" class="form-control" rows="3" required placeholder="Contoh: Data Aset Dinas Pertanian Tahun 2024..."></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tujuan Penggunaan Informasi</label>
                            <textarea name="purpose" class="form-control" rows="2" required placeholder="Contoh: Untuk keperluan penelitian skripsi..."></textarea>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill shadow">
                                <i class="bi bi-send-fill"></i> Kirim Permohonan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
