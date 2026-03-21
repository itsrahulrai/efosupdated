<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Blog extends Model
{
    use HasFactory;

    // Fillable fields
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'short_content',
        'content',
        'image',
        'alt',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'meta_robot',
        'canonical',
        'status',
    ];


      // Automatically generate slug if empty
    protected static function booted()
    {
        static::creating(function ($blog) {
            if (empty($blog->slug) && !empty($blog->name)) {
                $blog->slug = Str::slug($blog->name);
            }
        });
    }

    // Relationship: Blog belongs to Category
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
