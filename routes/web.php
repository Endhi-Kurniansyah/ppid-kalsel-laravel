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
use App\Http\Controllers\GalleryController;
use App\Models\Post;
use App\Models\Survey;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes (FRONTEND / PUBLIK)
|--------------------------------------------------------------------------
*/

// PERBAIKAN: Root route sekarang mengarah ke landing page
Route::get('/', [PublicController::class, 'home'])->name('home');

// ROUTE PUBLIK LAINNYA
Route::get('/ajukan-permohonan', [InformationRequestController::class, 'create'])->name('requests.create');
Route::post('/ajukan-permohonan', [InformationRequestController::class, 'store'])->name('requests.store');
Route::get('/permohonan-sukses/{ticket}', [InformationRequestController::class, 'success'])->name('requests.success');
Route::get('/cek-status', [InformationRequestController::class, 'track'])->name('requests.track');

Route::get('/ajukan-keberatan', [ObjectionController::class, 'formSearch'])->name('objection.search');
Route::get('/ajukan-keberatan/form', [ObjectionController::class, 'formCreate'])->name('objection.create');
Route::post('/ajukan-keberatan', [ObjectionController::class, 'store'])->name('objection.store');
Route::get('/keberatan-sukses/{code}', [ObjectionController::class, 'success'])->name('objection.success');

Route::get('/berita', [PublicController::class, 'newsIndex'])->name('news.index');
Route::get('/berita/{slug}', [PublicController::class, 'showNews'])->name('news.show');
Route::get('/galeri', [PublicController::class, 'gallery'])->name('gallery.public');
Route::get('/pencarian-global', [PublicController::class, 'globalSearch'])->name('global.search');

Route::get('/dokumen/dip', [DocumentController::class, 'dipIndex'])->name('documents.dip');
Route::get('/pencarian', [DocumentController::class, 'indexPublic'])->name('documents.search');
Route::get('/dokumen-publik/{slug}', [DocumentController::class, 'showPublic'])->name('documents.public.show');
Route::get('/dokumen/{category?}', [DocumentController::class, 'indexPublic'])->name('documents.public');

Route::post('/survey', [SurveyController::class, 'store'])->name('survey.store');
Route::get('/page/kontak', [PublicController::class, 'contact'])->name('contact.index');
Route::get('/page/{slug}', [PageController::class, 'show'])->name('public.page');

Route::get('/refresh-captcha', function() {
    return response()->json(['captcha' => captcha_img('flat')]);
})->name('captcha.refresh');

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

    // 1. Profil & Notifikasi
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/admin/notifications/mark-all-read', function () {
        auth()->user()->unreadNotifications->markAsRead();
        return back()->with('success', 'Semua notifikasi telah ditandai dibaca.');
    })->name('admin.notifications.readAll');

    // 2. Grup Utama Admin
    Route::prefix('admin')->name('admin.')->group(function() {
        Route::resource('users', AdminUserController::class);
        Route::put('users/{id}/reset', [AdminUserController::class, 'resetPassword'])->name('users.reset');
        Route::put('users/{id}/toggle', [AdminUserController::class, 'toggleStatus'])->name('users.toggle');

        Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
        Route::put('/settings', [SettingController::class, 'update'])->name('settings.update');

        Route::get('/requests', [InformationRequestController::class, 'index'])->name('requests.index');
        Route::get('/requests/{id}', [InformationRequestController::class, 'show'])->name('requests.show');
        Route::put('/requests/{id}', [InformationRequestController::class, 'update'])->name('requests.update');

        Route::get('/objections', [ObjectionController::class, 'index'])->name('objections.index');
        Route::get('/objections/{id}', [ObjectionController::class, 'show'])->name('objections.show');
        Route::put('/objections/{id}', [ObjectionController::class, 'update'])->name('objections.update');
    });

    // 3. Resource Konten
    Route::resource('posts', PostController::class);
    Route::resource('documents', DocumentController::class);
    Route::resource('pages', PageController::class);
    Route::put('/pages/{id}/toggle-lock', [PageController::class, 'toggleLock'])->name('pages.toggle-lock');
    Route::post('/pages/upload-image', [PageController::class, 'uploadImage'])->name('pages.upload.image');
    Route::resource('galleries', GalleryController::class);

    Route::get('/surveys', [SurveyController::class, 'index'])->name('surveys.index');
    Route::get('/menus', [MenuController::class, 'index'])->name('menus.index');
    Route::post('/menus', [MenuController::class, 'store'])->name('menus.store');
    Route::get('/menus/{id}/edit', [MenuController::class, 'edit'])->name('menus.edit');
    Route::put('/menus/{id}', [MenuController::class, 'update'])->name('menus.update');
    Route::delete('/menus/{id}', [MenuController::class, 'destroy'])->name('menus.destroy');

    // 4. Laporan (Cetak PDF)
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
