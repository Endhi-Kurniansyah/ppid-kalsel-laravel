<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // Data Kategori
        $categories = [
            ['name' => 'Informasi Berkala', 'slug' => 'berkala', 'type' => 'document'],
            ['name' => 'Informasi Serta Merta', 'slug' => 'serta-merta', 'type' => 'document'],
            ['name' => 'Informasi Setiap Saat', 'slug' => 'setiap-saat', 'type' => 'document'],
            ['name' => 'Informasi Dikecualikan', 'slug' => 'dikecualikan', 'type' => 'document'],
            ['name' => 'SOP Layanan', 'slug' => 'sop', 'type' => 'document'],
            ['name' => 'Berita Kegiatan', 'slug' => 'berita-kegiatan', 'type' => 'news'],
            ['name' => 'Artikel', 'slug' => 'artikel', 'type' => 'news'],
            ['name' => 'Pengumuman', 'slug' => 'pengumuman', 'type' => 'news'],
        ];

        // Loop Simpan
        foreach ($categories as $cat) {
            Category::updateOrCreate(
                ['slug' => $cat['slug']],
                $cat
            );
        }
    }
}
