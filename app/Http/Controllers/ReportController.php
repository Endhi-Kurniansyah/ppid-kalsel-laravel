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
    // Fungsi pembantu untuk setting kertas A4
    private function generatePdf($view, $data, $filename) {
        // AMBIL SETTING LAPORAN
        $reportSettings = Setting::whereIn('key', [
            'report_header_address',
            'report_signer_name',
            'report_signer_nip',
            'report_signer_rank',
            'report_signer_position'
        ])->pluck('value', 'key')->toArray();

        // GABUNGKAN DATA
        $data = array_merge($data, ['reportSettings' => $reportSettings]);

        $pdf = Pdf::loadView($view, $data);
        $pdf->setPaper('a4', 'portrait');
        return $pdf->stream($filename . '.pdf');
    }

    // GANTI method printRequests dengan ini:
    public function printRequests(Request $request) {

        // 1. Query Dasar
        $query = InformationRequest::query();

        // 2. Filter Bulan
        if ($request->filled('month')) {
            $query->whereMonth('created_at', $request->month);
        }

        // 3. Filter Tahun
        if ($request->filled('year')) {
            $query->whereYear('created_at', $request->year);
        }

        // 4. Search by NIK, Name, or Ticket Number
        if ($request->filled('q')) {
            $keyword = $request->q;
            $query->where(function($q) use ($keyword) {
                $q->where('nik', 'LIKE', "%{$keyword}%")
                  ->orWhere('name', 'LIKE', "%{$keyword}%")
                  ->orWhere('ticket_number', 'LIKE', "%{$keyword}%");
            });
        }

        // 5. Filter Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $requests = $query->latest()->get();

        // 5. Label Periode Dinamis
        $periode = "TAHUN " . ($request->year ?? date('Y'));

        if ($request->filled('month') && $request->filled('year')) {
            $namaBulan = Carbon::createFromDate(null, $request->month)->translatedFormat('F');
            $periode = "PERIODE " . strtoupper($namaBulan) . " " . $request->year;
        }

        // 6. Generate PDF
        return $this->generatePdf('admin.reports.requests_pdf', compact('requests', 'periode'), 'Laporan_Permohonan');
    }

    // ==========================================
    // PERBAIKAN: printDocuments dengan Filter
    // ==========================================
    public function printDocuments(Request $request) {

        // 1. Query Dasar
        $query = Document::query();

        // 2. Filter Bulan
        if ($request->filled('month')) {
            $query->whereMonth('created_at', $request->month);
        }

        // 3. Filter Tahun
        if ($request->filled('year')) {
            $query->whereYear('created_at', $request->year);
        }

        // 4. Filter Kategori
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // 5. Search by Title/Description
        if ($request->filled('q')) {
            $keyword = $request->q;
            $query->where(function($q) use ($keyword) {
                $q->where('title', 'LIKE', "%{$keyword}%")
                  ->orWhere('description', 'LIKE', "%{$keyword}%");
            });
        }

        $documents = $query->latest()->get();

        // 6. Label Periode Dinamis
        $periode = "TAHUN " . ($request->year ?? date('Y'));

        if ($request->filled('month') && $request->filled('year')) {
            $namaBulan = Carbon::createFromDate(null, $request->month)->translatedFormat('F');
            $periode = "PERIODE " . strtoupper($namaBulan) . " " . $request->year;
        }

        // 7. Generate PDF
        return $this->generatePdf('admin.reports.documents_pdf', compact('documents', 'periode'), 'Laporan_Dokumen');
    }

    // ==========================================
    // printNews (Yang sudah diperbaiki sebelumnya)
    // ==========================================
    public function printNews(Request $request) {

        // 1. Query Dasar
        $query = Post::with(['category', 'user']);

        // 2. Filter Bulan
        if ($request->filled('month')) {
            $query->whereMonth('created_at', $request->month);
        }

        // 3. Filter Tahun
        if ($request->filled('year')) {
            $query->whereYear('created_at', $request->year);
        }

        // 4. Filter Kategori
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // 5. Search by Title
        if ($request->filled('q')) {
            $query->where('title', 'LIKE', '%' . $request->q . '%');
        }

        // 6. Sort Options
        $sort = $request->get('sort', 'terbaru');
        switch ($sort) {
            case 'terlama':
                $query->oldest();
                break;
            case 'terpopuler':
                $query->orderBy('views', 'desc');
                break;
            case 'terbaru':
            default:
                $query->latest();
                break;
        }

        $posts = $query->get();

        // 7. Label Periode Dinamis
        $labelPeriode = "TAHUN " . ($request->year ?? date('Y'));

        if ($request->filled('month') && $request->filled('year')) {
            $namaBulan = Carbon::createFromDate(null, $request->month)->translatedFormat('F');
            $labelPeriode = "PERIODE " . strtoupper($namaBulan) . " " . $request->year;
        }

        // 8. Generate PDF
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

        // 4. Filter Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // 5. Search by Objection Code or Applicant Name
        if ($request->filled('q')) {
            $keyword = $request->q;
            $query->where(function($q) use ($keyword) {
                $q->where('objection_code', 'LIKE', "%{$keyword}%")
                  ->orWhereHas('request', function($subQ) use ($keyword) {
                      $subQ->where('name', 'LIKE', "%{$keyword}%")
                           ->orWhere('ticket_number', 'LIKE', "%{$keyword}%");
                  });
            });
        }

        $objections = $query->get();

        // 6. Label Periode Dinamis
        $periode = "TAHUN " . ($request->year ?? date('Y'));

        if ($request->filled('month') && $request->filled('year')) {
            $namaBulan = Carbon::createFromDate(null, $request->month)->translatedFormat('F');
            $periode = "PERIODE " . strtoupper($namaBulan) . " " . $request->year;
        }

        // 7. Generate PDF
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
