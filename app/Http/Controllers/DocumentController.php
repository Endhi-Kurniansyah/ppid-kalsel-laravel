<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class DocumentController extends Controller
{
    // Tampilkan Daftar Dokumen
    public function index()
    {
        $documents = Document::with('category', 'user')->latest()->paginate(10);
        return view('admin.documents.index', compact('documents'));
    }

    // Tampilkan Form Upload
    public function create()
    {
        $categories = Category::where('type', 'document')->get();
        return view('admin.documents.create', compact('categories'));
    }

    // Proses Simpan Dokumen
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'category_id' => 'required',
            'file_path' => 'required|mimes:pdf,doc,docx,xls,xlsx|max:5048', // Max 5MB
            'published_date' => 'required|date',
        ]);

        // Upload File
        $path = $request->file('file_path')->store('documents', 'public');

        Document::create([
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'user_id' => auth()->id(), // Siapa admin yang upload
            'published_date' => $request->published_date,
            'file_path' => $path,
        ]);

        return redirect()->route('documents.index')->with('success', 'Dokumen berhasil diupload!');
    }

    // Hapus Dokumen
    public function destroy($id)
    {
        $doc = Document::findOrFail($id);
        Storage::disk('public')->delete($doc->file_path); // Hapus filenya juga
        $doc->delete();

        return redirect()->back()->with('success', 'Dokumen dihapus.');
    }

    // Cetak Laporan
    public function print()
    {
        $documents = Document::with('category')->orderBy('category_id')->get();
        $pdf = Pdf::loadView('admin.documents.print', compact('documents'));
        $pdf->setPaper('a4', 'landscape');
        return $pdf->stream('laporan-inventaris-dokumen.pdf');
    }
}
