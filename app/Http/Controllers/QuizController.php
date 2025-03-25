<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quiz;
use App\Models\Topic;

class QuizController extends Controller
{
    // Show quizzes for a specific topic
    public function showQuiz($topicId)
    {
        $topic = Topic::findOrFail($topicId);
        $quizzes = Quiz::where('topic_id', $topicId)->get();
        return view('admin.quizzes.index', compact('topic', 'quizzes'));
    }

    // Show form to create a quiz for a specific topic
    public function create($topicId)
    {
        $topic = Topic::findOrFail($topicId);
        return view('admin.quizzes.create', compact('topic'));
    }

    // Store the quiz for a specific topic
    public function store(Request $request, $topicId)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Quiz::create([
            'topic_id' => $topicId,
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.topics.quiz', $topicId)->with('success', 'Quiz created successfully.');
    }
}

