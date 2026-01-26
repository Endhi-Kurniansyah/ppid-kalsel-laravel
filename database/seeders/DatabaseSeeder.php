<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Page; // Jangan lupa import Page
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ==========================================
        // 1. BUAT USER (SUPER ADMIN & ADMIN BIASA)
        // ==========================================

        // Buat SUPER ADMIN
        User::updateOrCreate(
            ['email' => 'super@ppid.com'],
            [
                'name' => 'Super Administrator',
                'password' => Hash::make('password'),
                'role' => 'super_admin'
            ]
        );

        // Buat ADMIN BIASA
        User::updateOrCreate(
            ['email' => 'admin@ppid.com'],
            [
                'name' => 'Staf Admin',
                'password' => Hash::make('password'),
                'role' => 'admin'
            ]
        );

        // ==========================================
        // 2. PANGGIL SEEDER LAIN (KATEGORI)
        // ==========================================
        // Karena CategorySeeder sudah dipisah, kita panggil di sini
        $this->call([
            CategorySeeder::class,
            MenuSeeder::class,
        ]);

        // ==========================================
        // 3. BUAT HALAMAN PENTING (VISI MISI, DLL)
        // ==========================================
        // Kita taruh sini saja (atau bisa buat PageSeeder terpisah kalau mau)
        $halamanWajib = [
            ['title' => 'Visi Misi', 'slug' => 'visi-misi', 'content' => '<p>Isi Visi Misi...</p>'],
            ['title' => 'Tentang PPID', 'slug' => 'tentang-ppid', 'content' => '<p>Sejarah PPID...</p>'],
            ['title' => 'Struktur Organisasi', 'slug' => 'struktur-organisasi', 'content' => '<p>Gambar struktur...</p>'],
            ['title' => 'Tugas & Fungsi', 'slug' => 'tugas-fungsi', 'content' => '<p>Tugas dan fungsi...</p>'],

            // TAMBAHAN BARU DI SINI:
            [
                'title' => 'Cara Memperoleh Informasi',
                'slug' => 'cara-memperoleh-informasi',
                'content' => '<p>Prosedur dan tata cara memperoleh informasi publik...</p>'
            ],
            [
                'title' => 'Maklumat Pelayanan',
                'slug' => 'maklumat-pelayanan',
                'content' => '<p>Kami siap melayani Anda dengan sungguh-sungguh...</p>'
            ],
        ];

        foreach ($halamanWajib as $halaman) {
            Page::updateOrCreate(
                ['slug' => $halaman['slug']],
                [
                    'title' => $halaman['title'],
                    'content' => $halaman['content'],
                    'is_static' => 1, // Kita set 1 agar statusnya 'UTAMA' dan terkunci (tidak bisa dihapus sembarangan)
                ]
            );
        }
    }
}
