@extends('layouts.frontend')

@section('content')
<div class="container py-5" style="margin-top: 60px;">
    <div class="text-center mb-5">
        <h2 class="fw-bold text-primary">{{ $category->name }}</h2>
        <p class="text-muted">Daftar Dokumen Publik - PPID Provinsi Kalimantan Selatan</p>
    </div>

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm h-100 bg-primary text-white">
                <div class="card-body p-4 d-flex flex-column justify-content-center align-items-center text-center">
                    <i class="bi bi-folder-fill fs-1 mb-3"></i>
                    <h4>Arsip Digital</h4>
                    <p class="small">Dokumen ini dapat diunduh secara bebas oleh masyarakat sebagai bentuk transparansi publik.</p>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            @forelse($documents as $doc)
            <div class="card border-0 shadow-sm mb-3 hover-zoom">
                <div class="card-body d-flex align-items-center">
                    <div class="flex-shrink-0 me-3">
                        <div class="bg-light p-3 rounded-circle text-danger">
                            <i class="bi bi-file-pdf-fill fs-4"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1">
                        <h5 class="mb-1">{{ $doc->title }}</h5>
                        <p class="mb-0 text-muted small">
                            <i class="bi bi-calendar"></i> Terbit: {{ \Carbon\Carbon::parse($doc->published_date)->format('d M Y') }}
                        </p>
                        @if($doc->description)
                            <p class="mb-0 text-muted small mt-1">{{ $doc->description }}</p>
                        @endif
                    </div>
                    <div>
                        <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="btn btn-outline-primary btn-sm rounded-pill px-4">
                            <i class="bi bi-download"></i> Unduh
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="alert alert-info text-center">
                Belum ada dokumen pada kategori ini.
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
