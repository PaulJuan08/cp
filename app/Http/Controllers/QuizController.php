<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class QuizController extends Controller
{
    public function index($encryptedTopicId)
    {
        try {
            $topicId = Crypt::decrypt($encryptedTopicId);
            $topic = Topic::findOrFail($topicId);
            $quizzes = Quiz::where('topic_id', $topic->id)->get();
            
            return view('admin.topics.quiz.index', compact('topic', 'quizzes', 'encryptedTopicId'));
            
        } catch (DecryptException $e) {
            abort(404, 'Invalid topic ID');
        }
    }

    public function create($encryptedTopicId)
    {
        try {
            $topicId = Crypt::decrypt($encryptedTopicId);
            $topic = Topic::findOrFail($topicId);
            
            return view('admin.topics.quiz.create', compact('topic', 'encryptedTopicId'));
            
        } catch (DecryptException $e) {
            abort(404, 'Invalid topic ID');
        }
    }

    public function store(Request $request, $encryptedTopicId)
    {
        try {
            $topicId = Crypt::decrypt($encryptedTopicId);
            $topic = Topic::findOrFail($topicId);

            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
            ]);

            Quiz::create([
                'topic_id' => $topic->id,
                'title' => $request->title,
                'description' => $request->description,
            ]);

            return redirect()->route('admin.topics.quiz.index', $encryptedTopicId)
                            ->with('success', 'Quiz created successfully!');
                            
        } catch (DecryptException $e) {
            abort(404, 'Invalid topic ID');
        }
    }

    public function show($encryptedTopicId, $encryptedQuizId)
    {
        try {
            $topicId = Crypt::decrypt($encryptedTopicId);
            $quizId = Crypt::decrypt($encryptedQuizId);
            
            $topic = Topic::findOrFail($topicId);
            $quiz = Quiz::with(['questions.answers'])->findOrFail($quizId);
            
            return view('admin.topics.quiz.show', compact('topic', 'quiz', 'encryptedTopicId'));
            
        } catch (DecryptException $e) {
            abort(404, 'Invalid ID');
        }
    }

    public function edit($encryptedTopicId, $encryptedQuizId)
    {
        try {
            $topicId = Crypt::decrypt($encryptedTopicId);
            $quizId = Crypt::decrypt($encryptedQuizId);
            
            $topic = Topic::findOrFail($topicId);
            $quiz = Quiz::findOrFail($quizId);
            
            return view('admin.topics.quiz.edit', compact('topic', 'quiz', 'encryptedTopicId'));
            
        } catch (DecryptException $e) {
            abort(404, 'Invalid ID');
        }
    }

    public function update(Request $request, $encryptedTopicId, $encryptedQuizId)
    {
        try {
            $topicId = Crypt::decrypt($encryptedTopicId);
            $quizId = Crypt::decrypt($encryptedQuizId);
            
            $quiz = Quiz::findOrFail($quizId);

            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
            ]);

            $quiz->update($request->all());

            return redirect()->route('admin.topics.quiz.index', $encryptedTopicId)
                            ->with('success', 'Quiz updated successfully!');
                            
        } catch (DecryptException $e) {
            abort(404, 'Invalid ID');
        }
    }

    public function destroy($encryptedTopicId, $encryptedQuizId)
    {
        try {
            $quizId = Crypt::decrypt($encryptedQuizId);
            $quiz = Quiz::findOrFail($quizId);
            $quiz->delete();

            return redirect()->route('admin.topics.quiz.index', $encryptedTopicId)
                            ->with('success', 'Quiz deleted successfully!');
                            
        } catch (DecryptException $e) {
            abort(404, 'Invalid quiz ID');
        }
    }

    public function viewAsUser($encryptedTopicId, $encryptedQuizId)
    {
        try {
            $topicId = Crypt::decrypt($encryptedTopicId);
            $quizId = Crypt::decrypt($encryptedQuizId);
            
            $topic = Topic::findOrFail($topicId);
            $quiz = Quiz::findOrFail($quizId);

            return view('admin.topics.quiz.user_quiz', compact('topic', 'quiz'));
            
        } catch (DecryptException $e) {
            abort(404, 'Invalid ID');
        }
    }
}