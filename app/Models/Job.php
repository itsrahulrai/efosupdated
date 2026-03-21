<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;
    protected $perPage = 5;


    protected $fillable = [
        'job_category_id',
        'job_sub_category_id',
        'title',
        'company_name',
        'company_logo',
        'posted_by',
        'area',
        'district',
        'state',
        'salary',
        'job_type',
        'work_mode',
        'shift',
        'experience',
        'education',
        'eligibility',
        'age_limit',
        'gender',
        'english_level',
        'skills',
        'short_description',
        'description',
        'highlights',
        'slug',
        'is_featured',
        'status',
        'expiry_date',
         // SEO Meta fields
        'meta_title',
        'meta_description',
        'meta_keywords',
        'meta_robots',
        'canonical_url',
        //Open Graph / Social
        'og_title',
        'og_description',
        'og_image',
        ];

    protected $casts = [
        'highlights' => 'array',
        'is_featured' => 'boolean',
        'status' => 'boolean',
        'expiry_date' => 'date',
    ];

   public function category()
    {
        return $this->belongsTo(JobCategory::class, 'job_category_id');
    }

    public function subCategory()
    {
        return $this->belongsTo(JobSubCategory::class, 'job_sub_category_id');
    }

    public function applications()  
    {
        return $this->hasMany(JobApplication::class);
    }

}
