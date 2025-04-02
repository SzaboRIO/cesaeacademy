<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Migrar dados da tabela antiga para a nova
        $courses = DB::table('courses')->get();

        foreach ($courses as $course) {
            DB::table('new_courses')->insert([
                'id' => $course->id,
                'title' => $course->title,
                'slug' => $course->slug,
                'description' => $course->description,
                'image' => $course->image,
                'level' => $course->level,
                'duration' => $course->duration,
                'goals' => $course->what_you_will_learn ?? '',
                'category_id' => $course->category_id,
                'instructor_id' => $course->instructor_id,
                'status' => $course->status,
                'published_at' => $course->published_at,
                'created_at' => $course->created_at,
                'updated_at' => $course->updated_at,
                'objectives' => null,
                'video_url' => null,
                'favorite_count' => 0,
                'tags' => null,
                'last_updated_at' => $course->updated_at
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Limpar dados da nova tabela
        DB::table('new_courses')->truncate();
    }
};
