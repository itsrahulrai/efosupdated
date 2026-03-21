<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [

        /* CORE */
        'user_id',
        'franchise_id',
        'name',
        'phone',
        'email',
        'registration_number',

        /* BASIC */
        'whatsapp',
        'age_group',
        'gender',
        'present_status',
        'state',
        'district',
        'looking_for',

        /* PROFILE */
        'profile_summary',

        /* PERSONAL */
        'pincode',
        'father_name',
        'mother_name',
        'category',
        'address',

        /* EDUCATION */
        'highest_qualification',

        // 10th
        'tenth_board',
        'tenth_year',
        'tenth_marks',
        'tenth_stream',

        // 12th
        'twelfth_board',
        'twelfth_year',
        'twelfth_marks',
        'twelfth_stream',

        // Graduation
        'graduation_university',
        'graduation_year',
        'graduation_marks',
        'graduation_stream',
        'graduation_field',

        // PG / PhD
        'pg_university',
        'pg_year',
        'pg_marks',
        'pg_stream',
        'pg_field',

        // PhD
        'phd_university',
        'phd_year',
        'phd_subject',
        'phd_status',

        /* SKILL */
        'skill_type',
        'skill_trade',
        'skill_year',

        /* JOB (type only, actual jobs in experiences table) */
        'experience_type',

        /* OTHER */
        'passport',
        'relocation',
        'blood_group',
        'photo',

        /* META */
        'apply_type',
        'profile_completed',
        'agree_terms',

        'utm_source',
        'utm_medium',
        'utm_campaign',
        'utm_term',
        'utm_content',
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($student) {

            if ($student->user) {
                $student->user->delete();
            }

        });
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function experiences()
    {
        return $this->hasMany(StudentExperience::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function jobApplications()
    {
        return $this->hasMany(JobApplication::class);
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }
    public function assignedCourses()
    {
        return $this->hasMany(AssignedCourse::class);
    }
}
