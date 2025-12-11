@extends('layouts.admin')

@section('page-title', 'Tulis Berita Baru')

@section('content')
<div class="card shadow-sm">
    <div class="card-body">

        <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Judul Berita</label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" placeholder="Masukkan judul berita menarik..." required>
                        @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Isi Berita</label>
                        <textarea name="content" id="content-editor" class="form-control">{{ old('content') }}</textarea>
                        @error('content') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card bg-light border-0">
                        <div class="card-body">
                            <h6 class="fw-bold mb-3">Pengaturan Publikasi</h6>

                            <div class="mb-3">
                                <label class="form-label small text-muted">Kategori</label>
                                <select name="category_id" class="form-select" required>
                                    <option value="" disabled selected>-- Pilih Kategori --</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label small text-muted">Gambar Utama (Thumbnail)</label>
                                <input type="file" name="image" class="form-control" accept="image/*">
                                <small class="text-muted d-block mt-1" style="font-size: 11px;">Format: JPG, PNG, JPEG. Max: 2MB</small>
                            </div>

                            <hr>

                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-send-fill me-1"></i> Terbitkan Berita
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
