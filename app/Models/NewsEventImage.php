<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsEventImage extends Model
{
    use HasFactory;

     protected $fillable = [
        'news_event_id',
        'image',
    ];

   public function newsEvent()
    {
        return $this->belongsTo(NewsEvent::class);
    }


}
