<?php

namespace App\Models;

use App\Models\Course;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
        'stake_holder',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function accessibleCourses()
    {
        return Course::whereHas('assignedRoles', function($query) {
            $query->where('role_name', $this->role_name);
        });
    }

    public function hasCompletedTopic($topicId)
    {
        // Implement your logic to check if user has completed the topic
        return $this->completedTopics()->where('topic_id', $topicId)->exists();
    }

    public function hasPassedQuiz($topicId)
    {
        // Implement your logic to check if user has passed the quiz
        return $this->quizAttempts()
                    ->where('topic_id', $topicId)
                    ->where('passed', true)
                    ->exists();
    }

    public function completedTopics()
    {
        return $this->belongsToMany(Topic::class, 'user_completed_topics')
                    ->withTimestamps();
    }

    public function quizAttempts()
    {
        return $this->hasMany(QuizAttempt::class);
    }

}