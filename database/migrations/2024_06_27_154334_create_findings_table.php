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
        Schema::create('findings', function (Blueprint $table) {
            $table->id('id');
            $table->bigInteger('audit_id')->unsigned();
            $table->foreign('audit_id')
                ->references('id')->on('audits')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('title')->nullable();
            $table->integer('consequence')->nullable();
            $table->integer('type_finding')->nullable();
            $table->integer('mark_finding')->nullable()->comment('jika nilai type_finding 1 maka mark_finding diisi');
            $table->json('reason')->nullable();
            $table->json('criteria')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('findings');
    }
};
