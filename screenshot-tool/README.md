# PPID Kalsel Auto Screenshot Tool

Alat untuk mengambil screenshot otomatis seluruh halaman website PPID Kalsel.
Berguna untuk keperluan **Laporan/Skripsi**.

## Instalasi

1. Pastikan Python 3.8+ sudah terinstall
2. Install dependencies:
   ```bash
   pip install -r requirements.txt
   playwright install chromium
   ```

## Penggunaan

1. **Pastikan server Laravel berjalan:**
   ```bash
   # Di folder utama project
   php artisan serve
   ```
   Atau gunakan Laragon dengan Virtual Host `ppid-kalsel.test`

2. **Sesuaikan Konfigurasi** (jika perlu):
   Buka `auto_screenshot.py`, edit bagian:
   ```python
   BASE_URL = "http://127.0.0.1:8000"  # Sesuaikan
   ADMIN_EMAIL = "super@admin.com"     # Email Admin
   ADMIN_PASSWORD = "password"          # Password Admin
   ```

3. **Jalankan Script:**
   ```bash
   cd screenshot-tool
   python auto_screenshot.py
   ```

4. **Hasil Screenshot:**
   Semua screenshot akan tersimpan di folder `./screenshots/`

## Daftar Halaman yang di-Screenshot

### Halaman Public (11 halaman)
- Beranda
- Daftar Berita
- Galeri
- Dokumen Publik
- DIP (Daftar Informasi Publik)
- Cek Status Permohonan
- Form Permohonan Informasi
- Form Keberatan
- Visi Misi
- Tentang PPID
- Kontak

### Halaman Admin (12 halaman)
- Login
- Dashboard
- Kelola Permohonan
- Kelola Keberatan
- Kelola Berita
- Kelola Dokumen
- Kelola Halaman Statis
- Kelola Galeri
- Hasil Survey
- Kelola User
- Pengaturan Website
- Kelola Menu

**Total: 23 Screenshot**
