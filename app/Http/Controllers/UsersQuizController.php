<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\User;
use App\Models\Topic;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UsersQuizController extends Controller
{
    public function show(Topic $topic, $quizId)
    {
        $quiz = $topic->quizzes()->findOrFail($quizId);
        return view('users.quiz.show', compact('quiz', 'topic'));
    }

    public function submit(Request $request, Topic $topic, Quiz $quiz)
    {
        $validated = $request->validate([
            'answers' => 'required|array',
            'answers.*' => 'required',
        ]);
        
        $user = auth()->user();
        $score = $this->calculateScore($quiz, $validated['answers']);
        $totalQuestions = $quiz->questions->count();
        $percentage = ($totalQuestions > 0) ? round(($score / $totalQuestions) * 100) : 0;
        $passed = $percentage >= 70; // Passing threshold
        
        try {
            // Record quiz attempt
            $quizAttempt = $user->quizAttempts()->create([
                'topic_id' => $topic->id,
                'quiz_id' => $quiz->id,
                'score' => $score,
                'total_questions' => $totalQuestions,
                'passed' => $passed
            ]);
            
            $responseData = [
                'success' => true,
                'score' => $score,
                'total' => $totalQuestions,
                'percentage' => $percentage,
                'passed' => $passed,
                'message' => "You scored $score out of $totalQuestions ($percentage%)" . 
                            ($passed ? " - Passed!" : " - Try again!"),
                'feedback' => $this->getFeedback($score, $totalQuestions),
                'topic_id' => $topic->id
            ];
            
            if ($passed) {
                // Only mark as completed if passed
                $user->completedTopics()->syncWithoutDetaching([$topic->id => [
                    'completed_at' => now(),
                    'quiz_attempt_id' => $quizAttempt->id
                ]]);
                
                // Get the course and calculate progress
                $course = $topic->courses()->first();
                if ($course) {
                    $responseData['progress'] = $this->calculateCourseProgress($user, $course);
                    
                    // Unlock next topic if exists
                    $nextTopic = $this->getNextTopic($course, $topic);
                    if ($nextTopic) {
                        $responseData['next_topic_available'] = true;
                        $responseData['next_topic_url'] = route('users.contents.show', $nextTopic->id);
                    } else {
                        $responseData['next_topic_available'] = false;
                    }
                }
            } else {
                // For failed attempts, still return current progress
                $course = $topic->courses()->first();
                if ($course) {
                    $responseData['progress'] = $this->calculateCourseProgress($user, $course);
                }
            }
            
            return response()->json($responseData);
            
        } catch (\Exception $e) {
            Log::error('Quiz submission error', [
                'error' => $e->getMessage(),
                'topic_id' => $topic->id,
                'quiz_id' => $quiz->id,
                'user_id' => auth()->id()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error submitting quiz. Please try again.'
            ], 500);
        }
    }

    private function calculateCourseProgress(User $user, Course $course): int
    {
        // Count only topics with passed quizzes
        $completed = $user->completedTopics()
            ->whereHas('quizzes.attempts', function($query) use ($user) {
                $query->where('user_id', $user->id)
                      ->where('passed', true);
            })
            ->whereHas('courses', function($query) use ($course) {
                $query->where('course_id', $course->id);
            })
            ->count();
        
        $total = $course->topics()->count();
        
        return $total > 0 ? (int) round(($completed / $total) * 100) : 0;
    }

    private function getNextTopic(?Course $course, Topic $currentTopic): ?Topic
    {
        if (!$course) {
            return null;
        }

        // Load the pivot data if not already loaded
        if (!$currentTopic->relationLoaded('courses')) {
            $currentTopic->load(['courses' => function($query) use ($course) {
                $query->where('course_id', $course->id);
            }]);
        }

        $currentSequence = optional($currentTopic->courses->first())->pivot->sequence_order;
        
        if (is_null($currentSequence)) {
            Log::warning('No sequence order found for topic', [
                'topic_id' => $currentTopic->id,
                'course_id' => $course->id
            ]);
            return null;
        }
        
        return $course->topics()
            ->wherePivot('sequence_order', '>', (int)$currentSequence)
            ->orderByPivot('sequence_order')
            ->first();
    }

    private function calculateScore(Quiz $quiz, array $userAnswers): int
    {
        $score = 0;
        
        foreach ($quiz->questions as $question) {
            $userAnswer = $userAnswers[$question->id] ?? null;
            
            if ($userAnswer) {
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

    private function getFeedback(int $score, int $total): string
    {
        if ($total === 0) return 'No questions available';
        
        $percentage = ($score / $total) * 100;
        
        if ($percentage >= 80) return 'Excellent work!';
        if ($percentage >= 75) return 'Good job!';
        if ($percentage >= 74) return 'Keep practicing!';
        return 'Review the material and try again!';
    }
}