<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama menu (Misal: "Profil")
            $table->string('url')->nullable(); // Link tujuannya

            // INI KUNCINYA AGAR BISA BERTINGKAT
            // Jika kosong = Menu Utama. Jika ada isi = Sub Menu.
            $table->unsignedBigInteger('parent_id')->nullable();

            $table->integer('order')->default(0); // Untuk mengatur urutan (1, 2, 3...)
            $table->boolean('is_active')->default(true); // Bisa disembunyikan tanpa dihapus
            $table->timestamps();

            // Relasi agar aman (Self Join)
            $table->foreign('parent_id')->references('id')->on('menus')->onDelete('cascade');
        });
    }

        /**
         * Reverse the migrations.
         */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
