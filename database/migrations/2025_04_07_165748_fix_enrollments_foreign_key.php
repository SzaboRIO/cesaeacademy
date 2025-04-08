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
        Schema::table('enrollments', function (Blueprint $table) {
            // Remover a chave estrangeira antiga
            $table->dropForeign('enrollments_course_id_foreign');

            // Adicionar a nova chave estrangeira apontando para a tabela correta
            $table->foreign('course_id')
                  ->references('id')
                  ->on('courses')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('enrollments', function (Blueprint $table) {
            // Remover a nova chave estrangeira
            $table->dropForeign('enrollments_course_id_foreign');

            // Restaurar a chave estrangeira original
            $table->foreign('course_id')
                  ->references('id')
                  ->on('courses_old')
                  ->onDelete('cascade');
        });
    }
};
