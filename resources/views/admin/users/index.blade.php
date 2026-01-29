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
            <h4 class="fw-bold text-dark mb-1">Manajemen Pengguna</h4>
            <p class="text-muted small mb-0">Kelola hak akses admin dan operator panel kendali website.</p>
        </div>

        <div class="mt-3 mt-md-0 d-flex gap-2 align-items-center">
            {{-- CETAK LAPORAN --}}
            {{-- CETAK LAPORAN --}}
            <a href="{{ route('admin.reports.users') }}" target="_blank" class="btn btn-danger btn-sm rounded-pill px-3 fw-bold shadow-sm hover-scale" style="font-size: 0.75rem;">
                <i class="bi bi-printer-fill me-1"></i> Cetak Laporan
            </a>

            {{-- TAMBAH USER --}}
            <button type="button" class="btn btn-primary btn-sm rounded-pill px-3 fw-bold shadow-none hover-scale" data-bs-toggle="modal" data-bs-target="#modalTambah" style="background-color: #0d6efd; font-size: 0.75rem;">
                <i class="bi bi-person-plus-fill me-1"></i> Tambah Admin
            </button>
        </div>
    </div>

    {{-- 2. NOTIFIKASI (FLAT) --}}
    @if(session('success'))
        <div class="alert alert-success border-0 shadow-none rounded-3 mb-2 py-2 px-3 d-flex align-items-center bg-white border-start border-success border-4 flex-shrink-0">
            <i class="bi bi-check-circle-fill me-2 text-success"></i>
            <div class="text-dark fw-medium small">{{ session('success') }}</div>
            <button type="button" class="btn-close ms-auto small" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- 3. TABLE CARD (SCROLLABLE INTERNAL) --}}
    <div class="card border border-light shadow-none rounded-4 overflow-hidden flex-grow-1 d-flex flex-column bg-white">

        <div class="card-header bg-white py-3 px-4 border-bottom d-flex justify-content-between align-items-center flex-shrink-0">
            <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-people me-2 text-primary"></i>Daftar Pengguna Aktif</h6>
            <span class="badge bg-light text-primary border rounded-pill fw-normal px-3" style="font-size: 0.7rem;">Total: {{ $users->count() }} User</span>
        </div>

        <div class="card-body p-0 overflow-auto custom-scrollbar position-relative">
            <table class="table table-hover align-middle mb-0 w-100 text-nowrap">
                <thead class="bg-light text-secondary sticky-top" style="z-index: 5;">
                    <tr class="text-muted small text-uppercase fw-bold">
                        <th class="ps-4 py-3 border-0 bg-light">Nama & Email</th>
                        <th class="py-3 border-0 bg-light">Hak Akses (Role)</th>
                        <th class="py-3 border-0 bg-light">Status Akun</th>
                        <th class="py-3 border-0 text-end pe-4 bg-light">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center">
                                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 38px; height: 38px;">
                                    <i class="bi bi-person text-secondary fs-5"></i>
                                </div>
                                <div>
                                    <div class="fw-bold text-dark mb-0" style="font-size: 0.85rem;">{{ $user->name }}</div>
                                    <small class="text-muted font-monospace" style="font-size: 0.7rem;">{{ $user->email }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($user->role == 'super_admin')
                                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary small rounded-pill px-3 py-1 fw-bold" style="font-size: 0.65rem;">SUPER ADMIN</span>
                            @else
                                <span class="badge bg-info bg-opacity-10 text-info border border-info small rounded-pill px-3 py-1 fw-bold" style="font-size: 0.65rem;">ADMIN</span>
                            @endif
                        </td>
                        <td>
                            @if($user->is_active)
                                <span class="badge bg-success bg-opacity-10 text-success border border-success small rounded-pill px-3 py-1 fw-bold" style="font-size: 0.65rem;">AKTIF</span>
                            @else
                                <span class="badge bg-danger bg-opacity-10 text-danger border border-danger small rounded-pill px-3 py-1 fw-bold" style="font-size: 0.65rem;">NONAKTIF</span>
                            @endif
                        </td>
                        <td class="text-end pe-4">
                            <div class="d-flex justify-content-end gap-2">
                                {{-- RESET PASSWORD --}}
                                <button class="btn btn-sm btn-outline-warning rounded-circle d-flex align-items-center justify-content-center hover-scale" style="width: 32px; height: 32px;" data-bs-toggle="modal" data-bs-target="#modalReset{{ $user->id }}" title="Reset Password">
                                    <i class="bi bi-key-fill"></i>
                                </button>

                                @if(auth()->id() != $user->id)
                                    {{-- LOCK/UNLOCK --}}
                                    <form action="{{ route('admin.users.toggle', $user->id) }}" method="POST" class="d-inline">
                                        @csrf @method('PUT')
                                        <button class="btn btn-sm {{ $user->is_active ? 'btn-outline-dark' : 'btn-outline-success' }} rounded-circle d-flex align-items-center justify-content-center hover-scale" style="width: 32px; height: 32px;" title="{{ $user->is_active ? 'Kunci Akun' : 'Buka Kunci' }}">
                                            <i class="bi {{ $user->is_active ? 'bi-lock-fill' : 'bi-unlock-fill' }}"></i>
                                        </button>
                                    </form>

                                    {{-- DELETE --}}
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus admin ini secara permanen?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger rounded-circle d-flex align-items-center justify-content-center hover-scale" style="width: 32px; height: 32px;" title="Hapus">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>

                    {{-- MODAL RESET PASSWORD --}}
                    <div class="modal fade" id="modalReset{{ $user->id }}" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content border-0 shadow-none rounded-4">
                                <div class="modal-header border-bottom py-3">
                                    <h6 class="modal-title fw-bold text-dark"><i class="bi bi-key me-2 text-warning"></i>Reset Password: {{ $user->name }}</h6>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="{{ route('admin.users.reset', $user->id) }}" method="POST">
                                    @csrf @method('PUT')
                                    <div class="modal-body p-4">
                                        <div class="mb-2">
                                            <label class="form-label fw-bold small text-muted text-uppercase ls-1">Password Baru</label>
                                            <input type="text" name="new_password" class="form-control bg-light border-0 py-2 shadow-none" required placeholder="Minimal 6 karakter">
                                        </div>
                                    </div>
                                    <div class="modal-footer border-top-0 p-4 pt-0">
                                        <button type="button" class="btn btn-light rounded-pill px-4 small fw-bold" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-warning rounded-pill px-4 small fw-bold shadow-none text-dark">Simpan Perubahan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- MODAL TAMBAH USER --}}
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-none rounded-4">
            <div class="modal-header border-bottom py-3">
                <h6 class="modal-title fw-bold text-dark"><i class="bi bi-person-plus me-2 text-primary"></i>Tambah Admin Baru</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted text-uppercase ls-1">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control bg-light border-0 py-2 shadow-none" required placeholder="Contoh: Budi Santoso">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted text-uppercase ls-1">Email Login</label>
                        <input type="email" name="email" class="form-control bg-light border-0 py-2 shadow-none" required placeholder="email@kalselprov.go.id">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted text-uppercase ls-1">Password</label>
                        <input type="password" name="password" class="form-control bg-light border-0 py-2 shadow-none" required placeholder="Masukkan password">
                    </div>
                    <div class="mb-0">
                        <label class="form-label fw-bold small text-muted text-uppercase ls-1">Role / Hak Akses</label>
                        <select name="role" class="form-select bg-light border-0 py-2 shadow-none">
                            <option value="admin">Admin Biasa (Operator)</option>
                            <option value="super_admin">Super Admin (Administrator)</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-top-0 p-4 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4 small fw-bold" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 small fw-bold shadow-none">Daftarkan Admin</button>
                </div>
            </form>
        </div>
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
    .hover-scale { transition: transform 0.2s ease; }
    .hover-scale:hover { transform: scale(1.1); }

    /* Form UI */
    .form-control:focus, .form-select:focus {
        background-color: #fff !important;
        border: 1px solid #0d6efd !important;
    }
    .ls-1 { letter-spacing: 0.5px; }
</style>

@endsection
