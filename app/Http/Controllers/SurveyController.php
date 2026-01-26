<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class SurveyController extends Controller
{
    // 1. Fungsi Simpan Vote dari Masyarakat
    public function store(Request $request)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'feedback' => 'nullable|string', // Pastikan validasi pakai feedback
        ]);

        Survey::create([
            'rating' => $request->rating,
            // INI YANG BIKIN ERROR SEBELUMNYA.
            // Ubah dari 'comment' => ... menjadi:
            'feedback' => $request->feedback,
            'ip_address' => $request->ip()
        ]);

        return back()->with('success_survey', 'Terima kasih atas penilaian Anda!');
    }

    // 2. Fungsi Halaman Admin (Melihat Hasil)
    // Pastikan baris ini ada di paling atas file (di bawah namespace)
    // use Illuminate\Http\Request;
    // use Illuminate\Support\Facades\DB;
    // use App\Models\Survey;

    public function index(Request $request)
    {
        // 1. Query Dasar (Termasuk perintah 'latest' / urutkan tanggal)
        $query = Survey::latest();

        // 2. Filter Bulan
        if ($request->filled('month')) {
            $query->whereMonth('created_at', $request->month);
        }

        // 3. Filter Tahun
        if ($request->filled('year')) {
            $query->whereYear('created_at', $request->year);
        }

        // 4. Ambil Data Statistik (Card)
        // PERBAIKAN: Tambahkan ->reorder() untuk menghapus efek 'latest()'
        $results = (clone $query)
            ->reorder() // <--- INI SOLUSINYA. Hapus urutan tanggal biar gak error Group By
            ->select('rating', DB::raw('count(*) as total'))
            ->groupBy('rating')
            ->orderBy('rating', 'desc')
            ->get();

        // 5. Ambil Data Tabel
        // Kalau tabel tetap butuh 'latest()', jadi biarkan saja
        $surveys = (clone $query)
            ->paginate(10)
            ->appends($request->all());

        return view('admin.surveys.index', compact('results', 'surveys'));
    }
}
