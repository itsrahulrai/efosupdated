<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'quiz_id',
        'answers',
        'total_questions',
        'answered_questions',
        'score',
        'is_passed',
        'time_taken',
        'submit_type',
        'submitted_at',
    ];

    protected $casts = [
        'answers' => 'array',
        'submitted_at' => 'datetime',
        'is_passed' => 'boolean',
    ];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function quizAnswers()
    {
        return $this->hasMany(QuizAnswer::class, 'attempt_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
