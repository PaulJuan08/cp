<?php

namespace App\Models;

use App\Models\Quiz;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use App\Traits\HasHashedIds;

class QuizQuestion extends Model
{
    use HasFactory;
    // use HasHashedIds;

    protected $table = 'quiz_questions';

    protected $fillable = ['quiz_id', 'question_text'];

    protected $casts = [
        'is_correct' => 'boolean',
    ];
    

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
        return $this->hasMany(QuizAnswer::class, 'question_id', 'id');
    }

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

}
