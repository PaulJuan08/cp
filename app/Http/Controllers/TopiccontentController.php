<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class TopiccontentController extends Controller
{
    // public function show(Course $course, Topic $topic)
    // {
    //     // Verify this topic belongs to this course
    //     if (!$course->topics()->where('topic_id', $topic->id)->exists()) {
    //         abort(404);
    //     }
        
    //     return view('admin.topics.contents.show', compact('course', 'topic'));
    // }

    public function show($encryptedCourseId, $encryptedTopicId)
    {
        try {
            // Decrypt both IDs
            $courseId = Crypt::decrypt($encryptedCourseId);
            $topicId = Crypt::decrypt($encryptedTopicId);
            
            // Find the course and topic
            $course = Course::findOrFail($courseId);
            $topic = Topic::findOrFail($topicId);

            // Verify this topic belongs to this course
            if (!$course->topics()->where('topic_id', $topic->id)->exists()) {
                abort(404, 'Topic not found in this course');
            }
            
            return view('admin.topics.contents.show', [
                'course' => $course,
                'topic' => $topic,
                'encryptedCourseId' => $encryptedCourseId,
                'encryptedTopicId' => $encryptedTopicId
            ]);
            
        } catch (DecryptException $e) {
            abort(404, 'Invalid resource identifier');
        }
    }
}
