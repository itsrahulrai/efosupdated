<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class MentorProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'mentor_category_id',
        'name',
        'slug',
        'email',
        'phone',
        'state',
        'city',
        'zip_code',
        'address',
        'shortbio',
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

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($mentor)
        {

            if (!empty($mentor->name))
            {

                $slug = Str::slug($mentor->name);

                // check duplicate slug
                $count = self::where('slug', 'LIKE', "{$slug}%")
                    ->where('id', '!=', $mentor->id)
                    ->count();

                $mentor->slug = $count
                ? "{$slug}-" . ($count + 1)
                : $slug;
            }

        });

    }

}
