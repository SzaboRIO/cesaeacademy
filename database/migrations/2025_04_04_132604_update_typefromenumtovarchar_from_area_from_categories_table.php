<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE `categories` MODIFY `area` VARCHAR(255) NOT NULL");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE `categories`
            MODIFY `area` ENUM('Development', 'IT Network', 'Media Design', 'People')
            CHARACTER SET utf8mb4
            COLLATE utf8mb4_unicode_ci NOT NULL
        ");
    }
};
