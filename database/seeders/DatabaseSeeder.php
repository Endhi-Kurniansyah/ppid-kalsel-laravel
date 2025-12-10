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
        ];

        foreach ($halamanWajib as $halaman) {
            Page::updateOrCreate(
                ['slug' => $halaman['slug']],
                [
                    'title' => $halaman['title'],
                    'content' => $halaman['content'],
                    'is_static' => 1, // Kunci Halaman
                ]
            );
        }
    }
}
