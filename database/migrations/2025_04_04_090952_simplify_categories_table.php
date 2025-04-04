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
        Schema::table('categories', function (Blueprint $table) {
            // Primeiro verificamos se os campos existem antes de removê-los
            if (Schema::hasColumn('categories', 'name')) {
                $table->dropColumn('name');
            }

            if (Schema::hasColumn('categories', 'slug')) {
                $table->dropIndex('categories_slug_unique');
                $table->dropColumn('slug');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            // Restauramos os campos caso seja necessário reverter
            if (!Schema::hasColumn('categories', 'name')) {
                $table->string('name')->after('id');
            }

            if (!Schema::hasColumn('categories', 'slug')) {
                $table->string('slug')->unique()->after('name');
            }
        });
    }
};
