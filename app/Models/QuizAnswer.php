<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use App\Traits\HasHashedIds;

class QuizAnswer extends Model
{
    use HasFactory;
    // use HasHashedIds;

    protected $table = 'quiz_answers';

    protected $fillable = [
        'quiz_id', 
        'question_id', 
        'answer_text', 
        'is_correct'
    ];

    /**
     * Defines a relationship with QuizQuestion.
     */
    public function question()
    {
        return $this->belongsTo(QuizQuestion::class, 'question_id');
    }
}
