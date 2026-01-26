@extends('layouts.admin')

@section('content')
{{--
    KONSISTEN DENGAN DESAIN BERITA:
    - Scroll body normal (overflow-y: auto).
    - Background light dengan kartu putih bersih.
--}}
<div class="container-fluid p-4" style="background-color: #f8fafc; min-height: 100vh;">

    {{-- 1. HEADER HALAMAN --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 pb-3 border-bottom border-secondary border-opacity-10">
        <div>
            <h4 class="fw-bold text-dark mb-1">Tambah Halaman Baru</h4>
            <p class="text-muted small mb-0">Buat konten informasi statis baru untuk portal publik.</p>
        </div>
        <div class="mt-3 mt-md-0">
            <a href="{{ route('pages.index') }}" class="btn btn-light btn-sm rounded-pill px-4 shadow-sm border fw-bold text-secondary hover-scale">
                <i class="bi bi-arrow-left me-2"></i>Kembali ke Daftar
            </a>
        </div>
    </div>

    {{-- 2. FORM UTAMA --}}
    <form action="{{ route('pages.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row g-4">

            {{-- KOLOM KIRI: EDITOR KONTEN --}}
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden">
                    <div class="card-header bg-white py-3 px-4 border-bottom">
                        <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-pencil-square me-2 text-primary"></i>Konten Halaman</h6>
                    </div>
                    <div class="card-body p-4">
                        {{-- Input Judul --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-uppercase text-muted ls-1">Judul Halaman <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control form-control-lg border-0 bg-light fw-bold text-dark shadow-none @error('title') is-invalid @enderror"
                                   value="{{ old('title') }}" placeholder="Contoh: Struktur Organisasi atau Visi Misi" required autofocus style="font-size: 1.1rem;">
                            @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Editor Konten --}}
                        <div class="mb-0">
                            <label class="form-label fw-bold small text-uppercase text-muted ls-1 mb-2">Isi Konten <span class="text-danger">*</span></label>
                            <div class="editor-wrapper border rounded-3 overflow-hidden shadow-sm">
                                <textarea name="content" id="editor" class="form-control">{!! old('content') !!}</textarea>
                            </div>
                            @error('content') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- KOLOM KANAN: PENGATURAN & AKSI --}}
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden mb-4">
                    <div class="card-header bg-white py-3 px-4 border-bottom text-primary fw-bold">
                        <i class="bi bi-gear-fill me-2"></i>Pengaturan
                    </div>
                    <div class="card-body p-4">

                        {{-- Info Tambahan (Opsional, jika Mas ada input lain bisa ditaruh sini) --}}
                        <div class="alert alert-primary border-0 bg-primary bg-opacity-10 rounded-3 mb-4">
                            <div class="d-flex">
                                <i class="bi bi-info-circle-fill me-2 mt-1"></i>
                                <small class="text-dark">Halaman yang Anda buat akan muncul secara otomatis di database, pastikan untuk mengatur tautannya di Manajemen Menu.</small>
                            </div>
                        </div>

                        <hr class="my-4 opacity-10">

                        {{-- TOMBOL AKSI --}}
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary fw-bold rounded-pill shadow-sm py-2 px-4 hover-scale">
                                <i class="bi bi-cloud-arrow-up-fill me-2"></i> Simpan Halaman
                            </button>
                            <button type="reset" class="btn btn-light border rounded-pill fw-bold py-2 text-muted">
                                Reset Form
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </form>
</div>

<style>
    /* Styling Body */
    body { background-color: #f8fafc; overflow-y: auto !important; }

    /* CKEditor Normal Height */
    .ck-editor__editable { min-height: 450px; border-radius: 0 0 10px 10px !important; }
    .ck.ck-editor { border: none !important; }

    /* Fokus Input */
    .form-control:focus {
        background-color: #fff !important;
        border: 1px solid #0d6efd !important;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.05);
    }

    /* Hover Scale Effect */
    .hover-scale { transition: transform 0.2s; }
    .hover-scale:hover { transform: translateY(-2px); }

    .ls-1 { letter-spacing: 0.5px; }

    /* Tombol Utama */
    .btn-primary { background-color: #0d6efd; border: none; }
    .btn-primary:hover { background-color: #0b5ed7; }
</style>

{{-- SCRIPT EDITOR (Sesuai Fungsi Asli Anda) --}}
<script src="https://cdn.ckeditor.com/ckeditor5/40.2.0/classic/ckeditor.js"></script>
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
        .create(document.querySelector('#editor'), {
            extraPlugins: [ MyCustomUploadAdapterPlugin ],
            toolbar: [
                'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', '|',
                'insertTable', 'mediaEmbed', '|', 'undo', 'redo', '|', 'imageUpload'
            ]
        })
        .catch(error => { console.error(error); });
</script>
@endsection
