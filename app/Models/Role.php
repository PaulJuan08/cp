<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
// use App\Traits\HasHashedIds;

class Role extends Model
{
    // use HasHashedIds;
    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'name';
    
    protected $fillable = ['name'];
    
    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'course_roles', 'role_name', 'course_id')
            ->withTimestamps();
    }
    
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'course_roles', 'role_name', 'user_id')
            ->withTimestamps();
    }
}