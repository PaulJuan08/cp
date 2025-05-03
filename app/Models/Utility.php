<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Utility extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'title',
        'content',
        'is_published',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_published' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Available utility types.
     *
     * @var array
     */
    public const TYPES = [
        'terms' => 'Terms and Conditions',
        'privacy' => 'Privacy Policy',
        'cookies' => 'Cookies Policy',
    ];

    /**
     * Scope a query to only include published utilities.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Get the human-readable type name.
     *
     * @return string
     */
    public function getTypeNameAttribute()
    {
        return self::TYPES[$this->type] ?? ucfirst($this->type);
    }

    /**
     * Get the latest published version of a specific utility type.
     *
     * @param string $type
     * @return \App\Models\Utility|null
     */
    public static function getPublished($type)
    {
        return self::where('type', $type)
            ->published()
            ->latest()
            ->first();
    }
}