<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Survey;
use App\Models\Document;
use App\Models\InformationRequest;
use App\Models\Objection;
use App\Models\Setting;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Carbon\Carbon; // Pastikan Carbon sudah di-import

class ReportController extends Controller
{
    // Fungsi pembantu untuk setting kertas A4
    private function generatePdf($view, $data, $filename) {
        $pdf = Pdf::loadView($view, $data);
        $pdf->setPaper('a4', 'portrait');
        return $pdf->stream($filename . '.pdf');
    }

    // GANTI method printRequests dengan ini:
    public function printRequests(Request $request) {

        // 1. Query Dasar
        $query = InformationRequest::latest();

        // 2. Filter Bulan
        if ($request->filled('month')) {
            $query->whereMonth('created_at', $request->month);
        }

        // 3. Filter Tahun
        if ($request->filled('year')) {
            $query->whereYear('created_at', $request->year);
        }

        $requests = $query->get();

        // 4. Label Periode Dinamis
        $periode = "TAHUN " . ($request->year ?? date('Y'));

        if ($request->filled('month') && $request->filled('year')) {
            $namaBulan = Carbon::createFromDate(null, $request->month)->translatedFormat('F');
            $periode = "PERIODE " . strtoupper($namaBulan) . " " . $request->year;
        }

        // 5. Generate PDF
        return $this->generatePdf('admin.reports.requests_pdf', compact('requests', 'periode'), 'Laporan_Permohonan');
    }

    // ==========================================
    // PERBAIKAN: printDocuments dengan Filter
    // ==========================================
    public function printDocuments(Request $request) {

        // 1. Query Dasar
        $query = Document::query()->latest();

        // 2. Filter Bulan
        if ($request->filled('month')) {
            $query->whereMonth('created_at', $request->month);
        }

        // 3. Filter Tahun
        if ($request->filled('year')) {
            $query->whereYear('created_at', $request->year);
        }

        $documents = $query->get();

        // 4. Label Periode Dinamis
        // Default: TAHUN [Tahun Input] atau [Tahun Sekarang]
        $periode = "TAHUN " . ($request->year ?? date('Y'));

        // Jika Bulan & Tahun dipilih, judul lebih spesifik
        if ($request->filled('month') && $request->filled('year')) {
            $namaBulan = Carbon::createFromDate(null, $request->month)->translatedFormat('F');
            $periode = "PERIODE " . strtoupper($namaBulan) . " " . $request->year;
        }

        // 5. Generate PDF
        // Variabel '$periode' dikirim ke view agar judul PDF berubah
        return $this->generatePdf('admin.reports.documents_pdf', compact('documents', 'periode'), 'Laporan_Dokumen');
    }

    // ==========================================
    // printNews (Yang sudah diperbaiki sebelumnya)
    // ==========================================
    public function printNews(Request $request) {

        // 1. Query Dasar
        $query = Post::with(['category', 'user'])->latest();

        // 2. Filter Bulan
        if ($request->filled('month')) {
            $query->whereMonth('created_at', $request->month);
        }

        // 3. Filter Tahun
        if ($request->filled('year')) {
            $query->whereYear('created_at', $request->year);
        }

        $posts = $query->get();

        // 4. Label Periode Dinamis
        $labelPeriode = "TAHUN " . ($request->year ?? date('Y'));

        if ($request->filled('month') && $request->filled('year')) {
            $namaBulan = Carbon::createFromDate(null, $request->month)->translatedFormat('F');
            $labelPeriode = "PERIODE " . strtoupper($namaBulan) . " " . $request->year;
        }

        // 5. Generate PDF
        // Note: View PDF Berita memakai variabel '$labelPeriode', sedangkan Dokumen memakai '$periode'
        return $this->generatePdf('admin.reports.news_pdf', compact('posts', 'labelPeriode'), 'Laporan_Berita');
    }

