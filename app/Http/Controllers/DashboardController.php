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
        // Ambil data
        $totalRequests   = InformationRequest::count();
        $pendingRequests = InformationRequest::where('status', 'pending')->count();
        $totalPosts      = Post::count();
        $totalDocs       = Document::count();
        $latestRequests  = InformationRequest::latest()->take(5)->get();

        // Pastikan SEMUA ada di dalam compact ini
        return view('admin.dashboard', compact(
            'totalRequests',
            'pendingRequests',
            'totalPosts',
            'totalDocs',
            'latestRequests'
        ));
    }
}
