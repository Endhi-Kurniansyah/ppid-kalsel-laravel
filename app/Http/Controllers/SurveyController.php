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
            'rating' => 'required|integer|between:1,5', // 1 sampai 5
            'feedback' => 'nullable|string'
        ]);

        Survey::create([
            'rating' => $request->rating,
            'feedback' => $request->feedback,
            'ip_address' => $request->ip() // Catat IP biar keren (Audit trail)
        ]);

        return redirect()->back()->with('success_survey', 'Terima kasih atas penilaian Anda!');
    }

    // 2. Fungsi Halaman Admin (Melihat Hasil)
    public function index()
    {
        // Hitung jumlah vote per kategori (Group By)
        // Contoh: Bintang 5 ada 10 orang, Bintang 4 ada 3 orang.
        $results = Survey::select('rating', DB::raw('count(*) as total'))
                         ->groupBy('rating')
                         ->orderBy('rating', 'desc')
                         ->get();

        // Ambil data detail untuk tabel di bawahnya
        $surveys = Survey::latest()->paginate(10);

        return view('admin.surveys.index', compact('results', 'surveys'));
    }

    // 3. Fungsi Cetak Laporan PDF
    public function print()
    {
        $surveys = Survey::latest()->get();

        // Hitung rata-rata kepuasan
        $average = Survey::avg('rating');

        $pdf = Pdf::loadView('admin.surveys.print', compact('surveys', 'average'));
        $pdf->setPaper('a4', 'portrait');

        return $pdf->stream('laporan-survei-kepuasan.pdf');
    }
}
