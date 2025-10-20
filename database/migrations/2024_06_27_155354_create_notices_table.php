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
        Schema::create('notices', function (Blueprint $table) {
            $table->id('id');
            $table->bigInteger('audit_id')->unsigned();
            $table->foreign('audit_id')
                ->references('id')->on('audits')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->integer('consequence')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notices');
    }
};
