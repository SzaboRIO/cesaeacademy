<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            // Primeiro remove a foreign key
            $table->dropForeign('new_courses_instructor_id_foreign');

            // Depois remove as colunas
            $table->dropColumn(['goals', 'instructor_id']);
        });
    }

    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->text('goals')->nullable(false);
            $table->unsignedBigInteger('instructor_id');

            // Recriar a foreign key (ajusta o nome da tabela se necessário)
            $table->foreign('instructor_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
};

