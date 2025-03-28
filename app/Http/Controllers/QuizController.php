<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Topic;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    // List all quizzes for a given topic
    public function index(Topic $topic)
    {
        $quizzes = Quiz::where('topic_id', $topic->id)->get();
        return view('admin.topics.quiz.index', compact('topic', 'quizzes'));
    }

    // Show a specific quiz
    public function show(Topic $topic, Quiz $quiz)
    {
        // Load questions along with all their answers
        $quiz->load(['questions.answers']);
    
        return view('admin.topics.quiz.show', compact('topic', 'quiz'));
    }
    


    // Show the form to create a new quiz
    public function create(Topic $topic)
    {
        return view('admin.topics.quiz.create', compact('topic'));
    }

    // Store a new quiz
    public function store(Request $request, Topic $topic)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Create the quiz
        $quiz = Quiz::create([
            'topic_id' => $topic->id,
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.topics.quiz.index', $topic)
                         ->with('success', 'Quiz created successfully!');
    }

    // Show the edit form
    public function edit(Topic $topic, Quiz $quiz)
    {
        return view('admin.topics.quiz.edit', compact('topic', 'quiz'));
    }

    // Update the quiz
    public function update(Request $request, Topic $topic, Quiz $quiz)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $quiz->update($request->all());

        return redirect()->route('admin.topics.quiz.index', $topic)
                         ->with('success', 'Quiz updated successfully!');
    }

    // Delete a quiz
    public function destroy(Topic $topic, Quiz $quiz)
    {
        $quiz->delete();

        return redirect()->route('admin.topics.quiz.index', $topic)
                         ->with('success', 'Quiz deleted successfully!');
    }
}
