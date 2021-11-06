<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'content',
        'has_file',
        'file_address',
        'file_name',
        'file_size',
        'file_description'
    ];

    /**
     * Get the user that owns this post.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all comments that in this post.
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
