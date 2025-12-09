@extends('layouts.admin')
@section('page-title', 'Buat Halaman Baru')
@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('pages.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label>Judul Halaman</label>
                <input type="text" name="title" class="form-control" placeholder="Contoh: Tata Cara, Visi Misi" required>
            </div>
            <div class="mb-3">
                <label class="fw-bold mb-2">Isi Konten Halaman</label>
                <textarea name="content" id="content-editor" class="form-control"></textarea>
            </div>
            <button class="btn btn-primary">Simpan Halaman</button>
        </form>
    </div>
</div>
@endsection
