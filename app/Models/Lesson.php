<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'course_id',
        'video_url',
        'module',
        'order'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function studentProgress()
    {
        return $this->hasMany(StudentProgress::class);
    }
}
