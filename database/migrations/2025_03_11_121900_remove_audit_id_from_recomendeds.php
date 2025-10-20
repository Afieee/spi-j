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
        Schema::table('recomendeds', function (Blueprint $table) {
            $table->dropForeign(['audit_id']);
            $table->dropColumn('audit_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('recomendeds', function (Blueprint $table) {
            $table->unsignedBigInteger('audit_id')->after('id');
            $table->foreign('audit_id')->references('id')->on('audits')->onDelete('cascade');
        });
    }
};
