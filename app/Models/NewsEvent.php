<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsEvent extends Model
{
    protected $fillable = ['heading', 'category', 'description'];

   public function images()
{
    return $this->hasMany(NewsEventImage::class);
}

}
