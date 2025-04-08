<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixReviewsForeignKey extends Migration
{
    /**
     * Run the migrations.
     *
     * Este método 'up' vai:
     * - Remover a foreign key que referencia 'courses_old';
     * - Criar nova foreign key para a tabela 'courses'.
     */
    public function up()
    {
        Schema::table('reviews', function (Blueprint $table) {
            // 1. Primeiro removemos a FK antiga
            // Obs: Substitua 'reviews_course_id_foreign' pelo nome exato da FK se for diferente
            $table->dropForeign('reviews_course_id_foreign');

            // 2. Agora criamos a FK correta apontando para 'courses'
            $table->foreign('course_id')
                  ->references('id')
                  ->on('courses')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * Aqui, se quiser voltar atrás, você recriaria a FK antiga
     * apontando para 'courses_old', caso ainda exista.
     */
    public function down()
    {
        Schema::table('reviews', function (Blueprint $table) {
            // Remover a nova FK
            $table->dropForeign(['course_id']);

            // Se desejar recriar a FK antiga para 'courses_old', faça:
            $table->foreign('course_id')
                  ->references('id')
                  ->on('courses_old')
                  ->onDelete('cascade');
        });
    }
}
