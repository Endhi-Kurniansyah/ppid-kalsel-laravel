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
        Schema::create('applicants', function (Blueprint $table) {
            $table->id();
            $table->string('nik_ktp')->unique(); // Identitas wajib
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->text('address');
            $table->string('job')->nullable(); // Pekerjaan
            $table->enum('type', ['perorangan', 'kelompok', 'badan_hukum']); // Jenis Pemohon
            $table->string('ktp_file')->nullable(); // Foto KTP
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applicants');
    }
};
