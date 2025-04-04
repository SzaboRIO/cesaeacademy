<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('modules', function (Blueprint $table) {
            // 1. Soltar a FK antiga, se existir
            $table->dropForeign(['course_id']);

            // 2. Recriar a FK correta
            $table->foreign('course_id')
                  ->references('id')
                  ->on('courses')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        // No "down", você poderia refazer a FK antiga se quisesse, mas em geral só deixa vazio ou repete inverso.
        Schema::table('modules', function (Blueprint $table) {
            $table->dropForeign(['course_id']);
            // Se quiser recolocar a antiga, faria aqui.
        });
    }
};
