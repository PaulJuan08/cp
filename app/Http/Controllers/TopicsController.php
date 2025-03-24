<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Topic;
use Illuminate\Support\Facades\Storage;

class TopicsController extends Controller
{
    // Assign topics to courses
    public function assignTopicsToCourses(Request $request)
    {
        $request->validate([
            'topic_id' => 'required|exists:topics,id',
            'course_ids' => 'required|array',
            'course_ids.*' => 'exists:courses,id',
        ]);

        $topic = Topic::findOrFail($request->topic_id);
        $topic->courses()->sync($request->course_ids);

        return response()->json(['message' => 'Topic assigned to courses successfully']);
    }

    // Display all topics
    public function index()
    {
        $topics = Topic::all();
        return view('admin.topics.index', compact('topics'));
    }

    // Store a new topic
    public function store(Request $request)
    {
        $request->validate([
            'topic_name' => 'required|string|max:255',
            'topic_desc' => 'nullable|string',
            'content' => 'nullable|string',
            'audio_path' => 'nullable|string',
            'video_url' => 'nullable|string',
        ]);

        $topic = Topic::create([
            'topic_name' => $request->input('topic_name'),
            'topic_desc' => $request->input('topic_desc'),
            'content' => $request->input('content'),
            'audio_path' => $request->input('audio_path'),
            'video_url' => $request->input('video_url'),
        ]);

        if ($topic) {
            return redirect()->route('admin.topics.index')->with('success', 'Topic added successfully.');
        } else {
            return back()->with('error', 'Failed to add topic.');
        }
    }

    public function show($id)
    {
        $topic = Topic::findOrFail($id);
        return view('admin.content', compact('topic'));
    }

    // Edit a topic
    public function edit($id)
    {
        $topic = Topic::findOrFail($id);
        return view('admin.edit_topic', compact('topic'));
    }

    // Update a topic
    public function update(Request $request, $id)
    {
        $request->validate([
            'topic_name' => 'required|string|max:255',
            'topic_desc' => 'required|string',
            'content' => 'required|string',
            'audio' => 'nullable|file|mimes:mp3,wav,m4a|max:5120', // Changed from 'voice' to 'audio'
            'video_url' => [
                'nullable',
                'url',
                'regex:/^(https?:\/\/)?(www\.)?(youtube\.com\/watch\?v=|youtu\.be\/)[A-Za-z0-9_-]+$/'
            ],
        ]);

        $topic = Topic::findOrFail($id);

        // Handle audio file upload
        if ($request->hasFile('audio')) {
            if ($topic->audio_path) { // Changed from 'voice_path' to 'audio_path'
                Storage::disk('public')->delete($topic->audio_path); // Changed from 'voice_path' to 'audio_path'
            }
            $topic->audio_path = $request->file('audio')->store('uploads/audios', 'public'); // Changed path to 'uploads/audios'
        }

        // Update the topic
        $topic->update([
            'topic_name' => $request->topic_name,
            'topic_desc' => $request->topic_desc,
            'content' => $request->content,
            'audio_path' => $topic->audio_path, // Changed from 'voice_path' to 'audio_path'
            'video_url' => $request->video_url,
        ]);

        return redirect()->route('admin.topics')->with('success', 'Topic updated successfully!');
    }

    // Delete a topic
    public function destroy($id)
    {
        $topic = Topic::findOrFail($id);

        // Delete associated files
        if ($topic->audio_path) { // Changed from 'voice_path' to 'audio_path'
            Storage::disk('public')->delete($topic->audio_path); // Changed from 'voice_path' to 'audio_path'
        }

        $topic->delete();

        return redirect()->route('admin.topics')->with('success', 'Topic deleted successfully!');
    }
}