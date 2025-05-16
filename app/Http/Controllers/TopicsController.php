<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Topic;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

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

        // Get YouTube thumbnail if URL provided
        $thumbnailUrl = $this->getYouTubeThumbnail($validatedData['video_url'] ?? null);

        // Store the topic with default status = 1
        Topic::create([
            'topic_name' => $validatedData['topic_name'],
            'topic_desc' => $validatedData['topic_desc'] ?? null,
            'content' => $validatedData['content'] ?? null,
            'audio_path' => $audioPath,
            'video_url' => $validatedData['video_url'] ?? null,
            'youtube_thumbnail_url' => $thumbnailUrl,
            'status' => 1, 
        ]);

        return redirect()->route('admin.topics.index')
            ->with('success', 'Topic added successfully.');
    }

    public function show($encryptedId)
    {
        try {
            $id = Crypt::decrypt($encryptedId);
            $topic = Topic::findOrFail($id);
            return view('admin.content', compact('topic'));
        } catch (DecryptException $e) {
            abort(404, 'Topic not found');
        }
    }

    public function edit($encryptedId)
    {
        try {
            $id = Crypt::decrypt($encryptedId);
            $topic = Topic::findOrFail($id);
            return view('admin.edit_topic', compact('topic'));
        } catch (DecryptException $e) {
            abort(404, 'Topic not found');
        }
    }

    public function update(Request $request, $encryptedId)
    {
        try {
            $id = Crypt::decrypt($encryptedId);
            $topic = Topic::findOrFail($id);

            $request->validate([
                'topic_name' => 'required|string|max:255',
                'topic_desc' => 'required|string',
                'content' => 'required|string',
                'audio' => 'nullable|file|mimes:mp3,wav,m4a|max:5120',
                'video_url' => 'nullable|url|starts_with:https://www.youtube.com,https://youtu.be',
            ]);

            // Handle audio file update
            $audioPath = $topic->audio_path;
            if ($request->hasFile('audio')) {
                // Delete old audio if exists
                if ($topic->audio_path) {
                    Storage::disk('public')->delete($topic->audio_path);
                }
                $audioPath = $request->file('audio')->store('uploads/audios', 'public');
            }

            // Get YouTube thumbnail if URL provided
            $thumbnailUrl = $this->getYouTubeThumbnail($request->video_url);

            $topic->update([
                'topic_name' => $request->topic_name,
                'topic_desc' => $request->topic_desc,
                'content' => $request->content,
                'audio_path' => $audioPath,
                'video_url' => $request->video_url,
                'youtube_thumbnail_url' => $thumbnailUrl,
            ]);

            return redirect()->route('admin.topics.index')
                ->with('success', 'Topic updated successfully!');
        } catch (DecryptException $e) {
            abort(404, 'Topic not found');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error updating topic: ' . $e->getMessage());
        }
    }

    public function destroy($encryptedId)
    {
        try {
            $id = Crypt::decrypt($encryptedId);
            $topic = Topic::findOrFail($id);
            
            // Delete associated audio file
            if ($topic->audio_path) {
                Storage::disk('public')->delete($topic->audio_path);
            }
            
            $topic->delete();
            
            return redirect()->route('admin.topics.index')
                ->with('success', 'Topic deleted successfully!');
        } catch (DecryptException $e) {
            abort(404, 'Topic not found');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error deleting topic: ' . $e->getMessage());
        }
    }

    public function quizIndex($encryptedTopicId)
    {
        try {
            $topicId = Crypt::decrypt($encryptedTopicId);
            $topic = Topic::findOrFail($topicId);
            $quizzes = $topic->quizzes; // Assuming you have a relationship
            
            return view('admin.quiz.index', compact('quizzes', 'topic'));
        } catch (DecryptException $e) {
            abort(404, 'Topic not found');
        }
    }

    public function hide($encryptedId)
    {
        try {
            $id = Crypt::decrypt($encryptedId);
            $topic = Topic::findOrFail($id);
            $topic->status = 0;
            $topic->save();
            
            return redirect()->back()
                ->with('success', 'Topic removed from the list.');
        } catch (DecryptException $e) {
            abort(404, 'Topic not found');
        }
    }

    /**
     * Extract YouTube thumbnail URL from video URL
     */
    private function getYouTubeThumbnail($url)
    {
        if (!$url) return null;
        
        if (preg_match('/youtube\.com\/watch\?v=([^\&\?\/]+)/', $url, $matches)) {
            return "https://img.youtube.com/vi/{$matches[1]}/0.jpg";
        }
        if (preg_match('/youtu\.be\/([^\&\?\/]+)/', $url, $matches)) {
            return "https://img.youtube.com/vi/{$matches[1]}/0.jpg";
        }
        return null;
    }
}