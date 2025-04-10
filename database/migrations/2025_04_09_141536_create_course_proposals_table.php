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
        Schema::create('course_proposals', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->string('como_descobriu');
            $table->text('descricao');
            $table->enum('status', ['pendente', 'em_analise', 'aprovado', 'rejeitado'])->default('pendente');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_proposals');
    }
};
