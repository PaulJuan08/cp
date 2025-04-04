<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Topic;
use Illuminate\Support\Facades\Storage;

class TopicsController extends Controller
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
        return view('admin.topics.index', compact('topics'));

    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'topic_name' => 'required|string|max:255',
            'topic_desc' => 'nullable|string',
            'content' => 'nullable|string',
            'audio' => 'nullable|file|mimes:mp3,wav,m4a|max:5120',
            'video_url' => 'nullable|url|starts_with:https://www.youtube.com,https://youtu.be',
        ]);

        // Handle audio file upload
        $audioPath = $request->hasFile('audio') 
            ? $request->file('audio')->store('uploads/audios', 'public') 
            : null;

        // Store the topic with default status = 1
        Topic::create([
            'topic_name' => $validatedData['topic_name'],
            'topic_desc' => $validatedData['topic_desc'] ?? null,
            'content' => $validatedData['content'] ?? null,
            'audio_path' => $audioPath,
            'video_url' => $validatedData['video_url'] ?? null,
            'status' => 1, 
        ]);

        return redirect()->route('admin.topics.index')->with('success', 'Topic added successfully.');
    }


    public function show(Topic $topic)
    {
        return view('admin.content', compact('topic'));
    }

    public function edit(Topic $topic)
    {
        return view('admin.edit_topic', compact('topic'));
    }

    public function update(Request $request, Topic $topic)
    {
        $request->validate([
            'topic_name' => 'required|string|max:255',
            'topic_desc' => 'required|string',
            'content' => 'required|string',
        ]);

        if ($request->hasFile('audio')) {
            if ($topic->audio_path) {
                Storage::disk('public')->delete($topic->audio_path);
            }
            $audioPath = $request->file('audio')->store('uploads/audios', 'public');
        } else {
            $audioPath = $topic->audio_path; // Keep the existing path
        }
        
        $topic->update([
            'topic_name' => $request->topic_name,
            'topic_desc' => $request->topic_desc,
            'content' => $request->content,
            'audio_path' => $audioPath,
            'video_url' => $request->video_url,
        ]);
        

        return redirect()->route('admin.topics.index')->with('success', 'Topic updated successfully!');
    }

    public function destroy(Topic $topic)
    {
        if ($topic->audio_path) {
            Storage::disk('public')->delete($topic->audio_path);
        }

        $topic->delete();

        return redirect()->route('admin.topics.index')->with('success', 'Topic deleted successfully!');
    }

    public function hide($id)
    {
        $topic = Topic::findOrFail($id);
        $topic->status = 0; // Mark as hidden
        $topic->save();

        return redirect()->back()->with('success', 'Topic removed from the list.');
    }

}
