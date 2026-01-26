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
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        Page::create([
            'title' => $request->title,
            'slug' => \Illuminate\Support\Str::slug($request->title),

            // PAKAI INI:
            'content' => $request->input('content'),

            // Jangan pakai $request->content !
        ]);

        return redirect()->route('pages.index')->with('success', 'Halaman berhasil dibuat!');
    }

    // Form Edit
    public function edit($id)
    {
        $page = Page::findOrFail($id);

        return view('admin.pages.edit', compact('page'));
    }

    public function update(Request $request, $id)
    {
        $page = Page::findOrFail($id);

        // 1. Validasi
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        // 2. Update Data
        $page->update([
            'title'   => $request->title,

            // Pastikan pakai Str::slug (Huruf besar S)
            'slug'    => \Illuminate\Support\Str::slug($request->title),

            // --- INI PERBAIKANNYA ---
            // Jangan pakai $request->content, tapi pakai input()
            // supaya tidak bentrok dengan variabel sistem.
            'content' => $request->input('content'),
        ]);

        return redirect()->route('pages.index')->with('success', 'Halaman berhasil diupdate!');
    }

    public function destroy($id)
    {
        $page = Page::findOrFail($id);

        // --- KEAMANAN TAMBAHAN ---
        // Jika halaman terkunci DAN yang mau hapus BUKAN Super Admin, tolak!
        if ($page->is_locked && auth()->user()->role !== 'super') {
            return redirect()->back()->with('error', 'Halaman ini terkunci dan tidak bisa dihapus!');
        }
        // -------------------------

        // Lanjut proses hapus...
        if ($page->is_static) {
            return redirect()->back()->with('error', 'Halaman statis utama tidak bisa dihapus.');
        }

        $page->delete();
        return redirect()->route('pages.index')->with('success', 'Halaman berhasil dihapus.');
    }
    public function toggleLock($id)
    {
        // 1. Cek apakah user adalah Super Admin
        if (auth()->user()->role !== 'super') {
            abort(403, 'Anda tidak memiliki akses untuk mengubah status kunci.');
        }

        $page = Page::findOrFail($id);

        // 2. Ubah status (True jadi False, False jadi True)
        $page->update([
            'is_locked' => !$page->is_locked
        ]);

        $status = $page->is_locked ? 'dikunci' : 'dibuka kuncinya';
        return back()->with('success', "Halaman berhasil $status.");
    }
    // FUNGSI KHUSUS UPLOAD GAMBAR DARI CKEDITOR
    public function uploadImage(Request $request)
    {
        if ($request->hasFile('upload')) {
            // 1. Ambil filenya
            $file = $request->file('upload');

            // 2. Beri nama unik (biar gak bentrok)
            $fileName = time() . '_' . $file->getClientOriginalName();

            // 3. Simpan di folder "public/uploads"
            $file->storeAs('public/uploads', $fileName);

            // 4. Balikin URL-nya ke CKEditor
            return response()->json([
                'url' => asset('storage/uploads/' . $fileName)
            ]);
        }

        return response()->json(['error' => 'Gagal upload gambar.']);
    }
    public function show($slug)
    {
        // 1. Cari halaman berdasarkan slug
        // Pastikan statusnya 'published' atau 'active' (sesuaikan dengan database Mas)
        $page = Page::where('slug', $slug)->first();

        // 2. Jika tidak ketemu, tampilkan 404
        if (!$page) {
            abort(404);
        }

        // 3. Jika ketemu, kirim ke tampilan frontend
        return view('frontend.page', compact('page'));
    }
}
