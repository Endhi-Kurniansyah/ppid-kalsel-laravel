<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Page;

class PublicController extends Controller
{
    // =================================================================
    // 1. HALAMAN BERITA (BLOG/ARTIKEL)
    // =================================================================

    // Menampilkan daftar berita (Halaman Depan Berita)
    public function newsIndex()
    {
        // Ambil berita terbaru, 6 per halaman
        // Relasi 'category' dan 'user' dipanggil agar efisien
        $posts = Post::with('category', 'user')
                     ->latest()
                     ->paginate(6);

        return view('frontend.news-index', compact('posts'));
    }

    // Menampilkan detail satu berita
    public function showNews($slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();

        // Fitur tambah viewer (opsional, aktifkan jika kolom views ada di db)
        $post->increment('views');

        return view('frontend.news-detail', compact('post'));
    }

    // =================================================================
    // 2. HALAMAN STATIS (PROFIL, VISI MISI, SEJARAH, DLL)
    // =================================================================

    public function showPage($slug)
    {
        // Cari halaman berdasarkan slug
        $page = Page::where('slug', $slug)->firstOrFail();

        return view('frontend.page', compact('page'));
    }
    public function contact()
{
    // Pastikan file view 'frontend.contact' benar-benar ada di folder resources/views/frontend/
    return view('frontend.contact');
}
}
