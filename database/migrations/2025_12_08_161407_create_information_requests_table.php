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
        Schema::create('information_requests', function (Blueprint $table) {
            $table->id();

            // --- BAGIAN 1: DATA DIRI (Pindahan dari tabel Applicants) ---
            $table->string('name');             // Nama Pemohon
            $table->string('nik');              // NIK KTP
            $table->string('ktp_file')->nullable(); // Foto KTP
            $table->string('email');
            $table->string('phone');
            $table->text('address');
            $table->string('job')->nullable();  // Pekerjaan

            // --- BAGIAN 2: DATA PERMINTAAN ---
            $table->string('ticket_number')->unique(); // Kode Tiket (REQ-001)
            $table->text('details');            // Rincian Info
            $table->text('purpose');            // Tujuan Penggunaan
            $table->string('get_method')->default('softcopy');      // Softcopy/Hardcopy
            $table->string('delivery_method')->default('email');    // Email/Langsung

            // --- BAGIAN 3: STATUS & ADMIN ---
            $table->string('status')->default('pending'); // pending, processed, finished, rejected
            $table->text('admin_note')->nullable();       // Jawaban Admin
            $table->string('reply_file')->nullable();     // File Jawaban

            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('information_requests');
    }
};
