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
            $table->string('ticket_number')->unique(); // No Tiket unik
            $table->text('information_needed'); // Rincian Informasi yang dibutuhkan
            $table->text('reason'); // Tujuan penggunaan informasi
            $table->enum('status', ['pending', 'process', 'accepted', 'rejected'])->default('pending');
            $table->date('finished_date')->nullable();
            // Relasi ke Tabel Applicants (Pemohon)
            $table->foreignId('applicant_id')->constrained('applicants')->onDelete('cascade');
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
