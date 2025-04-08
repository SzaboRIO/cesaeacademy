<?php

namespace App\Models;

use App\Models\Enrollment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    public function modules()
    {
        return $this->hasMany(Module::class)->orderBy('order');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

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

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }
}
