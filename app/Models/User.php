<?php

namespace App\Models;

use App\Models\Course;
use App\Models\QuizAttempt;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'contact',
        'password',
        'role_name', 
        'employeeID',
        'college_department',
        'office_unit',
        'studentID',
        'stakeholder',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $appends = ['encrypted_id'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getEncryptedIdAttribute()
    {
        return Crypt::encrypt($this->id);
    }

    public static function findByEncryptedId($encryptedId)
    {
        try {
            $id = Crypt::decrypt($encryptedId);
            return self::findOrFail($id);
        } catch (DecryptException $e) {
            return null;
        }
    }

    public function accessibleCourses()
    {
        return Course::whereHas('assignedRoles', function($query) {
            $query->where('role_name', $this->role_name);
        });
    }

    public function hasCompletedTopic(Topic $topic): bool
    {
        return $this->completedTopics()->where('topic_id', $topic->id)->exists();
    }

    public function hasPassedQuiz($topicId): bool
    {
        try {
            // Handle both encrypted and plain IDs
            $decryptedId = is_numeric($topicId) ? $topicId : Crypt::decrypt($topicId);
            return $this->quizAttempts()
                      ->where('topic_id', $decryptedId)
                      ->where('passed', true)
                      ->exists();
        } catch (DecryptException $e) {
            return false;
        }
    }

    public function calculateCourseProgress(Course $course): int
    {
        $completedTopics = $this->completedTopics()
            ->whereHas('courses', function($query) use ($course) {
                $query->where('courses.id', $course->id);
            })
            ->whereHas('quizzes.attempts', function($query) {
                $query->where('user_id', $this->id)
                      ->where('passed', true);
            })
            ->count();

        $totalTopics = $course->topics()->count();

        return $totalTopics > 0 ? (int) round(($completedTopics / $totalTopics) * 100) : 0;
    }

    public function hasCompletedCourse(Course $course): bool
    {
        $totalTopics = $course->topics()->count();
        if ($totalTopics === 0) return false;

        $completedTopics = $this->completedTopics()
            ->whereHas('courses', function($query) use ($course) {
                $query->where('courses.id', $course->id);
            })
            ->whereHas('quizzes.attempts', function($query) {
                $query->where('user_id', $this->id)
                      ->where('passed', true);
            })
            ->count();

        return $completedTopics === $totalTopics;
    }

    public function completedTopics(): BelongsToMany
    {
        return $this->belongsToMany(Topic::class, 'user_completed_topics')
            ->withPivot(['quiz_attempt_id', 'completed_at'])
            ->withTimestamps();
    }

    public function quizAttempts()
    {
        return $this->hasMany(QuizAttempt::class);
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_roles', 'user_id', 'course_id')
            ->using(CourseRole::class)
            ->withPivot('role_name');
    }

    public function topicAccesses()
    {
        return $this->hasMany(TopicAccess::class);
    }

    public function getNextAccessibleTopic(Course $course, Topic $currentTopic): ?Topic
    {
        $topics = $course->topics()->orderBy('id')->get();
        $currentIndex = $topics->search(function($topic) use ($currentTopic) {
            return $topic->id === $currentTopic->id;
        });

        if ($currentIndex === false) return null;

        $nextTopic = $topics->get($currentIndex + 1);
        
        if (!$nextTopic) return null;
        
        // Check if user has passed current topic
        if (!$this->hasPassedQuiz($currentTopic->id)) {
            return null;
        }

        return $nextTopic;
    }
}