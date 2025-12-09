@extends('layouts.admin')
@section('page-title', 'Inventaris Dokumen Publik')
@section('content')

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card">
    <div class="card-header d-flex justify-content-between">
        <a href="{{ route('documents.create') }}" class="btn btn-primary"><i class="bi bi-plus"></i> Upload Dokumen</a>
        <a href="{{ route('documents.print') }}" class="btn btn-danger" target="_blank"><i class="bi bi-printer"></i> Cetak Laporan</a>
    </div>
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Judul Dokumen</th>
                    <th>Kategori</th>
                    <th>Tgl Terbit</th>
                    <th>File</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($documents as $doc)
                <tr>
                    <td>
                        {{ $doc->title }} <br>
                        <small class="text-muted">Upload by: {{ $doc->user->name }}</small>
                    </td>
                    <td><span class="badge bg-info">{{ $doc->category->name }}</span></td>
                    <td>{{ $doc->published_date }}</td>
                    <td>
                        <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">Download</a>
                    </td>
                    <td>
                        <form action="{{ route('documents.destroy', $doc->id) }}" method="POST" onsubmit="return confirm('Hapus dokumen ini?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $documents->links() }}
    </div>
</div>
@endsection
