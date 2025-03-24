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
        $topics = Topic::all();
        return view('admin.topics.index', compact('topics'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'topic_name' => 'required|string|max:255',
            'topic_desc' => 'nullable|string',
            'content' => 'nullable|string',
            'audio' => 'nullable|file|mimes:mp3,wav,m4a|max:5120',
            'video_url' => 'nullable|url|starts_with:https://www.youtube.com/,https://youtu.be/',
        ]);

        $audioPath = $request->hasFile('audio') 
            ? $request->file('audio')->store('uploads/audios', 'public') 
            : null;

        Topic::create([
            'topic_name' => $request->topic_name,
            'topic_desc' => $request->topic_desc,
            'content' => $request->content,
            'audio_path' => $audioPath,
            'video_url' => $request->video_url,
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
            'audio' => 'nullable|file|mimes:mp3,wav,m4a|max:5120',
            'video_url' => 'nullable|url|starts_with:https://www.youtube.com/,https://youtu.be/',
        ]);

        if ($request->hasFile('audio')) {
            if ($topic->audio_path) {
                Storage::disk('public')->delete($topic->audio_path);
            }
            $topic->audio_path = $request->file('audio')->store('uploads/audios', 'public');
        }

        $topic->update([
            'topic_name' => $request->topic_name,
            'topic_desc' => $request->topic_desc,
            'content' => $request->content,
            'audio_path' => $topic->audio_path,
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
}
