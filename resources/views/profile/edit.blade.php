@extends('layouts.admin')

@section('content')
{{-- Scroll Normal --}}
<div class="container-fluid p-4" style="background-color: #f8fafc; min-height: 100vh;">

    {{-- 1. HEADER HALAMAN --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 pb-3 border-bottom border-secondary border-opacity-10">
        <div>
            <h4 class="fw-bold text-dark mb-1">Pengaturan Profil</h4>
            <p class="text-muted small mb-0">Kelola informasi identitas akun dan keamanan kata sandi Anda.</p>
        </div>
    </div>

    <div class="row g-4">
        {{-- CARD 1: INFORMASI PROFIL --}}
        <div class="col-12 col-lg-6">
            <div class="card border border-light shadow-none rounded-4 bg-white overflow-hidden h-100">
                <div class="card-header bg-white py-3 px-4 border-bottom">
                    <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-person-circle me-2 text-primary"></i>Informasi Akun</h6>
                </div>
                <div class="card-body p-4">
                    <form method="post" action="{{ route('profile.update') }}">
                        @csrf
                        @method('patch')

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted text-uppercase ls-1">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control bg-light border-0 py-2 shadow-none fw-bold" value="{{ old('name', $user->name) }}" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-bold text-muted text-uppercase ls-1">Alamat Email</label>
                            <input type="email" name="email" class="form-control bg-light border-0 py-2 shadow-none" value="{{ old('email', $user->email) }}" required>
                        </div>

                        <div class="d-flex align-items-center gap-3">
                            <button type="submit" class="btn btn-primary px-4 py-2 fw-bold rounded-pill shadow-none hover-scale">
                                <i class="bi bi-check-circle me-2"></i>Simpan Perubahan
                            </button>
                            @if (session('status') === 'profile-updated')
                                <span class="text-success small fw-bold animate__animated animate__fadeIn"><i class="bi bi-check-all"></i> Tersimpan</span>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- CARD 2: GANTI PASSWORD --}}
        <div class="col-12 col-lg-6">
            <div class="card border border-light shadow-none rounded-4 bg-white overflow-hidden h-100">
                <div class="card-header bg-white py-3 px-4 border-bottom">
                    <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-shield-lock-fill me-2 text-warning"></i>Perbarui Keamanan</h6>
                </div>
                <div class="card-body p-4">
                    <form method="post" action="{{ route('password.update') }}">
                        @csrf
                        @method('put')

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted text-uppercase ls-1">Password Saat Ini</label>
                            <input type="password" name="current_password" class="form-control bg-light border-0 py-2 shadow-none">
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted text-uppercase ls-1">Password Baru</label>
                            <input type="password" name="password" class="form-control bg-light border-0 py-2 shadow-none">
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-bold text-muted text-uppercase ls-1">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="form-control bg-light border-0 py-2 shadow-none">
                        </div>

                        <div class="d-flex align-items-center gap-3">
                            <button type="submit" class="btn btn-warning px-4 py-2 fw-bold rounded-pill shadow-none text-dark hover-scale">
                                <i class="bi bi-key-fill me-2"></i>Update Password
                            </button>
                            @if (session('status') === 'password-updated')
                                <span class="text-success small fw-bold animate__animated animate__fadeIn"><i class="bi bi-check-all"></i> Berhasil Diganti</span>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- CARD 3: HAPUS AKUN (FOOTER) --}}
        <div class="col-12">
            <div class="card border border-light shadow-none rounded-4 bg-white overflow-hidden">
                <div class="card-body p-4 d-flex flex-column flex-md-row justify-content-between align-items-center">
                    <div class="d-flex align-items-center mb-3 mb-md-0">
                        <div class="p-3 bg-danger bg-opacity-10 rounded-circle me-3 text-danger">
                            <i class="bi bi-exclamation-triangle-fill fs-4"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold text-danger mb-1">Zona Bahaya: Hapus Akun</h6>
                            <p class="text-muted small mb-0">Hapus akun secara permanen jika sudah tidak digunakan kembali. Data tidak dapat dipulihkan.</p>
                        </div>
                    </div>
                    <button class="btn btn-outline-danger px-4 py-2 fw-bold rounded-pill hover-scale" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal">
                        <i class="bi bi-trash3 me-2"></i>Hapus Akun Sekarang
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- MODAL KONFIRMASI HAPUS (GAYA CLEAN) --}}
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-none rounded-4">
            <div class="modal-header border-bottom py-3">
                <h6 class="modal-title fw-bold text-dark">Konfirmasi Hapus Akun</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="{{ route('profile.destroy') }}">
                @csrf
                @method('delete')
                <div class="modal-body p-4 text-center">
                    <i class="bi bi-exclamation-octagon text-danger display-4 mb-3 d-block"></i>
                    <p class="text-dark fw-bold mb-1">Apakah Anda yakin ingin menghapus akun?</p>
                    <p class="text-muted small">Setelah akun dihapus, semua data akan hilang secara permanen. Masukkan password Anda untuk konfirmasi.</p>
                    <input type="password" name="password" class="form-control bg-light border-0 py-2 text-center" placeholder="Masukkan Password Anda" required>
                </div>
                <div class="modal-footer border-0 p-4 pt-0 justify-content-center gap-2">
                    <button type="button" class="btn btn-light rounded-pill px-4 fw-bold" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger rounded-pill px-4 fw-bold shadow-none">Ya, Hapus Permanen</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    body { background-color: #f8fafc; overflow-y: auto !important; }
    .ls-1 { letter-spacing: 0.5px; }
    .hover-scale { transition: transform 0.2s ease; }
    .hover-scale:hover { transform: translateY(-2px); }

    .form-control:focus {
        background-color: #fff !important;
        border: 1px solid #0d6efd !important;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.05) !important;
    }
    .btn-primary { background-color: #0d6efd; border: none; }
    .btn-warning { background-color: #f59e0b; border: none; }
</style>
@endsection
