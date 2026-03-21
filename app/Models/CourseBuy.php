<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseBuy extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'learning_course_id',
         'bundle_id',
        'type',
        'amount',
        'discount_amount',
        'coupon_code',
        'payment_status',
        'transaction_id',
        'payment_gateway',
        'is_active',
        'is_refunded',
        'purchased_at',
        'refunded_at',
        'expires_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'is_active' => 'boolean',
        'is_refunded' => 'boolean',
        'purchased_at' => 'datetime',
        'refunded_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    public function course()
    {
        return $this->belongsTo(LearningCourse::class, 'learning_course_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bundle()
    {
        return $this->belongsTo(CourseBundle::class, 'bundle_id');
    }

}
