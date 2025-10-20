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
        Schema::table('audits', function (Blueprint $table) {
            $table->text('berita_acara_exit_meeting')->nullable();
            $table->text('pka')->nullable();
            $table->text('laporan_dan_lampiran')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('audits', function (Blueprint $table) {
            $table->dropColumn(['berita_acara_exit_meeting', 'pka', 'laporan_dan_lampiran']);
        });
    }
};
