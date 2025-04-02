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
        Schema::create('new_courses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->text('objectives')->nullable();
            $table->string('image')->nullable();
            $table->string('video_url')->nullable();
            $table->enum('level', ['Iniciante', 'Intermediário', 'Avançado'])->default('Iniciante');
            $table->integer('duration')->comment('em minutos');
            $table->integer('favorite_count')->default(0);
            $table->text('goals');
            $table->foreignId('category_id')->constrained();
            $table->foreignId('instructor_id')->constrained('users');
            $table->enum('status', ['pendente', 'aprovado', 'rejeitado'])->default('pendente');
            $table->json('tags')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamp('last_updated_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('new_courses');
    }
};
