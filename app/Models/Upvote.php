<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Upvote extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'post_id',
    ];

    /**
     * Get the user upvote the post.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the post that owns this upvote.
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function notification() {
        return $this->hasOne(Notification::class);
    }
}
