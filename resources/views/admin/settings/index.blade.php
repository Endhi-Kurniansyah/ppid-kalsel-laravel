@extends('layouts.admin')

@section('content')
{{-- 
    CONTAINER: FIXED WIDTH (Container-XL)
    Agar tidak terlalu lebar di layar besar, memberikan fokus yang lebih baik.
--}}
<div class="container-fluid d-flex flex-column h-100 p-4" style="background-color: #f8fafc; overflow: hidden;">

    {{-- 1. HEADER HALAMAN --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-3 flex-shrink-0">
        <div>
            <h4 class="fw-bold text-dark mb-1">Konfigurasi Website</h4>
            <p class="text-muted small mb-0">Kelola identitas, kontak, dan pengaturan global sistem.</p>
        </div>
        <div>
            {{-- Tombol Simpan di Header (Pintasan) --}}
            <button type="submit" form="settingsForm" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm hover-scale" style="background-color: var(--primary); border-color: var(--primary);">
                <i class="bi bi-save2-fill me-2"></i>Simpan Perubahan
            </button>
        </div>
    </div>

    {{-- 2. NOTIFIKASI --}}
    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4 d-flex align-items-center bg-white border-start border-success border-4 animate-fade-in">
            <div class="bg-success bg-opacity-10 text-success rounded-circle p-2 me-3">
                <i class="bi bi-check-lg fs-5"></i>
            </div>
            <div class="text-dark fw-bold small">{{ session('success') }}</div>
            <button type="button" class="btn-close ms-auto small" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form id="settingsForm" action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="flex-grow-1 d-flex flex-column overflow-hidden">
        @csrf
        @method('PUT')

        <div class="row g-4 flex-grow-1 overflow-hidden">
            {{-- 3. SIDEBAR NAVIGATION --}}
            <div class="col-lg-3 flex-shrink-0">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
                    <div class="card-body p-2">
                        <div class="nav flex-column nav-pills gap-1" id="settingsTab" role="tablist">
                            <button class="nav-link active text-start py-3 px-3 rounded-3 fw-bold small text-uppercase d-flex align-items-center gap-3" data-bs-toggle="pill" data-bs-target="#tab-visual" type="button">
                                <div class="icon-box rounded-circle"><i class="bi bi-palette-fill"></i></div>
                                <span>Identitas Visual</span>
                            </button>
                            <button class="nav-link text-start py-3 px-3 rounded-3 fw-bold small text-uppercase d-flex align-items-center gap-3" data-bs-toggle="pill" data-bs-target="#tab-footer" type="button">
                                <div class="icon-box rounded-circle"><i class="bi bi-info-circle-fill"></i></div>
                                <span>Info Kontak</span>
                            </button>
                            <button class="nav-link text-start py-3 px-3 rounded-3 fw-bold small text-uppercase d-flex align-items-center gap-3" data-bs-toggle="pill" data-bs-target="#tab-social" type="button">
                                <div class="icon-box rounded-circle"><i class="bi bi-share-fill"></i></div>
                                <span>Sosial Media</span>
                            </button>
                            <button class="nav-link text-start py-3 px-3 rounded-3 fw-bold small text-uppercase d-flex align-items-center gap-3" data-bs-toggle="pill" data-bs-target="#tab-report" type="button">
                                <div class="icon-box rounded-circle"><i class="bi bi-file-earmark-pdf-fill"></i></div>
                                <span>Laporan PDF</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 4. CONTENT AREA --}}
            <div class="col-lg-9 h-100 overflow-hidden">
                <div class="tab-content h-100 overflow-auto pe-2" id="settingsTabContent" style="scrollbar-width: thin;">

                    {{-- TAB: IDENTITAS VISUAL --}}
                    <div class="tab-pane fade show active" id="tab-visual" role="tabpanel">
                        <div class="card border border-light shadow-none rounded-4 h-100 d-flex flex-column bg-white">
                            <div class="card-header bg-white py-3 px-4 border-bottom flex-shrink-0">
                                <h6 class="fw-bold text-dark mb-0">Logo & Branding</h6>
                            </div>
                            <div class="card-body p-4 flex-grow-1 overflow-auto custom-scrollbar">
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div class="p-3 border rounded-4 bg-light bg-opacity-50 h-100">
                                            <label class="fw-bold text-dark small text-uppercase mb-3 d-block ls-1">Logo Navbar (Header)</label>
                                            <div class="d-flex align-items-center justify-content-center p-3 bg-white rounded-3 border mb-3" style="height: 120px; border-style: dashed !important;">
                                                @if(isset($settings['site_logo']))
                                                    <img src="{{ asset('storage/' . $settings['site_logo']) }}" class="img-fluid" style="max-height: 60px;">
                                                @else
                                                    <small class="text-muted">Upload Logo</small>
                                                @endif
                                            </div>
                                            <input type="file" name="site_logo" class="form-control form-control-sm bg-white">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="p-3 border rounded-4 bg-dark h-100">
                                            <label class="fw-bold text-white-50 small text-uppercase mb-3 d-block ls-1">Logo Footer</label>
                                            <div class="d-flex align-items-center justify-content-center p-3 bg-white bg-opacity-10 rounded-3 border border-secondary mb-3" style="height: 120px; border-style: dashed !important;">
                                                @if(isset($settings['footer_logo']))
                                                    <img src="{{ asset('storage/' . $settings['footer_logo']) }}" class="img-fluid" style="max-height: 60px;">
                                                @else
                                                    <small class="text-white-50">Upload Logo Putih</small>
                                                @endif
                                            </div>
                                            <input type="file" name="footer_logo" class="form-control form-control-sm bg-white bg-opacity-10 text-white border-secondary">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="p-3 border rounded-4 bg-white">
                                            <label class="fw-bold text-dark small text-uppercase mb-2 d-block ls-1">Hero Background (Beranda)</label>
                                            <div class="row align-items-center">
                                                <div class="col-md-4">
                                                    <div class="rounded-3 overflow-hidden border bg-light d-flex align-items-center justify-content-center" style="height: 100px;">
                                                        @if(isset($settings['hero_bg']))
                                                            <img src="{{ asset('storage/' . $settings['hero_bg']) }}" class="img-fluid w-100 h-100 object-fit-cover">
                                                        @else
                                                            <small class="text-muted">No Image</small>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-8">
                                                    <input type="file" name="hero_bg" class="form-control mb-1">
                                                    <small class="text-muted d-block">Ukuran ideal: 1920x1080 px (Landscape).</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- TAB: INFO KONTAK --}}
                    <div class="tab-pane fade" id="tab-footer" role="tabpanel">
                        <div class="card border border-light shadow-none rounded-4 h-100 d-flex flex-column bg-white">
                            <div class="card-header bg-white py-3 px-4 border-bottom flex-shrink-0">
                                <h6 class="fw-bold text-dark mb-0">Informasi Kontak & Operasional</h6>
                            </div>
                            <div class="card-body p-4 flex-grow-1 overflow-auto custom-scrollbar">
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold text-muted text-uppercase">Jam Layanan (Senin-Kamis)</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-0"><i class="bi bi-clock"></i></span>
                                            <input type="text" name="footer_hours_weekday" class="form-control bg-light border-0 fw-bold" value="{{ $settings['footer_hours_weekday'] ?? '08:00 - 16:00' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold text-muted text-uppercase">Jam Layanan (Jumat)</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-0"><i class="bi bi-clock-history"></i></span>
                                            <input type="text" name="footer_hours_friday" class="form-control bg-light border-0 fw-bold" value="{{ $settings['footer_hours_friday'] ?? '08:00 - 11:00' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold text-muted text-uppercase">Telepon / WhatsApp</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-0"><i class="bi bi-telephone"></i></span>
                                            <input type="text" name="footer_phone" class="form-control bg-light border-0 fw-bold" value="{{ $settings['footer_phone'] ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold text-muted text-uppercase">Email Resmi</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-0"><i class="bi bi-envelope"></i></span>
                                            <input type="email" name="footer_email" class="form-control bg-light border-0 fw-bold" value="{{ $settings['footer_email'] ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label small fw-bold text-muted text-uppercase">Alamat Lengkap</label>
                                        <textarea name="footer_address" class="form-control bg-light border-0 fw-medium" rows="2">{{ $settings['footer_address'] ?? '' }}</textarea>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label small fw-bold text-muted text-uppercase">Embed Google Maps</label>
                                        <textarea name="contact_google_maps_link" class="form-control bg-light border-0 font-monospace small text-muted" rows="3" placeholder="<iframe src='...'></iframe>">{{ $settings['contact_google_maps_link'] ?? '' }}</textarea>
                                        <div class="form-text text-muted small"><i class="bi bi-info-circle me-1"></i>Copy kode 'Embed a map' dari Google Maps, bukan link share biasa.</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- TAB: SOSIAL MEDIA --}}
                    <div class="tab-pane fade" id="tab-social" role="tabpanel">
                        <div class="card border border-light shadow-none rounded-4 h-100 d-flex flex-column bg-white">
                            <div class="card-header bg-white py-3 px-4 border-bottom flex-shrink-0">
                                <h6 class="fw-bold text-dark mb-0">Tautan Media Sosial</h6>
                            </div>
                            <div class="card-body p-4 flex-grow-1 overflow-auto custom-scrollbar">
                                <div class="row g-3">
                                    @php
                                        $socials = [
                                            ['name' => 'social_facebook', 'label' => 'Facebook', 'icon' => 'bi-facebook', 'color' => '#1877F2', 'ph' => 'facebook.com/...'],
                                            ['name' => 'social_instagram', 'label' => 'Instagram', 'icon' => 'bi-instagram', 'color' => '#E4405F', 'ph' => 'instagram.com/...'],
                                            ['name' => 'social_twitter', 'label' => 'X (Twitter)', 'icon' => 'bi-twitter-x', 'color' => '#000000', 'ph' => 'x.com/...'],
                                            ['name' => 'social_youtube', 'label' => 'YouTube', 'icon' => 'bi-youtube', 'color' => '#FF0000', 'ph' => 'youtube.com/...'],
                                        ];
                                    @endphp
                                    @foreach($socials as $soc)
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center p-2 border rounded-4 bg-white hover-scale">
                                            <div class="rounded-3 d-flex align-items-center justify-content-center p-3 me-3" style="background-color: {{ $soc['color'] }}15; color: {{ $soc['color'] }}; width: 50px; height: 50px;">
                                                <i class="bi {{ $soc['icon'] }} fs-4"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <label class="small fw-bold text-muted text-uppercase mb-0" style="font-size: 0.65rem;">{{ $soc['label'] }}</label>
                                                <input type="url" name="{{ $soc['name'] }}" class="form-control form-control-sm border-0 shadow-none ps-0 fw-bold text-dark" value="{{ $settings[$soc['name']] ?? '' }}" placeholder="{{ $soc['ph'] }}">
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- TAB: LAPORAN PDF --}}
                    <div class="tab-pane fade" id="tab-report" role="tabpanel">
                        <div class="card border border-light shadow-none rounded-4 h-100 d-flex flex-column bg-white">
                            <div class="card-header bg-white py-3 px-4 border-bottom flex-shrink-0">
                                <h6 class="fw-bold text-dark mb-0">Format Kop Laporan</h6>
                            </div>
                            <div class="card-body p-4 flex-grow-1 overflow-auto custom-scrollbar">
                                <div class="row g-3 mb-4">
                                    <div class="col-12">
                                        <label class="form-label small fw-bold text-muted text-uppercase">Alamat Kop Surat</label>
                                        <textarea name="report_header_address" class="form-control bg-light border-0 fw-medium" rows="2" placeholder="Jl. Dharma Praja No. 1...">{{ $settings['report_header_address'] ?? '' }}</textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold text-muted text-uppercase">Laman (Website)</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-0"><i class="bi bi-globe"></i></span>
                                            <input type="text" name="report_header_website" class="form-control bg-light border-0 fw-bold" value="{{ $settings['report_header_website'] ?? '' }}" placeholder="diskominfomc.kalselprov.go.id">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold text-muted text-uppercase">Email</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-0"><i class="bi bi-envelope"></i></span>
                                            <input type="email" name="report_header_email" class="form-control bg-light border-0 fw-bold" value="{{ $settings['report_header_email'] ?? '' }}" placeholder="diskominfo@kalselprov.go.id">
                                        </div>
                                    </div>
                                </div>
                                <h6 class="fw-bold text-primary small text-uppercase mb-3 mt-4 border-bottom pb-2">Penanda Tangan (Pejabat)</h6>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold text-muted">Nama Lengkap</label>
                                        <input type="text" name="report_signer_name" class="form-control bg-light border-0 fw-bold" value="{{ $settings['report_signer_name'] ?? '' }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold text-muted">NIP</label>
                                        <input type="text" name="report_signer_nip" class="form-control bg-light border-0 fw-bold font-monospace" value="{{ $settings['report_signer_nip'] ?? '' }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold text-muted">Jabatan</label>
                                        <input type="text" name="report_signer_position" class="form-control bg-light border-0 fw-bold" value="{{ $settings['report_signer_position'] ?? '' }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold text-muted">Pangkat/Golongan</label>
                                        <input type="text" name="report_signer_rank" class="form-control bg-light border-0 fw-bold" value="{{ $settings['report_signer_rank'] ?? '' }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </form>
