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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('title');

            // --- INI PERUBAHANNYA ---
            // Kita ubah jadi string biasa (teks), bukan foreignId.
            // Supaya Mas bisa langsung simpan 'sop', 'berkala', dll.
            $table->string('category');
            // ------------------------

            $table->string('file_path');

            // Deskripsi boleh kosong
            $table->text('description')->nullable();

            // Tanggal terbit (opsional, kalau kosong pakai created_at saja)
            $table->date('published_date')->nullable();

            // Kita hapus user_id dulu biar gak ribet error login
            // $table->foreignId('user_id')->constrained();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
