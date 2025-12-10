@extends('layouts.admin')

@section('page-title', 'Manajemen Halaman Statis')

@section('content')

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
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
                        <th width="30%">Judul Halaman</th>
                        <th width="15%">Tipe</th>
                        <th width="25%">Link (Slug)</th>
                        <th width="15%">Terakhir Update</th>
                        <th width="15%">Aksi</th>
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
                        <td class="text-muted small">
                            /page/{{ $page->slug }}
                            <a href="{{ route('public.page', $page->slug) }}" target="_blank" class="text-decoration-none ms-1">
                                <i class="bi bi-box-arrow-up-right"></i>
                            </a>
                        </td>
                        <td>{{ $page->updated_at->format('d M Y') }}</td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('pages.edit', $page->id) }}" class="btn btn-warning btn-sm text-white" title="Edit Halaman">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                @if($page->is_static == 0)
                                    <form action="{{ route('pages.destroy', $page->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus halaman ini secara permanen?')" title="Hapus Halaman">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                @else
                                    <button class="btn btn-secondary btn-sm" disabled title="Halaman Utama tidak dapat dihapus">
                                        <i class="bi bi-lock-fill"></i>
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">
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
