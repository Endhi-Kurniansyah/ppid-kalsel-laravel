<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\Paginator;

// Import Model
use App\Models\Setting;
use App\Models\Page;
use App\Models\Menu;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // 1. Set Paginator Bootstrap (Agar tampilan tabel rapi)
        Paginator::useBootstrap();

        // 2. Logika Sharing Data (Dibungkus Try-Catch agar aman saat Migrate)
        try {

            // A. LOGIKA SETTINGS (Global)
            if (Schema::hasTable('settings')) {
                // Ambil semua setting jadikan array [key => value]
                $globalSettings = Setting::pluck('value', 'key')->toArray();
                View::share('globalSettings', $globalSettings);
            } else {
                View::share('globalSettings', []);
            }

            // B. LOGIKA MENU NAVBAR (Dinamis 3 Level)
            if (Schema::hasTable('menus')) {
                $navbarMenus = Menu::whereNull('parent_id') // Ambil Bapak (Level 1)
                    ->with(['children' => function ($query) {
                        // Ambil Anak (Level 2) & Urutkan
                        $query->orderBy('order', 'asc')
                              ->with(['children' => function ($subQuery) {
                                  // Ambil Cucu (Level 3) & Urutkan
                                  $subQuery->orderBy('order', 'asc');
                              }]);
                    }])
                    ->orderBy('order', 'asc') // Urutkan Bapak
                    ->get();

                View::share('navbarMenus', $navbarMenus);
            } else {
                // Kirim koleksi kosong jika tabel belum ada
                View::share('navbarMenus', collect([]));
            }

            // C. LOGIKA HALAMAN STATIS (Opsional / Legacy)
            if (Schema::hasTable('pages')) {
                $navbarPages = Page::where('is_static', 0)->latest()->get();
                View::share('navbarPages', $navbarPages);
            } else {
                View::share('navbarPages', collect([]));
            }

        } catch (\Exception $e) {
            // JIKA DATABASE ERROR / BELUM DI-MIGRATE
            // Kita kirim data kosong agar website tidak crash (Blank White Screen)
            View::share('globalSettings', []);
            View::share('navbarMenus', collect([]));
            View::share('navbarPages', collect([]));
        }
    }
}
