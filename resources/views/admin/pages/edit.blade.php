@extends('layouts.admin')

@section('page-title', 'Edit Halaman')

@section('content')

<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('pages.update', $page->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Judul Halaman</label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $page->title) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Isi Halaman</label>
                <textarea name="content" id="editor" class="form-control">{{ old('content', $page->content) }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Update Halaman</button>
            <a href="{{ route('pages.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>

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
        .create(document.querySelector('#editor'), {
            extraPlugins: [MyCustomUploadAdapterPlugin],

            // --- BAGIAN INI YANG KITA PERBAIKI ---
            toolbar: [
                'heading', '|',
                'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', '|',
                'insertTable', 'mediaEmbed', 'uploadImage', // <--- TOMBOL GAMBAR SAYA KEMBALIKAN DISINI
                'undo', 'redo'
            ],

            // Konfigurasi tambahan biar gambar bisa di-resize (opsional)
            image: {
                toolbar: [
                    'imageStyle:inline',
                    'imageStyle:block',
                    'imageStyle:side',
                    '|',
                    'toggleImageCaption',
                    'imageTextAlternative'
                ]
            }
        })
        .catch(error => {
            console.error(error);
        });
</script>
<style>
    /* ATURAN 1: Supaya Gambar Tidak Kebesaran */
    .ck-content img {
        max-width: 100%;     /* Lebar gambar mentok 100% layar, gak boleh lebih */
        height: auto;        /* Tinggi menyesuaikan biar gambar gak gepeng */
        display: block;      /* Biar bisa diatur posisinya */
        margin: 20px auto;   /* auto = Rata Tengah Otomatis */
        border-radius: 10px; /* Opsional: Biar sudut gambar agak melengkung manis */
        box-shadow: 0 4px 6px rgba(0,0,0,0.1); /* Opsional: Kasih bayangan dikit biar keren */
    }

    /* ATURAN 2: Supaya Tulisan Rapi */
    .ck-content p {
        margin-bottom: 15px; /* Jarak antar paragraf */
        line-height: 1.6;    /* Jarak antar baris tulisan biar enak dibaca */
        font-size: 16px;     /* Ukuran huruf standar */
        text-align: justify; /* Rata kanan-kiri (opsional, hapus kalau gak suka) */
    }

    /* ATURAN 3: Supaya Caption/Keterangan Gambar Rapi */
    .ck-content figure {
        margin: 0;
        text-align: center; /* Keterangan gambar rata tengah */
    }
</style>

@endsection
