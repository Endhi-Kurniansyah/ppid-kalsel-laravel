<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // Di bagian paling atas file, pastikan ada ini:

// ... di dalam class migration ...

    public function up(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            // UBAH JADI LONGTEXT AGAR MUAT GAMBAR BASE64
            // Kita perlu nambahin ->nullable() buat jaga-jaga kalau datanya kosong
            $table->longText('content')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            // Kembalikan ke TEXT biasa kalau di-rollback
            $table->text('content')->nullable()->change();
        });
    }
};
