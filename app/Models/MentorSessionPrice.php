<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MentorSessionPrice extends Model
{
    use HasFactory;

    protected $fillable = [
        'mentor_id',
        'duration_minutes',
        'price',
        'discount_price',
        'is_free',
        'session_type',
        'meeting_platform',
        'status'
    ];

    public function mentor()
    {
        return $this->belongsTo(MentorProfile::class,'mentor_id');
    }
}
