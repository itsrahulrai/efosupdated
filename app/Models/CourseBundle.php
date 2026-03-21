<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseBundle extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'slug',
        'short_description',
        'description',
        'thumbnail',
        'currency',
        'price',
        'is_free',
        'has_discount',
        'discount_price',
        'discount_from',
        'discount_to',
        'status',
    ];

    protected $casts = [
        'is_free' => 'boolean',
        'has_discount' => 'boolean',
        'status' => 'boolean',
        'discount_from' => 'date',
        'discount_to' => 'date',
    ];

    public function courses()
    {
        return $this->belongsToMany(
            LearningCourse::class,
            'bundle_courses',
            'bundle_id',
            'course_id'
        );
    }

}