    // GANTI method printSurveys dengan ini:
    public function printSurveys(Request $request) {

        // 1. Query Dasar
        $query = Survey::latest();

        // 2. Filter Bulan
        if ($request->filled('month')) {
            $query->whereMonth('created_at', $request->month);
        }

        // 3. Filter Tahun
        if ($request->filled('year')) {
            $query->whereYear('created_at', $request->year);
        }

        $surveys = $query->get();

        // Hitung rata-rata manual dari data yang sudah difilter
        $average = $surveys->count() > 0 ? $surveys->avg('rating') : 0;

        // 4. Label Periode Dinamis
        $periode = "TAHUN " . ($request->year ?? date('Y'));

        if ($request->filled('month') && $request->filled('year')) {
            $namaBulan = Carbon::createFromDate(null, $request->month)->translatedFormat('F');
            $periode = "PERIODE " . strtoupper($namaBulan) . " " . $request->year;
        }

        // 5. Generate PDF
        return $this->generatePdf('admin.reports.surveys_pdf', compact('surveys', 'average', 'periode'), 'Laporan_IKM');
    }

    public function printUsers() {
        // Ambil semua user
        // Urutkan: Super Admin dulu, baru Admin Biasa. Lalu urutkan nama A-Z.
        $users = User::orderBy('role', 'desc')
                     ->orderBy('name', 'asc')
                     ->get();

        // Generate PDF
        return $this->generatePdf('admin.reports.users_pdf', compact('users'), 'Laporan_Daftar_Petugas_PPID');
    }


    public function printObjections(Request $request)
    {
        // 1. Query Dasar
        $query = Objection::with('request')->latest();

        // 2. Filter Bulan
        if ($request->filled('month')) {
            $query->whereMonth('created_at', $request->month);
        }

        // 3. Filter Tahun
        if ($request->filled('year')) {
            $query->whereYear('created_at', $request->year);
        }

        $objections = $query->get();

        // 4. Label Periode Dinamis
        $periode = "TAHUN " . ($request->year ?? date('Y'));

        if ($request->filled('month') && $request->filled('year')) {
            $namaBulan = Carbon::createFromDate(null, $request->month)->translatedFormat('F');
            $periode = "PERIODE " . strtoupper($namaBulan) . " " . $request->year;
        }

        // 5. Generate PDF
        $pdf = Pdf::loadView('admin.reports.objections_pdf', compact('objections', 'periode'));
        $pdf->setPaper('a4', 'landscape'); // Landscape karena kolom keberatan biasanya lebar
        return $pdf->stream('Laporan_Keberatan.pdf');
    }

    public function printStatistics(Request $request) {

        // 1. Ambil Tahun (Default tahun sekarang jika kosong)
        $year = $request->input('year', date('Y'));

        // 2. Hitung Statistik Berdasarkan Tahun Tersebut
        $stats = [
            'requests_total'   => InformationRequest::whereYear('created_at', $year)->count(),
            'requests_pending' => InformationRequest::whereYear('created_at', $year)->where('status', 'pending')->count(),
            'requests_done'    => InformationRequest::whereYear('created_at', $year)->whereIn('status', ['finished', 'rejected'])->count(),

            'posts_total'      => Post::whereYear('created_at', $year)->count(),
            'posts_news'       => Post::whereYear('created_at', $year)->whereHas('category', fn($q) => $q->where('type', 'news'))->count(),

            'docs_total'       => Document::whereYear('created_at', $year)->count(),

            'surveys_total'    => Survey::whereYear('created_at', $year)->count(),
            'surveys_avg'      => Survey::whereYear('created_at', $year)->avg('rating') ?? 0,
        ];

        // 3. Label Periode
        $periode = "TAHUN " . $year;

        // 4. Generate PDF
        return $this->generatePdf('admin.reports.statistics_pdf', compact('stats', 'periode'), 'Laporan_Statistik_Tahunan');
    }
}
