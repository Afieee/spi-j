<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('recomendeds', function (Blueprint $table) {
            $table->unsignedBigInteger('id_temuan')->after('id');
            $table->foreign('id_temuan')->references('id')->on('temuan')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('recomendeds', function (Blueprint $table) {
            $table->dropForeign(['id_temuan']);
            $table->dropColumn('id_temuan');
        });
    }
};
