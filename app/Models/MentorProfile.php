<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MentorProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'mentor_category_id',
        'name',
        'email',
        'phone',
        'state',
        'city',
        'zip_code',
        'address',
        'bio',
        'skills',
        'experience',
        'profile_photo',
        'status',

    ];

    public function category()
    {
        return $this->belongsTo(
            MentorCategory::class,
            'mentor_category_id'
        )->withDefault([
            'name' => 'N/A',
        ]);
    }

    public function sessionPrices()
    {
        return $this->hasMany(MentorSessionPrice::class, 'mentor_id');
    }

    public function availabilities()
    {
        return $this->hasMany(MentorAvailability::class, 'mentor_id');
    }
}
