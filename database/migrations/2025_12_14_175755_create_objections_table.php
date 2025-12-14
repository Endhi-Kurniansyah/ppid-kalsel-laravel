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
        Schema::create('objections', function (Blueprint $table) {
            $table->id();

            // Terhubung ke tabel Permohonan Informasi
            $table->foreignId('information_request_id')->constrained()->onDelete('cascade');

            // Kode Unik Keberatan (Misal: OBJ-2025-001)
            $table->string('objection_code')->unique();

            // Data Pengajuan
            $table->string('reason'); // Alasan Keberatan (Pilih dari opsi)
            $table->text('description'); // Kasus Posisi (Cerita lengkapnya)

            // Data Proses Admin (Atasan PPID)
            $table->string('status')->default('pending'); // pending, processed, finished, rejected
            $table->text('admin_note')->nullable(); // Keputusan Atasan PPID

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('objections');
    }
};
