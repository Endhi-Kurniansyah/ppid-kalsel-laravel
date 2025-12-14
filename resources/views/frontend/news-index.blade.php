@extends('layouts.frontend')

@section('content')

<div class="bg-light py-5 mb-5">
    <div class="container text-center">
        <h1 class="fw-bold text-primary">Kabar PPID</h1>
        <p class="text-muted">Informasi terkini dan kegiatan Dinas Kominfo Kalsel</p>
    </div>
</div>

<div class="container mb-5">

    <div class="row justify-content-center mb-5">
        <div class="col-md-6">
            <form action="" method="GET">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Cari berita..." name="q">
                    <button class="btn btn-primary" type="button"><i class="bi bi-search"></i></button>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        @forelse($posts as $post)
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm border-0 hover-card">
                <div class="position-relative">
                    @if($post->image)
                        <img src="{{ asset('storage/' . $post->image) }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                    @else
                        <img src="https://via.placeholder.com/400x200?text=No+Image" class="card-img-top" style="height: 200px; object-fit: cover;">
                    @endif

                    <span class="badge bg-primary position-absolute top-0 start-0 m-3">
                        {{ $post->category->name ?? 'Berita' }}
                    </span>
                </div>

                <div class="card-body">
                    <small class="text-muted d-block mb-2">
                        <i class="bi bi-calendar-event"></i> {{ $post->created_at->format('d M Y') }}
                    </small>

                    <h5 class="card-title fw-bold">
                        <a href="{{ route('news.show', $post->slug) }}" class="text-decoration-none text-dark stretched-link">
                            {{ Str::limit($post->title, 60) }}
                        </a>
                    </h5>

                    <p class="card-text text-muted small">
                        {{ Str::limit(strip_tags($post->content), 100) }}
                    </p>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <img src="https://cdni.iconscout.com/illustration/premium/thumb/empty-state-2130362-1800926.png" style="width: 200px; opacity: 0.5;">
            <p class="mt-3 text-muted">Belum ada berita yang diterbitkan.</p>
        </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $posts->links() }}
    </div>

</div>
@endsection
