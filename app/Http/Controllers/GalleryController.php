<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gallery;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $galleries = Gallery::latest()->paginate(12);
        return view('admin.galleries.index', compact('galleries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // View not needed if using modal in index, but user might want separate page?
        // Let's stick to modal for simplicity and "modern" feel for single image uploads.
        // Or if we want separate page, return view('admin.galleries.create');
        // I'll stick to index-modal workflow for now as it's efficient for galleries.
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120', // Max 5MB
        ]);

        $path = $request->file('image')->store('galleries', 'public');

        Gallery::create([
            'title' => $request->title,
            'description' => $request->description,
            'file_path' => $path,
            'type' => 'image',
            'is_active' => true,
        ]);

        return redirect()->route('galleries.index')->with('success', 'Foto berhasil ditambahkan ke galeri.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Gallery $gallery)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Gallery $gallery)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Used for toggling active status usually? or editing title
        // For now let's implement validation if they send title
        
        $gallery = Gallery::findOrFail($id);

        if ($request->has('title')) {
            $gallery->update([
                'title' => $request->title,
                'description' => $request->description,
            ]);
        }

        return back()->with('success', 'Informasi galeri diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $gallery = Gallery::findOrFail($id);
        
        if ($gallery->file_path && Storage::disk('public')->exists($gallery->file_path)) {
            Storage::disk('public')->delete($gallery->file_path);
        }

        $gallery->delete();

        return back()->with('success', 'Foto dihapus dari galeri.');
    }
}
