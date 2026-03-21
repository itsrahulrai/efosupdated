<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobSubCategory extends Model
{
    use HasFactory;

     protected $fillable = ['job_category_id', 'name', 'slug', 'status'];

    public function category()
    {
        return $this->belongsTo(JobCategory::class, 'job_category_id');
    }

    public function jobs()
    {
        return $this->hasMany(Job::class);
    }
}
