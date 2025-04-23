<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

// use App\Traits\HasHashedIds;

class Topic extends Model
{
    use HasFactory;
    // use HasHashedIds;

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
     * Accessor for getting the encrypted ID
     */
    public function getEncryptedIdAttribute()
    {
        return Crypt::encrypt($this->id);
    }

    /**
     * Find a topic by its encrypted ID
     */
    public static function findByEncryptedId($encryptedId)
    {
        try {
            $id = Crypt::decrypt($encryptedId);
            return self::findOrFail($id);
        } catch (DecryptException $e) {
            return null;
        }
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
        return $this->belongsToMany(Course::class, 'course_topics', 
        'topic_id', 'course_id')->withTimestamps();
    }


    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_completed_topics')
            ->withPivot(['quiz_attempt_id', 'completed_at'])
            ->withTimestamps();
    }

    public function isCompletedBy(User $user): bool
    {
        return $this->quizzes()
            ->whereHas('attempts', function($query) use ($user) {
                $query->where('user_id', $user->id)
                    ->where('passed', true);
            })
            ->exists();
    }

    public function isAccessibleBy(User $user): bool
    {
        // First topic is always accessible
        if ($this->isFirstInCourse()) {
            return true;
        }
        
        // Subsequent topics require previous completion
        $prevTopic = $this->getPreviousTopic();
        return $prevTopic ? $prevTopic->isCompletedBy($user) : false;
    }

    public function isFirstInCourse(): bool
    {
        return $this->courses()
            ->first()
            ?->topics()
            ->orderBy('order')
            ->first()
            ?->id === $this->id;
    }

    public function getPreviousTopic(): ?Topic
    {
        return $this->courses()
            ->first()
            ?->topics()
            ->where('order', '<', $this->order)
            ->orderBy('order', 'desc')
            ->first();
    }

    public function quizAttempts()
    {
        return $this->hasMany(QuizAttempt::class);
    }

}