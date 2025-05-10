<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;

class UsersTopicsController extends Controller
{
    public function assignTopicsToCourses(Request $request)
    {
        $request->validate([
            'topic_id' => 'required|exists:topics,id',
            'course_ids' => 'required|array',
            'course_ids.*' => 'exists:courses,id',
        ]);

        $topic = Topic::findOrFail($request->topic_id);
        $topic->courses()->syncWithoutDetaching($request->course_ids);

        return response()->json(['message' => 'Topic assigned to courses successfully']);
    }

    public function index()
    {
        $topics = Topic::where('status', 1)->get();
        return view('users.topics.index', compact('topics'));

    }


    public function show(Topic $topic)
    {
        return view('users.content', compact('topic'));
    }

    public function edit(Topic $topic)
    {
        return view('users.edit_topic', compact('topic'));
    }

    

    

    
}
