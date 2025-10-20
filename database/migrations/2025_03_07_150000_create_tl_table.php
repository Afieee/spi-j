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
        Schema::create('tl', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_recomendeds');
            $table->text('catatan_tl')->nullable();
            $table->string('status_tl')->nullable();
            $table->date('batas_waktu')->nullable();
            $table->timestamps();

            $table->foreign('id_recomendeds')
                ->references('id')->on('recomendeds')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tl');
    }
};