</div>

{{-- CSS KHUSUS --}}
<style>
    /* Paksa Body Tidak Scroll */
    html, body { height: 100%; overflow: hidden !important; background-color: #f8fafc; }

    /* Scrollbar Halus */
    .custom-scrollbar::-webkit-scrollbar { width: 5px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }

    /* Premium Styling */
    .icon-box {
        width: 32px; height: 32px;
        display: flex; align-items: center; justify-content: center;
        background-color: #f1f5f9; color: #64748b;
        transition: all 0.2s;
    }

    .nav-pills .nav-link {
        color: #64748b;
        background: transparent;
        transition: all 0.2s;
    }

    .nav-pills .nav-link:hover {
        background-color: #f8fafc;
        color: #0d6efd;
    }
    .nav-pills .nav-link:hover .icon-box {
        background-color: #e0f2fe; color: #0d6efd;
    }

    /* Layout Fixes */
    .tab-content { height: 100%; }
    .tab-pane { height: 100%; display: flex; flex-direction: column; min-height: 0; }
    .card { min-height: 0; }
    
    /* Hide Global Footer on this page to prevent scrolling */
    footer { display: none !important; }

    .nav-pills .nav-link.active {
        background-color: var(--primary) !important; /* Use System Primary Color */
        color: white !important;
        box-shadow: 0 4px 12px rgba(67, 97, 238, 0.3);
    }
    .nav-pills .nav-link.active .icon-box {
        background-color: rgba(255,255,255,0.2) !important; 
        color: white !important;
    }

    .hover-scale { transition: transform 0.2s; }
    .hover-scale:hover { transform: translateY(-2px); }
    
    .form-control:focus {
        box-shadow: none; border-bottom: 2px solid #0d6efd !important;
        background-color: #fff !important;
    }
    .ls-1 { letter-spacing: 0.5px; }

    .object-fit-cover { object-fit: cover; }
    
    .animate-fade-in { animation: fadeIn 0.5s ease-in-out; }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endsection
