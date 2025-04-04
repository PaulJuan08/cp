<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Topic;
use Illuminate\Http\Request;

class UsersQuizController extends Controller
{
    public function show(Topic $topic, $quizId)
    {
        // Option 1: If you have a relationship
        // $quiz = $topic->quizzes()->findOrFail($quizId);
        
        // Option 2: If quizzes are independent
        $quiz = Quiz::findOrFail($quizId);
        
        return view('users.quiz.show', compact('quiz', 'topic'));
    }

    public function submit(Request $request, Topic $topic, Quiz $quiz)
    {
        $validated = $request->validate([
            'answers' => 'required|array',
            'answers.*' => 'required',
            '_token' => 'required'
        ]);
        
        $score = 0;
        $totalQuestions = $quiz->questions->count();
        
        foreach ($quiz->questions as $question) {
            $submittedAnswerId = $validated['answers'][$question->id];
            $correctAnswer = $question->answers->where('is_correct', true)->first();
            
            if ($correctAnswer && $correctAnswer->id == $submittedAnswerId) {
                $score++;
            }
        }
        
        $percentage = round(($score / $totalQuestions) * 100);
        
        return response()->json([
            'success' => true,
            'score' => $score,
            'total' => $totalQuestions,
            'percentage' => $percentage,
            'feedback' => $this->getFeedback($score, $totalQuestions)
        ]);
    }

    private function calculateScore(Quiz $quiz, array $userAnswers)
    {
        $score = 0;
        
        foreach ($quiz->questions as $question) {
            $userAnswer = $userAnswers[$question->id] ?? null;
            
            if ($userAnswer) {
                // Check if the selected answer is correct
                $isCorrect = $question->answers()
                    ->where('id', $userAnswer)
                    ->value('is_correct');
                
                if ($isCorrect) {
                    $score++;
                }
            }
        }
        
        return $score;
    }

    private function getFeedback($score, $total)
    {
        $percentage = ($score / $total) * 100;
        
        if ($percentage >= 80) return 'Excellent work!';
        if ($percentage >= 60) return 'Good job!';
        if ($percentage >= 40) return 'Keep practicing!';
        return 'Review the material and try again!';
    }
}
