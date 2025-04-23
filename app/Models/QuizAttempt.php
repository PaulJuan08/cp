<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use App\Traits\HasHashedIds;

class QuizAttempt extends Model
{
    use HasFactory;
    // use HasHashedIds;

    protected $fillable = [
        'user_id',
        'topic_id',
        'quiz_id',
        'score',
        'total_questions',
        'passed'
    ];
    

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }
}