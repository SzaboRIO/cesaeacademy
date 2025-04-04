<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'objectives',
        'image',
        'video_url',
        'level',
        'duration',
        'favorite_count',
        'inscricoes_count',
        'status',
        'user_id',
        'category_id',
        'tags',
        'published_at',
        'last_updated_at'
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'last_updated_at' => 'datetime',
        'tags' => 'array'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function modules()
    {
        return $this->hasMany(Module::class)->orderBy('order');
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // Métodos auxiliares
    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }

    public function getLessonsCountAttribute()
    {
        return $this->lessons()->count();
    }

    public function getStudentsCountAttribute()
    {
        return $this->enrollments()->count();
    }
}
