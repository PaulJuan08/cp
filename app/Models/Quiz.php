<?php

namespace App\Models;

use App\Models\QuizQuestion;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\Console\Question\Question;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Quiz extends Model
{
    protected $fillable = ['title', 'description', 'topic_id'];

    public function topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class);
    }

    public function questions(): HasMany
    {
        return $this->hasMany(QuizQuestion::class, 'quiz_id', 'id');
    }

    public function attempts(): HasMany
    {
        return $this->hasMany(QuizAttempt::class, 'quiz_id', 'id');
    }
}