<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\Gallery;
use Illuminate\Support\Str;

class PostToGallerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posts = Post::whereNotNull('image')->get();
        $count = 0;

        foreach ($posts as $post) {
            // Check if already in gallery (avoid duplicates if run multiple times)
            if (!Gallery::where('file_path', $post->image)->exists()) {
                Gallery::create([
                    'title'       => $post->title,
                    'description' => 'Dokumentasi Berita: ' . Str::limit(strip_tags($post->content), 150),
                    'type'        => 'image',
                    'file_path'   => $post->image,
                    'is_active'   => true,
                    'created_at'  => $post->created_at, // Preserve original date
                    'updated_at'  => $post->updated_at,
                ]);
                $count++;
            }
        }
        
        $this->command->info("Synced {$count} posts to gallery.");
    }
}
