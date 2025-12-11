<?php

use App\Http\Controllers\ProfileController;
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

Route::get('/dashboard', function () {
    return view('admin.dashboard'); // Arahkan ke folder admin/dashboard
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/requests/print', [App\Http\Controllers\InformationRequestController::class, 'print'])->name('requests.print');
    Route::resource('requests', \App\Http\Controllers\InformationRequestController::class);
    Route::get('/surveys/print', [App\Http\Controllers\SurveyController::class, 'print'])->name('surveys.print');
    Route::get('/surveys', [App\Http\Controllers\SurveyController::class, 'index'])->name('surveys.index');
    Route::get('/documents/print', [App\Http\Controllers\DocumentController::class, 'print'])->name('documents.print');
    Route::resource('documents', App\Http\Controllers\DocumentController::class);
    Route::resource('pages', \App\Http\Controllers\PageController::class);
    // 5. Rute Berita / Artikel
    Route::resource('posts', \App\Http\Controllers\PostController::class);
});
// Rute Publik (Bisa diakses siapa saja)
Route::get('/ajukan-permohonan', [App\Http\Controllers\PublicController::class, 'showForm'])->name('public.form');
Route::post('/ajukan-permohonan', [App\Http\Controllers\PublicController::class, 'submitRequest'])->name('public.submit');
Route::post('/survey', [App\Http\Controllers\SurveyController::class, 'store'])->name('survey.store');
Route::get('/informasi/{slug}', [App\Http\Controllers\PublicController::class, 'showDocuments'])->name('public.documents');
Route::get('/page/{slug}', [App\Http\Controllers\PublicController::class, 'showPage'])->name('public.page');

require __DIR__.'/auth.php';
