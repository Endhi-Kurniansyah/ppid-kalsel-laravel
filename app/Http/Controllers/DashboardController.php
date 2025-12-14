<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InformationRequest; // Model Permohonan
use App\Models\Post;               // Model Berita
use App\Models\Document;           // Model Dokumen
use App\Models\User;               // Model User (Opsional)

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Hitung Data Statistik
        $totalRequests   = InformationRequest::count();
        $pendingRequests = InformationRequest::where('status', 'pending')->count();
        $totalPosts      = Post::count();
        $totalDocs       = Document::count();

        // 2. Ambil 5 Permohonan Terbaru (buat tabel mini)
        $latestRequests  = InformationRequest::latest()->take(5)->get();

        // 3. Kirim data ke View Dashboard
        return view('admin.dashboard', compact(
            'totalRequests',
            'pendingRequests',
            'totalPosts',
            'totalDocs',
            'latestRequests'
        ));
    }
}
