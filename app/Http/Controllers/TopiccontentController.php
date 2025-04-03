<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use App\Models\Course;
use Illuminate\Http\Request;

class TopiccontentController extends Controller
{
    public function show(Course $course, Topic $topic)
    {
        // Verify this topic belongs to this course
        if (!$course->topics()->where('topic_id', $topic->id)->exists()) {
            abort(404);
        }
        
        return view('admin.topics.contents.show', compact('course', 'topic'));
    }
}
