<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\QuizAnswer;
use App\Models\QuizQuestion;
use Illuminate\Http\Request;

class QuizQuestionController extends Controller
{
    public function store(Request $request, $quiz_id)
    {
        $request->validate([
            'question_text' => 'required|string|max:255',
            'correct_answers' => 'required|array|min:1', // At least one correct answer is required
            'options' => 'nullable|array', // Options are optional
        ]);

        // Create the question
        $question = QuizQuestion::create([
            'quiz_id' => $quiz_id,
            'question_text' => $request->question_text,
        ]);

        // Store all correct answers (is_correct = 1)
        foreach ($request->correct_answers as $correctAnswer) {
            QuizAnswer::create([
                'quiz_id' => $quiz_id,
                'question_id' => $question->id,
                'answer_text' => $correctAnswer,
                'is_correct' => 1, // Marked as correct
            ]);
        }

        // Store all incorrect options (is_correct = 0)
        if (!empty($request->options)) {
            foreach ($request->options as $option) {
                QuizAnswer::create([
                    'quiz_id' => $quiz_id,
                    'question_id' => $question->id,
                    'answer_text' => $option,
                    'is_correct' => 0, // Marked as incorrect
                ]);
            }
        }

        return redirect()->back()->with('success', 'Question and answers added successfully!');
    }

    public function destroy($topic_id, $quiz_id, $question_id)
    {
        $question = QuizQuestion::findOrFail($question_id);
        $question->delete();

        return redirect()->back()->with('success', 'Question deleted successfully.');
    }



}
