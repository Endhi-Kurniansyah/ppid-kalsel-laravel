<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\InformationRequestController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ObjectionController;
use App\Http\Controllers\AdminUserController; // <--- 1. INI DITAMBAHKAN
use App\Models\Post;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// === 1. HALAMAN DEPAN (PUBLIK) ===
Route::get('/', function () {
    $posts = Post::with('user', 'category')->latest()->take(3)->get();
    return view('welcome', compact('posts'));
});

// === 2. DASHBOARD (LOGIN DULU) ===
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// === 3. GROUP KHUSUS ADMIN (HARUS LOGIN) ===
Route::middleware('auth')->group(function () {

    // A. Profil Admin
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // B. Manajemen Permohonan Informasi
    Route::get('/admin/requests/print', [InformationRequestController::class, 'print'])->name('admin.requests.print');
    Route::get('/admin/requests', [InformationRequestController::class, 'index'])->name('admin.requests.index');
    Route::get('/admin/requests/{id}', [InformationRequestController::class, 'show'])->name('admin.requests.show');
    Route::put('/admin/requests/{id}', [InformationRequestController::class, 'update'])->name('admin.requests.update');

    // C. Manajemen Pengajuan Keberatan
    Route::get('/admin/objections', [ObjectionController::class, 'index'])->name('admin.objections.index');
    Route::get('/admin/objections/{id}', [ObjectionController::class, 'show'])->name('admin.objections.show');
    Route::put('/admin/objections/{id}', [ObjectionController::class, 'update'])->name('admin.objections.update');

    // D. Manajemen Konten (Berita, Dokumen, Halaman, Survey)
    Route::resource('posts', \App\Http\Controllers\PostController::class);
    Route::get('/documents/print', [App\Http\Controllers\DocumentController::class, 'print'])->name('documents.print');
    Route::resource('documents', App\Http\Controllers\DocumentController::class);
    Route::resource('pages', \App\Http\Controllers\PageController::class);
    Route::put('/pages/{id}/toggle-lock', [\App\Http\Controllers\PageController::class, 'toggleLock'])->name('pages.toggle-lock');
    Route::get('/surveys/print', [App\Http\Controllers\SurveyController::class, 'print'])->name('surveys.print');
    Route::get('/surveys', [App\Http\Controllers\SurveyController::class, 'index'])->name('surveys.index');

    // E. MANAJEMEN USER / SUPER ADMIN (YANG BARU KITA BUAT)
    // -----------------------------------------------------
    Route::resource('admin/users', AdminUserController::class)->names('admin.users');
    Route::put('admin/users/{id}/reset', [AdminUserController::class, 'resetPassword'])->name('admin.users.reset');
    Route::put('admin/users/{id}/toggle', [AdminUserController::class, 'toggleStatus'])->name('admin.users.toggle');
    // -----------------------------------------------------
    Route::post('/pages/upload-image', [App\Http\Controllers\PageController::class, 'uploadImage'])->name('pages.upload.image');
});

// === 4. RUTE AKSES PUBLIK (TANPA LOGIN) ===

// Layanan Permohonan
Route::get('/ajukan-permohonan', [InformationRequestController::class, 'create'])->name('requests.create');
Route::post('/ajukan-permohonan', [InformationRequestController::class, 'store'])->name('requests.store');
Route::get('/permohonan-sukses/{ticket}', [InformationRequestController::class, 'success'])->name('requests.success');
Route::get('/cek-status', [InformationRequestController::class, 'track'])->name('requests.track');

// Layanan Keberatan
Route::get('/ajukan-keberatan', [ObjectionController::class, 'formSearch'])->name('objection.search');
Route::get('/ajukan-keberatan/form', [ObjectionController::class, 'formCreate'])->name('objection.create');
Route::post('/ajukan-keberatan', [ObjectionController::class, 'store'])->name('objection.store');
Route::get('/keberatan-sukses/{code}', [ObjectionController::class, 'success'])->name('objection.success');

// Halaman Informasi & Berita
Route::get('/berita', [PublicController::class, 'newsIndex'])->name('news.index');
Route::get('/berita/{slug}', [PublicController::class, 'showNews'])->name('news.show');
Route::get('/informasi/{slug}', [PublicController::class, 'showDocuments'])->name('public.documents');
Route::get('/page/{slug}', [PublicController::class, 'showPage'])->name('public.page');

// Survey Kepuasan
Route::post('/survey', [App\Http\Controllers\SurveyController::class, 'store'])->name('survey.store');

require __DIR__.'/auth.php';
