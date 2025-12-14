<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\InformationRequestController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ObjectionController;
use App\Models\Post;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    // Ambil 3 berita terbaru yang statusnya 'published'
    // with('user') gunanya biar kita bisa menampilkan nama penulisnya
    $posts = Post::with('user', 'category')->latest()->take(3)->get();

    return view('welcome', compact('posts'));
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/admin/requests/print', [App\Http\Controllers\InformationRequestController::class, 'print'])->name('admin.requests.print');
    Route::get('/admin/requests', [App\Http\Controllers\InformationRequestController::class, 'index'])->name('admin.requests.index');
    Route::get('/admin/requests/{id}', [InformationRequestController::class, 'show'])->name('admin.requests.show');
    Route::put('/admin/requests/{id}', [InformationRequestController::class, 'update'])->name('admin.requests.update');
    Route::get('/surveys/print', [App\Http\Controllers\SurveyController::class, 'print'])->name('surveys.print');
    Route::get('/surveys', [App\Http\Controllers\SurveyController::class, 'index'])->name('surveys.index');
    Route::get('/documents/print', [App\Http\Controllers\DocumentController::class, 'print'])->name('documents.print');
    Route::resource('documents', App\Http\Controllers\DocumentController::class);
    Route::resource('pages', \App\Http\Controllers\PageController::class);
    // RUTE ADMIN: KELOLA KEBERATAN
    Route::get('/admin/objections', [ObjectionController::class, 'index'])->name('admin.objections.index');
    Route::get('/admin/objections/{id}', [ObjectionController::class, 'show'])->name('admin.objections.show');
    Route::put('/admin/objections/{id}', [ObjectionController::class, 'update'])->name('admin.objections.update');
    // 5. Rute Berita / Artikel
    Route::resource('posts', \App\Http\Controllers\PostController::class);
});
// Rute Publik (Bisa diakses siapa saja)
Route::get('/ajukan-permohonan', [InformationRequestController::class, 'create'])->name('requests.create');
Route::post('/ajukan-permohonan', [InformationRequestController::class, 'store'])->name('requests.store');
Route::get('/permohonan-sukses/{ticket}', [InformationRequestController::class, 'success'])->name('requests.success');
Route::get('/cek-status', [InformationRequestController::class, 'track'])->name('requests.track');
Route::post('/survey', [App\Http\Controllers\SurveyController::class, 'store'])->name('survey.store');
Route::get('/informasi/{slug}', [App\Http\Controllers\PublicController::class, 'showDocuments'])->name('public.documents');
Route::get('/page/{slug}', [App\Http\Controllers\PublicController::class, 'showPage'])->name('public.page');
Route::get('/berita/{slug}', [PublicController::class, 'showNews'])->name('news.show');
// HALAMAN ARSIP BERITA
Route::get('/berita', [PublicController::class, 'newsIndex'])->name('news.index');
Route::get('/ajukan-keberatan', [ObjectionController::class, 'formSearch'])->name('objection.search'); // Cari Tiket
Route::get('/ajukan-keberatan/form', [ObjectionController::class, 'formCreate'])->name('objection.create'); // Isi Form
Route::post('/ajukan-keberatan', [ObjectionController::class, 'store'])->name('objection.store'); // Simpan
Route::get('/keberatan-sukses/{code}', [ObjectionController::class, 'success'])->name('objection.success'); // Sukses

require __DIR__.'/auth.php';
