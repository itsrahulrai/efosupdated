<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizAnswer extends Model
{
    use HasFactory;

    protected $table = 'quiz_answers';
    protected $fillable = [
        'attempt_id', 'question_id',
        'selected_option_id', 'text_answer', 'is_correct',
    ];

    public function question()
    {
        return $this->belongsTo(QuizQuestion::class);
    }

    public function selectedOption()
    {
        return $this->belongsTo(QuizOption::class, 'selected_option_id');
    }
}
