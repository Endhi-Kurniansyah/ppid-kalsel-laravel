@extends('layouts.admin')
@section('page-title', 'Edit Halaman')
@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('pages.update', $page->id) }}" method="POST">
            @csrf @method('PUT')
            <div class="mb-3">
                <label>Judul Halaman</label>
                <input type="text" name="title" class="form-control" value="{{ $page->title }}" required>
            </div>
            <div class="mb-3">
                <label class="fw-bold mb-2">Isi Konten Halaman</label>
                <textarea name="content" id="content-editor" class="form-control">{{ $page->content }}</textarea>
            </div>
            <button class="btn btn-primary">Update Halaman</button>
        </form>
    </div>
</div>
@endsection
