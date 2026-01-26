{{-- FOOTER --}}
<footer>
    <div class="container">
        <div class="row gy-5"> {{-- Jarak antar kolom lebih lega (gy-5) --}}

            {{-- Kolom 1: Identitas --}}
            <div class="col-lg-4 col-md-6">
                <div class="d-flex align-items-center mb-4">
                    <img src="{{ isset($globalSettings['footer_logo']) ? asset('storage/' . $globalSettings['footer_logo']) : (isset($globalSettings['site_logo']) ? asset('storage/' . $globalSettings['site_logo']) : asset('assets/static/images/logo/favicon.svg')) }}"
                         alt="Logo Footer" style="height: 55px;" class="me-3">

                    <div>
                        <h6 class="fw-bold text-white m-0 ls-1">PPID KALSEL</h6>
                        <small class="text-warning" style="font-size: 0.7rem; letter-spacing: 0.5px;">PROVINSI KALIMANTAN SELATAN</small>
                    </div>
                </div>

                <p class="opacity-75 mb-4" style="line-height: 1.8;">
                    Memberikan layanan informasi publik yang transparan, cepat, tepat, dan akuntabel untuk seluruh masyarakat.
                </p>

                <div class="d-flex">
                    @if(!empty($globalSettings['social_facebook'])) <a href="{{ $globalSettings['social_facebook'] }}" class="social-link" target="_blank"><i class="bi bi-facebook"></i></a> @endif
                    @if(!empty($globalSettings['social_instagram'])) <a href="{{ $globalSettings['social_instagram'] }}" class="social-link" target="_blank"><i class="bi bi-instagram"></i></a> @endif
                    @if(!empty($globalSettings['social_twitter'])) <a href="{{ $globalSettings['social_twitter'] }}" class="social-link" target="_blank"><i class="bi bi-twitter-x"></i></a> @endif
                    @if(!empty($globalSettings['social_youtube'])) <a href="{{ $globalSettings['social_youtube'] }}" class="social-link" target="_blank"><i class="bi bi-youtube"></i></a> @endif
                </div>
            </div>

            {{-- Kolom 2: JELAJAHI (Sudah tanpa titik, pakai panah) --}}
            <div class="col-lg-2 col-md-6">
                <h6 class="footer-header">Jelajahi</h6>
                <ul class="footer-links">
                    <li><a href="{{ url('/') }}"><i class="bi bi-chevron-right me-2"></i> Beranda</a></li>
                    <li><a href="{{ route('news.index') }}"><i class="bi bi-chevron-right me-2"></i> Berita Terkini</a></li>
                    <li><a href="{{ route('documents.dip') }}"><i class="bi bi-chevron-right me-2"></i> Dokumen Publik</a></li>
                    <li><a href="{{ route('requests.create') }}"><i class="bi bi-chevron-right me-2"></i> Permohonan Info</a></li>
                </ul>
            </div>

            {{-- Kolom 3: Jam Pelayanan --}}
            <div class="col-lg-3 col-md-6">
                <h6 class="footer-header">Jam Pelayanan</h6>
                <ul class="schedule-list">
                    <li>
                        <span>Senin - Kamis</span>
                        <span class="text-white fw-bold">{{ $globalSettings['footer_hours_weekday'] ?? '08:00 - 16:00' }}</span>
                    </li>
                    <li>
                        <span>Jumat</span>
                        <span class="text-white fw-bold">{{ $globalSettings['footer_hours_friday'] ?? '08:00 - 11:00' }}</span>
                    </li>
                    <li>
                        <span>Sabtu - Minggu</span>
                        <span class="badge bg-danger bg-opacity-25 text-danger px-2">TUTUP</span>
                    </li>
                </ul>
            </div>

            {{-- Kolom 4: HUBUNGI KAMI (Sudah dirapikan) --}}
            <div class="col-lg-3 col-md-6">
                <h6 class="footer-header">Hubungi Kami</h6>
                <ul class="contact-list">
                    <li>
                        <i class="bi bi-geo-alt-fill"></i>
                        <span>{{ $globalSettings['footer_address'] ?? 'Banjarbaru, Kalimantan Selatan' }}</span>
                    </li>
                    <li>
                        <i class="bi bi-envelope-fill"></i>
                        <span>{{ $globalSettings['footer_email'] ?? 'ppid@kalselprov.go.id' }}</span>
                    </li>
                    <li>
                        <i class="bi bi-telephone-fill"></i>
                        <span>{{ $globalSettings['footer_phone'] ?? '(0511) 477XXXX' }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="copyright-bar">
        <div class="container text-center text-md-start d-md-flex justify-content-between align-items-center">
            <p class="mb-0">&copy; {{ date('Y') }} <strong>Dinas Komunikasi dan Informatika</strong> Prov. Kalsel.</p>
            <p class="mb-0 opacity-50 small mt-2 mt-md-0">Melayani dengan Hati, Bekerja dengan Pasti.</p>
        </div>
    </div>
</footer>
