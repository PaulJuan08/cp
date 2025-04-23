<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Crypt;
// use App\Traits\HasHashedIds;

class Course extends Model
{
    use HasFactory;
    // use HasHashedIds;

    protected $fillable = [
        'course_name',
        'course_desc',
        'user_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($course) {
            $course->slug = Str::slug($course->name) . '-' . Str::random(6);
        });
    }

    // Use slug for route binding
    public function getRouteKeyName()
    {
        return 'slug';
    }

    // Add these methods for ID encryption/decryption
    public function getEncryptedIdAttribute()
    {
        return encrypt($this->id);
    }

    public static function findByEncryptedId($encryptedId)
    {
        try {
            $id = decrypt($encryptedId);
            return self::findOrFail($id);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            abort(404, 'Course not found');
        }
    }

    // Topics relationship (unchanged)
    public function topics(): BelongsToMany
    {
        return $this->belongsToMany(Topic::class, 'course_topics')
            ->orderBy('topics.id')
            ->withTimestamps();
    }

    // Main users relationship with role filtering capability
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'course_roles', 'course_id', 'user_id')
            ->using(CourseRole::class)
            ->withPivot('role_name')
            ->distinct();
    }

    // Get users by specific role (e.g., Faculty, Staff, etc.)
    public function usersByRole(string $role): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'course_roles', 'course_id', 'user_id')
            ->wherePivot('role_name', $role)
            ->using(CourseRole::class)
            ->withPivot('role_name')
            ->distinct();
    }

    // Convenience methods for each role type
    public function faculty(): BelongsToMany
    {
        return $this->usersByRole('Faculty');
    }

    public function staff(): BelongsToMany
    {
        return $this->usersByRole('Staff');
    }

    public function students(): BelongsToMany
    {
        return $this->usersByRole('Student');
    }

    public function others(): BelongsToMany
    {
        return $this->usersByRole('Others');
    }

    // Relationship to get all unique role assignments
    public function assignedRoles(): HasMany
    {
        return $this->hasMany(CourseRole::class);
    }

    // Get all unique role names assigned to this course
    public function getRoleNamesAttribute(): array
    {
        return $this->assignedRoles->pluck('role_name')->unique()->values()->toArray();
    }

    // Get all users grouped by their roles
    public function getUsersGroupedByRole(): \Illuminate\Support\Collection
    {
        return $this->users()
            ->get()
            ->groupBy('pivot.role_name');
    }

    // Progress calculation (unchanged)
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

    public function enrolledUsers()
    {
        return $this->belongsToMany(User::class, 'course_user')
                    ->withPivot('role_name')
                    ->withTimestamps();
    }
}