<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FranchiseProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'owner_name',
        'company_name',
        'phone',
        'email',
        'state',
        'district',
        'address',
        'business_experience',
        'message',
        'status',
        'is_active',
        'approved_at',
        'approved_by',
        'franchise_code',
        'location',
        'investment_range',
    ];
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function approvedBy()
    {
        return $this->belongsTo(\App\Models\User::class, 'approved_by');
    }

    public function students()
    {
        return $this->hasMany(Student::class, 'franchise_id');
    }
}
