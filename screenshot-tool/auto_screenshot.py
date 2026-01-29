# Auto Screenshot Script for PPID Kalsel
# Menggunakan Playwright untuk screenshot otomatis
# Untuk keperluan Laporan/Skripsi

import os
import time
from playwright.sync_api import sync_playwright

# ============== KONFIGURASI ==============
# Gunakan salah satu BASE_URL sesuai server Mas:
BASE_URL = "http://127.0.0.1:8000"  # Jika pakai php artisan serve
# BASE_URL = "http://ppid-kalsel.test"  # Jika pakai Laragon Virtual Host

OUTPUT_DIR = "./screenshots"

# Kredensial Admin (Sesuaikan dengan akun Mas)
ADMIN_EMAIL = "super@admin.com"
ADMIN_PASSWORD = "password"

# ============== DAFTAR HALAMAN ==============

# HALAMAN PUBLIC (Tidak perlu login)
PUBLIC_ROUTES = [
    {"path": "/", "name": "01_beranda", "desc": "Halaman Utama", "full_page": True},
    {"path": "/berita", "name": "02_berita_list", "desc": "Daftar Berita", "full_page": True},
    {"path": "/galeri", "name": "03_galeri", "desc": "Galeri Foto", "full_page": True},
    {"path": "/dokumen/dip", "name": "04_dip", "desc": "Daftar Informasi Publik", "full_page": True},
    {"path": "/cek-status", "name": "05_cek_status", "desc": "Cek Status Permohonan", "full_page": True},
    {"path": "/ajukan-permohonan", "name": "06_form_permohonan", "desc": "Form Permohonan Informasi", "full_page": True},
    {"path": "/ajukan-keberatan", "name": "07_form_keberatan_search", "desc": "Cari Tiket untuk Keberatan", "full_page": True},
    {"path": "/page/visi-misi", "name": "08_visi_misi", "desc": "Halaman Visi Misi", "full_page": True},
    {"path": "/page/tentang-ppid", "name": "09_tentang_ppid", "desc": "Halaman Tentang PPID", "full_page": True},
    {"path": "/page/kontak", "name": "10_kontak", "desc": "Halaman Kontak", "full_page": True},
    {"path": "/page/maklumat-pelayanan", "name": "11_maklumat_pelayanan", "desc": "Maklumat Pelayanan", "full_page": True},
    {"path": "/page/struktur-organisasi", "name": "12_struktur_organisasi", "desc": "Struktur Organisasi", "full_page": True},
    {"path": "/page/tugas-fungsi", "name": "13_tugas_fungsi", "desc": "Tugas dan Fungsi", "full_page": True},
    {"path": "/page/cara-memperoleh-informasi", "name": "14_cara_memperoleh_informasi", "desc": "Cara Memperoleh Informasi", "full_page": True},
]

# HALAMAN ADMIN (Perlu login)
ADMIN_ROUTES = [
    {"path": "/login", "name": "16_login", "desc": "Halaman Login Admin", "need_login": False},
    {"path": "/dashboard", "name": "17_admin_dashboard", "desc": "Dashboard Admin"},
    {"path": "/admin/requests", "name": "18_admin_permohonan", "desc": "Kelola Permohonan"},
    {"path": "/admin/objections", "name": "19_admin_keberatan", "desc": "Kelola Keberatan"},
    {"path": "/posts", "name": "20_admin_berita", "desc": "Kelola Berita"},
    {"path": "/documents", "name": "21_admin_dokumen", "desc": "Kelola Dokumen"},
    {"path": "/pages", "name": "22_admin_halaman", "desc": "Kelola Halaman Statis"},
    {"path": "/galleries", "name": "23_admin_galeri", "desc": "Kelola Galeri"},
    {"path": "/surveys", "name": "24_admin_survey", "desc": "Hasil Survey"},
    {"path": "/admin/users", "name": "25_admin_users", "desc": "Kelola User Admin"},
    {"path": "/admin/settings", "name": "26_admin_settings", "desc": "Pengaturan Website"},
    {"path": "/menus", "name": "27_admin_menu", "desc": "Kelola Navigasi Menu"},
]


def login(page, email, password):
    """Login ke aplikasi Laravel"""
    print(f"[LOGIN] Login sebagai: {email}")
    page.goto(f"{BASE_URL}/login")
    page.wait_for_load_state("networkidle")
    page.wait_for_timeout(1500)
    
    # Isi form login
    page.fill("input[name='email']", email)
    page.fill("input[name='password']", password)
    
    # Klik tombol login
    page.click("button[type='submit']")
    
    page.wait_for_timeout(3000)
    page.wait_for_load_state("networkidle")
    print("[OK] Login berhasil!")


def take_screenshot(page, url, filepath, desc, full_page=False):
    """Ambil screenshot satu halaman"""
    print(f"[SCREENSHOT] {desc}")
    print(f"   URL: {url}")
    
    page.goto(url)
    page.wait_for_load_state("networkidle")
    page.wait_for_timeout(2000)  # Tunggu animasi selesai
    
    page.screenshot(path=filepath, full_page=full_page)
    print(f"   [OK] Tersimpan: {filepath}")


def main():
    """Fungsi utama"""
    print("=" * 60)
    print("[START] PPID KALSEL - Auto Screenshot Tool")
    print("   Untuk keperluan Laporan/Skripsi")
    print("=" * 60)
    
    # Buat folder output
    if not os.path.exists(OUTPUT_DIR):
        os.makedirs(OUTPUT_DIR)
        print(f"[FOLDER] Folder dibuat: {OUTPUT_DIR}")
    
    with sync_playwright() as p:
        # Launch browser (headless=False agar terlihat prosesnya)
        browser = p.chromium.launch(headless=False)
        context = browser.new_context(
            viewport={"width": 1920, "height": 1080}
        )
        page = context.new_page()
        
        # ========== SCREENSHOT HALAMAN PUBLIC ==========
        print("\n" + "=" * 60)
        print("[PUBLIC] SCREENSHOT HALAMAN PUBLIC (Tanpa Login)")
        print("=" * 60)
        
        for route in PUBLIC_ROUTES:
            url = f"{BASE_URL}{route['path']}"
            filepath = os.path.join(OUTPUT_DIR, f"{route['name']}.png")
            full_page = route.get("full_page", False)
            take_screenshot(page, url, filepath, route['desc'], full_page)
        
        # ========== SCREENSHOT HALAMAN ADMIN ==========
        # (Dinonaktifkan sementara karena ada Captcha)
        # Untuk mengaktifkan, hapus tanda # di bawah ini
        #
        # print("\n" + "=" * 60)
        # print("[ADMIN] SCREENSHOT HALAMAN ADMIN (Dengan Login)")
        # print("=" * 60)
        # 
        # is_logged_in = False
        # 
        # for route in ADMIN_ROUTES:
        #     url = f"{BASE_URL}{route['path']}"
        #     filepath = os.path.join(OUTPUT_DIR, f"{route['name']}.png")
        #     full_page = route.get("full_page", False)
        #     
        #     # Cek apakah perlu login
        #     if route.get("need_login", True) and not is_logged_in:
        #         login(page, ADMIN_EMAIL, ADMIN_PASSWORD)
        #         is_logged_in = True
        #     
        #     take_screenshot(page, url, filepath, route['desc'], full_page)
        
        browser.close()
    
    print("\n" + "=" * 60)
    print(f"[DONE] SELESAI! Screenshot tersimpan di: {OUTPUT_DIR}")
    print(f"   Total: {len(PUBLIC_ROUTES)} halaman public")
    print("=" * 60)


if __name__ == "__main__":
    main()
