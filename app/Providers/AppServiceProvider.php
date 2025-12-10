<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Page;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        try {
            // Logika: Ambil halaman yang TIDAK TERKUNCI (is_static = 0)
            // Ini adalah halaman-halaman tambahan yang dibuat admin (termasuk yang "ngasal")
            $halamanTambahan = Page::where('is_static', 0)->latest()->get();

            // Kirim variabel $navbarPages ke semua tampilan website
            View::share('navbarPages', $halamanTambahan);

        } catch (\Exception $e) {
            // Kalau error, kirim kosong saja biar web gak crash
            View::share('navbarPages', collect([]));
        }
    }
}
