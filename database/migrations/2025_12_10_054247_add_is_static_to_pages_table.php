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
        Schema::table('pages', function (Blueprint $table) {
            // Kita tambahkan kolom is_static dengan default 0 (False/Tidak Statis)
            $table->boolean('is_static')->default(0)->after('content');
        });
    }

    public function down()
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn('is_static');
        });
    }
};
