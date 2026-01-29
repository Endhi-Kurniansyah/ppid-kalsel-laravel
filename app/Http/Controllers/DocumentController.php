<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DocumentController extends Controller
{
    // =================================================================
    // BAGIAN ADMIN (BACKEND) - Tidak Berubah
    // =================================================================

    public function index(Request $request)
    {
        $query = Document::query();
        
        // Filter Bulan
        if ($request->filled('month')) {
            $query->whereMonth('created_at', $request->month);
        }
        
        // Filter Tahun
        if ($request->filled('year')) {
            $query->whereYear('created_at', $request->year);
        }
        
        // Filter Kategori
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        
        // Search by Title/Description
        if ($request->filled('q')) {
            $keyword = $request->q;
            $query->where(function($q) use ($keyword) {
                $q->where('title', 'LIKE', "%{$keyword}%")
                  ->orWhere('description', 'LIKE', "%{$keyword}%");
            });
        }
        
        $documents = $query->latest()->paginate(10)->appends($request->all());
        return view('admin.documents.index', compact('documents'));
    }
    public function show($id)
    {
        // Kita arahkan ke tampilan detail publik saja
        return $this->showPublic($id);
    }

    public function create()
    {
        return view('admin.documents.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'category'    => 'required|string',
            'file_path'   => 'nullable|mimes:pdf,doc,docx,xls,xlsx,jpg,png|max:10240',
            'description' => 'required|string',
        ]);

        $path = null;
        if ($request->hasFile('file_path')) {
            $path = $request->file('file_path')->store('documents', 'public');
        }

        Document::create([
            'title'       => $request->title,
            'category'    => $request->category,
            'description' => $request->input('description'),
            'file_path'   => $path,
            'slug'        => Str::slug($request->title) . '-' . time(),
        ]);

        return redirect()->route('documents.index')->with('success', 'Dokumen berhasil dipublikasikan!');
    }

    public function edit($id)
    {
        $document = Document::findOrFail($id);
        return view('admin.documents.edit', compact('document'));
    }

    public function update(Request $request, $id)
    {
        $document = Document::findOrFail($id);
        $request->validate([
            'title'    => 'required',
            'category' => 'required',
            'file'     => 'nullable|mimes:pdf,doc,docx,xls,xlsx|max:10000',
        ]);
        $document->title = $request->title;
        $document->category = $request->category;
        if($request->has('description')) {
            $document->description = $request->description;
        }
        if ($request->hasFile('file')) {
            if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
                Storage::disk('public')->delete($document->file_path);
            }
            $path = $request->file('file')->store('documents', 'public');
            $document->file_path = $path;
        }
        $document->save();
        return redirect()->route('documents.index')->with('success', 'Dokumen berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $doc = Document::findOrFail($id);
        if ($doc->file_path && Storage::disk('public')->exists($doc->file_path)) {
            Storage::disk('public')->delete($doc->file_path);
        }
        $doc->delete();
        return redirect()->back()->with('success', 'Dokumen berhasil dihapus.');
    }


    // =================================================================
    // BAGIAN PUBLIK / FRONTEND (YANG DIPERBAIKI)
    // =================================================================

    /**
     * MENAMPILKAN SEMUA DOKUMEN & KATEGORI UMUM
     */
    public function indexPublic(Request $request, $category = null)
    {
        // Redirect /dokumen ke /dokumen/dip jika tidak ada category
        if (!$category && !$request->has('q')) {
            return redirect()->route('documents.dip');
        }

        $query = Document::query();

        $category_title = 'Dokumen Publik';
        $category_desc  = 'Daftar Informasi Publik PPID Provinsi Kalimantan Selatan';

        // 1. LOGIKA KATEGORI
        // 1. LOGIKA KATEGORI
        if ($category) {
            // FIX: Menangani ketidakkonsistenan antara 'sop' dan 'sop-ppid'
            if ($category == 'sop-ppid' || $category == 'sop') {
                $query->where(function ($q) {
                    $q->where('category', 'sop')
                      ->orWhere('category', 'sop-ppid');
                });
                $category_title = 'SOP PPID';
            } else {
                $query->where('category', 'LIKE', '%' . $category . '%');
                
                // Judul Header
                switch ($category) {
                    case 'berkala': $category_title = 'Informasi Berkala'; break;
                    case 'serta-merta': $category_title = 'Informasi Serta Merta'; break;
                    case 'setiap-saat': $category_title = 'Informasi Setiap Saat'; break;
                    case 'dikecualikan': $category_title = 'Informasi Dikecualikan'; break;
                    default: $category_title = ucwords(str_replace('-', ' ', $category)); break;
                }
            }
        }

        // 2. LOGIKA PENCARIAN
        if ($request->has('q') && $request->q != '') {
            $keyword = $request->q;
            $query->where(function($q) use ($keyword) {
                $q->where('title', 'LIKE', "%{$keyword}%")
                  ->orWhere('description', 'LIKE', "%{$keyword}%");
            });
            $category_title = 'Hasil Pencarian';
        }

        $documents = $query->latest()->paginate(10)->appends($request->all());

        // PERBAIKAN UTAMA: Arahkan ke 'frontend.documents' (sesuai nama file Mas)
        return view('frontend.documents', compact('documents', 'category_title', 'category_desc'));
    }

    /**
     * KHUSUS HALAMAN DAFTAR INFORMASI PUBLIK (DIP)
     */
    /**
     * KHUSUS HALAMAN DAFTAR INFORMASI PUBLIK (DIP) - TABEL KATEGORI
     */
    public function dipIndex(Request $request)
    {
        // 1. Query dasar: SEMUA Dokumen, KECUALI kategori 'lainnya'
        $query = Document::where('category', '!=', 'lainnya');
        
        // 2. Filter Tahun & Bulan
        if ($request->filled('year')) {
            $query->whereYear('created_at', $request->year);
        }
        if ($request->filled('month')) {
            $query->whereMonth('created_at', $request->month);
        }
        
        // 3. Ambil dan urutkan dari yang terbaru
        $documents = $query->latest()->get();

        // 4. Kelompokkan Dokumen berdasarkan kolom 'category'
        $groupedDocuments = $documents->groupBy('category');

        // 5. Judul Halaman
        $category_title = 'Daftar Informasi Publik (DIP)';
        $category_desc  = 'Rekapitulasi seluruh dokumen publik berdasarkan kategori.';

        // 6. Return ke View KHUSUS DIP
        return view('frontend.dip', compact('groupedDocuments', 'category_title', 'category_desc'));
    }
    public function showPublic($id)
    {
        $document = Document::findOrFail($id);

        // Asumsi file detail bernama 'document-show.blade.php' di folder frontend
        // Jika nama filenya lain, sesuaikan di sini.
        return view('frontend.document-show', compact('document'));
    }
}
