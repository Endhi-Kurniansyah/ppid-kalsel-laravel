@extends('layouts.admin')

@section('content')
<div class="container-fluid p-4" style="background-color: #f8fafc; min-height: 100vh;">

    {{-- 1. HEADER --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 pb-3 border-bottom border-secondary border-opacity-10">
        <div>
            <h4 class="fw-bold text-dark mb-1">Galeri Multimedia</h4>
            <p class="text-muted small mb-0">Kelola dokumentasi kegiatan dan publikasi visual.</p>
        </div>
        <div class="mt-3 mt-md-0">
            <button class="btn btn-primary btn-sm rounded-pill px-4 shadow-sm fw-bold d-flex align-items-center gap-2 hover-scale" data-bs-toggle="modal" data-bs-target="#addGalleryModal" style="background-color: #0d6efd;">
                <i class="bi bi-cloud-plus-fill"></i> Upload Foto
            </button>
        </div>
    </div>

    {{-- 2. NOTIFIKASI --}}
    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-3 mb-4 py-2 px-3 d-flex align-items-center bg-white border-start border-success border-4">
            <i class="bi bi-check-circle-fill me-2 text-success"></i>
            <div class="text-dark fw-medium small">{{ session('success') }}</div>
            <button type="button" class="btn-close ms-auto small" data-bs-dismiss="alert"></button>
        </div>
    @endif
    
    @if($errors->any())
        <div class="alert alert-danger border-0 shadow-sm rounded-3 mb-4 py-2 px-3 bg-white border-start border-danger border-4">
            <ul class="mb-0 small text-danger fw-bold ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- 3. GRID GALERI --}}
    <div class="row g-4 section-animation">
        @forelse($galleries as $gallery)
        <div class="col-md-4 col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden hover-shadow transition-all bg-white group-action">
                {{-- Image Thumbnail --}}
                <div class="position-relative overflow-hidden" style="height: 200px;">
                    <img src="{{ asset('storage/' . $gallery->file_path) }}" class="w-100 h-100 object-fit-cover transition-transform" role="button" onclick="showLightbox('{{ asset('storage/' . $gallery->file_path) }}', '{{ $gallery->title }}')">
                    
                    {{-- Overlay Gradient --}}
                    <div class="position-absolute bottom-0 start-0 w-100 p-3 bg-gradient-dark text-white d-flex justify-content-between align-items-end" style="background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);">
                        <small class="opacity-75" style="font-size: 0.65rem;">{{ $gallery->created_at->format('d M Y') }}</small>
                    </div>

                    {{-- Action Buttons (Absolute Top Left) --}}
                    <!--div class="position-absolute top-0 end-0 p-2 d-none group-action-show">
                         Action buttons moved to footer/modal for cleaner look or overlay
                    </div-->
                </div>

                {{-- Content --}}
                <div class="card-body p-3 d-flex flex-column">
                    <h6 class="fw-bold text-dark mb-1 text-truncate" title="{{ $gallery->title }}">{{ $gallery->title }}</h6>
                    <p class="text-muted small mb-3 flex-grow-1" style="font-size: 0.75rem; line-height: 1.4;">
                        {{ \Illuminate\Support\Str::limit($gallery->description, 60) ?: 'Tidak ada deskripsi' }}
                    </p>
                    
                    <div class="d-flex justify-content-between align-items-center pt-2 border-top border-light">
                        <button class="btn btn-sm btn-light rounded-circle text-primary hover-scale border-0" style="width: 32px; height: 32px;"
                                data-bs-toggle="modal" data-bs-target="#editGalleryModal{{ $gallery->id }}">
                            <i class="bi bi-pencil-fill" style="font-size: 0.8rem;"></i>
                        </button>
                        
                        <form action="{{ route('galleries.destroy', $gallery->id) }}" method="POST" onsubmit="return confirmDelete(event)">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-light rounded-circle text-danger hover-scale border-0" style="width: 32px; height: 32px;">
                                <i class="bi bi-trash3-fill" style="font-size: 0.8rem;"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- EDIT MODAL --}}
        <div class="modal fade" id="editGalleryModal{{ $gallery->id }}" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg rounded-4">
                    <form action="{{ route('galleries.update', $gallery->id) }}" method="POST">
                        @csrf @method('PUT')
                        <div class="modal-body p-4">
                            <h6 class="fw-bold text-dark mb-3">Edit Informasi Foto</h6>
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted text-uppercase">Judul</label>
                                <input type="text" name="title" class="form-control border-0 bg-light shadow-none fw-bold" value="{{ $gallery->title }}" required>
                            </div>
                            <div class="mb-0">
                                <label class="form-label small fw-bold text-muted text-uppercase">Deskripsi</label>
                                <textarea name="description" class="form-control border-0 bg-light shadow-none" rows="3">{{ $gallery->description }}</textarea>
                            </div>
                        </div>
                        <div class="modal-footer border-0 p-3 pt-0">
                            <button type="button" class="btn btn-light rounded-pill px-4 small fw-bold" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary rounded-pill px-4 small fw-bold shadow-none">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @empty
        <div class="col-12 text-center py-5">
            <div class="opacity-25 mb-3 text-secondary"><i class="bi bi-images display-1"></i></div>
            <h6 class="text-secondary fw-bold">Belum ada foto</h6>
            <p class="text-muted small mb-0">Upload foto dokumentasi kegiatan terbaru.</p>
        </div>
        @endforelse
    </div>

    {{-- 4. PAGINATION --}}
    @if($galleries->hasPages())
    <div class="mt-4 d-flex justify-content-center">
        {{ $galleries->links('pagination::bootstrap-5') }}
    </div>
    @endif

