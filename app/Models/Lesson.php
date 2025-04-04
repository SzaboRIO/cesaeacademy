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
        'module_id',
        'video_url',
        'order'
    ];

    public function course()
    {
        return $this->module->course;
    }

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function studentProgress()
    {
        return $this->hasMany(StudentProgress::class);
    }
}
