<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseRole extends Model
{
    protected $table = 'course_roles';
    protected $fillable = ['course_id', 'role_name'];
    public $timestamps = true;

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}