<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id', 'chapter_id', 'title', 'description',
        'total_marks', 'pass_marks',
        'duration_minutes', 'is_active',
    ];

    public function course()
    {
        return $this->belongsTo(LearningCourse::class, 'course_id');
    }

    public function chapter()
    {
        return $this->belongsTo(CourseChapter::class);
    }

    public function questions()
    {
        return $this->hasMany(QuizQuestion::class);
    }
}
