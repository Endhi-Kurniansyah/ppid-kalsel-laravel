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
        Schema::create('surveys', function (Blueprint $table) {
            $table->id();
            $table->integer('rating'); // 1 (Sangat Buruk) - 5 (Sangat Puas)
            $table->text('feedback')->nullable(); // Masukan/Saran
            $table->ipAddress('ip_address')->nullable(); // Mencegah spam
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surveys');
    }
};
