<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuizAnswer extends Model
{
    protected $fillable = [
        'quiz_id', 
        'question_id', 
        'answer_text', 
        'is_correct'
    ];

    public function question()
    {
        return $this->belongsTo(QuizQuestion::class);
    }

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }
}