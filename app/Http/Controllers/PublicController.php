<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Page;
use App\Models\Survey;
use App\Models\Setting;
use App\Models\Gallery;

class PublicController extends Controller
{
    public function home()
    {
        // 1. Berita Terbaru (3 item)
        $posts = Post::with('category', 'user')->latest()->take(3)->get();

        // 2. Statistik Survei
        $avg = Survey::avg('rating') ?? 0;
        $count = Survey::count();
        $surveyStats = [
            'average' => $avg,
            'count' => $count
        ];

        // Label Kepuasan
        $label = 'Belum Ada Data';
        if ($count > 0) {
            if ($avg >= 4.5) $label = 'Sangat Memuaskan';
            elseif ($avg >= 4) $label = 'Memuaskan';
            elseif ($avg >= 3) $label = 'Cukup';
            elseif ($avg >= 2) $label = 'Kurang';
            else $label = 'Sangat Kurang';
        }

        // 3. Global Settings (Background, dll)
        $globalSettings = Setting::pluck('value', 'key')->toArray();

        return view('welcome', compact('posts', 'surveyStats', 'label', 'globalSettings'));
    }
    // =================================================================
    // 1. HALAMAN BERITA (BLOG/ARTIKEL)
    // =================================================================

    // Menampilkan daftar berita (Halaman Depan Berita)
    // Menampilkan daftar berita (Halaman Depan Berita)
    public function newsIndex(Request $request)
    {
        // Fitur Pencarian Berita
        $query = Post::with('category', 'user')->latest();

        if ($request->has('q') && $request->q != '') {
            $keyword = $request->q;
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', "%{$keyword}%")
                  ->orWhere('content', 'like', "%{$keyword}%");
            });
        }

        $posts = $query->paginate(6);
        
        return view('frontend.news-index', compact('posts'));
    }

    // Pencarian Global (Berita + Dokumen)
    public function globalSearch(Request $request)
    {
        $keyword = $request->input('q');
        
        // 1. Cari Berita
        $posts = Post::with('category', 'user')
                    ->where(function($q) use ($keyword) {
                        $q->where('title', 'like', "%{$keyword}%")
                          ->orWhere('content', 'like', "%{$keyword}%");
                    })
                    ->latest()
                    ->take(6) // Ambil 6 berita teratas
                    ->get();

        // 2. Cari Dokumen (Public)
        $documents = \App\Models\Document::where(function($q) use ($keyword) {
                        $q->where('title', 'like', "%{$keyword}%")
                          ->orWhere('description', 'like', "%{$keyword}%");
                    })
                    ->latest()
                    ->take(8) // Ambil 8 dokumen teratas
                    ->get();
        
        // Ambil Global Settings untuk background hero
        $globalSettings = Setting::pluck('value', 'key')->toArray();

        return view('frontend.search', compact('posts', 'documents', 'keyword', 'globalSettings'));
    }

    // Menampilkan detail satu berita
    public function showNews($slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();

        // Fitur tambah viewer (opsional, aktifkan jika kolom views ada di db)
        $post->increment('views');

        return view('frontend.news-detail', compact('post'));
    }

    public function gallery()
    {
        $galleries = Gallery::where('is_active', true)->latest()->paginate(12);
        
        // Ambil Global Settings untuk background hero
        $globalSettings = Setting::pluck('value', 'key')->toArray();

        return view('frontend.gallery', compact('galleries', 'globalSettings'));
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
        // Ambil Global Settings
        $globalSettings = Setting::pluck('value', 'key')->toArray();

        return view('frontend.contact', compact('globalSettings'));
    }
}
