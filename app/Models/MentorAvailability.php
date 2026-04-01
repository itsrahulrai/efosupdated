<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MentorAvailability extends Model
{
    use HasFactory;

    protected $fillable = [
        'mentor_id',
        'day',
        'start_time',
        'end_time',
        'slot_gap',
        'timezone',
        'is_active'
        ];

    public function mentor()
    {
        return $this->belongsTo(MentorProfile::class);
    }
}
