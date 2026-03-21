<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    protected $fillable = [
        'category_id', // parent category
        'name',
        'slug',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'og_title',
        'og_description',
        'og_image',
        'schema',
    ];

    // Automatically generate slug if empty
    protected static function booted()
    {
        static::creating(function ($category) {
            if (empty($category->slug) && !empty($category->name)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    // Relationship: Category has many Blogs
    public function blogs()
    {
        return $this->hasMany(Blog::class, 'category_id');
    }

    // Optional: Self-referencing relationship for parent/child categories
    public function parent()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'category_id');
    }

    
    public function subcategories()
    {
        return $this->hasMany(SubCategory::class);
    }

    public function jobs()
    {
        return $this->hasMany(Job::class);
    }



}
