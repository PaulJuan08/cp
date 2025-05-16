<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Topic;
use App\Models\QuizAnswer;
use App\Models\QuizQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class QuizQuestionController extends Controller
{
    public function create($encryptedTopic, $encryptedQuiz)
    {
        try {
            $topicId = decrypt($encryptedTopic);
            $quizId = decrypt($encryptedQuiz);
            
            $topic = Topic::findOrFail($topicId);
            $quiz = Quiz::findOrFail($quizId);
            
            return view('admin.topics.quiz.questions.create', compact('topic', 'quiz', 'encryptedTopic', 'encryptedQuiz'));
            
        } catch (DecryptException $e) {
            abort(404, 'Invalid ID');
        }
    }

    public function store(Request $request, $encryptedTopic, $encryptedQuiz)
    {
        try {
            $topicId = decrypt($encryptedTopic);
            $quizId = decrypt($encryptedQuiz);
            
            $validated = $request->validate([
                'question_text' => 'required|string',
                'correct_answers' => 'required|array',
                'correct_answers.*' => 'required|string',
                'options' => 'nullable|array',
                'options.*' => 'nullable|string',
            ]);
            
            $question = QuizQuestion::create([
                'quiz_id' => $quizId,
                'question_text' => $validated['question_text'],
            ]);
            
            foreach ($validated['correct_answers'] as $answer) {
                $question->answers()->create([
                    'answer_text' => $answer,
                    'is_correct' => true,
                ]);
            }
            
            if (!empty($validated['options'])) {
                foreach ($validated['options'] as $option) {
                    if (!empty($option)) {
                        $question->answers()->create([
                            'answer_text' => $option,
                            'is_correct' => false,
                        ]);
                    }
                }
            }
            
            return redirect()->route('admin.topics.quiz.show', [
                'encryptedTopic' => $encryptedTopic,
                'encryptedQuiz' => $encryptedQuiz
            ])->with('success', 'Question added successfully');
            
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to add question: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $encryptedTopic, $encryptedQuiz, $encryptedQuestion)
    {
        try {
            $topicId = decrypt($encryptedTopic);
            $quizId = decrypt($encryptedQuiz);
            $questionId = decrypt($encryptedQuestion);
            
            $validated = $request->validate([
                'question_text' => 'required|string',
                'correct_answers' => 'required|array',
                'correct_answers.*' => 'required|string',
                'options' => 'nullable|array',
                'options.*' => 'nullable|string',
            ]);
            
            $question = QuizQuestion::findOrFail($questionId);
            $question->update(['question_text' => $validated['question_text']]);
            
            // Update answers
            $question->answers()->delete();
            
            foreach ($validated['correct_answers'] as $answer) {
                $question->answers()->create([
                    'answer_text' => $answer,
                    'is_correct' => true,
                ]);
            }
            
            if (!empty($validated['options'])) {
                foreach ($validated['options'] as $option) {
                    if (!empty($option)) {
                        $question->answers()->create([
                            'answer_text' => $option,
                            'is_correct' => false,
                        ]);
                    }
                }
            }
            
            return redirect()->route('admin.topics.quiz.show', [
                'encryptedTopic' => $encryptedTopic,
                'encryptedQuiz' => $encryptedQuiz
            ])->with('success', 'Question updated successfully');
            
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update question: ' . $e->getMessage());
        }
    }

    public function destroy($encryptedTopic, $encryptedQuiz, $encryptedQuestion)
    {
        try {
            $questionId = decrypt($encryptedQuestion);
            $question = QuizQuestion::findOrFail($questionId);
            $question->delete();

            return redirect()->route('admin.topics.quiz.show', [
                'encryptedTopic' => $encryptedTopic,
                'encryptedQuiz' => $encryptedQuiz
            ])->with('success', 'Question deleted successfully');
            
        } catch (DecryptException $e) {
            abort(404, 'Invalid ID');
        } catch (\Exception $e) {
            return back()->with('error', 'Error deleting question: ' . $e->getMessage());
        }
    }
}