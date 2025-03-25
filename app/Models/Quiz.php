<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = ['topic_id', 'title', 'description'];

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }
}
