<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{
    BelongsTo,
    HasMany,
    HasOne
};

class QuizItem extends Model
{
    protected $fillable = [
        'quiz_id', 'question', 'question_type',
        'points', 'order', 'explanation'
    ];

    protected $casts = [
        'points' => 'integer',
        'order' => 'integer'
    ];

    const TYPES = [
        'multiple_choice' => 'Multiple Choice',
        'true_false' => 'True/False',
        'short_answer' => 'Short Answer',
        'essay' => 'Essay'
    ];

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    public function options(): HasMany
    {
        return $this->hasMany(QuizOption::class)->orderBy('order');
    }

    public function answer(): HasOne
    {
        return $this->hasOne(QuizAnswer::class);
    }

    public function getTypeNameAttribute(): string
    {
        return self::TYPES[$this->question_type] ?? $this->question_type;
    }
}