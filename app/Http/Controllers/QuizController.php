<?php

namespace App\Http\Controllers;


use App\Models\Quiz;
use App\Models\Topic;
use Illuminate\Http\Request;

class QuizController extends Controller
{

    public function index(Topic $topic)
    {
        $quizzes = $topic->quizzes()->with('options')->paginate(10);
        return view('admin.quizzes.index', compact('topic', 'quizzes'));
    }

    public function show(Topic $topic)
    {
        $quiz = $topic->quiz()->with(['items.options', 'items.answer'])->firstOrFail();
        return view('admin.quizzes.show', compact('topic', 'quiz'));
    }

    public function edit(Topic $topic)
    {
        $quiz = $topic->quiz()->firstOrNew();
        return view('admin.quizzes.edit', compact('topic', 'quiz'));
    }

    public function update(Request $request, Topic $topic)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'time_limit' => 'nullable|integer|min:1',
            'is_published' => 'boolean'
        ]);

        $quiz = $topic->quiz()->updateOrCreate([], $validated);

        return redirect()->route('admin.topics.quiz.show', $topic)
            ->with('success', 'Quiz settings updated successfully');
    }

    public function create(Topic $topic)
    {
        // Check if quiz already exists
        if ($topic->quiz) {
            return redirect()->route('admin.topics.quiz.show', $topic)
                ->with('warning', 'This topic already has a quiz');
        }

        return view('admin.quizzes.create', compact('topic'));
    }

    public function store(Request $request, Topic $topic)
    {
        $validated = $request->validate([
            'question' => 'required|string',
            'options' => 'required|array|size:4',
            'options.*.text' => 'required|string',
            'correct_answer' => 'required|in:A,B,C,D'
        ]);

        // Create quiz for this topic
        $quiz = $topic->quizzes()->create([
            'question' => $validated['question'],
            'correct_answer' => $validated['correct_answer']
        ]);

        // Create options
        foreach ($validated['options'] as $label => $option) {
            $quiz->options()->create([
                'option_label' => $label,
                'option_text' => $option['text']
            ]);
        }

        return redirect()->route('admin.topics.quizzes.index', $topic)
            ->with('success', 'Quiz created successfully!');
    }
}
