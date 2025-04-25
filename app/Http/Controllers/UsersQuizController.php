<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\User;
use App\Models\Topic;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Validation\Rule;

class UsersQuizController extends Controller
{
    const QUESTIONS_TO_SHOW = 10; // Number of questions to display

    public function show($encryptedTopicId, $encryptedQuizId)
    {
        try {
            // Decrypt the IDs
            $topicId = Crypt::decrypt($encryptedTopicId);
            $quizId = Crypt::decrypt($encryptedQuizId);
            
            $topic = Topic::findOrFail($topicId);
            $quiz = $topic->quizzes()
                        ->with(['questions' => function($query) {
                            $query->inRandomOrder()
                                ->take(self::QUESTIONS_TO_SHOW)
                                ->with(['answers' => function($query) {
                                    $query->inRandomOrder();
                                }]);
                        }])
                        ->findOrFail($quizId);

            $questions = $quiz->questions;
            $totalQuestions = $quiz->questions()->count();

            return view('users.quiz.show', [
                'quiz' => $quiz,
                'topic' => $topic,
                'questions' => $questions,
                'totalQuestions' => $totalQuestions,
                'questionsToShow' => self::QUESTIONS_TO_SHOW,
                'encryptedTopicId' => $encryptedTopicId,
                'encryptedQuizId' => $encryptedQuizId
            ]);
            
        } catch (DecryptException $e) {
            Log::error("Failed to decrypt IDs", [
                'topicId' => $encryptedTopicId,
                'quizId' => $encryptedQuizId,
                'error' => $e->getMessage()
            ]);
            abort(404, 'Quiz not found');
        } catch (\Exception $e) {
            Log::error("Quiz show failed", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            abort(500, 'Error loading quiz');
        }
    }

    public function submit(Request $request, $encryptedTopicId, $encryptedQuizId)
    {
        try {
            // Decrypt the IDs
            $topicId = Crypt::decrypt($encryptedTopicId);
            $quizId = Crypt::decrypt($encryptedQuizId);
            
            $topic = Topic::findOrFail($topicId);
            $quiz = Quiz::findOrFail($quizId);
            $course = $topic->courses()->first();
            
            // Simplified validation - remove the exists rule temporarily
            $validated = $request->validate([
                'answers' => 'required|array',
                'answers.*' => 'required|integer'
            ]);
            
            $user = $request->user();
            
            // Calculate score
            $score = $this->calculateScore($quiz, $validated['answers']);
            $totalQuestions = count($validated['answers']);
            $percentage = ($totalQuestions > 0) ? round(($score / $totalQuestions) * 100) : 0;
            $passed = $percentage >= 70;
            
            // Record quiz attempt
            $quizAttempt = $user->quizAttempts()->create([
                'topic_id' => $topic->id,
                'quiz_id' => $quiz->id,
                'score' => $score,
                'total_questions' => $totalQuestions,
                'passed' => $passed,
                'questions_shown' => $totalQuestions
            ]);
            
            // Prepare response
            $responseData = [
                'success' => true,
                'score' => $score,
                'total' => $totalQuestions,
                'percentage' => $percentage,
                'passed' => $passed,
                'message' => "You scored $score out of $totalQuestions ($percentage%)" . 
                            ($passed ? " - Passed!" : " - Try again!"),
                'feedback' => $this->getFeedback($score, $totalQuestions),
                'topic_id' => $topic->id,
                'progress' => $course ? $this->calculateCourseProgress($user, $course) : 0,
                'next_topic_available' => false,
                'next_topic_url' => null
            ];
            
            if ($passed) {
                $user->completedTopics()->syncWithoutDetaching([$topic->id => [
                    'completed_at' => now(),
                    'quiz_attempt_id' => $quizAttempt->id
                ]]);
                
                if ($course) {
                    $nextTopic = $this->getNextTopic($course, $topic);
                    if ($nextTopic) {
                        $responseData['next_topic_available'] = true;
                        $responseData['next_topic_url'] = route('users.contents.show', encrypt($nextTopic->id));
                    }
                }
            }
            
            return response()->json($responseData);
            
        } catch (DecryptException $e) {
            Log::error('Decryption failed', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => 'Invalid quiz access'], 403);
        } catch (\Exception $e) {
            Log::error('Quiz submission error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Error submitting quiz: ' . $e->getMessage()
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

        // Get all topics for the course ordered by ID
        $topics = $course->topics()->orderBy('id')->get();
        
        // Find the current topic's position
        $currentIndex = $topics->search(function($topic) use ($currentTopic) {
            return $topic->id === $currentTopic->id;
        });
        
        // Return the next topic if it exists
        return $topics->get($currentIndex + 1);
    }

    private function calculateScore(Quiz $quiz, array $userAnswers): int
    {
        $score = 0;
        
        foreach ($userAnswers as $questionId => $answerId) {
            try {
                $isCorrect = $quiz->questions()
                    ->where('id', $questionId)
                    ->whereHas('answers', function($query) use ($answerId) {
                        $query->where('id', $answerId)
                              ->where('is_correct', true);
                    })
                    ->exists();
                
                if ($isCorrect) {
                    $score++;
                }
            } catch (\Exception $e) {
                Log::error('Error checking answer', [
                    'questionId' => $questionId,
                    'answerId' => $answerId,
                    'error' => $e->getMessage()
                ]);
                continue;
            }
        }
        
        return $score;
    }

    private function getFeedback(int $score, int $total): string
    {
        if ($total === 0) return 'No questions available';
        
        $percentage = ($score / $total) * 100;
        
        if ($percentage >= 80) return 'Excellent work!';
        if ($percentage >= 70) return 'Good job!';
        return 'Review the material and try again!';
    }
}