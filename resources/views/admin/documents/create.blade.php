@extends('layouts.admin')
@section('page-title', 'Upload Dokumen Baru')
@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label>Judul Dokumen</label>
                <input type="text" name="title" class="form-control" required placeholder="Contoh: Laporan Keuangan 2024">
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Kategori</label>
                    <select name="category_id" class="form-select" required>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Tanggal Terbit</label>
                    <input type="date" name="published_date" class="form-control" required>
                </div>
            </div>

            <div class="mb-3">
                <label>File Dokumen (PDF/Word/Excel)</label>
                <input type="file" name="file_path" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Deskripsi Singkat (Opsional)</label>
                <textarea name="description" class="form-control" rows="2"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Simpan Dokumen</button>
            <a href="{{ route('documents.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection
