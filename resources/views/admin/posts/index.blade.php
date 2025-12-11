@extends('layouts.admin')

@section('page-title', 'Kelola Berita & Artikel')

@section('content')

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Daftar Berita</h5>
        <a href="{{ route('posts.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Tulis Berita Baru
        </a>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="5%">No</th>
                        <th width="15%">Gambar</th>
                        <th width="35%">Judul Berita</th>
                        <th width="15%">Kategori</th>
                        <th width="10%">Penulis</th>
                        <th width="10%">Views</th>
                        <th width="10%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($posts as $key => $post)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>
                            @if($post->image)
                                <img src="{{ asset('storage/' . $post->image) }}" class="rounded" style="width: 80px; height: 50px; object-fit: cover;">
                            @else
                                <span class="badge bg-secondary">No Image</span>
                            @endif
                        </td>
                        <td>
                            <strong>{{ $post->title }}</strong>
                            <br>
                            <small class="text-muted">{{ $post->created_at->format('d M Y, H:i') }}</small>
                        </td>
                        <td>
                            <span class="badge bg-info text-dark">{{ $post->category->name ?? 'Umum' }}</span>
                        </td>
                        <td>{{ $post->user->name }}</td>
                        <td>
                            <span class="badge bg-light text-dark border">
                                <i class="bi bi-eye"></i> {{ $post->views }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-warning btn-sm text-white" title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-sm" onclick="return confirm('Hapus berita ini?')" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <img src="https://cdni.iconscout.com/illustration/premium/thumb/empty-state-2130362-1800926.png" style="width: 200px; opacity: 0.5;">
                            <p class="mt-3">Belum ada berita yang diterbitkan.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
