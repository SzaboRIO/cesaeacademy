<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeUsersFirstnameLastnameNullable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Make the firstname and lastname columns nullable
            $table->string('firstname')->nullable()->change();
            $table->string('lastname')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Revert the changes by making firstname and lastname not nullable
            $table->string('firstname')->nullable(false)->change();
            $table->string('lastname')->nullable(false)->change();
        });
    }
}
