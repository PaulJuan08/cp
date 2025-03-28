<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizQuestion extends Model
{
    use HasFactory;

    protected $table = 'quiz_questions';

    protected $fillable = ['quiz_id', 'question_text'];

    /**
     * Get the correct answer for the question.
     */
    public function correctAnswer()
    {
        return $this->hasOne(QuizAnswer::class, 'question_id');
    }

    /**
     * Get all possible answers (assuming multiple choices).
     */
    public function answers()
    {
        return $this->hasMany(QuizAnswer::class, 'question_id');
    }
}
