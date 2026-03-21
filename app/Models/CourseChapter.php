<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseChapter extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'title',
        'description',
        'sort_order',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    /**
     * Relationship: Chapter belongs to a Course
     */
    public function course()
    {
        return $this->belongsTo(LearningCourse::class, 'course_id');
    }


   public function quizzes()
{
    return $this->hasMany(Quiz::class, 'chapter_id');
}


    public function lessons()
    {
        return $this->hasMany(CourseLesson::class, 'chapter_id');
    }


    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

}
