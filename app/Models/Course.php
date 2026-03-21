<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'short_description',
        'description',  
        'image',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'status'
    ];
}
