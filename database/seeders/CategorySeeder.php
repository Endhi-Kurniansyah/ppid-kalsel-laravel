<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // Kita tampung datanya dalam variabel dulu
        $categories = [
            ['name' => 'SOP Layanan', 'slug' => 'sop', 'type' => 'document', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Informasi Berkala', 'slug' => 'berkala', 'type' => 'document'],
            ['name' => 'Informasi Serta Merta', 'slug' => 'serta-merta', 'type' => 'document'],
            ['name' => 'Informasi Setiap Saat', 'slug' => 'setiap-saat', 'type' => 'document'],
            ['name' => 'Informasi Dikecualikan', 'slug' => 'dikecualikan', 'type' => 'document'],
            // Ini data baru yang mau kita masukkan
            ['name' => 'SOP Layanan', 'slug' => 'sop', 'type' => 'document'],
        ];

        // Looping (Perulangan) agar diproses satu per satu
        foreach ($categories as $cat) {
            Category::updateOrCreate(
                ['slug' => $cat['slug']], // Kunci Pengecekan: Cek berdasarkan SLUG
                $cat                      // Data yang akan disimpan/diupdate
            );
        }
    }
}
