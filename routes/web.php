<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\InformationRequestController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ObjectionController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\SettingController;
use App\Models\Post;
use App\Models\Survey; // Pastikan Model Survey di-import
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes (FRONTEND / PUBLIK)
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    // 1. Ambil 3 Berita Terbaru
    $posts = Post::with('user', 'category')->latest()->take(3)->get();

    // 2. Hitung Statistik Survei
    $surveyStats = [
        'average' => Survey::avg('rating') ?? 0,
        'count'   => Survey::count(),
        '5_star'  => Survey::where('rating', 5)->count(),
    ];

    // 3. Label Kepuasan
    $avg = $surveyStats['average'];
    $label = 'Belum Ada Data';

    if ($avg > 0) $label = 'Kurang';
    if ($avg > 2) $label = 'Cukup';
    if ($avg > 3) $label = 'Baik';
    if ($avg > 4) $label = 'Sangat Baik';
    if ($avg > 4.8) $label = 'Luar Biasa';

    return view('welcome', compact('posts', 'surveyStats', 'label'));
});

// 1. PERMOHONAN INFORMASI
Route::get('/ajukan-permohonan', [InformationRequestController::class, 'create'])->name('requests.create');
Route::post('/ajukan-permohonan', [InformationRequestController::class, 'store'])->name('requests.store');
Route::get('/permohonan-sukses/{ticket}', [InformationRequestController::class, 'success'])->name('requests.success');
Route::get('/cek-status', [InformationRequestController::class, 'track'])->name('requests.track');

// 2. PENGAJUAN KEBERATAN
Route::get('/ajukan-keberatan', [ObjectionController::class, 'formSearch'])->name('objection.search');
Route::get('/ajukan-keberatan/form', [ObjectionController::class, 'formCreate'])->name('objection.create');
Route::post('/ajukan-keberatan', [ObjectionController::class, 'store'])->name('objection.store');
Route::get('/keberatan-sukses/{code}', [ObjectionController::class, 'success'])->name('objection.success');

// 3. BERITA
Route::get('/berita', [PublicController::class, 'newsIndex'])->name('news.index');
Route::get('/berita/{slug}', [PublicController::class, 'showNews'])->name('news.show');

// ==========================================================
// 4. DOKUMEN PUBLIK (FIXED ORDER)
// ==========================================================

// A. Route SPESIFIK (Wajib di Atas) - Menangani Menu DIP
Route::get('/dokumen/dip', [DocumentController::class, 'dipIndex'])->name('documents.dip');

// B. Route PENCARIAN - Diarahkan ke indexPublic
Route::get('/pencarian', [DocumentController::class, 'indexPublic'])->name('documents.search');

// C. Route DETAIL DOKUMEN
// Ganti 'documents.show' menjadi 'documents.public.show'
Route::get('/dokumen-publik/{slug}', [DocumentController::class, 'showPublic'])->name('documents.public.show');

// D. Route WILDCARD / UMUM (Wajib Paling Bawah)
// Menangani kategori seperti /dokumen/berkala, /dokumen/serta-merta, dll
Route::get('/dokumen/{category?}', [DocumentController::class, 'indexPublic'])->name('documents.public');


// 5. SURVEI & KONTAK
Route::post('/survey', [SurveyController::class, 'store'])->name('survey.store');
Route::get('/page/kontak', [PublicController::class, 'contact'])->name('contact.index');

// 6. HALAMAN DINAMIS
Route::get('/page/{slug}', [PageController::class, 'show'])->name('public.page');


/*
|--------------------------------------------------------------------------
| Auth & Admin Routes
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Notifikasi
    Route::get('/admin/notifications/mark-all-read', function () {
        auth()->user()->unreadNotifications->markAsRead();
        return back()->with('success', 'Semua notifikasi telah ditandai dibaca.');
    })->name('admin.notifications.readAll');

    // Manual Controllers
    Route::get('/admin/requests', [InformationRequestController::class, 'index'])->name('admin.requests.index');
    Route::get('/admin/requests/{id}', [InformationRequestController::class, 'show'])->name('admin.requests.show');
    Route::put('/admin/requests/{id}', [InformationRequestController::class, 'update'])->name('admin.requests.update');

    Route::get('/admin/objections', [ObjectionController::class, 'index'])->name('admin.objections.index');
    Route::get('/admin/objections/{id}', [ObjectionController::class, 'show'])->name('admin.objections.show');
    Route::put('/admin/objections/{id}', [ObjectionController::class, 'update'])->name('admin.objections.update');

    // Resource Controllers
    Route::resource('posts', PostController::class);
    Route::resource('documents', DocumentController::class);
    Route::resource('pages', PageController::class);
    Route::put('/pages/{id}/toggle-lock', [PageController::class, 'toggleLock'])->name('pages.toggle-lock');
    Route::post('/pages/upload-image', [PageController::class, 'uploadImage'])->name('pages.upload.image');

    // Admin Tools
    Route::get('/surveys', [SurveyController::class, 'index'])->name('surveys.index');
    Route::resource('admin/users', AdminUserController::class)->names('admin.users');
    Route::put('admin/users/{id}/reset', [AdminUserController::class, 'resetPassword'])->name('admin.users.reset');
    Route::put('admin/users/{id}/toggle', [AdminUserController::class, 'toggleStatus'])->name('admin.users.toggle');

    // Menus & Settings
    Route::get('/menus', [MenuController::class, 'index'])->name('menus.index');
    Route::post('/menus', [MenuController::class, 'store'])->name('menus.store');
    Route::get('/menus/{id}/edit', [MenuController::class, 'edit'])->name('menus.edit');
    Route::put('/menus/{id}', [MenuController::class, 'update'])->name('menus.update');
    Route::delete('/menus/{id}', [MenuController::class, 'destroy'])->name('menus.destroy');

    Route::get('/admin/settings', [SettingController::class, 'index'])->name('admin.settings.index');
    Route::put('/admin/settings', [SettingController::class, 'update'])->name('admin.settings.update');

    // Reports
    Route::prefix('admin/reports')->name('admin.reports.')->group(function () {
        Route::get('/requests', [ReportController::class, 'printRequests'])->name('requests');
        Route::get('/documents', [ReportController::class, 'printDocuments'])->name('documents');
        Route::get('/surveys', [ReportController::class, 'printSurveys'])->name('surveys');
        Route::get('/news', [ReportController::class, 'printNews'])->name('news');
        Route::get('/objections', [ReportController::class, 'printObjections'])->name('objections');
        Route::get('/statistics', [ReportController::class, 'printStatistics'])->name('statistics');
        Route::get('/users', [ReportController::class, 'printUsers'])->name('users');
    });
});
