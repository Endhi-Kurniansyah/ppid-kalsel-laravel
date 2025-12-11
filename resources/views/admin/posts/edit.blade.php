@extends('layouts.admin')

@section('page-title', 'Edit Berita')

@section('content')
<div class="card shadow-sm">
    <div class="card-body">

        <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Judul Berita</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title', $post->title) }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Isi Berita</label>
                        <textarea name="content" id="content-editor" class="form-control">{!! old('content', $post->content) !!}</textarea>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card bg-light border-0">
                        <div class="card-body">
                            <h6 class="fw-bold mb-3">Update Publikasi</h6>

                            <div class="mb-3">
                                <label class="form-label small text-muted">Kategori</label>
                                <select name="category_id" class="form-select" required>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}" {{ $post->category_id == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label small text-muted">Ganti Gambar (Opsional)</label>
                                <input type="file" name="image" class="form-control" accept="image/*">

                                @if($post->image)
                                    <div class="mt-2">
                                        <small>Gambar Saat Ini:</small><br>
                                        <img src="{{ asset('storage/' . $post->image) }}" class="rounded img-fluid mt-1" style="max-height: 150px;">
                                    </div>
                                @endif
                            </div>

                            <hr>

                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-save-fill me-1"></i> Simpan Perubahan
                            </button>
                            <a href="{{ route('posts.index') }}" class="btn btn-outline-secondary w-100 mt-2">Batal</a>
                        </div>
                    </div>
                </div>
            </div>

        </form>

    </div>
</div>
@endsection
