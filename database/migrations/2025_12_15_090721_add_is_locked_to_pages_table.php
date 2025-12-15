<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            // 1. Tambahkan kolom 'status' jika belum ada (Supaya tidak error view-nya nanti)
            if (!Schema::hasColumn('pages', 'status')) {
                // Kita taruh setelah 'content' (isi halaman)
                $table->string('status')->default('published')->after('content');
            }

            // 2. Tambahkan kolom 'is_locked' (Untuk fitur kunci halaman)
            // Kita taruh setelah 'content' juga (atau setelah status jika baru dibuat)
            $table->boolean('is_locked')->default(false)->after('content');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            // Hapus kolom saat rollback
            $table->dropColumn('is_locked');

            // Opsional: Hapus status jika mau (tapi hati-hati data hilang)
            // $table->dropColumn('status');
        });
    }
};
