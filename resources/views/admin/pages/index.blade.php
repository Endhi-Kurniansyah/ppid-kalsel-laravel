@extends('layouts.admin')

@section('page-title', 'Manajemen Halaman Statis')

@section('content')

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Daftar Halaman Website</h5>
        <a href="{{ route('pages.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Tambah Halaman Baru
        </a>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover table-striped align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="25%">Judul Halaman</th>
                        <th width="10%">Tipe</th>
                        <th width="10%">Status Kunci</th> <th width="20%">Link (Slug)</th>
                        <th width="15%">Terakhir Update</th>
                        <th width="20%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pages as $page)
                    <tr>
                        <td>
                            <strong>{{ $page->title }}</strong>
                        </td>

                        <td>
                            @if($page->is_static)
                                <span class="badge bg-primary">
                                    <i class="bi bi-shield-lock"></i> Utama
                                </span>
                            @else
                                <span class="badge bg-success">Tambahan</span>
                            @endif
                        </td>

                        <td>
                            @if($page->is_locked)
                                <span class="badge bg-danger"><i class="bi bi-lock-fill"></i> Terkunci</span>
                            @else
                                <span class="badge bg-success"><i class="bi bi-unlock-fill"></i> Terbuka</span>
                            @endif
                        </td>

                        <td class="text-muted small">
                            /page/{{ $page->slug }}
                            <a href="{{ route('public.page', $page->slug) }}" target="_blank" class="text-decoration-none ms-1">
                                <i class="bi bi-box-arrow-up-right"></i>
                            </a>
                        </td>

                        <td>{{ $page->updated_at->format('d M Y') }}</td>
                    <td>
                        <div class="d-flex gap-1">

                            {{-- 1. TOMBOL EDIT: Muncul untuk SEMUA (Walau terkunci tetap bisa edit) --}}
                            <a href="{{ route('pages.edit', $page->id) }}" class="btn btn-warning btn-sm text-white" title="Edit Halaman">
                                <i class="bi bi-pencil-square"></i>
                            </a>

                            {{-- 2. TOMBOL HAPUS: Hanya muncul jika TIDAK TERKUNCI atau user adalah SUPER ADMIN --}}
                            {{-- Logika: Kunci hanya melindungi dari penghapusan --}}
                            @if(!$page->is_locked || auth()->user()->role == 'super')

                                @if($page->is_static == 0)
                                    <form action="{{ route('pages.destroy', $page->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus halaman ini secara permanen?')" title="Hapus Halaman">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                @else
                                    {{-- Halaman Statis Utama (Visi Misi dll) memang tidak boleh dihapus siapa pun biasanya --}}
                                    <button class="btn btn-secondary btn-sm" disabled title="Halaman Utama tidak dapat dihapus">
                                        <i class="bi bi-shield-fill-x"></i>
                                    </button>
                                @endif

                            @else
                                {{-- Jika Terkunci & User Biasa -> Muncul icon Gembok (Tanda gak bisa hapus) --}}
                                <button class="btn btn-secondary btn-sm" disabled title="Terkunci: Tidak bisa dihapus">
                                    <i class="bi bi-lock-fill"></i>
                                </button>
                            @endif


                            {{-- 3. TOMBOL GEMBOK (Tetap Khusus Super Admin) --}}
                            @if(auth()->user()->role == 'super')
                                <form action="{{ route('pages.toggle-lock', $page->id) }}" method="POST" class="d-inline ms-2 border-start ps-2">
                                    @csrf
                                    @method('PUT')
                                    @if($page->is_locked)
                                        <button class="btn btn-outline-success btn-sm" title="Buka Kunci">
                                            <i class="bi bi-unlock"></i>
                                        </button>
                                    @else
                                        <button class="btn btn-outline-dark btn-sm" title="Kunci Halaman (Agar tidak dihapus staf)">
                                            <i class="bi bi-lock"></i>
                                        </button>
                                    @endif
                                </form>
                            @endif

                        </div>
                    </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">
                            Belum ada halaman yang dibuat.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
