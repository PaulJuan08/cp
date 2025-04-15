<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_name',
        'course_desc',
        'user_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function topics(): BelongsToMany
    {
        return $this->belongsToMany(Topic::class, 'course_topics')
            ->orderBy('topics.id') 
            ->withTimestamps();
    }

    // public function users(): BelongsToMany
    // {
    //     return $this->belongsToMany(User::class, 'course_roles')
    //         ->using(CourseRole::class)
    //         ->withPivot('role_name', 'created_at', 'updated_at');
    // }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'course_roles', 'course_id', 'user_id')
            ->using(CourseRole::class)
            ->withPivot('role_name');
    }


    public function assignedRoles(): HasMany
    {
        return $this->hasMany(CourseRole::class);
    }

    public function getRoleNamesAttribute(): array
    {
        return $this->assignedRoles->pluck('role_name')->unique()->toArray();
    }

    // public function progressForUser(User $user): int
    // {
    //     // Count only topics where user has passed the quiz
    //     $completed = $user->completedTopics()
    //         ->whereHas('quizzes.attempts', function($query) use ($user) {
    //             $query->where('user_id', $user->id)
    //                 ->where('passed', true);
    //         })
    //         ->whereHas('courses', function($query) {
    //             $query->where('courses.id', $this->id);
    //         })
    //         ->count();

    //     $total = $this->topics()->count();

    //     return $total > 0 ? (int) round(($completed / $total) * 100) : 0;
    // }

    public function progressForUser(User $user): int
    {
        if (!$this->relationLoaded('topics')) {
            $this->load('topics');
        }

        $completed = $this->topics->filter(function($topic) use ($user) {
            return $user->hasCompletedTopic($topic) && 
                   $user->hasPassedQuiz($topic->id);
        })->count();

        $total = $this->topics->count();

        return $total > 0 ? (int) round(($completed / $total) * 100) : 0;
    }

}