<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Topic;
use App\Models\QuizAttempt;
use App\Models\QuizQuestion;
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

    public function viewAsUser($topicId, $quizId)
    {
        $topic = Topic::findOrFail($topicId);
        $quiz = Quiz::findOrFail($quizId);

        return view('admin.topics.quiz.user_quiz', compact('topic', 'quiz'));
    }


    // Quiz Submission Logic
    // public function submitQuiz(Request $request, $topicId)
    // {
    //     $user = auth()->user();
    //     $topic = Topic::findOrFail($topicId);
    //     $course = $topic->course;
        
    //     // Calculate score
    //     $totalQuestions = count($request->questions);
    //     $correctAnswers = 0;
        
    //     foreach ($request->questions as $questionId => $answer) {
    //         $question = QuizQuestion::find($questionId);
    //         if ($question && $question->correct_answer == $answer) {
    //             $correctAnswers++;
    //         }
    //     }
        
    //     $score = ($correctAnswers / $totalQuestions) * 100;
    //     $passed = $score >= 70;
        
    //     // Record quiz attempt
    //     $quizAttempt = QuizAttempt::create([
    //         'user_id' => $user->id,
    //         'topic_id' => $topicId,
    //         'score' => $score,
    //         'passed' => $passed
    //     ]);
        
    //     // If passed, mark topic as completed
    //     if ($passed) {
    //         $user->completedTopics()->syncWithoutDetaching([$topicId]);
            
    //         return response()->json([
    //             'success' => true,
    //             'score' => $score,
    //             'passed' => true,
    //             'message' => "You scored $correctAnswers out of $totalQuestions ($score%) - Excellent work!",
    //             'next_topic_url' => $this->getNextTopicUrl($course, $topic)
    //         ]);
    //     }
        
    //     return response()->json([
    //         'success' => true,
    //         'score' => $score,
    //         'passed' => false,
    //         'message' => "You scored $correctAnswers out of $totalQuestions ($score%) - Please try again!",
    //         'retry_url' => route('quiz.show', $topicId)
    //     ]);
    // }

    // private function getNextTopicUrl($course, $currentTopic)
    // {
    //     $nextTopic = $course->topics()
    //         ->where('status', 1)
    //         ->where('id', '>', $currentTopic->id)
    //         ->orderBy('id')
    //         ->first();
        
    //     return $nextTopic ? route('users.contents.show', $nextTopic->id) : null;
    // }

    

}
