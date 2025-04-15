<?php

namespace App\Models;

use App\Models\Course;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class CourseRole extends Pivot
{
    protected $table = 'course_roles';
    protected $fillable = ['user_id', 'course_id', 'role_name'];
    public $timestamps = true;

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}