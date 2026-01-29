<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        // 1. MENU: BERANDA
        Menu::create([
            'name' => 'Beranda',
            'url' => '/',
            'order' => 1,
            'parent_id' => null
        ]);

        // 2. MENU: PROFIL (Punya Anak)
        $profil = Menu::create([
            'name' => 'Profil',
            'url' => '#',
            'order' => 2,
            'parent_id' => null
        ]);
            // Anak Profil (Maklumat Pelayanan sudah dipindah ke sini)
            Menu::create(['name' => 'Tentang PPID', 'url' => '/page/tentang-ppid', 'order' => 1, 'parent_id' => $profil->id]);
            Menu::create(['name' => 'Visi Misi', 'url' => '/page/visi-misi', 'order' => 2, 'parent_id' => $profil->id]);
            Menu::create(['name' => 'Maklumat Pelayanan', 'url' => '/page/maklumat-pelayanan', 'order' => 3, 'parent_id' => $profil->id]); // <--- PINDAH KE SINI
            Menu::create(['name' => 'Struktur Organisasi', 'url' => '/page/struktur-organisasi', 'order' => 4, 'parent_id' => $profil->id]);
            Menu::create(['name' => 'Tugas & Fungsi', 'url' => '/page/tugas-fungsi', 'order' => 5, 'parent_id' => $profil->id]);

        // 3. MENU: INFORMASI PUBLIK (Punya Anak)
        $info = Menu::create([
            'name' => 'Informasi Publik',
            'url' => '#',
            'order' => 3,
            'parent_id' => null
        ]);
            // Anak Informasi Publik
            Menu::create(['name' => 'Daftar Informasi Publik (DIP)', 'url' => '/dokumen/dip', 'order' => 1, 'parent_id' => $info->id]);
            Menu::create(['name' => 'Informasi Berkala', 'url' => '/dokumen/berkala', 'order' => 2, 'parent_id' => $info->id]);
            Menu::create(['name' => 'Informasi Serta Merta', 'url' => '/dokumen/serta-merta', 'order' => 3, 'parent_id' => $info->id]);
            Menu::create(['name' => 'Informasi Setiap Saat', 'url' => '/dokumen/setiap-saat', 'order' => 4, 'parent_id' => $info->id]);
            Menu::create(['name' => 'Informasi Dikecualikan', 'url' => '/dokumen/dikecualikan', 'order' => 5, 'parent_id' => $info->id]);

        // 4. MENU: LAYANAN (Punya Anak)
        $layanan = Menu::create([
            'name' => 'Layanan',
            'url' => '#',
            'order' => 4,
            'parent_id' => null
        ]);
            // Anak Layanan (Maklumat sudah dihapus dari sini)
            Menu::create(['name' => 'SOP PPID', 'url' => '/dokumen/sop-ppid', 'order' => 1, 'parent_id' => $layanan->id]);
            Menu::create(['name' => 'Cara Memperoleh Informasi', 'url' => '/page/cara-memperoleh-informasi', 'order' => 2, 'parent_id' => $layanan->id]);
            Menu::create(['name' => 'Form Permohonan Informasi', 'url' => '/ajukan-permohonan', 'order' => 3, 'parent_id' => $layanan->id]);
            Menu::create(['name' => 'Cek Status', 'url' => '/cek-status', 'order' => 4, 'parent_id' => $layanan->id]);
            Menu::create(['name' => 'Ajukan Keberatan', 'url' => '/ajukan-keberatan', 'order' => 5, 'parent_id' => $layanan->id]);

        // 5. MENU: BERITA
        Menu::create([
            'name' => 'Berita',
            'url' => '/berita',
            'order' => 5,
            'parent_id' => null
        ]);

        // 6. MENU: GALERI
        Menu::create([
            'name' => 'Galeri',
            'url' => '/galeri',
            'order' => 6,
            'parent_id' => null
        ]);

        // 7. MENU: KONTAK
        Menu::create([
            'name' => 'Kontak',
            'url' => '/page/kontak',
            'order' => 7,
            'parent_id' => null
        ]);
    }
}
