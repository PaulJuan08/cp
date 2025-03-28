<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany};

class Quiz extends Model
{
    use HasFactory;
    
    protected $fillable = ['topic_id', 'title', 'description'];

    public function questions()
    {
        return $this->hasMany(QuizQuestion::class);
    }


    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }
}