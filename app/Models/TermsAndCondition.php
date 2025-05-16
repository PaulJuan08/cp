<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Crypt;

class TermsAndCondition extends Model
{
    protected $fillable = ['content', 'is_published', 'published_at'];
    
    public static function current()
    {
        return self::where('is_published', true)->latest('published_at')->first();
    }
}