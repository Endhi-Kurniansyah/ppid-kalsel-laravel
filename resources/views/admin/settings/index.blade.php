@extends('layouts.admin')

@section('content')
{{-- Scroll Normal --}}
<div class="container-fluid p-4" style="background-color: #f8fafc; min-height: 100vh;">

    {{-- 1. HEADER HALAMAN --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 pb-3 border-bottom border-secondary border-opacity-10">
        <div>
            <h4 class="fw-bold text-dark mb-1">Konfigurasi Website</h4>
            <p class="text-muted small mb-0">Atur identitas visual, informasi kontak, dan media sosial portal publik.</p>
        </div>
    </div>

    {{-- 2. NOTIFIKASI --}}
    @if(session('success'))
        <div class="alert alert-success border-0 shadow-none rounded-3 mb-4 d-flex align-items-center bg-white border-start border-success border-4">
            <i class="bi bi-check-circle-fill me-3 fs-5 text-success"></i>
            <div class="text-dark fw-medium small"><strong>Berhasil!</strong> {{ session('success') }}</div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- 3. MAIN CARD (FLAT DESIGN) --}}
    <div class="card border border-light shadow-none rounded-4 overflow-hidden bg-white">
        <div class="card-body p-0">
            <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row g-0">
                    {{-- SIDE NAV TABS --}}
                    <div class="col-md-3 border-end bg-light bg-opacity-30">
                        <div class="nav flex-column nav-pills p-3 gap-2" id="settingsTab" role="tablist">
                            <button class="nav-link active text-start py-3 px-4 border-0 rounded-3 fw-bold small text-uppercase ls-1" data-bs-toggle="pill" data-bs-target="#tab-visual" type="button">
                                <i class="bi bi-palette me-2"></i> Identitas Visual
                            </button>
                            <button class="nav-link text-start py-3 px-4 border-0 rounded-3 fw-bold small text-uppercase ls-1" data-bs-toggle="pill" data-bs-target="#tab-footer" type="button">
                                <i class="bi bi-info-square me-2"></i> Informasi Footer
                            </button>
                            <button class="nav-link text-start py-3 px-4 border-0 rounded-3 fw-bold small text-uppercase ls-1" data-bs-toggle="pill" data-bs-target="#tab-social" type="button">
                                <i class="bi bi-share me-2"></i> Media Sosial
                            </button>
                        </div>
                    </div>

                    {{-- CONTENT AREA --}}
                    <div class="col-md-9">
                        <div class="tab-content p-4 p-md-5" id="settingsTabContent">

                            {{-- TAB: IDENTITAS VISUAL --}}
                            <div class="tab-pane fade show active" id="tab-visual" role="tabpanel">
                                <h6 class="fw-bold text-dark mb-4 border-bottom pb-2 text-uppercase ls-1">Logo & Branding</h6>
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div class="p-4 border border-light rounded-4 bg-white">
                                            <label class="fw-bold text-muted small text-uppercase mb-3 d-block ls-1">Logo Navbar (Terang)</label>
                                            <div class="d-flex align-items-center p-3 bg-light rounded-4 mb-3 border border-dashed" style="min-height: 140px;">
                                                @if(isset($settings['site_logo']))
                                                    <img src="{{ asset('storage/' . $settings['site_logo']) }}" class="img-fluid mx-auto d-block" style="max-height: 70px;">
                                                @else
                                                    <div class="text-center w-100 text-muted opacity-50 small"><i class="bi bi-image fs-1 d-block mb-1"></i> Belum ada logo</div>
                                                @endif
                                            </div>
                                            <input type="file" name="site_logo" class="form-control form-control-sm bg-light border-0 shadow-none">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="p-4 border-0 rounded-4 bg-dark shadow-none">
                                            <label class="fw-bold text-white-50 small text-uppercase mb-3 d-block ls-1">Logo Footer (Gelap)</label>
                                            <div class="d-flex align-items-center p-3 bg-white bg-opacity-10 rounded-4 mb-3 border border-secondary border-dashed" style="min-height: 140px;">
                                                @if(isset($settings['footer_logo']))
                                                    <img src="{{ asset('storage/' . $settings['footer_logo']) }}" class="img-fluid mx-auto d-block" style="max-height: 70px;">
                                                @else
                                                    <div class="text-center w-100 text-white-50 opacity-50 small"><i class="bi bi-image fs-1 d-block mb-1"></i> Belum ada logo</div>
                                                @endif
                                            </div>
                                            <input type="file" name="footer_logo" class="form-control form-control-sm bg-white bg-opacity-10 text-white border-0 shadow-none">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="p-4 border border-light rounded-4 bg-white mt-2">
                                            <label class="fw-bold text-muted small text-uppercase mb-3 d-block ls-1">Background Hero (Halaman Utama)</label>
                                            <div class="row g-4 align-items-center">
                                                <div class="col-md-5">
                                                    @if(isset($settings['hero_bg']))
                                                        <div class="rounded-4 overflow-hidden border border-light shadow-none">
                                                            <img src="{{ asset('storage/' . $settings['hero_bg']) }}" class="img-fluid d-block" style="max-height: 160px; width: 100%; object-fit: cover;">
                                                        </div>
                                                    @else
                                                        <div class="bg-light rounded-4 d-flex align-items-center justify-content-center border border-dashed" style="height: 160px;">
                                                            <span class="text-muted small opacity-50">Belum ada gambar</span>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="col-md-7">
                                                    <input type="file" name="hero_bg" class="form-control bg-light border-0 shadow-none py-2 mb-2">
                                                    <small class="text-muted d-block">Rekomendasi ukuran: 1920 x 1080 pixel (HD) untuk hasil maksimal di desktop.</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- TAB: INFORMASI FOOTER --}}
                            <div class="tab-pane fade" id="tab-footer" role="tabpanel">
                                <h6 class="fw-bold text-dark mb-4 border-bottom pb-2 text-uppercase ls-1">Kontak & Operasional</h6>
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div class="p-4 border border-light rounded-4 bg-white">
                                            <h6 class="fw-bold mb-4 small text-primary text-uppercase ls-1"><i class="bi bi-clock me-2"></i>Jam Layanan</h6>
                                            <div class="mb-3">
                                                <label class="form-label small fw-bold text-muted">Senin - Kamis</label>
                                                <input type="text" name="footer_hours_weekday" class="form-control border-0 bg-light shadow-none" value="{{ $settings['footer_hours_weekday'] ?? '08:00 - 16:00' }}">
                                            </div>
                                            <div>
                                                <label class="form-label small fw-bold text-muted">Jumat</label>
                                                <input type="text" name="footer_hours_friday" class="form-control border-0 bg-light shadow-none" value="{{ $settings['footer_hours_friday'] ?? '08:00 - 11:00' }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="p-4 border border-light rounded-4 bg-white">
                                            <h6 class="fw-bold mb-4 small text-primary text-uppercase ls-1"><i class="bi bi-telephone me-2"></i>Kontak Kantor</h6>
                                            <div class="mb-3">
                                                <label class="form-label small fw-bold text-muted">WhatsApp / Telepon</label>
                                                <input type="text" name="footer_phone" class="form-control border-0 bg-light shadow-none" value="{{ $settings['footer_phone'] ?? '' }}">
                                            </div>
                                            <div>
                                                <label class="form-label small fw-bold text-muted">Email Resmi</label>
                                                <input type="email" name="footer_email" class="form-control border-0 bg-light shadow-none" value="{{ $settings['footer_email'] ?? '' }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="p-4 border border-light rounded-4 bg-white">
                                            <label class="fw-bold text-muted small text-uppercase mb-3 d-block ls-1">Alamat Kantor Lengkap</label>
                                            <textarea name="footer_address" class="form-control border-0 bg-light shadow-none" rows="4">{{ $settings['footer_address'] ?? '' }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- TAB: MEDIA SOSIAL --}}
                            <div class="tab-pane fade" id="tab-social" role="tabpanel">
                                <h6 class="fw-bold text-dark mb-4 border-bottom pb-2 text-uppercase ls-1">Media Sosial</h6>
                                <div class="row g-3">
                                    @php
                                        $socials = [
                                            ['name' => 'social_facebook', 'label' => 'Facebook', 'icon' => 'bi-facebook', 'color' => '#1877F2'],
                                            ['name' => 'social_instagram', 'label' => 'Instagram', 'icon' => 'bi-instagram', 'color' => '#E4405F'],
                                            ['name' => 'social_twitter', 'label' => 'Twitter / X', 'icon' => 'bi-twitter-x', 'color' => '#000000'],
                                            ['name' => 'social_youtube', 'label' => 'Youtube', 'icon' => 'bi-youtube', 'color' => '#FF0000'],
                                        ];
                                    @endphp
                                    @foreach($socials as $social)
                                    <div class="col-md-6">
                                        <div class="p-3 border border-light rounded-4 d-flex align-items-center gap-3 bg-white">
                                            <div class="p-3 rounded-circle bg-light d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; color: {{ $social['color'] }};">
                                                <i class="bi {{ $social['icon'] }} fs-4"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <label class="small fw-bold text-muted text-uppercase mb-1 d-block" style="font-size: 0.65rem;">{{ $social['label'] }} URL</label>
                                                <input type="url" name="{{ $social['name'] }}" class="form-control border-0 bg-light shadow-none py-1" value="{{ $settings[$social['name']] ?? '' }}" placeholder="https://...">
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="mt-5 pt-4 border-top d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary px-5 py-2 fw-bold rounded-pill shadow-none hover-scale">
                                    <i class="bi bi-save2-fill me-2"></i> Simpan Konfigurasi
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    /* Styling Body */
    body { background-color: #f8fafc; overflow-y: auto !important; }

    /* Tabs Styling - Flat & Clean */
    .nav-pills .nav-link {
        color: #64748b;
        transition: all 0.2s ease;
        border: 1px solid transparent !important;
    }
    .nav-pills .nav-link.active {
        background-color: #0d6efd !important;
        color: white !important;
        box-shadow: none !important;
    }
    .nav-pills .nav-link:not(.active):hover {
        background-color: #f1f5f9;
        color: #0f172a;
    }

    /* Form UI */
    .form-control:focus {
        background-color: #fff !important;
        border: 1px solid #0d6efd !important;
    }

    .border-dashed { border-style: dashed !important; border-width: 2px !important; border-color: #e2e8f0 !important; }

    .ls-1 { letter-spacing: 0.5px; }
    .hover-scale { transition: transform 0.2s ease; }
    .hover-scale:hover { transform: translateY(-2px); }

    /* Button Primary Custom */
    .btn-primary { background-color: #0d6efd; border: none; }
    .btn-primary:hover { background-color: #0b5ed7; }
</style>
@endsection
