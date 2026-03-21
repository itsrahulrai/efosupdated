<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

     protected $fillable = [
        'user_id',
        'student_id',
        'title',
        'file_path',
        'file_type',
        'file_size',
        'is_verified',
    ];

        /* ================= RELATIONS ================= */

        public function user()
        {
            return $this->belongsTo(User::class);
        }

        public function student()
        {
            return $this->belongsTo(Student::class);
        }
    }
