@extends('layouts.admin')
@section('page-title', 'Manajemen Halaman Statis')
@section('content')

@if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif

<div class="card">
    <div class="card-header">
        <a href="{{ route('pages.create') }}" class="btn btn-primary">Tambah Halaman Baru</a>
    </div>
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Judul Halaman</th>
                    <th>Link (Slug)</th>
                    <th>Terakhir Update</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pages as $page)
                <tr>
                    <td>{{ $page->title }}</td>
                    <td>/page/{{ $page->slug }}</td>
                    <td>{{ $page->updated_at->format('d M Y') }}</td>
                    <td>
                        <a href="{{ route('pages.edit', $page->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('pages.destroy', $page->id) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Hapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
