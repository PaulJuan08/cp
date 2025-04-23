<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class UsersTopicsController extends Controller
{
    // public function assignTopicsToCourses(Request $request)
    // {
    //     $request->validate([
    //         'topic_id' => 'required|exists:topics,id',
    //         'course_ids' => 'required|array',
    //         'course_ids.*' => 'exists:courses,id',
    //     ]);

    //     $topic = Topic::findOrFail($request->topic_id);
    //     $topic->courses()->syncWithoutDetaching($request->course_ids);

    //     return response()->json(['message' => 'Topic assigned to courses successfully']);
    // }

    public function assignTopicsToCourses(Request $request)
    {
        try {
            $request->validate([
                'topic_id' => 'required',
                'course_ids' => 'required|array',
                'course_ids.*' => 'required',
            ]);

            // Decrypt the topic ID
            $topicId = Crypt::decrypt($request->topic_id);
            $topic = Topic::findOrFail($topicId);

            // Decrypt all course IDs
            $courseIds = collect($request->course_ids)->map(function ($encryptedId) {
                return Crypt::decrypt($encryptedId);
            });

            // Verify courses exist
            $existingCourses = Course::whereIn('id', $courseIds)->pluck('id');
            if ($existingCourses->count() !== count($courseIds)) {
                return response()->json(['error' => 'One or more courses not found'], 404);
            }

            $topic->courses()->syncWithoutDetaching($courseIds);

            return response()->json(['message' => 'Topic assigned to courses successfully']);

        } catch (DecryptException $e) {
            return response()->json(['error' => 'Invalid ID format'], 400);
        }
    }

    // public function index()
    // {
    //     $topics = Topic::where('status', 1)->get();
    //     return view('users.topics.index', compact('topics'));

    // }

    public function index()
    {
        $topics = Topic::where('status', 1)->get();
        return view('users.topics.index', [
            'topics' => $topics,
            'encryptedIds' => $topics->map(function ($topic) {
                return encrypt($topic->id);
            })
        ]);
    }


    // public function show(Topic $topic)
    // {
    //     return view('users.content', compact('topic'));
    // }

    public function show($encryptedTopicId)
    {
        try {
            $topicId = Crypt::decrypt($encryptedTopicId);
            $topic = Topic::findOrFail($topicId);
            
            return view('users.content', [
                'topic' => $topic,
                'encryptedTopicId' => $encryptedTopicId
            ]);
            
        } catch (DecryptException $e) {
            abort(404, 'Topic not found');
        }
    }

    // public function edit(Topic $topic)
    // {
    //     return view('users.edit_topic', compact('topic'));
    // }

    public function edit($encryptedTopicId)
    {
        try {
            $topicId = Crypt::decrypt($encryptedTopicId);
            $topic = Topic::findOrFail($topicId);
            
            return view('users.edit_topic', [
                'topic' => $topic,
                'encryptedTopicId' => $encryptedTopicId
            ]);
            
        } catch (DecryptException $e) {
            abort(404, 'Topic not found');
        }
    }

    

    

    
}
