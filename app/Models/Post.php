<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'content',
    ];

    /**
     * Get the user that owns this post.
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all comments that in this post.
     * @return HasMany
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get all upvotes that in this post.
     * @return HasMany
     */
    public function upvotes(): HasMany
    {
        return $this->hasMany(Upvote::class);
    }

    /**
     * Get file attach this post.
     * @return HasOne
     */
    public function file(): HasOne
    {
        return $this->hasOne(File::class);
    }
}
