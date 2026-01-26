@extends('layouts.admin')

@section('content')
{{-- Scroll Normal --}}
<div class="container-fluid p-4" style="background-color: #f8fafc; min-height: 100vh;">

    {{-- 1. HEADER HALAMAN --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 pb-3 border-bottom border-secondary border-opacity-10">
        <div>
            {{-- Judul dibuat warna Dark agar konsisten --}}
            <h4 class="fw-bold text-dark mb-1">
                Edit Menu: {{ $menu->name }}
            </h4>
            <p class="text-muted small mb-0">Perbarui informasi, hierarki, dan tautan menu navigasi Anda.</p>
        </div>
        <div class="d-flex gap-2 mt-3 mt-md-0">
            <a href="{{ route('menus.index') }}" class="btn btn-light btn-sm rounded-pill px-4 shadow-sm border fw-bold text-secondary hover-scale">
                <i class="bi bi-arrow-left me-2"></i>Kembali
            </a>
            <button type="button" class="btn btn-outline-danger btn-sm rounded-pill px-4 shadow-sm fw-bold hover-scale"
                    onclick="if(confirm('Yakin hapus menu ini? \nPERINGATAN: Semua anak menu di bawahnya juga akan terhapus.')) document.getElementById('delete-form').submit()">
                <i class="bi bi-trash me-2"></i>Hapus
            </button>
        </div>
    </div>

    {{-- 2. NOTIFIKASI ERROR --}}
    @if($errors->any())
        <div class="alert alert-danger border-0 shadow-sm rounded-4 mb-4 d-flex align-items-center bg-white border-start border-danger border-4">
            <div class="p-2 bg-danger bg-opacity-10 rounded-circle text-danger me-3">
                <i class="bi bi-exclamation-triangle-fill fs-5"></i>
            </div>
            <div>
                <strong class="text-dark small text-uppercase">Gagal Menyimpan:</strong>
                <ul class="mb-0 mt-1 text-muted small ps-3">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="row g-4">
        {{-- KOLOM KIRI: FORM EDIT UTAMA --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 bg-white mb-4" style="overflow: visible !important;">
                <div class="card-header bg-white py-3 px-4 border-bottom">
                    <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-pencil-square me-2 text-primary"></i>Konfigurasi Menu</h6>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('menus.update', $menu->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- LABEL MENU --}}
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-muted text-uppercase ls-1">Nama Label <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control form-control-lg border-0 bg-light fw-bold text-dark shadow-none"
                                   value="{{ old('name', $menu->name) }}" required placeholder="Contoh: Profil Dinas">
                        </div>

                        {{-- TARGET LINK (FULL LIST) --}}
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-muted text-uppercase ls-1">Target Link <span class="text-danger">*</span></label>

                            <select id="linkSelector" class="form-select mb-2 border-0 bg-light shadow-none py-2 px-3 fw-medium custom-select-down" onchange="fillUrl()">
                                <option value="">-- Pilih Pintasan Cepat (Opsional) --</option>
                                <option value="#"># (Folder Dropdown)</option>

                                <optgroup label="Halaman Utama">
                                    <option value="/">Beranda (Home)</option>
                                    <option value="{{ route('news.index') }}">Berita & Artikel</option>
                                    <option value="/page/kontak">Kontak Kami</option>
                                </optgroup>

                                <optgroup label="Informasi Publik">
                                    <option value="/dokumen/dip">DIP (Daftar Info Publik)</option>
                                    <option value="/dokumen/berkala">Info Berkala</option>
                                    <option value="/dokumen/serta-merta">Info Serta Merta</option>
                                    <option value="/dokumen/setiap-saat">Info Setiap Saat</option>
                                    <option value="/dokumen/dikecualikan">Info Dikecualikan</option>
                                </optgroup>

                                <optgroup label="Layanan & Regulasi">
                                    <option value="/dokumen/regulasi">Produk Hukum / Regulasi</option>
                                    <option value="/dokumen/sop">SOP Layanan</option>
                                    <option value="/page/tata-cara">Tata Cara Permohonan</option>
                                    <option value="{{ route('requests.create') }}">Formulir Permohonan</option>
                                    <option value="/cek-status">Cek Status Tiket</option>
                                    <option value="{{ route('objection.search') }}">Ajukan Keberatan</option>
                                </optgroup>

                                <optgroup label="Halaman Statis">
                                    @foreach($listHalaman as $page)
                                        <option value="/page/{{ $page->slug }}">{{ $page->title }}</option>
                                    @endforeach
                                </optgroup>

                                <option value="custom">Manual (Custom Link)</option>
                            </select>

                            <div class="input-group">
                                <span class="input-group-text bg-light border-0 text-muted"><i class="bi bi-link-45deg"></i></span>
                                <input type="text" name="url" id="urlInput" class="form-control bg-light border-0 shadow-none text-muted small"
                                       value="{{ old('url', $menu->url) }}" required placeholder="/page/profil atau #">
                            </div>
                        </div>

                        {{-- INDUK (PARENT) --}}
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-muted text-uppercase ls-1">Posisi Induk</label>
                            <select name="parent_id" class="form-select border-0 bg-light shadow-none py-2 px-3 fw-medium">
                                <option value="">◈ Jadikan Menu Utama (Root)</option>
                                @foreach($parentMenus as $parent)
                                    @if($parent->id != $menu->id)
                                        <option value="{{ $parent->id }}" {{ old('parent_id', $menu->parent_id) == $parent->id ? 'selected' : '' }} class="fw-bold text-primary">📂 {{ $parent->name }}</option>
                                        @if($parent->children)
                                            @foreach($parent->children as $child)
                                                @if($child->id != $menu->id)
                                                    <option value="{{ $child->id }}" {{ old('parent_id', $menu->parent_id) == $child->id ? 'selected' : '' }}>&nbsp;&nbsp;&nbsp;↳ {{ $child->name }} (Sub)</option>
                                                @endif
                                            @endforeach
                                        @endif
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        {{-- URUTAN --}}
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-muted text-uppercase ls-1">Nomor Urut</label>
                            <input type="number" name="order" class="form-control border-0 bg-light w-25 text-center fw-bold shadow-none"
                                   value="{{ old('order', $menu->order) }}" min="0">
                        </div>

                        <hr class="my-4 opacity-10">

                        <button type="submit" class="btn btn-primary px-5 py-2 fw-bold rounded-pill shadow-sm hover-scale">
                            <i class="bi bi-check-circle-fill me-2"></i>Simpan Perubahan
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- KOLOM KANAN: PANEL INFORMASI & PREVIEW (BERSIH) --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden mb-4">
                <div class="card-header bg-white py-3 px-4 border-bottom">
                    <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-info-circle me-2 text-primary"></i>Detail Sistem</h6>
                </div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <label class="small text-muted text-uppercase fw-bold d-block mb-1">ID Menu</label>
                        <span class="fs-5 fw-bold text-dark font-monospace">#{{ $menu->id }}</span>
                    </div>
                    <div class="mb-3">
                        <label class="small text-muted text-uppercase fw-bold d-block mb-1">Terdaftar Sejak</label>
                        <span class="text-dark small"><i class="bi bi-calendar-check me-2 text-muted"></i>{{ $menu->created_at->format('d M Y, H:i') }}</span>
                    </div>
                    <div class="mb-4 pb-3 border-bottom">
                        <label class="small text-muted text-uppercase fw-bold d-block mb-1">Induk Saat Ini</label>
                        <span class="badge bg-light text-primary border rounded-pill fw-bold">
                            {{ $menu->parent ? $menu->parent->name : '◈ Root (Utama)' }}
                        </span>
                    </div>

                    {{-- PREVIEW TANPA BUTTON --}}
                    <label class="small text-muted text-uppercase fw-bold d-block mb-2">Akan Mengarah Ke:</label>
                    <div class="p-3 bg-light rounded-4 border border-dashed text-center">
                        @if($menu->url == '#')
                            <i class="bi bi-diagram-2 fs-2 text-muted d-block mb-1"></i>
                            <span class="small fw-bold text-secondary">Dropdown Menu</span>
                        @else
                            <code class="text-primary small fw-bold text-break d-block">{{ $menu->url }}</code>
                        @endif
                    </div>
                </div>
            </div>

            {{-- ALERT SUB-MENU JIKA ADA --}}
            @if($menu->children->count() > 0)
                <div class="alert alert-warning border-0 shadow-sm rounded-4 p-4">
                    <div class="d-flex align-items-start">
                        <i class="bi bi-exclamation-triangle-fill fs-4 text-warning me-3"></i>
                        <div>
                            <h6 class="fw-bold text-dark mb-1 small text-uppercase">Memiliki Anak Menu</h6>
                            <p class="small text-muted mb-0 lh-sm">Menu ini terhubung dengan <strong>{{ $menu->children->count() }} sub-menu</strong>. Perubahan posisi induk akan memindahkan seluruh cabangnya.</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<form id="delete-form" action="{{ route('menus.destroy', $menu->id) }}" method="POST" class="d-none">
    @csrf @method('DELETE')
</form>

<script>
    function fillUrl() {
        let selector = document.getElementById('linkSelector');
        let input = document.getElementById('urlInput');
        let selectedValue = selector.value;
        input.classList.remove('bg-white', 'bg-light', 'text-muted');
        if (selectedValue === 'custom') {
            input.readOnly = false;
            input.classList.add('bg-white');
            input.focus();
        } else {
            input.value = selectedValue;
            input.readOnly = true;
            input.classList.add('bg-light', 'text-muted');
        }
    }
</script>

<style>
    body { background-color: #f8fafc; overflow-y: auto !important; }
    .ls-1 { letter-spacing: 0.5px; }
    .hover-scale { transition: transform 0.2s ease; }
    .hover-scale:hover { transform: translateY(-2px); }
    .border-dashed { border-style: dashed !important; border-width: 2px !important; border-color: #dee2e6 !important; }

    /* Paksa Dropdown terbuka ke bawah */
    .custom-select-down {
        appearance: none;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 0.75rem center;
        background-size: 16px 12px;
    }

    .form-control:focus, .form-select:focus {
        background-color: #fff !important;
        border: 1px solid #0d6efd !important;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.05);
    }
    .btn-primary { background-color: #0d6efd; border: none; }
    .btn-primary:hover { background-color: #0b5ed7; }
</style>
@endsection
