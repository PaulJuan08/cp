<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\QuizAnswer;

class QuizQuestionController extends Controller
{
    public function store(Request $request, $quiz_id)
    {
        $request->validate([
            'question_text' => 'required|string|max:255',
            'answer_text' => 'required|string|max:255',
        ]);

        // Create the question
        $question = QuizQuestion::create([
            'quiz_id' => $quiz_id,
            'question_text' => $request->question_text,
        ]);

        // Create the answer
        QuizAnswer::create([
            'quiz_id' => $quiz_id,
            'question_id' => $question->id,
            'answer_text' => $request->answer_text,
        ]);

        return redirect()->back()->with('success', 'Question added successfully!');
    }
}
