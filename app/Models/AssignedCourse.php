<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CourseBuy;


class AssignedCourse extends Model
{
    use HasFactory;
     protected $fillable = [
        'student_id',
        'course_id',
        'bundle_id',
        
        'assigned_by',
        'assigned_at',
        'status'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function course()
    {
        return $this->belongsTo(LearningCourse::class, 'course_id');
    }

    public function assignedBy()
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }

    public function bundle()
    {
        return $this->belongsTo(CourseBundle::class, 'bundle_id');
    }


   protected static function booted()
    {
        static::created(function ($assign) {

            $student = $assign->student;

            if (!$student || !$student->user_id) {
                return;
            }

            CourseBuy::updateOrCreate(
                [
                    'user_id' => $student->user_id,
                    'learning_course_id' => $assign->course_id
                ],
                [
                    'type' => 'admin_assign',
                    'amount' => 0,
                    'payment_status' => 'success',
                    'payment_gateway' => 'admin',
                    'is_active' => 1,
                    'purchased_at' => now()
                ]
            );

        });
    }
}


