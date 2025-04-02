<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'course_id',
        'enrolled_at',
        'completed_at'
    ];

    protected $casts = [
        'enrolled_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function progress()
    {
        return $this->hasMany(StudentProgress::class);
    }

    // Métodos auxiliares
    public function getProgressPercentageAttribute()
    {
        $completedLessons = $this->progress()->where('completed', true)->count();
        $totalLessons = $this->course->lessons()->count();

        if ($totalLessons === 0) {
            return 0;
        }

        return round(($completedLessons / $totalLessons) * 100);
    }
}
