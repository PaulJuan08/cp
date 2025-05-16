<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use App\Traits\HasHashedIds;

class QuizOption extends Model
{
    use HasFactory;
    // use HasHashedIds;

    protected $fillable = ['question_id', 'option_text'];

    public function question()
    {
        return $this->belongsTo(QuizQuestion::class, 'question_id');
    }
}
