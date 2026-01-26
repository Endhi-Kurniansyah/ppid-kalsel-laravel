@extends('layouts.admin')

@section('content')
{{--
    KONSISTEN DENGAN CREATE:
    - Scroll body normal.
    - Semua card berwarna putih agar bersih.
--}}
<div class="container-fluid p-4" style="background-color: #f8fafc; min-height: 100vh;">

    {{-- 1. HEADER HALAMAN --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 pb-3 border-bottom">
        <div>
            <h4 class="fw-bold text-dark mb-1">Edit Berita / Artikel</h4>
            <p class="text-muted small mb-0">Perbarui konten atau pengaturan publikasi berita ini.</p>
        </div>
        <div class="mt-3 mt-md-0">
            <a href="{{ route('posts.index') }}" class="btn btn-light btn-sm rounded-pill px-4 shadow-sm border fw-bold text-secondary hover-scale">
                <i class="bi bi-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>

    {{-- 2. FORM UTAMA --}}
    <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row g-4">

            {{-- KOLOM KIRI: EDITOR (WARNA PUTIH) --}}
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden">
                    <div class="card-header bg-white py-3 px-4 border-bottom">
                        <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-pencil-square me-2 text-primary"></i>Konten Utama</h6>
                    </div>
                    <div class="card-body p-4">
                        {{-- Input Judul --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-uppercase text-muted">Judul Berita <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control form-control-lg border-0 bg-light fw-bold text-dark shadow-none @error('title') is-invalid @enderror"
                                   value="{{ old('title', $post->title) }}" placeholder="Masukkan judul berita..." required style="font-size: 1.1rem;">
                            @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Editor Konten --}}
                        <div class="mb-0">
                            <label class="form-label fw-bold small text-uppercase text-muted mb-2">Isi Berita <span class="text-danger">*</span></label>
                            <div class="editor-wrapper border rounded-3 overflow-hidden shadow-sm">
                                <textarea name="content" id="content-editor" class="form-control">{!! old('content', $post->content) !!}</textarea>
                            </div>
                            @error('content') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- KOLOM KANAN: PANEL PUBLIKASI (WARNA PUTIH BERSIH) --}}
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden mb-4">
                    <div class="card-header bg-white py-3 px-4 border-bottom text-primary fw-bold">
                        <i class="bi bi-arrow-repeat me-2"></i>Update Publikasi
                    </div>
                    <div class="card-body p-4">

                        {{-- Kategori --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-muted text-uppercase">Kategori Berita</label>
                            <select name="category_id" class="form-select border-0 bg-light shadow-none py-2 rounded-3 fw-medium" required>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ old('category_id', $post->category_id) == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Gambar Utama --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-muted text-uppercase">Gambar Utama (Thumbnail)</label>
                            <div class="p-4 bg-light rounded-4 border border-dashed text-center mb-3">
                                <i class="bi bi-cloud-arrow-up-fill fs-1 text-primary opacity-25 mb-2 d-block"></i>
                                <input type="file" name="image" class="form-control form-control-sm bg-white shadow-none" accept="image/*">
                            </div>

                            @if($post->image)
                                <div class="mt-2 p-2 border rounded-4 bg-white shadow-sm text-center">
                                    <small class="text-muted d-block mb-2">Gambar Saat Ini:</small>
                                    <img src="{{ asset('storage/' . $post->image) }}" class="rounded img-fluid border" style="max-height: 180px; object-fit: cover;">
                                </div>
                            @endif
                            <small class="text-muted d-block mt-2 text-center" style="font-size: 0.7rem;">
                                *Biarkan kosong jika tidak ingin mengganti gambar.
                            </small>
                        </div>

                        <hr class="my-4 opacity-10">

                        {{-- Tombol Aksi --}}
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary fw-bold rounded-pill shadow-sm py-2 px-4 hover-scale">
                                <i class="bi bi-save2-fill me-2"></i> Simpan Perubahan
                            </button>
                            <a href="{{ route('posts.index') }}" class="btn btn-light border rounded-pill fw-bold py-2 text-muted">
                                Batal
                            </a>
                        </div>

                        <div class="mt-4 text-center">
                            <small class="text-muted" style="font-size: 10px;">
                                Terakhir diperbarui: <br><strong>{{ $post->updated_at->format('d M Y, H:i') }} WITA</strong>
                            </small>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </form>
</div>

<style>
    /* Styling Body */
    body { background-color: #f8fafc; }

    /* CKEditor Normal Height */
    .ck-editor__editable { min-height: 450px; }
    .ck.ck-editor { border: none !important; }

    /* Border Dashed untuk Upload */
    .border-dashed { border-style: dashed !important; border-width: 2px !important; border-color: #dee2e6 !important; }

    .hover-scale { transition: transform 0.2s; }
    .hover-scale:hover { transform: translateY(-2px); }

    .btn-primary { background-color: #0d6efd; border: none; }
    .btn-primary:hover { background-color: #0b5ed7; }
</style>

{{-- SCRIPT EDITOR (Sesuai Fungsi Lama Anda) --}}
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
    class MyUploadAdapter {
        constructor(loader) { this.loader = loader; }
        upload() {
            return this.loader.file.then(file => new Promise((resolve, reject) => {
                const reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onload = () => resolve({ default: reader.result });
                reader.onerror = error => reject(error);
            }));
        }
        abort() {}
    }

    function MyCustomUploadAdapterPlugin(editor) {
        editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
            return new MyUploadAdapter(loader);
        };
    }

    ClassicEditor
        .create(document.querySelector('#content-editor'), {
            extraPlugins: [ MyCustomUploadAdapterPlugin ],
            // Tanpa tombol gambar di editor sesuai permintaan
            toolbar: [
                'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', '|',
                'insertTable', 'mediaEmbed', '|', 'undo', 'redo'
            ]
        })
        .catch(error => { console.error(error); });
</script>
@endsection
