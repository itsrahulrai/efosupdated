<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentExperience extends Model
{
    use HasFactory;

     protected $fillable = [
        'student_id',
        'company_name',
        'job_profile',
        'job_duration',
        'job_state',
        'job_district',
        'salary_range',
        'job_summary',
    ];

     /* ================= RELATIONSHIPS ================= */

    public function student()
    {
        return $this->belongsTo(Student::class);
    }


}
