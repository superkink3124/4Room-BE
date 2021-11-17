<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'post_id',
        'content'
    ];

    /**
     * Get the post that owns this comment.
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * Get the user that owns this comment.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function notification()
    {
        return $this->hasOne(Notification::class);
    }
}
