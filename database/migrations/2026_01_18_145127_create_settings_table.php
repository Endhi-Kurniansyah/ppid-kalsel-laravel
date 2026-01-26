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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            // Kolom 'key' untuk nama setting (misal: site_logo, hero_bg)
            // Dibuat unique agar tidak ada nama setting yang kembar
            $table->string('key')->unique();

            // Kolom 'value' untuk menyimpan path gambar
            // Dibuat text dan nullable (boleh kosong)
            $table->text('value')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
