<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use App\Traits\HasHashedIds;

class TopicAccess extends Model
{
    use HasFactory;
    // use HasHashedIds;

    protected $fillable = ['user_id', 'topic_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }
}