<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Fazer backup da tabela original (opcional)
        Schema::rename('courses', 'courses_old');

        // Renomear a nova tabela para o nome original
        Schema::rename('new_courses', 'courses');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reverter renomeação
        Schema::rename('courses', 'new_courses');
        Schema::rename('courses_old', 'courses');
    }
};
