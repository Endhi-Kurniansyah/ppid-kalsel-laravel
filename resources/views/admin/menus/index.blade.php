@extends('layouts.admin')

@section('content')
<div class="container-fluid p-4" style="background-color: #f8fafc; min-height: 100vh;">

    {{-- 1. HEADER & ACTION --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 pb-3 border-bottom">
        <div>
            <h4 class="fw-bold text-dark mb-1">Manajemen Menu Navbar</h4>
            <p class="text-muted small mb-0">Atur hierarki (Induk/Anak/Cucu) dan tautan navigasi website utama.</p>
        </div>
        <div class="mt-3 mt-md-0">
            <span class="badge bg-primary bg-opacity-10 text-primary border border-primary px-3 py-2 rounded-pill shadow-sm fw-bold">
                <i class="bi bi-diagram-3-fill me-1"></i> Total: {{ $menus->count() }} Item
            </span>
        </div>
    </div>

    {{-- 2. NOTIFIKASI --}}
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 border-start border-success border-4 mb-4 rounded-3 bg-white" role="alert">
        <div class="d-flex align-items-center">
            <i class="bi bi-check-circle-fill text-success fs-5 me-3"></i>
            <div class="fw-medium text-dark">{{ session('success') }}</div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="row g-4">

        {{-- KOLOM KIRI: FORMULIR TAMBAH --}}
        <div class="col-lg-4 align-self-start">
            <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden">
                <div class="card-header bg-white py-3 px-4 border-bottom">
                    <h6 class="fw-bold text-dark mb-0"><i class="bi bi-plus-lg me-2 text-primary"></i>Tambah Menu Baru</h6>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('menus.store') }}" method="POST">
                        @csrf

                        {{-- LABEL MENU --}}
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted text-uppercase ls-1">Nama Label</label>
                            <input type="text" name="name" class="form-control border-0 bg-light py-2 px-3 fw-bold shadow-none" placeholder="Contoh: Tata Cara" required>
                        </div>

                        {{-- TARGET LINK --}}
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted text-uppercase ls-1">Target Link</label>
                            {{-- CSS custom-select-down ditambahkan agar dropdown tidak lari ke atas --}}
                            <select id="linkSelector" class="form-select mb-2 border-0 bg-light shadow-none py-2 px-3 custom-select-down" onchange="fillUrl()">
                                <option value="">-- Pilih Pintasan Cepat --</option>
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

                            <input type="text" name="url" id="urlInput" class="form-control border-0 bg-light text-muted small py-2 px-3 shadow-none" placeholder="URL otomatis..." required readonly style="font-size: 0.75rem;">
                        </div>

                        {{-- INDUK (PARENT) --}}
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted text-uppercase ls-1">Posisi Induk</label>
                            <select name="parent_id" class="form-select border-0 bg-light shadow-none py-2 px-3">
                                <option value="" class="fw-bold">◈ Menu Utama (Root)</option>
                                @foreach($parentMenus as $parent)
                                    <option value="{{ $parent->id }}" class="text-primary fw-bold">📂 {{ $parent->name }}</option>
                                    @if($parent->children)
                                        @foreach($parent->children as $child)
                                            <option value="{{ $child->id }}" class="text-dark">
                                                &nbsp;&nbsp;&nbsp;↳ {{ $child->name }} (Sub)
                                            </option>
                                        @endforeach
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        {{-- URUTAN --}}
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-muted text-uppercase ls-1">Nomor Urut</label>
                            <input type="number" name="order" class="form-control border-0 bg-light w-50 py-2 px-3 fw-bold shadow-none" value="0" min="0">
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2 fw-bold shadow-sm rounded-pill hover-scale">
                            <i class="bi bi-save2 me-2"></i>Simpan Konfigurasi
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- KOLOM KANAN: TABEL HIERARKI --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden">
                <div class="card-header bg-white py-3 px-4 border-bottom d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold text-dark mb-0"><i class="bi bi-list-nested me-2 text-primary"></i>Struktur Menu Aktif</h6>
                    <span class="text-muted small">Urutan: Kecil ke Besar</span>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr class="text-muted small text-uppercase fw-bold">
                                    <th class="ps-4 py-3 border-0" width="45%">Hierarki Menu</th>
                                    <th class="py-3 border-0" width="30%">Target Link</th>
                                    <th class="py-3 border-0 text-center" width="10%">Urutan</th>
                                    <th class="py-3 border-0 text-end pe-4" width="15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($menus as $menu)
                                    @php
                                        $level = 1;
                                        if($menu->parent_id) {
                                            $level = 2;
                                            if($menu->parent && $menu->parent->parent_id) { $level = 3; }
                                        }
                                    @endphp

                                    <tr>
                                        <td class="ps-4 py-3">
                                            <div class="d-flex align-items-center">
                                                @if($level == 1)
                                                    <div class="bg-primary bg-opacity-10 p-2 rounded-3 me-3 text-primary d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                                        <i class="bi bi-folder-fill"></i>
                                                    </div>
                                                    <span class="fw-bold text-dark">{{ $menu->name }}</span>
                                                @elseif($level == 2)
                                                    <div style="width: 32px;" class="me-3"></div>
                                                    <div class="text-muted opacity-25 me-3" style="border-left: 2px solid #ccc; height: 25px;"></div>
                                                    <i class="bi bi-arrow-return-right text-muted me-2"></i>
                                                    <span class="fw-medium text-secondary">{{ $menu->name }}</span>
                                                @elseif($level == 3)
                                                    <div style="width: 64px;" class="me-3"></div>
                                                    <div class="text-muted opacity-25 me-3" style="border-left: 2px solid #ccc; height: 25px;"></div>
                                                    <i class="bi bi-dot text-muted me-1 fs-4"></i>
                                                    <span class="text-muted small fst-italic">{{ $menu->name }}</span>
                                                @endif
                                            </div>
                                        </td>

                                        <td>
                                            @if($menu->url == '#')
                                                <span class="badge bg-light text-muted border rounded-pill px-3 py-1 fw-bold" style="font-size: 10px;">
                                                    <i class="bi bi-diagram-2 me-1"></i> DROPDOWN
                                                </span>
                                            @else
                                                <div class="d-flex align-items-center text-muted">
                                                    <i class="bi bi-link-45deg me-1 fs-5"></i>
                                                    <span class="small font-monospace text-primary text-truncate d-inline-block" style="max-width: 150px;">{{ $menu->url }}</span>
                                                </div>
                                            @endif
                                        </td>

                                        <td class="text-center">
                                            <span class="badge bg-light text-dark border px-3 py-1 rounded-pill fw-bold">{{ $menu->order }}</span>
                                        </td>

                                        <td class="text-end pe-4">
                                            <div class="d-flex justify-content-end gap-2">
                                                <a href="{{ route('menus.edit', $menu->id) }}" class="btn btn-sm btn-outline-warning rounded-circle d-flex align-items-center justify-content-center hover-scale" style="width: 32px; height: 32px;" title="Ubah Data">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                                <form action="{{ route('menus.destroy', $menu->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus menu ini beserta cabangnya?')">
                                                    @csrf @method('DELETE')
                                                    <button class="btn btn-sm btn-outline-danger rounded-circle d-flex align-items-center justify-content-center hover-scale" style="width: 32px; height: 32px;" title="Hapus Permanen">
                                                        <i class="bi bi-trash3"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-5">
                                            <div class="d-flex flex-column align-items-center opacity-50">
                                                <i class="bi bi-diagram-2 fs-1 mb-2 text-muted"></i>
                                                <h6 class="text-muted fw-bold">Belum ada menu</h6>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- SCRIPT ASLI MAS (UTUH) --}}
<script>
    function fillUrl() {
        let selector = document.getElementById('linkSelector');
        let input = document.getElementById('urlInput');
        let selectedValue = selector.value;
        input.classList.remove('bg-white', 'bg-light', 'text-muted');
        if (selectedValue === 'custom') {
            input.value = '';
            input.readOnly = false;
            input.classList.add('bg-white');
            input.focus();
            input.placeholder = 'https://...';
        } else {
            input.value = selectedValue;
            input.readOnly = true;
            input.classList.add('bg-light', 'text-muted');
        }
    }
</script>

<style>
    body { background-color: #f8fafc; }
    .ls-1 { letter-spacing: 0.5px; }
    .hover-scale { transition: transform 0.2s ease; }
    .hover-scale:hover { transform: scale(1.1); }
    .form-control:focus, .form-select:focus {
        background-color: #fff !important;
        border: 1px solid #0d6efd !important;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.05);
    }
    .btn-primary { background-color: #0d6efd; border: none; }
    .btn-primary:hover { background-color: #0b5ed7; }
</style>
@endsection
