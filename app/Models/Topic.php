<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'topic_name',
        'topic_desc',
        'content',
        'video_url',
    ];

    /**
     * Accessor for getting the YouTube embed URL
     */
    public function getYoutubeEmbedUrlAttribute()
    {
        if (empty($this->video_url)) {
            return null;
        }
        
        // Extract YouTube video ID from various URL formats
        preg_match('/^(?:https?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$/', $this->video_url, $matches);
        
        return isset($matches[1]) ? 'https://www.youtube.com/embed/'.$matches[1] : null;
    }

    /**
     * Accessor for getting the YouTube thumbnail URL
     */
    public function getYoutubeThumbnailUrlAttribute()
    {
        if (empty($this->video_url)) {
            return null;
        }
        
        preg_match('/^(?:https?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$/', $this->video_url, $matches);
        
        return isset($matches[1]) ? 'https://img.youtube.com/vi/'.$matches[1].'/0.jpg' : null;
    }
    

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationship with courses
    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_topics', 'topic_id', 'course_id')->withTimestamps();
    }


    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }

}