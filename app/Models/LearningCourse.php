<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LearningCourse extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'language',
        'level',
        'duration',
        'short_description',
        'description',
        'subject_id',
        'demo_video',
        'currency',
        'price',
        'is_free',
        'has_discount',
        'discount_price',
        'discount_from',
        'discount_to',
        'thumbnail',
        'status',
    ];

    protected $casts = [
        'is_free' => 'boolean',
        'has_discount' => 'boolean',
        'status' => 'boolean',
        'discount_from' => 'date',
        'discount_to' => 'date',
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function chapters()
    {
        return $this->hasMany(CourseChapter::class, 'course_id');
    }

    public function quiz()
    {
        return $this->hasOne(Quiz::class, 'course_id');
    }

    public function getFinalPriceAttribute()
    {
        return $this->has_discount && $this->discount_price
        ? $this->discount_price
        : $this->price;
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class, 'course_id');
    }

    public function assignedStudents()
    {
        return $this->hasMany(AssignedCourse::class, 'course_id');
    }

    public function bundles()
    {
        return $this->belongsToMany(
            CourseBundle::class,
            'bundle_courses',
            'course_id',
            'bundle_id'
        );
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
