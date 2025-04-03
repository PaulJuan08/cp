<?php

namespace App\Models;

use App\Models\Role;
use App\Models\CourseRole;
use \App\Models\CourseTopic;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Course extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'course_name',
        'course_desc',
        'user_id',
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

    public function topics()
    {
        return $this->belongsToMany(Topic::class, 'course_topics', 'course_id', 'topic_id')
            ->withTimestamps();
    }

    // If you need many-to-many through users
    public function users()
    {
        return $this->belongsToMany(User::class, 'course_roles', 'course_id', 'role_name', 'id', 'role_name')
            ->using(CourseRole::class)
            ->withPivot('created_at', 'updated_at');
    }

    // Remove all role-related relationships except:
    public function assignedRoles()
    {
        return $this->hasMany(CourseRole::class);
    }

    // Keep this simple accessor
    public function getRoleNames()
    {
        return $this->assignedRoles->pluck('role_name')->unique()->toArray();
    }
   
}