<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('courses')) {
            Schema::create('courses', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->string('slug')->unique();
                $table->text('description');
                $table->text('objectives')->nullable();
                $table->string('image')->nullable();
                $table->string('video_url')->nullable();
                $table->enum('level', ['Iniciante', 'Intermediário', 'Avançado']);
                $table->integer('duration')->comment('em horas');
                $table->integer('favorite_count')->default(0);
                $table->integer('inscricoes_count')->default(0);
                $table->enum('status', ['pendente', 'aprovado', 'rejeitado'])->default('pendente');
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->foreignId('category_id')->constrained()->onDelete('cascade');
                $table->json('tags')->nullable();
                $table->timestamp('published_at')->nullable();
                $table->timestamp('last_updated_at')->nullable();
                $table->timestamps();
            });
        } else {
            Schema::table('courses', function (Blueprint $table) {
                if (!Schema::hasColumn('courses', 'title')) {
                    $table->string('title');
                }
                if (!Schema::hasColumn('courses', 'slug')) {
                    $table->string('slug')->unique();
                }
                if (!Schema::hasColumn('courses', 'description')) {
                    $table->text('description');
                }
                if (!Schema::hasColumn('courses', 'objectives')) {
                    $table->text('objectives')->nullable();
                }
                if (!Schema::hasColumn('courses', 'image')) {
                    $table->string('image')->nullable();
                }
                if (!Schema::hasColumn('courses', 'video_url')) {
                    $table->string('video_url')->nullable();
                }
                if (!Schema::hasColumn('courses', 'level')) {
                    $table->enum('level', ['Iniciante', 'Intermediário', 'Avançado']);
                }
                if (!Schema::hasColumn('courses', 'duration')) {
                    $table->integer('duration')->comment('em horas');
                }
                if (!Schema::hasColumn('courses', 'favorite_count')) {
                    $table->integer('favorite_count')->default(0);
                }
                if (!Schema::hasColumn('courses', 'inscricoes_count')) {
                    $table->integer('inscricoes_count')->default(0);
                }
                if (!Schema::hasColumn('courses', 'status')) {
                    $table->enum('status', ['pendente', 'aprovado', 'rejeitado'])->default('pendente');
                }
                if (!Schema::hasColumn('courses', 'user_id')) {
                    $table->foreignId('user_id')->constrained()->onDelete('cascade');
                }
                if (!Schema::hasColumn('courses', 'category_id') && Schema::hasTable('categories')) {
                    $table->foreignId('category_id')->constrained()->onDelete('cascade');
                }
                if (!Schema::hasColumn('courses', 'tags')) {
                    $table->json('tags')->nullable();
                }
                if (!Schema::hasColumn('courses', 'published_at')) {
                    $table->timestamp('published_at')->nullable();
                }
                if (!Schema::hasColumn('courses', 'last_updated_at')) {
                    $table->timestamp('last_updated_at')->nullable();
                }

                // Remover campo de rating se existir
                if (Schema::hasColumn('courses', 'rating')) {
                    $table->dropColumn('rating');
                }
            });
        }
    }

    public function down(): void
    {
        // Como esta é uma migração de modificação, não vamos fazer nada destrutivo aqui
    }
};
