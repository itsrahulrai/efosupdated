<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class MentorCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'status',
    ];

    protected static function boot()
    {
        parent::boot();

        // create slug on insert
        static::creating(function ($category)
        {
            $category->slug = Str::slug($category->name);
        });

        // update slug when name changes
        static::updating(function ($category)
        {
            $category->slug = Str::slug($category->name);
        });
    }

   public function mentors()
    {
        return $this->hasMany(MentorProfile::class);
    }
}
