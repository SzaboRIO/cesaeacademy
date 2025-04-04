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
        Schema::table('lessons', function (Blueprint $table) {
            // Adiciona a nova coluna module_id
            $table->foreignId('module_id')->nullable()->after('course_id')->constrained()->onDelete('cascade');

            // Não remove a coluna module ainda, para poder migrar os dados
        });

        // Aqui você pode adicionar código para migrar dados do campo module para module_id
        // se precisar manter dados existentes

        // Depois, em uma segunda operação, remove a coluna antiga
        Schema::table('lessons', function (Blueprint $table) {
            $table->dropColumn('module');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lessons', function (Blueprint $table) {
            // Adiciona o campo module de volta
            $table->integer('module')->nullable()->after('course_id');

            // Remove a chave estrangeira e a coluna module_id
            $table->dropForeign(['module_id']);
            $table->dropColumn('module_id');
        });
    }
};
