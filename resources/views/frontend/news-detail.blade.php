@extends('layouts.frontend') @section('content')

<div class="bg-light py-5 mb-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 text-center">
                <span class="badge bg-primary mb-2">{{ $post->category->name ?? 'Berita' }}</span>
                <h1 class="fw-bold text-dark">{{ $post->title }}</h1>
                <div class="text-muted mt-3">
                    <small>
                        <i class="bi bi-person me-1"></i> {{ $post->user->name }} &nbsp;•&nbsp;
                        <i class="bi bi-calendar-event me-1"></i> {{ $post->created_at->format('d M Y') }} &nbsp;•&nbsp;
                        <i class="bi bi-eye me-1"></i> Dibaca {{ $post->views }} kali
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container mb-5">
    <div class="row justify-content-center">
        <div class="col-md-9">

            @if($post->image)
                <div class="mb-4 shadow-sm rounded overflow-hidden">
                    <img src="{{ asset('storage/' . $post->image) }}" class="w-100" alt="{{ $post->title }}">
                </div>
            @endif

            <article class="blog-post fs-5 lh-lg text-dark">
                {!! $post->content !!}
            </article>

            <hr class="my-5">

            <div class="d-flex justify-content-between">
                <a href="{{ url('/') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali ke Beranda
                </a>

                <div>
                    <span class="text-muted me-2 small">Bagikan:</span>
                    <a href="#" class="btn btn-sm btn-primary"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="btn btn-sm btn-success"><i class="bi bi-whatsapp"></i></a>
                    <a href="#" class="btn btn-sm btn-info"><i class="bi bi-twitter"></i></a>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
