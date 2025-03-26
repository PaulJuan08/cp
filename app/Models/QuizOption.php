<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuizOption extends Model
{
    protected $fillable = [
        'quiz_item_id', 'option_text',
        'is_correct', 'order'
    ];

    protected $casts = [
        'is_correct' => 'boolean',
        'order' => 'integer'
    ];

    public function item(): BelongsTo
    {
        return $this->belongsTo(QuizItem::class);
    }
}