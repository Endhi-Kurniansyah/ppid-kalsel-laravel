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
            $table->string('ticket_number')->unique();
            $table->text('details'); // <--- PASTIKAN INI 'details', BUKAN 'information_needed'
            $table->text('purpose');
            $table->enum('status', ['pending', 'processed', 'accepted', 'rejected'])->default('pending');
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
