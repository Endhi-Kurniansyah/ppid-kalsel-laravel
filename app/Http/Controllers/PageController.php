<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageController extends Controller
{
    // Tampilkan Daftar Halaman
    public function index()
    {
        $pages = Page::latest()->get();
        return view('admin.pages.index', compact('pages'));
    }

    // Form Tambah
    public function create()
    {
        return view('admin.pages.create');
    }

    // Simpan ke DB
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        Page::create([
            'title' => $request->input('title'), // Gunakan input() biar lebih aman
            'slug' => Str::slug($request->input('title')),
            'content' => $request->input('content'), // Gunakan input()
        ]);

        return redirect()->route('pages.index')->with('success', 'Halaman berhasil dibuat!');
    }

    // Form Edit
    public function edit(Page $page)
    {
        return view('admin.pages.edit', compact('page'));
    }

    // Update DB
    // Update DB
    public function update(Request $request, Page $page)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required', // Hapus validasi slug unique dulu biar ga ribet
        ]);

        $page->update([
            'title' => $request->input('title'),

            // TAMBAHKAN BARIS INI (Agar slug berubah mengikuti judul baru)
            'slug' => Str::slug($request->input('title')),

            'content' => $request->input('content'),
        ]);

        return redirect()->route('pages.index')->with('success', 'Halaman berhasil diperbarui!');
    }

    // Hapus
    public function destroy(Page $page)
    {
        $page->delete();
        return redirect()->route('pages.index')->with('success', 'Halaman dihapus.');
    }
}
