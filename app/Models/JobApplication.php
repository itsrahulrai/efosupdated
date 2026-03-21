<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    use HasFactory;

     protected $fillable = [
        'student_id',
        'job_id',
        'job_title',
        'company_name',
        'district',
        'state',
        'status',
        'applied_at',
    ];

    protected $casts = [
        'applied_at' => 'datetime',
    ];

       /* RELATIONS */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function job()
    {
        return $this->belongsTo(Job::class);
    }
}
