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
        'audio_path', // Changed from 'voice_path' to 'audio_path'
        'video_url',
        'name', 
        'description'
    ];

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