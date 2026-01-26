<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Page;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Menampilkan daftar menu + form create (dalam satu halaman)
     */
    public function index()
{
    // 1. Ambil Menu Utama saja (Parent), tapi bawa serta anak-anaknya (Children)
    $parents = Menu::whereNull('parent_id')
                ->with(['children' => function($query) {
                    $query->orderBy('order', 'asc'); // Urutkan anak berdasarkan order
                }])
                ->orderBy('order', 'asc') // Urutkan bapak berdasarkan order
                ->get();

    // 2. Susun ulang menjadi satu list datar untuk tabel (Flat List)
    // Supaya di tabel urutannya: Bapak A -> Anak A1 -> Anak A2 -> Bapak B
    $menus = collect([]);

    foreach($parents as $parent) {
        $menus->push($parent); // Masukkan Bapak

        foreach($parent->children as $child) {
            $menus->push($child); // Masukkan Anak-anaknya tepat di bawah Bapaknya
        }
    }

    // 3. Data untuk Dropdown Form (Tetap sama)
    $parentMenus = $parents; // Bisa pakai variabel $parents yg sudah diambil di atas
    $listHalaman = Page::orderBy('title', 'asc')->get();

    return view('admin.menus.index', compact('menus', 'parentMenus', 'listHalaman'));
}
    /**
     * Menyimpan menu baru ke database
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'url' => 'required|string|max:255',
            'order' => 'nullable|integer|min:0',
            'parent_id' => 'nullable|exists:menus,id'
        ]);

        // Cegah circular reference (menu tidak bisa jadi parent dari parent-nya)
        if ($request->parent_id) {
            $parent = Menu::find($request->parent_id);
            if ($parent && $parent->parent_id) {
                return back()->withErrors(['parent_id' => 'Hanya bisa memilih menu utama (level 1) sebagai parent.'])->withInput();
            }
        }

        Menu::create([
            'name' => $validated['name'],
            'url' => $validated['url'],
            'order' => $validated['order'] ?? 0,
            'parent_id' => $validated['parent_id'],
            'is_active' => 1
        ]);

        return redirect()->route('menus.index')->with('success', 'Menu berhasil ditambahkan!');
    }

    /**
     * Menampilkan form untuk mengedit menu
     */
    public function edit($id)
    {
        $menu = Menu::findOrFail($id);

        // Dapatkan semua menu utama yang bisa jadi parent
        // Kecualikan menu itu sendiri untuk menghindari circular reference
        $parentMenus = Menu::whereNull('parent_id')
                        ->where('id', '!=', $id)
                        ->orderBy('order', 'asc')
                        ->get();

        $listHalaman = Page::orderBy('title', 'asc')->get();

        return view('admin.menus.edit', compact('menu', 'parentMenus', 'listHalaman'));
    }

    /**
     * Memperbarui menu yang ada di database
     */
    public function update(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'url' => 'required|string|max:255',
            'order' => 'nullable|integer|min:0',
            'parent_id' => 'nullable|exists:menus,id'
        ]);

        // Validasi khusus: cegah menu jadi parent dirinya sendiri
        if ($request->parent_id == $id) {
            return back()->withErrors(['parent_id' => 'Menu tidak bisa menjadi induk dirinya sendiri.'])->withInput();
        }

        // Validasi: cegah circular reference (menu tidak bisa jadi parent dari anaknya)
        if ($request->parent_id) {
            $childrenIds = $menu->children->pluck('id')->toArray();
            if (in_array($request->parent_id, $childrenIds)) {
                return back()->withErrors(['parent_id' => 'Menu tidak bisa menjadi induk dari menu turunannya sendiri.'])->withInput();
            }
        }

        $menu->update([
            'name' => $validated['name'],
            'url' => $validated['url'],
            'order' => $validated['order'] ?? $menu->order,
            'parent_id' => $validated['parent_id'],
        ]);

        return redirect()->route('menus.index')->with('success', 'Menu <strong>' . $menu->name . '</strong> berhasil diperbarui!');
    }

    /**
     * Menghapus menu dari database
     */
    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);

        // Jika menu memiliki anak, hapus juga anak-anaknya (cascade)
        if ($menu->children->count() > 0) {
            $menu->children()->delete();
        }

        $menuName = $menu->name;
        $menu->delete();

        return redirect()->route('menus.index')->with('success', 'Menu <strong>' . $menuName . '</strong> berhasil dihapus!');
    }
}
