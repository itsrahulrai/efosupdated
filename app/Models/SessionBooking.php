<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'mentor_id',
        'student_id',
        'session_price_id',
        'session_date',
        'start_time',
        'end_time',
        'duration_minutes',
        'price',
        'discount_price',
        'final_price',
        'payment_status',
        'payment_gateway',
        'transaction_id',
        'meeting_platform',
        'zoom_meeting_id',
        'zoom_join_url',
        'zoom_start_url',
        'zoom_password',
        'status',
    ];

    public function mentor()
    {
        return $this->belongsTo(MentorProfile::class, 'mentor_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function sessionPrice()
    {
        return $this->belongsTo(MentorSessionPrice::class, 'session_price_id');
    }
}
