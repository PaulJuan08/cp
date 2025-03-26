<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany};

class Quiz extends Model
{
    protected $fillable = [
        'topic_id', 'title', 'description',
        'total_points', 'time_limit', 'is_published'
    ];

    protected $casts = [
        'is_published' => 'boolean'
    ];

    public function topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(QuizItem::class)->orderBy('order');
    }

    public function updateTotalPoints(): void
    {
        $this->update(['total_points' => $this->items()->sum('points')]);
    }
}