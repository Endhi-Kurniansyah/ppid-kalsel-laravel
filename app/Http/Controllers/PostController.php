<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    // 1. TAMPILKAN DAFTAR BERITA
    public function index()
    {
        $posts = Post::with('category')->latest()->get();
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
            $data['image'] = $request->file('image')->store('post-images', 'public');
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
            if ($post->image) {
                Storage::delete($post->image);
            }
            $data['image'] = $request->file('image')->store('post-images', 'public');
        }

        $post->update($data);

        return redirect()->route('posts.index')->with('success', 'Berita berhasil diperbarui!');
    }

    // 6. HAPUS BERITA
    public function destroy(Post $post)
    {
        if ($post->image) {
            Storage::delete($post->image);
        }

        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Berita telah dihapus.');
    }
}
