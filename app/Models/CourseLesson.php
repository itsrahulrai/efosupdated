<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseLesson extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'course_id',
        'chapter_id',
        'title',
        'slug',
        'type',
        'pdf_file',
        'video_source',
        'video_url',
        'content',
        'duration_seconds',
        'sort_order',
        'is_free_preview',
        'is_mandatory',
        'status',
    ];

    protected $casts = [
        'is_free_preview' => 'boolean',
        'is_mandatory' => 'boolean',
        'status' => 'boolean',
    ];

    public function chapter()
    {
        return $this->belongsTo(CourseChapter::class);
    }

    public function course()
    {
        return $this->belongsTo(LearningCourse::class);
    }

    public function quiz()
    {
        return $this->hasOne(Quiz::class, 'course_id')
            ->where('is_active', 1);
    }

    public function getEmbedVideoUrlAttribute()
    {
        if (!$this->video_url)
        {
            return null;
        }

        // youtube.com/watch?v=
        if (str_contains($this->video_url, 'youtube.com/watch'))
        {
            parse_str(parse_url($this->video_url, PHP_URL_QUERY), $params);
            return isset($params['v'])
            ? 'https://www.youtube.com/embed/' . $params['v']
            : null;
        }

        // youtu.be/
        if (str_contains($this->video_url, 'youtu.be/'))
        {
            return 'https://www.youtube.com/embed/' . basename($this->video_url);
        }

        // already embed or other providers
        return $this->video_url;
    }

}
