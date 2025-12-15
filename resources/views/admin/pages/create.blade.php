@extends('layouts.admin')

@section('page-title', 'Tambah Halaman Baru')

@section('content')

<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('pages.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label">Judul Halaman</label>
                <input type="text" name="title" class="form-control" required placeholder="Contoh: Struktur Organisasi">
            </div>

            <div class="mb-3">
                <label class="form-label">Isi Halaman (Silakan Copy-Paste Gambar Disini)</label>
                <textarea name="content" id="editor" class="form-control"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Simpan Halaman</button>
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


@endsection
