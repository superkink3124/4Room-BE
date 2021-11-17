<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    public function upvote() {
        return $this->belongsTo(Upvote::class);
    }

    public function comment() {
        return $this->belongsTo(Comment::class);
    }

    public function follow() {
        return $this->belongsTo(Follow::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
