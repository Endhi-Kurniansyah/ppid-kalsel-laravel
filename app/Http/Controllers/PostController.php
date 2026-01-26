<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Models\Gallery; // Import Gallery
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    // 1. TAMPILKAN DAFTAR BERITA DENGAN FILTER
    public function index(Request $request)
    {
        // Mulai Query
        $query = Post::with('category', 'user')->latest();

        // Filter Bulan
        if ($request->filled('month')) {
            $query->whereMonth('created_at', $request->month);
        }

        // Filter Tahun
        if ($request->filled('year')) {
            $query->whereYear('created_at', $request->year);
        }

        // Ambil Data
        // Saya sarankan pakai paginate(10) biar halaman tidak berat jika beritanya ratusan
        $posts = $query->paginate(10)->appends($request->all());

        return view('admin.posts.index', compact('posts'));
    }

    // 2. FORM TAMBAH BERITA
    public function create()
    {
        // Filter hanya kategori tipe 'news'
        $categories = Category::where('type', 'news')->get();
        return view('admin.posts.create', compact('categories'));
    }

    // 3. PROSES SIMPAN (STORE)
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|max:255',
            'category_id' => 'required',
            'content'     => 'required',
            'image'       => 'image|file|max:2048',
        ]);

        // PERBAIKAN DI SINI: Gunakan input()
        $data = [
            'title'       => $request->input('title'),
            'slug'        => Str::slug($request->input('title')),
            'category_id' => $request->input('category_id'),
            'content'     => $request->input('content'), // <-- Ganti ini
            'user_id'     => Auth::id(),
            'views'       => 0
        ];

        if ($request->file('image')) {
            $path = $request->file('image')->store('post-images', 'public');
            $data['image'] = $path;

            // OTOMATIS MASUK GALERI
            Gallery::create([
                'title'     => $request->input('title'),
                'description' => 'Dokumentasi Berita: ' . Str::limit(strip_tags($request->input('content')), 150),
                'type'      => 'image',
                'file_path' => $path,
                'is_active' => true,
            ]);
        }

        Post::create($data);

        return redirect()->route('posts.index')->with('success', 'Berita berhasil diterbitkan!');
    }

    // 4. FORM EDIT
    public function edit(Post $post)
    {
        $categories = Category::where('type', 'news')->get();
        return view('admin.posts.edit', compact('post', 'categories'));
    }

    // 5. PROSES UPDATE
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title'       => 'required|max:255',
            'category_id' => 'required',
            'content'     => 'required',
            'image'       => 'image|file|max:2048',
        ]);

        // PERBAIKAN DI SINI: Gunakan input()
        $data = [
            'title'       => $request->input('title'),
            'category_id' => $request->input('category_id'),
            'content'     => $request->input('content'), // <-- Ganti ini
        ];

        if ($request->file('image')) {
            // Hapus gambar lama JIKA tidak ada di galeri (agar galeri tidak rusak)
            if ($post->image) {
                $isUsedInGallery = Gallery::where('file_path', $post->image)->exists();
                if (!$isUsedInGallery) {
                    Storage::delete($post->image);
                }
            }

            $path = $request->file('image')->store('post-images', 'public');
            $data['image'] = $path;

            // OTOMATIS TAMBAH FOTO BARU KE GALERI
            Gallery::create([
                'title'     => $request->input('title'),
                'description' => 'Update Berita: ' . Str::limit(strip_tags($request->input('content')), 150),
                'type'      => 'image',
                'file_path' => $path,
                'is_active' => true,
            ]);
        }

        $post->update($data);

        return redirect()->route('posts.index')->with('success', 'Berita berhasil diperbarui!');
    }

    // 6. HAPUS BERITA
    public function destroy(Post $post)
    {
        if ($post->image) {
            // Cek apakah gambar digunakan di galeri
            $isUsedInGallery = Gallery::where('file_path', $post->image)->exists();
            if (!$isUsedInGallery) {
                Storage::delete($post->image);
            }
        }

        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Berita telah dihapus.');
    }
}