</div>

{{-- MODAL TAMBAH --}}
<div class="modal fade" id="addGalleryModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <form action="{{ route('galleries.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header border-bottom py-3 bg-white">
                    <h6 class="modal-title fw-bold text-dark"><i class="bi bi-cloud-arrow-up me-2 text-primary"></i>Upload Foto Baru</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted text-uppercase">File Gambar</label>
                        <input type="file" name="image" class="form-control border bg-light shadow-none" accept="image/*" required>
                        <small class="text-muted" style="font-size: 0.7rem;">Maksimal 5MB (JPG, PNG).</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted text-uppercase">Judul</label>
                        <input type="text" name="title" class="form-control border-0 bg-light shadow-none fw-bold" placeholder="Judul kegiatan..." required>
                    </div>
                    <div class="mb-0">
                        <label class="form-label small fw-bold text-muted text-uppercase">Deskripsi (Opsional)</label>
                        <textarea name="description" class="form-control border-0 bg-light shadow-none" rows="3" placeholder="Keterangan singkat..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-top p-3 bg-white">
                    <button type="button" class="btn btn-light rounded-pill px-4 small fw-bold" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 small fw-bold shadow-none">Upload Sekarang</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- LIGHTBOX MODAL --}}
<div class="modal fade" id="lightboxModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content bg-transparent border-0 shadow-none">
            <div class="modal-body p-0 position-relative text-center">
                <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3 z-3" data-bs-dismiss="modal" aria-label="Close"></button>
                <img id="lightboxImage" src="" class="img-fluid rounded-4 shadow-lg" style="max-height: 80vh;">
                <h6 id="lightboxTitle" class="text-white mt-3 fw-bold text-shadow"></h6>
            </div>
        </div>
    </div>
</div>

<script>
    function showLightbox(src, title) {
        document.getElementById('lightboxImage').src = src;
        document.getElementById('lightboxTitle').innerText = title;
        new bootstrap.Modal(document.getElementById('lightboxModal')).show();
    }
</script>

<style>
    /* Styling Body */
    body { background-color: #f8fafc; overflow-y: auto !important; }

    .object-fit-cover { object-fit: cover; }
    
    .hover-shadow:hover { box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important; transform: translateY(-3px); }
    .transition-all { transition: all 0.3s ease; }
    
    .card:hover .transition-transform { transform: scale(1.05); }
    .transition-transform { transition: transform 0.5s ease; }

    .hover-scale { transition: transform 0.2s; }
    .hover-scale:hover { transform: scale(1.1); }
    
    .text-shadow { text-shadow: 0 2px 4px rgba(0,0,0,0.5); }
    
    /* Animation */
    .section-animation { animation: fadeInUp 0.5s ease-out; }
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    
    .btn-primary { background-color: #0d6efd; border: none; }
    .btn-primary:hover { background-color: #0b5ed7; }
</style>
@endsection
