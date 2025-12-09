<?php

namespace App\Http\Controllers;

use App\Models\InformationRequest;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class InformationRequestController extends Controller
{
    public function index()
    {
        // Mengambil semua data request, urutkan dari yang terbaru
        // 'applicant' itu nama fungsi relasi di Model InformationRequest tadi
        $requests = InformationRequest::with('applicant')->latest()->get();

        return view('admin.requests.index', compact('requests'));
    }
    // Fungsi untuk mencetak Laporan PDF
    public function print()
    {
        // Ambil data yang statusnya 'accepted' (Diterima) atau semua data
        $requests = InformationRequest::with('applicant')->get();

        // Load view khusus PDF (nanti kita buat)
        $pdf = Pdf::loadView('admin.requests.print', compact('requests'));

        // Setup ukuran kertas (A4 Landscape biar muat banyak)
        $pdf->setPaper('a4', 'landscape');

        // Download atau tampilkan di browser
        return $pdf->stream('laporan-permohonan-informasi.pdf');
    }
}
