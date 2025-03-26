<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuizAnswer extends Model
{
    protected $fillable = [
        'quiz_item_id', 'correct_answer',
        'keywords', 'max_words'
    ];

    public function item(): BelongsTo
    {
        return $this->belongsTo(QuizItem::class);
    }
}